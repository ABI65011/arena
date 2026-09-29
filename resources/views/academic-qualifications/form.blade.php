{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', isset($academicQualification) ? 'Edit Academic Qualification' : 'Add Academic Qualification')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ isset($academicQualification) ? 'Edit Academic Qualification' : 'Add Academic Qualification' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item active">{{ isset($academicQualification) ? 'Edit' : 'Add' }} Qualification</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-journal-bookmark-fill me-2"></i>
            {{ isset($academicQualification) ? 'Edit Academic Qualification' : 'Add Academic Qualification' }}
        </h3>
    </div>

    <form action="{{ isset($academicQualification) ? route('applications.academic-qualifications.update', [$application, $academicQualification]) : route('applications.academic-qualifications.store', $application) }}" method="POST">
        @csrf
        @if (isset($academicQualification))
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="institution_name" class="form-label">Institution Name</label>
                    <input type="text" name="institution_name" id="institution_name"
                        class="form-control @error('institution_name') is-invalid @enderror"
                        value="{{ old('institution_name', $academicQualification->institution_name ?? '') }}">
                    @error('institution_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="institution_address" class="form-label">Institution Address <small class="text-muted">(optional)</small></label>
                    <input type="text" name="institution_address" id="institution_address"
                        class="form-control @error('institution_address') is-invalid @enderror"
                        value="{{ old('institution_address', $academicQualification->institution_address ?? '') }}">
                    @error('institution_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="from_year" class="form-label">From Year</label>
                    <input type="text" name="from_year" id="from_year"
                        class="form-control @error('from_year') is-invalid @enderror"
                        value="{{ old('from_year', $academicQualification->from_year ?? '') }}">
                    @error('from_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="to_year" class="form-label">To Year</label>
                    <input type="text" name="to_year" id="to_year"
                        class="form-control @error('to_year') is-invalid @enderror"
                        value="{{ old('to_year', $academicQualification->to_year ?? '') }}">
                    @error('to_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="qualification" class="form-label">Qualification</label>
                    <input type="text" name="qualification" id="qualification"
                        class="form-control @error('qualification') is-invalid @enderror"
                        value="{{ old('qualification', $academicQualification->qualification ?? '') }}">
                    @error('qualification')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('applications.show', $application) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($academicQualification) ? 'Update Qualification' : 'Add Qualification' }}
            </button>
        </div>
    </form>
</div>
@endsection
