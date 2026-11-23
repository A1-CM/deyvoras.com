@extends('layouts.workspace')
@section('title', 'Activity')
@section('breadcrumb', 'Activity')
@section('content')
<section class="page-heading"><div><div class="eyebrow">WORKSPACE TRACEABILITY</div><h1>Activity</h1><p>A record of contract uploads, review decisions, and changes in your organization.</p></div></section>
<section class="panel activity-page"><div class="panel-heading"><div><span class="eyebrow">MOST RECENT FIRST</span><h2>Workspace activity</h2></div><span class="panel-count">{{ $activities->count() }} EVENTS</span></div>
    @forelse ($activities as $activity)<a class="activity-feed-row" href="{{ $activity->contract ? route('contracts.show', $activity->contract) : route('activity.index') }}"><span class="activity-feed-marker">{{ $activity->event === 'source_document_uploaded' ? '▤' : ($activity->event === 'contract_review_status_changed' || $activity->event === 'member_joined' ? '✓' : '·') }}</span><span class="activity-feed-main"><strong>{{ $activity->description }}</strong><small><b>{{ $activity->contract?->title ?? 'Workspace team' }}</b> · {{ $activity->user?->name ?? 'Former member' }}</small></span><time datetime="{{ $activity->created_at->toIso8601String() }}">{{ $activity->created_at->format('d M Y · H:i') }}</time><span class="row-arrow">→</span></a>@empty<div class="empty-state"><div class="empty-illustration">→</div><h3>Activity will appear here.</h3><p>When your team adds agreements, updates details, or checks clause records, those actions will be listed here.</p><a class="button button-outline" href="{{ route('contracts.index') }}">View contracts <span>→</span></a></div>@endforelse
</section>
<p class="page-footnote">Activity entries show who performed an action and when. They do not store the contents of contract files.</p>
@endsection
