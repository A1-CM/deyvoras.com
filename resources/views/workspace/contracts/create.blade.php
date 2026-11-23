@extends('layouts.workspace')
@section('title', 'Add contract')
@section('breadcrumb')<a href="{{ route('contracts.index') }}">Contracts</a><span>/</span><span>New contract</span>@endsection
@section('content')
<section class="page-heading"><div><div class="eyebrow">ADD TO YOUR REPOSITORY</div><h1>New contract</h1><p>Start with the details your team needs to find and follow this agreement.</p></div><a class="text-link" href="{{ route('contracts.index') }}">← Back to contracts</a></section>
<form method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data" class="contract-form panel">@csrf @include('workspace.contracts.form-fields', ['contract' => null, 'submitLabel' => 'Add contract'])</form>
@endsection
