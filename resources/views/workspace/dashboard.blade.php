@extends('layouts.workspace')
@section('title', 'Overview')
@section('content')
<section class="page-heading dashboard-heading"><div><div class="eyebrow">{{ now()->format('l · j F Y') }}</div><h1>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ Str::before(auth()->user()->name, ' ') }}.</h1><p>Here is the current picture of your agreements.</p></div>@can('manage-contracts')<a class="button" href="{{ route('contracts.create') }}"><span>＋</span> New contract</a>@endcan</section>
<section class="metric-grid" aria-label="Workspace summary">
    <article class="metric-card"><div class="metric-label"><span>ACTIVE AGREEMENTS</span><span class="metric-icon">▤</span></div><strong>{{ str_pad($contractCount, 2, '0', STR_PAD_LEFT) }}</strong><p>In your organization workspace</p><a href="{{ route('contracts.index') }}">View contracts <span>→</span></a></article>
    <article class="metric-card"><div class="metric-label"><span>NEEDS REVIEW</span><span class="metric-icon">⌕</span></div><strong>{{ str_pad($reviewCount, 2, '0', STR_PAD_LEFT) }}</strong><p>Records awaiting human review</p><a href="{{ route('contracts.index', ['review' => 'needs_review']) }}">Review records <span>→</span></a></article>
    <article class="metric-card"><div class="metric-label"><span>OPEN OBLIGATIONS</span><span class="metric-icon">◷</span></div><strong>{{ str_pad($obligationCount, 2, '0', STR_PAD_LEFT) }}</strong><p>Commitments still in progress</p><a href="#obligations">See upcoming <span>→</span></a></article>
</section>
<div class="dashboard-columns">
    <section class="panel recent-panel" id="reviews"><div class="panel-heading"><div><span class="eyebrow">YOUR REPOSITORY</span><h2>Recent contracts</h2></div><a class="text-link" href="{{ route('contracts.index') }}">All contracts <span>→</span></a></div>
        @forelse ($recent as $contract)
            <a class="contract-row" href="{{ route('contracts.show', $contract) }}"><span class="doc-icon">{{ strtoupper(substr($contract->document_type, 0, 1)) }}</span><span class="contract-row-main"><strong>{{ $contract->title }}</strong><small>{{ $contract->counterparty ?: $contract->document_type }} · Added {{ $contract->created_at->diffForHumans() }}</small></span><span class="tag {{ $contract->review_status === 'needs_review' ? 'tag-review' : '' }}">{{ $contract->review_status === 'needs_review' ? 'Needs review' : ucfirst($contract->status) }}</span><span class="row-arrow">→</span></a>
        @empty
            <div class="empty-state"><div class="empty-illustration">▤</div><h3>Your repository starts here.</h3><p>Add an agreement to keep its source file, key details, and review work together.</p><a class="button button-outline" href="{{ route('contracts.create') }}">Add your first contract <span>→</span></a></div>
        @endforelse
    </section>
    <aside class="panel due-panel" id="obligations"><div class="panel-heading"><div><span class="eyebrow">LOOKING AHEAD</span><h2>Renewal dates</h2></div><span class="panel-count">90 DAYS</span></div>
        @forelse ($upcoming as $contract)
            <a class="date-row" href="{{ route('contracts.show', $contract) }}"><span class="date-badge"><small>{{ $contract->expiry_date->format('M') }}</small><b>{{ $contract->expiry_date->format('d') }}</b></span><span><strong>{{ $contract->title }}</strong><small>{{ $contract->counterparty ?: 'Counterparty not recorded' }}</small></span><span class="date-arrow">→</span></a>
        @empty
            <div class="empty-compact"><span>◷</span><p>No renewal dates in the next 90 days. Add an expiry date when you create a contract to see it here.</p></div>
        @endforelse
        <div class="dashboard-note"><span>i</span><p>Deyvoras helps organize contract information. Always confirm important dates against the signed agreement.</p></div>
    </aside>
</div>
<section class="workspace-principle" id="activity"><span class="principle-mark">D</span><div><span class="eyebrow">REVIEW WITH CONFIDENCE</span><p>Keep the original agreement close to every summary, clause, and follow-up. Information in Deyvoras should be checked by your team before you rely on it.</p></div><a href="{{ route('home') }}#workflow">Our workflow <span>→</span></a></section>
@endsection
