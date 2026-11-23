@extends('layouts.workspace')
@section('title', 'Edit contract')
@section('breadcrumb')<a href="{{ route('contracts.index') }}">Contracts</a><span>/</span><span>Edit</span>@endsection
@section('content')
<section class="page-heading"><div><div class="eyebrow">UPDATE YOUR REPOSITORY</div><h1>Edit contract</h1><p>Keep the record aligned with the current agreement and review work.</p></div><a class="text-link" href="{{ route('contracts.show', $contract) }}">← Back to agreement</a></section>
<form method="POST" action="{{ route('contracts.update', $contract) }}" enctype="multipart/form-data" class="contract-form panel">@csrf @method('PUT') @include('workspace.contracts.form-fields', ['submitLabel' => 'Save changes'])</form>
@endsection
