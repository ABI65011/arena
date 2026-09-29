{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Applicant Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Applicant Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applicants.index') }}">Applicants</a></li>
                <li class="breadcrumb-item active">{{ $applicant->surname }} {{ $applicant->other_name }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-person-vcard-fill me-2"></i>
            {{ $applicant->title ? $applicant->title . ' ' : '' }}{{ $applicant->surname }} {{ $applicant->other_name }}
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applicants.edit', $applicant) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('applicants.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">User Account</dt>
            <dd class="col-sm-9">{{ $applicant->user->name }} ({{ $applicant->user->email }})</dd>

            <dt class="col-sm-3">Surname</dt>
            <dd class="col-sm-9">{{ $applicant->surname }}</dd>

            <dt class="col-sm-3">Other Name</dt>
            <dd class="col-sm-9">{{ $applicant->other_name }}</dd>

            <dt class="col-sm-3">Title</dt>
            <dd class="col-sm-9">{{ $applicant->title ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Date of Birth</dt>
            <dd class="col-sm-9">{{ $applicant->date_of_birth->format('d M Y') }}</dd>

            <dt class="col-sm-3">Gender</dt>
            <dd class="col-sm-9">{{ $applicant->gender->value }}</dd>

            <dt class="col-sm-3">Phone</dt>
            <dd class="col-sm-9">{{ $applicant->phone }}</dd>

            <dt class="col-sm-3">Nationality</dt>
            <dd class="col-sm-9">{{ $applicant->nationality }}</dd>
        </dl>
    </div>
</div>

{{-- Applications: an applicant always has at least one (that's how the record was created) --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-file-earmark-text-fill me-2"></i> Applications
            <span class="badge bg-info ms-2">{{ $applicant->applications->count() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.create') }}?user_id={{ $applicant->user_id }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> New Application
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Application No.</th>
                    <th>Intake</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicant->applications as $application)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $application->application_no }}</td>
                        <td>{{ $application->intake->name }}</td>
                        <td>{{ $application->application_type->value }}</td>
                        <td><span class="badge bg-secondary">{{ $application->status->value }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('applications.show', $application) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
