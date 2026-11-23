<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContractWorkspaceController extends Controller
{
    public function storeClause(Request $request, int $contract): RedirectResponse
    {
        $contract = $this->ownedContract($request, $contract);
        $data = $request->validate([
            'category' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:180'],
            'excerpt' => ['nullable', 'string', 'max:5000'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $contract->clauses()->create($data + ['verification_status' => 'unverified']);
        $this->log($request, $contract, 'clause_added', 'Clause information added for review.');

        return back()->with('status', 'Clause record added. Verify its wording against the source document.');
    }

    public function verifyClause(Request $request, int $contract, int $clause): RedirectResponse
    {
        $contract = $this->ownedContract($request, $contract);
        $record = $contract->clauses()->findOrFail($clause);
        $record->update([
            'verification_status' => $record->verification_status === 'verified' ? 'unverified' : 'verified',
        ]);
        $this->log($request, $contract, 'clause_verification_changed', 'Clause verification status changed.');

        return back()->with('status', 'Clause review status updated.');
    }

    public function updateClause(Request $request, int $contract, int $clause): RedirectResponse
    {
        $contract = $this->ownedContract($request, $contract);
        $record = $contract->clauses()->findOrFail($clause);
        $data = $request->validate([
            'category' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:180'],
            'excerpt' => ['nullable', 'string', 'max:5000'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
        $changed = $record->category !== $data['category']
            || $record->title !== $data['title']
            || $record->excerpt !== ($data['excerpt'] ?? null);
        $record->update($data + ($changed ? ['verification_status' => 'unverified'] : []));
        $this->log($request, $contract, 'clause_updated', $changed
            ? 'Clause wording or category changed; source verification was reset.'
            : 'Clause reviewer note updated.');

        return back()->with('status', $changed
            ? 'Clause saved. Check the updated wording against the source document.'
            : 'Clause reviewer note saved.');
    }

    public function storeObligation(Request $request, int $contract): RedirectResponse
    {
        $contract = $this->ownedContract($request, $contract);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:3000'],
            'responsible_name' => ['nullable', 'string', 'max:120'],
            'assigned_to_user_id' => ['nullable', 'integer', Rule::exists('users', 'id')->where('organization_id', $request->user()->organization_id)],
            'due_at' => ['nullable', 'date'],
        ]);

        $contract->obligations()->create($data + ['status' => 'open']);
        $this->log($request, $contract, 'obligation_added', 'Contract obligation recorded.');

        return back()->with('status', 'Obligation added to the tracker.');
    }

    public function toggleObligation(Request $request, int $contract, int $obligation): RedirectResponse
    {
        $contract = $this->ownedContract($request, $contract);
        $record = $contract->obligations()->findOrFail($obligation);
        $record->update(['status' => $record->status === 'complete' ? 'open' : 'complete']);
        $this->log($request, $contract, 'obligation_status_changed', 'Obligation marked '.$record->status.'.');

        return back()->with('status', 'Obligation status updated.');
    }

    public function toggleReview(Request $request, int $contract): RedirectResponse
    {
        $contract = $this->ownedContract($request, $contract);
        $contract->update(['review_status' => $contract->review_status === 'reviewed' ? 'needs_review' : 'reviewed']);
        $this->log(
            $request,
            $contract,
            'contract_review_status_changed',
            $contract->review_status === 'reviewed' ? 'Contract review marked complete by a team member.' : 'Contract review reopened.',
        );

        return back()->with('status', $contract->review_status === 'reviewed' ? 'Review marked complete.' : 'Review reopened.');
    }

    private function ownedContract(Request $request, int $id): Contract
    {
        return Contract::where('organization_id', $request->user()->organization_id)->findOrFail($id);
    }

    private function log(Request $request, Contract $contract, string $event, string $description): void
    {
        $contract->activities()->create([
            'user_id' => $request->user()->id,
            'event' => $event,
            'description' => $description,
        ]);
    }
}
