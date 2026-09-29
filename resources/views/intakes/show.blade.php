{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Intake Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Intake Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('intakes.index') }}">Intakes</a></li>
                <li class="breadcrumb-item active">{{ $intake->name }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-calendar-event-fill me-2"></i> {{ $intake->name }}
        </h3>
        <div class="ms-auto">
            <a href="{{ route('intakes.edit', $intake) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('intakes.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $intake->name ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Month</dt>
            <dd class="col-sm-9">{{ $intake->month->value }}</dd>

            <dt class="col-sm-3">Academic Year</dt>
            <dd class="col-sm-9">{{ $intake->academic_year ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Application Opens</dt>
            <dd class="col-sm-9">{{ $intake->application_open_date->format('d M Y') }}</dd>

            <dt class="col-sm-3">Application Closes</dt>
            <dd class="col-sm-9">{{ $intake->application_close_date->format('d M Y') }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                @if ($intake->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </dd>

            <dt class="col-sm-3">Created</dt>
            <dd class="col-sm-9">{{ $intake->created_at->format('d M Y, h:i A') }}</dd>
        </dl>
    </div>
</div>

@if ($intake->applications->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-file-earmark-text-fill me-2"></i> Applications
                <span class="badge bg-info ms-2">{{ $intake->applications->count() }}</span>
            </h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Application No.</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($intake->applications as $application)
                        <tr>
                            <td>{{ $application->application_no }}</td>
                            <td>{{ $application->application_type->value }}</td>
                            <td>{{ $application->status->value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
