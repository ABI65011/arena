{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', isset($user) ? 'Edit User' : 'Add User')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ isset($user) ? 'Edit User' : 'Add User' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ isset($user) ? 'Edit' : 'Add' }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-person-lines-fill me-2"></i>
            {{ isset($user) ? 'Edit User' : 'Add User' }}
        </h3>
    </div>

    <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
        @csrf
        @if (isset($user))
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name ?? '') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email ?? '') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    Password
                    @if (isset($user))
                        <small class="text-muted">(leave blank to keep current password)</small>
                    @endif
                </label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control">
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($user) ? 'Update User' : 'Create User' }}
            </button>
        </div>
    </form>
</div>
@endsection
