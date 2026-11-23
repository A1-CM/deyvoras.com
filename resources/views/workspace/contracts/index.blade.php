@extends('layouts.workspace')
@section('title', 'Contracts')
@section('breadcrumb', 'Contracts')
@section('content')
<section class="page-heading"><div><div class="eyebrow">AGREEMENT REPOSITORY</div><h1>Contracts</h1><p>Search, organize, and review your organization’s agreements.</p></div>@can('manage-contracts')<a class="button" href="{{ route('contracts.create') }}"><span>＋</span> New contract</a>@endcan</section>
<section class="panel table-panel">
    <form class="filter-bar" method="GET" action="{{ route('contracts.index') }}"><label class="search-field"><span>⌕</span><input type="search" name="q" value="{{ request('q') }}" placeholder="Search title, counterparty, or number" aria-label="Search contracts"></label><select name="type" aria-label="Filter by type"><option value="">All types</option>@foreach ($types as $type)<option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>@endforeach</select><select name="review" aria-label="Filter by review status"><option value="">All review states</option><option value="needs_review" @selected(request('review') === 'needs_review')>Needs review</option></select><button class="button button-outline button-small" type="submit">Filter</button></form>
    <form method="GET" action="{{ route('contracts.compare') }}">@error('ids')<div class="form-alert compare-error" role="alert">Choose between two and four contracts to compare.</div>@enderror<div class="compare-toolbar"><span>Compare 2–4 agreements using their recorded details.</span><button class="button button-outline button-small" type="submit">Compare selected <span>→</span></button></div>
    <div class="table-scroll"><table class="data-table"><thead><tr><th><span class="visually-hidden">SELECT</span></th><th>AGREEMENT</th><th>TYPE</th><th>COUNTERPARTY</th><th>EXPIRY</th><th>STATUS</th><th></th></tr></thead><tbody>
        @forelse ($contracts as $contract)
            <tr><td><input class="compare-check" type="checkbox" name="ids[]" value="{{ $contract->id }}" aria-label="Select {{ $contract->title }} to compare"></td><td><a class="table-title" href="{{ route('contracts.show', $contract) }}">{{ $contract->title }}</a><small>{{ $contract->contract_number ?: 'No reference number' }}</small></td><td>{{ $contract->document_type }}</td><td>{{ $contract->counterparty ?: '—' }}</td><td>{{ $contract->expiry_date?->format('d M Y') ?: '—' }}</td><td><span class="tag {{ $contract->review_status === 'needs_review' ? 'tag-review' : ($contract->status === 'archived' ? 'tag-muted' : '') }}">{{ $contract->status === 'archived' ? 'Archived' : ($contract->review_status === 'needs_review' ? 'Needs review' : ucfirst($contract->status)) }}</span></td><td><a class="row-arrow" href="{{ route('contracts.show', $contract) }}" aria-label="Open {{ $contract->title }}">→</a></td></tr>
        @empty
            <tr><td colspan="7"><div class="empty-state table-empty"><div class="empty-illustration">▤</div><h3>No contracts found.</h3><p>@if (request()->hasAny(['q', 'type', 'review'])) Try another search or clear your filters. @else Add an agreement to create your first repository record. @endif</p>@can('manage-contracts')<a class="button button-outline" href="{{ route('contracts.create') }}">Add a contract <span>→</span></a>@endcan</div></td></tr>
        @endforelse
    </tbody></table></div></form>
    @if ($contracts->hasPages())<div class="pagination-wrap">{{ $contracts->links() }}</div>@endif
</section>
<p class="page-footnote">Contract information should be reviewed against its source agreement before being relied upon.</p>
@endsection
