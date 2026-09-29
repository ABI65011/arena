{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Academic Qualification Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Academic Qualification Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item active">{{ $academicQualification->institution_name }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-journal-bookmark-fill me-2"></i> {{ $academicQualification->institution_name }}
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.academic-qualifications.edit', [$application, $academicQualification]) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('applications.show', $application) }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Institution Name</dt>
            <dd class="col-sm-9">{{ $academicQualification->institution_name }}</dd>

            <dt class="col-sm-3">Institution Address</dt>
            <dd class="col-sm-9">{{ $academicQualification->institution_address ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">From Year</dt>
            <dd class="col-sm-9">{{ $academicQualification->from_year }}</dd>

            <dt class="col-sm-3">To Year</dt>
            <dd class="col-sm-9">{{ $academicQualification->to_year }}</dd>

            <dt class="col-sm-3">Qualification</dt>
            <dd class="col-sm-9">{{ $academicQualification->qualification }}</dd>
        </dl>
    </div>
</div>
@endsection
