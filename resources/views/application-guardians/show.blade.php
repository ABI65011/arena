{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Guardian Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Guardian Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item active">{{ $guardian->type->value }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="bi bi-people-fill me-2"></i> {{ $guardian->type->value }}</h3>
        <div class="ms-auto">
            <a href="{{ route('applications.guardians.edit', [$application, $guardian]) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('applications.show', $application) }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $guardian->name ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">P.O. Box</dt>
            <dd class="col-sm-9">{{ $guardian->po_box ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Town</dt>
            <dd class="col-sm-9">{{ $guardian->town ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Telephone</dt>
            <dd class="col-sm-9">{{ $guardian->telephone ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $guardian->email ?: 'No information provided' }}</dd>
        </dl>
    </div>
</div>
@endsection
