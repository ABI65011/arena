{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Status Change Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Status Change Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.status-histories.index', $application) }}">Status History</a></li>
                <li class="breadcrumb-item active">{{ $statusHistory->created_at->format('d M Y, H:i') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="bi bi-clock-history me-2"></i> Status Change</h3>
        <div class="ms-auto">
            <a href="{{ route('applications.status-histories.index', $application) }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">From</dt>
            <dd class="col-sm-9">{{ $statusHistory->from_status ?? '—' }}</dd>

            <dt class="col-sm-3">To</dt>
            <dd class="col-sm-9">{{ $statusHistory->to_status }}</dd>

            <dt class="col-sm-3">Changed By</dt>
            <dd class="col-sm-9">{{ $statusHistory->changedBy->name ?? 'System' }}</dd>

            <dt class="col-sm-3">Remarks</dt>
            <dd class="col-sm-9">{{ $statusHistory->remarks ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">When</dt>
            <dd class="col-sm-9">{{ $statusHistory->created_at->format('d M Y, H:i') }}</dd>
        </dl>
    </div>
</div>
@endsection
