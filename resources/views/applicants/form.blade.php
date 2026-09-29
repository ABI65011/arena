{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Edit Applicant')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Applicant</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applicants.index') }}">Applicants</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="bi bi-person-vcard-fill me-2"></i> Edit Applicant</h3>
    </div>

    <form action="{{ route('applicants.update', $applicant) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">User Account</label>
                <input type="text" class="form-control" disabled
                    value="{{ $applicant->user->name }} ({{ $applicant->user->email }})">
                <small class="text-muted">The linked user account cannot be changed here.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="surname" class="form-label">Surname</label>
                    <input type="text" name="surname" id="surname"
                        class="form-control @error('surname') is-invalid @enderror"
                        value="{{ old('surname', $applicant->surname) }}">
                    @error('surname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="other_name" class="form-label">Other Name</label>
                    <input type="text" name="other_name" id="other_name"
                        class="form-control @error('other_name') is-invalid @enderror"
                        value="{{ old('other_name', $applicant->other_name) }}">
                    @error('other_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="title" class="form-label">Title <small class="text-muted">(optional)</small></label>
                    <input type="text" name="title" id="title" placeholder="e.g. Mr, Mrs, Rev, Dr"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $applicant->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth"
                        class="form-control @error('date_of_birth') is-invalid @enderror"
                        value="{{ old('date_of_birth', $applicant->date_of_birth->format('Y-m-d')) }}">
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="">-- Select --</option>
                        @foreach (\App\Helpers\Gender::cases() as $gender)
                            <option value="{{ $gender->value }}"
                                @selected(old('gender', $applicant->gender->value) == $gender->value)>
                                {{ $gender->value }}
                            </option>
                        @endforeach
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $applicant->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nationality" class="form-label">Nationality</label>
                    <input type="text" name="nationality" id="nationality"
                        class="form-control @error('nationality') is-invalid @enderror"
                        value="{{ old('nationality', $applicant->nationality) }}">
                    @error('nationality')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('applicants.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Applicant</button>
        </div>
    </form>
</div>
@endsection
