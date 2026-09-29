{{-- meow meow meow --}}

@extends('layout.student_layout')

@section('title', 'Edit My Profile')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="bi bi-person-vcard-fill me-2"></i> Edit My Profile</h3>
    </div>

    <form action="{{ route('my-profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">
            <h5 class="mb-3">Identity</h5>
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
                        @foreach (\App\Helpers\Gender::cases() as $g)
                            <option value="{{ $g->value }}" @selected(old('gender', $applicant->gender->value) == $g->value)>{{ $g->value }}</option>
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

            <hr>

            <h5 class="mb-3">Account Credentials</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $applicant->user->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('my-profile.show') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
</div>
@endsection
