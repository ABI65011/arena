{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Application Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Application Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item active">{{ $application->application_no }}</li>
            </ol>
        </div>
    </div>
@endsection

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
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#moveStatusModal">
                <i class="bi bi-arrow-repeat"></i> Move Status
            </button>
            <a href="{{ route('applications.edit', $application) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('applications.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Applicant</dt>
            <dd class="col-sm-9">
                <a href="{{ route('applicants.show', $application->applicant) }}">
                    {{ $application->applicant->surname }} {{ $application->applicant->other_name }}
                </a>
                ({{ $application->applicant->user->email }})
            </dd>

            <dt class="col-sm-3">Intake</dt>
            <dd class="col-sm-9">{{ $application->intake->name }} ({{ $application->intake->academic_year }})</dd>

            <dt class="col-sm-3">Application Type</dt>
            <dd class="col-sm-9">{{ $application->application_type->value }}</dd>

            <dt class="col-sm-3">Submitted At</dt>
            <dd class="col-sm-9">{{ $application->submitted_at?->format('d M Y, H:i') ?? 'No information provided' }}</dd>
        </dl>
    </div>
</div>

@include('admin.applications._application-details', ['application' => $application, 'showActions' => true])

{{-- Move Status modal --}}
<div class="modal fade" id="moveStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('applications.move-status', $application) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Move Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">New Status</label>
                        <select name="status" id="status" class="form-select @error('status', 'moveStatus') is-invalid @enderror">
                            @foreach (\App\Helpers\ApplicationStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected($application->status->value == $status->value)>
                                    {{ $status->value }}
                                </option>
                            @endforeach
                        </select>
                        @error('status', 'moveStatus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks <small class="text-muted">(optional)</small></label>
                        <textarea name="remarks" id="remarks" class="form-control @error('remarks', 'moveStatus') is-invalid @enderror" rows="3"></textarea>
                        @error('remarks', 'moveStatus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
