{{-- meow meow meow --}}

@extends('layout.student_layout')

@section('title', 'My Profile')

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
            <i class="bi bi-person-vcard-fill me-2"></i>
            {{ $applicant->title ? $applicant->title . ' ' : '' }}{{ $applicant->surname }} {{ $applicant->other_name }}
        </h3>
        <div class="ms-auto">
            <a href="{{ route('my-profile.edit') }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $applicant->user->email }}</dd>

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

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-file-earmark-text-fill me-2"></i> My Applications
            <span class="badge bg-info ms-2">{{ $applicant->applications->count() }}</span>
        </h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Application No.</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applicant->applications as $application)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $application->application_no }}</td>
                        <td>
                            <span class="badge bg-{{ $statusColors[$application->status->value] ?? 'secondary' }}">
                                {{ $application->status->value }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('my-applications.show', $application) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No information provided</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
