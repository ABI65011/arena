{{-- meow meow meow --}}

@extends('layout.student_layout')

@section('title', 'My Applications')

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
            <i class="bi bi-file-earmark-text-fill me-2"></i> My Applications
            <span class="badge bg-info ms-2">{{ $applications->count() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('apply') }}" class="btn btn-primary btn-sm">
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
                @forelse ($applications as $application)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $application->application_no }}</td>
                        <td>{{ $application->intake->name }}</td>
                        <td>{{ $application->application_type->value }}</td>
                        <td>
                            <span class="badge bg-{{ $statusColors[$application->status->value] ?? 'secondary' }}">
                                {{ $application->status->value }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('my-applications.show', $application) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No information provided</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
