<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContractController extends Controller
{
    public function index(Request $request): View
    {
        $query = Contract::where('organization_id', $request->user()->organization_id)
            ->with('creator')->latest();

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('counterparty', 'like', "%{$search}%")
                    ->orWhere('contract_number', 'like', "%{$search}%");
            });
        }

        if ($type = $request->query('type')) {
            $query->where('document_type', $type);
        }
        if ($request->query('review') === 'needs_review') {
            $query->where('review_status', 'needs_review');
        }

        return view('workspace.contracts.index', [
            'contracts' => $query->paginate(10)->withQueryString(),
            'types' => Contract::where('organization_id', $request->user()->organization_id)
                ->select('document_type')->distinct()->orderBy('document_type')->pluck('document_type'),
        ]);
    }

    public function create(): View
    {
        return view('workspace.contracts.create');
    }

    public function compare(Request $request): View
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:2', 'max:4'],
            'ids.*' => ['required', 'integer', 'distinct'],
        ]);
        $ids = array_map('intval', $validated['ids']);
        $contracts = Contract::where('organization_id', $request->user()->organization_id)
            ->with(['clauses', 'obligations'])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        abort_unless($contracts->count() === count($ids), 404);

        return view('workspace.contracts.compare', [
            'contracts' => collect($ids)->map(fn (int $id) => $contracts->get($id)),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateContract($request);
        $contract = DB::transaction(function () use ($request, $validated) {
            $contract = Contract::create([
                ...$validated,
                'organization_id' => $request->user()->organization_id,
                'created_by' => $request->user()->id,
            ]);

            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $path = $file->store("contracts/{$contract->organization_id}", 'local');
                $contract->update(['document_path' => $path, 'document_name' => $file->getClientOriginalName()]);
                $contract->documentVersions()->create([
                    'uploaded_by' => $request->user()->id,
                    'version_number' => 1,
                    'document_path' => $path,
                    'document_name' => $file->getClientOriginalName(),
                ]);
                $contract->activities()->create([
                    'user_id' => $request->user()->id,
                    'event' => 'source_document_uploaded',
                    'description' => 'Source document version 1 uploaded.',
                ]);
            }

            $contract->activities()->create([
                'user_id' => $request->user()->id,
                'event' => 'contract_created',
                'description' => 'Contract added to the repository.',
            ]);

            return $contract;
        });

        return redirect()->route('contracts.show', $contract)->with('status', 'Contract added to your repository.');
    }

    public function show(Request $request, int $contract): View
    {
        $contract = $this->ownedContract($request, $contract)->load(['creator', 'clauses', 'obligations.assignee', 'activities.user', 'documentVersions.uploader']);
        $members = User::where('organization_id', $request->user()->organization_id)->orderBy('name')->get(['id', 'name', 'role']);

        return view('workspace.contracts.show', compact('contract', 'members'));
    }

    public function edit(Request $request, int $contract): View
    {
        return view('workspace.contracts.edit', ['contract' => $this->ownedContract($request, $contract)]);
    }

    public function update(Request $request, int $contract): RedirectResponse
    {
        $contract = $this->ownedContract($request, $contract);
        $validated = $this->validateContract($request);
        $file = null;
        $path = null;
        $nextVersion = null;

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store("contracts/{$contract->organization_id}", 'local');
            $nextVersion = (int) $contract->documentVersions()->max('version_number') + 1;
            $validated['document_path'] = $path;
            $validated['document_name'] = $file->getClientOriginalName();
        }

        $contract->fill($validated);
        $changedFields = array_keys($contract->getDirty());

        if ($file && $path && $nextVersion) {
            DB::transaction(function () use ($contract, $request, $nextVersion, $path, $file) {
                $contract->save();
                $contract->documentVersions()->create([
                    'uploaded_by' => $request->user()->id,
                    'version_number' => $nextVersion,
                    'document_path' => $path,
                    'document_name' => $file->getClientOriginalName(),
                ]);
                $contract->activities()->create([
                    'user_id' => $request->user()->id,
                    'event' => 'source_document_uploaded',
                    'description' => "Source document version {$nextVersion} uploaded.",
                ]);
            });
        } else {
            $contract->save();
        }

        $contract->activities()->create([
            'user_id' => $request->user()->id,
            'event' => 'contract_updated',
            'description' => 'Contract details updated'.($changedFields ? ': '.implode(', ', $changedFields).'.' : '.'),
        ]);

        return redirect()->route('contracts.show', $contract)->with('status', 'Contract changes saved.');
    }

    public function archive(Request $request, int $contract): RedirectResponse
    {
        $contract = $this->ownedContract($request, $contract);
        $contract->update(['status' => $contract->status === 'archived' ? 'active' : 'archived']);
        $contract->activities()->create([
            'user_id' => $request->user()->id,
            'event' => $contract->status === 'archived' ? 'contract_archived' : 'contract_restored',
            'description' => $contract->status === 'archived' ? 'Contract archived.' : 'Contract restored to active records.',
        ]);

        return back()->with('status', $contract->status === 'archived' ? 'Contract archived.' : 'Contract restored.');
    }

    public function download(Request $request, int $contract): StreamedResponse
    {
        $contract = $this->ownedContract($request, $contract);
        abort_unless($contract->document_path && Storage::disk('local')->exists($contract->document_path), 404);
        $contract->activities()->create([
            'user_id' => $request->user()->id,
            'event' => 'source_document_accessed',
            'description' => 'Source document downloaded for review.',
        ]);

        return Storage::disk('local')->download($contract->document_path, $contract->document_name);
    }

    public function downloadVersion(Request $request, int $contract, int $version): StreamedResponse
    {
        $contract = $this->ownedContract($request, $contract);
        $document = $contract->documentVersions()->findOrFail($version);
        abort_unless(Storage::disk('local')->exists($document->document_path), 404);
        $contract->activities()->create([
            'user_id' => $request->user()->id,
            'event' => 'source_document_version_accessed',
            'description' => "Source document version {$document->version_number} downloaded for review.",
        ]);

        return Storage::disk('local')->download($document->document_path, $document->document_name);
    }

    private function ownedContract(Request $request, int $id): Contract
    {
        return Contract::where('organization_id', $request->user()->organization_id)->findOrFail($id);
    }

    private function validateContract(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'document_type' => ['required', Rule::in(['Service agreement', 'Supplier agreement', 'Employment agreement', 'Non-disclosure agreement', 'Commercial agreement', 'Lease agreement', 'Amendment', 'Other'])],
            'counterparty' => ['nullable', 'string', 'max:180'],
            'contract_number' => ['nullable', 'string', 'max:120'],
            'effective_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:effective_date'],
            'notice_days' => ['nullable', 'integer', 'between:0,3650'],
            'summary' => ['nullable', 'string', 'max:10000'],
            'status' => ['sometimes', Rule::in(['active', 'under_review', 'archived'])],
            'document' => ['nullable', 'file', 'mimes:pdf,doc,docx,txt,odt', 'max:20480'],
        ]);
    }
}
