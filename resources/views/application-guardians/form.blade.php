{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', isset($guardian) ? 'Edit Guardian' : 'Add Guardian')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ isset($guardian) ? 'Edit Guardian' : 'Add Guardian' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item active">{{ isset($guardian) ? 'Edit' : 'Add' }} Guardian</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-people-fill me-2"></i> {{ isset($guardian) ? 'Edit Guardian' : 'Add Guardian' }}
        </h3>
    </div>

    <form action="{{ isset($guardian) ? route('applications.guardians.update', [$application, $guardian]) : route('applications.guardians.store', $application) }}" method="POST">
        @csrf
        @if (isset($guardian))
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                    <option value="">-- Select --</option>
                    @foreach (\App\Helpers\ApplicationGuardianType::cases() as $type)
                        <option value="{{ $type->value }}"
                            @selected(old('type', $guardian->type->value ?? '') == $type->value)>
                            {{ $type->value }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Only one guardian of each type per application.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <small class="text-muted">(optional)</small></label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $guardian->name ?? '') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="po_box" class="form-label">P.O. Box <small class="text-muted">(optional)</small></label>
                    <input type="text" name="po_box" id="po_box"
                        class="form-control @error('po_box') is-invalid @enderror"
                        value="{{ old('po_box', $guardian->po_box ?? '') }}">
                    @error('po_box')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="town" class="form-label">Town <small class="text-muted">(optional)</small></label>
                    <input type="text" name="town" id="town"
                        class="form-control @error('town') is-invalid @enderror"
                        value="{{ old('town', $guardian->town ?? '') }}">
                    @error('town')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Telephone <small class="text-muted">(optional)</small></label>
                    <input type="text" name="telephone" id="telephone"
                        class="form-control @error('telephone') is-invalid @enderror"
                        value="{{ old('telephone', $guardian->telephone ?? '') }}">
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <small class="text-muted">(optional)</small></label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $guardian->email ?? '') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('applications.show', $application) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($guardian) ? 'Update Guardian' : 'Add Guardian' }}
            </button>
        </div>
    </form>
</div>
@endsection
