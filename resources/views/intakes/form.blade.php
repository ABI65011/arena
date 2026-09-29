{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', isset($intake) ? 'Edit Intake' : 'Add Intake')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ isset($intake) ? 'Edit Intake' : 'Add Intake' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('intakes.index') }}">Intakes</a></li>
                <li class="breadcrumb-item active">{{ isset($intake) ? 'Edit' : 'Add' }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-calendar-event-fill me-2"></i>
            {{ isset($intake) ? 'Edit Intake' : 'Add Intake' }}
        </h3>
    </div>

    <form action="{{ isset($intake) ? route('intakes.update', $intake) : route('intakes.store') }}" method="POST">
        @csrf
        @if (isset($intake))
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Intake Name</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $intake->name ?? '') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="month" class="form-label">Month</label>
                <select name="month" id="month" class="form-select @error('month') is-invalid @enderror">
                    <option value="">-- Select Month --</option>
                    @foreach (\App\Helpers\Month::cases() as $month)
                        <option value="{{ $month->value }}"
                            @selected(old('month', $intake->month->value ?? '') == $month->value)>
                            {{ $month->value }}
                        </option>
                    @endforeach
                </select>
                @error('month')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="academic_year" class="form-label">Academic Year</label>
                <input type="text" name="academic_year" id="academic_year" placeholder="e.g. 2026/2027"
                    class="form-control @error('academic_year') is-invalid @enderror"
                    value="{{ old('academic_year', $intake->academic_year ?? '') }}">
                @error('academic_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="application_open_date" class="form-label">Application Opens</label>
                    <input type="date" name="application_open_date" id="application_open_date"
                        class="form-control @error('application_open_date') is-invalid @enderror"
                        value="{{ old('application_open_date', isset($intake) ? $intake->application_open_date->format('Y-m-d') : '') }}">
                    @error('application_open_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="application_close_date" class="form-label">Application Closes</label>
                    <input type="date" name="application_close_date" id="application_close_date"
                        class="form-control @error('application_close_date') is-invalid @enderror"
                        value="{{ old('application_close_date', isset($intake) ? $intake->application_close_date->format('Y-m-d') : '') }}">
                    @error('application_close_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-check">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input"
                    @checked(old('is_active', $intake->is_active ?? true))>
                <label for="is_active" class="form-check-label">Active</label>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('intakes.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($intake) ? 'Update Intake' : 'Create Intake' }}
            </button>
        </div>
    </form>
</div>
@endsection
