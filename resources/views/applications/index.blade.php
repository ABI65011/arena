{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Applications')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Applications</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item active">All Applications</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-file-earmark-text-fill me-2"></i> Applications
            <span class="badge bg-info ms-2">{{ $applications->total() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Applicant</th>
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
                        <td>{{ $application->applicant->surname }} {{ $application->applicant->other_name }}</td>
                        <td>{{ $application->intake->name }}</td>
                        <td>{{ $application->application_type->value }}</td>
                        <td>
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
                            <span class="badge bg-{{ $statusColors[$application->status->value] ?? 'secondary' }}">
                                {{ $application->status->value }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('applications.show', $application) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('applications.edit', $application) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="delData({{ $application->id }}, '{{ route('applications.destroy', $application) }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No information provided</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $applications->links() }}
    </div>
</div>
@endsection
