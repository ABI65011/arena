{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Programme Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Programme Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('programmes.index') }}">Programmes</a></li>
                <li class="breadcrumb-item active">{{ $programme->name }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-mortarboard-fill me-2"></i> {{ $programme->name }}
        </h3>
        <div class="ms-auto">
            <a href="{{ route('programmes.edit', $programme) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('programmes.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $programme->name ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Code</dt>
            <dd class="col-sm-9">{{ $programme->code ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Level</dt>
            <dd class="col-sm-9">{{ $programme->level->value }}</dd>

            <dt class="col-sm-3">Faculty</dt>
            <dd class="col-sm-9">
                <a href="{{ route('faculties.show', $programme->faculty) }}">{{ $programme->faculty->name }}</a>
            </dd>

            <dt class="col-sm-3">Created</dt>
            <dd class="col-sm-9">{{ $programme->created_at->format('d M Y, h:i A') }}</dd>
        </dl>
    </div>
</div>
@endsection
