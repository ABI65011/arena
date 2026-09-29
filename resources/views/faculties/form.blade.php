{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', isset($faculty) ? 'Edit Faculty' : 'Add Faculty')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ isset($faculty) ? 'Edit Faculty' : 'Add Faculty' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('faculties.index') }}">Faculties</a></li>
                <li class="breadcrumb-item active">{{ isset($faculty) ? 'Edit' : 'Add' }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-diagram-3-fill me-2"></i>
            {{ isset($faculty) ? 'Edit Faculty' : 'Add Faculty' }}
        </h3>
    </div>

    <form action="{{ isset($faculty) ? route('faculties.update', $faculty) : route('faculties.store') }}" method="POST">
        @csrf
        @if (isset($faculty))
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Faculty Name</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $faculty->name ?? '') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Faculty Code</label>
                <input type="text" name="code" id="code"
                    class="form-control @error('code') is-invalid @enderror"
                    value="{{ old('code', $faculty->code ?? '') }}">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('faculties.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($faculty) ? 'Update Faculty' : 'Create Faculty' }}
            </button>
        </div>
    </form>
</div>
@endsection
