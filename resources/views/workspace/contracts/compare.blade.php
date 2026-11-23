@extends('layouts.workspace')
@section('title', 'Compare agreements')
@section('breadcrumb')<a href="{{ route('contracts.index') }}">Contracts</a><span>/</span><span>Compare</span>@endsection
@section('content')
<section class="page-heading"><div><div class="eyebrow">SIDE-BY-SIDE REVIEW</div><h1>Compare agreements</h1><p>Compare team-recorded details. This view does not interpret or assess legal differences.</p></div><a class="text-link" href="{{ route('contracts.index') }}">← Back to contracts</a></section>
<section class="panel comparison-panel"><div class="table-scroll"><table class="comparison-table"><thead><tr><th>RECORDED DETAIL</th>@foreach ($contracts as $contract)<th><a href="{{ route('contracts.show', $contract) }}">{{ $contract->title }} <span>→</span></a><small>{{ $contract->counterparty ?: 'Counterparty not recorded' }}</small></th>@endforeach</tr></thead><tbody>
    @foreach ([
        'Document type' => fn ($contract) => $contract->document_type,
        'Contract reference' => fn ($contract) => $contract->contract_number ?: 'Not recorded',
        'Status' => fn ($contract) => ucfirst(str_replace('_', ' ', $contract->status)),
        'Effective date' => fn ($contract) => $contract->effective_date?->format('d M Y') ?: 'Not recorded',
        'Expiry / renewal' => fn ($contract) => $contract->expiry_date?->format('d M Y') ?: 'Not recorded',
        'Notice period' => fn ($contract) => $contract->notice_days !== null ? $contract->notice_days.' days' : 'Not recorded',
        'Review status' => fn ($contract) => $contract->review_status === 'reviewed' ? 'Team marked reviewed' : 'Needs review',
        'Summary' => fn ($contract) => $contract->summary ?: 'No summary recorded',
    ] as $label => $value)<tr><th>{{ $label }}</th>@foreach ($contracts as $contract)<td>{{ $value($contract) }}</td>@endforeach</tr>@endforeach
    <tr><th>Clause records</th>@foreach ($contracts as $contract)<td>@forelse ($contract->clauses as $clause)<div class="compare-clause"><span class="tag tag-muted">{{ $clause->category }}</span><b>{{ $clause->title }}</b><small>{{ $clause->verification_status === 'verified' ? 'Checked against source' : 'Unverified' }}</small>@if ($clause->excerpt)<p>{{ $clause->excerpt }}</p>@endif</div>@empty<span class="muted-text">No clauses recorded</span>@endforelse</td>@endforeach</tr>
    <tr><th>Open obligations</th>@foreach ($contracts as $contract)<td>@forelse ($contract->obligations->where('status', 'open') as $obligation)<div class="compare-obligation"><b>{{ $obligation->title }}</b><small>{{ $obligation->due_at?->format('d M Y') ?: 'No due date' }} · {{ $obligation->responsible_name ?: 'Unassigned' }}</small></div>@empty<span class="muted-text">No open obligations</span>@endforelse</td>@endforeach</tr>
</tbody></table></div></section><p class="page-footnote">This comparison summarizes entered records. It does not detect every difference between the underlying agreements and is not legal advice.</p>
@endsection
