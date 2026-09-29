{{-- meow meow meow --}}

@extends('layout.student_layout')

@section('title', 'My Application')

@section('content')
@php
    $statusColors = [
        'Draft' => 'secondary',
        'Submitted' => 'info',
        'Under Review' => 'warning',
        'Accepted' => 'success',
        'Rejected' => 'danger',
        'Waitlisted' => 'dark',
    ];
@endphp

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-file-earmark-text-fill me-2"></i> {{ $application->application_no }}
            <span class="badge bg-{{ $statusColors[$application->status->value] ?? 'secondary' }} ms-2">
                {{ $application->status->value }}
            </span>
        </h3>
        <div class="ms-auto">
            @if ($application->status->value === 'Draft')
                <form action="{{ route('my-applications.submit', $application) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary btn-sm"
                        onclick="return confirm('Submit this application? You will not be able to make changes afterward.')">
                        <i class="bi bi-send-fill"></i> Submit Application
                    </button>
                </form>
            @endif
            <a href="{{ route('my-applications.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        @if ($application->status->value === 'Draft')
            <div class="alert alert-warning mb-0">
                This application is still a draft and hasn't been submitted yet. Review everything below, then use
                "Submit Application" when you're ready — you won't be able to change it after that.
            </div>
        @endif
    </div>

    <div class="card-body pt-0">
        <dl class="row mb-0">
            <dt class="col-sm-3">Intake</dt>
            <dd class="col-sm-9">{{ $application->intake->name }} ({{ $application->intake->academic_year }})</dd>

            <dt class="col-sm-3">Application Type</dt>
            <dd class="col-sm-9">{{ $application->application_type->value }}</dd>

            <dt class="col-sm-3">Submitted At</dt>
            <dd class="col-sm-9">{{ $application->submitted_at?->format('d M Y, H:i') ?? 'Not yet submitted' }}</dd>
        </dl>
    </div>
</div>

@include('admin.applications._application-details', ['application' => $application, 'showActions' => false])
@endsection
