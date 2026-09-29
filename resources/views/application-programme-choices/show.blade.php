{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Programme Choice Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Programme Choice Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item active">{{ $programmeChoice->priority->value }} Choice</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-mortarboard-fill me-2"></i> {{ $programmeChoice->priority->value }} Choice
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.programme-choices.edit', [$application, $programmeChoice]) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('applications.show', $application) }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Programme</dt>
            <dd class="col-sm-9">{{ $programmeChoice->programme->name }} ({{ $programmeChoice->programme->level->value }})</dd>

            <dt class="col-sm-3">Priority</dt>
            <dd class="col-sm-9">{{ $programmeChoice->priority->value }}</dd>

            <dt class="col-sm-3">Study Mode</dt>
            <dd class="col-sm-9">{{ $programmeChoice->study_mode->value }}</dd>
        </dl>
    </div>
</div>

@if ($programmeChoice->eligibilityResults->isNotEmpty() || $programmeChoice->admissionDecisions->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-clipboard-check-fill me-2"></i> Outcome</h3>
        </div>
        <div class="card-body">
            <p class="text-muted mb-0">Eligibility and decision details for this choice appear here in later weeks.</p>
        </div>
    </div>
@endif
@endsection
