{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', isset($programme) ? 'Edit Programme' : 'Add Programme')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ isset($programme) ? 'Edit Programme' : 'Add Programme' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('programmes.index') }}">Programmes</a></li>
                <li class="breadcrumb-item active">{{ isset($programme) ? 'Edit' : 'Add' }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-mortarboard-fill me-2"></i>
            {{ isset($programme) ? 'Edit Programme' : 'Add Programme' }}
        </h3>
    </div>

    <form action="{{ isset($programme) ? route('programmes.update', $programme) : route('programmes.store') }}" method="POST">
        @csrf
        @if (isset($programme))
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="mb-3">
                <label for="faculty_id" class="form-label">Faculty</label>
                <select name="faculty_id" id="faculty_id"
                    class="form-select @error('faculty_id') is-invalid @enderror">
                    <option value="">-- Select Faculty --</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}"
                            @selected(old('faculty_id', $programme->faculty_id ?? '') == $faculty->id)>
                            {{ $faculty->name }}
                        </option>
                    @endforeach
                </select>
                @error('faculty_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Programme Name</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $programme->name ?? '') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Programme Code</label>
                <input type="text" name="code" id="code"
                    class="form-control @error('code') is-invalid @enderror"
                    value="{{ old('code', $programme->code ?? '') }}">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select name="level" id="level"
                    class="form-select @error('level') is-invalid @enderror">
                    <option value="">-- Select Level --</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->value }}"
                            @selected(old('level', $programme->level->value ?? '') == $level->value)>
                            {{ $level->value }}
                        </option>
                    @endforeach
                </select>
                @error('level')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('programmes.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($programme) ? 'Update Programme' : 'Create Programme' }}
            </button>
        </div>
    </form>
</div>
@endsection
