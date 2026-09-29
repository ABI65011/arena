{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'User Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>User Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="bi bi-person-circle me-2"></i> {{ $user->name }}
                    </h3>
                    <div>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $user->name ?: 'No information provided' }}</dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">{{ $user->email ?: 'No information provided' }}</dd>

                        <dt class="col-sm-3">Created</dt>
                        <dd class="col-sm-9">{{ $user->created_at->format('d M Y, h:i A') }}</dd>

                        <dt class="col-sm-3">Last Updated</dt>
                        <dd class="col-sm-9">{{ $user->updated_at->format('d M Y, h:i A') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
