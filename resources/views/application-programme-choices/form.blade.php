{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', isset($programmeChoice) ? 'Edit Programme Choice' : 'Add Programme Choice')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ isset($programmeChoice) ? 'Edit Programme Choice' : 'Add Programme Choice' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item active">{{ isset($programmeChoice) ? 'Edit' : 'Add' }} Programme Choice</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-mortarboard-fill me-2"></i>
            {{ isset($programmeChoice) ? 'Edit Programme Choice' : 'Add Programme Choice' }}
        </h3>
    </div>

    <form action="{{ isset($programmeChoice) ? route('applications.programme-choices.update', [$application, $programmeChoice]) : route('applications.programme-choices.store', $application) }}" method="POST">
        @csrf
        @if (isset($programmeChoice))
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="mb-3">
                <label for="programme_id" class="form-label">Programme</label>
                <select name="programme_id" id="programme_id" class="form-select @error('programme_id') is-invalid @enderror">
                    <option value="">-- Select Programme --</option>
                    @foreach ($programmes as $programme)
                        <option value="{{ $programme->id }}" data-level="{{ $programme->level->value }}"
                            @selected(old('programme_id', $programmeChoice->programme_id ?? '') == $programme->id)>
                            {{ $programme->name }} ({{ $programme->level->value }})
                        </option>
                    @endforeach
                </select>
                @error('programme_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    This application is {{ $application->application_type->value }} — matching programmes are shown first.
                </small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror">
                        <option value="">-- Select --</option>
                        @foreach (\App\Helpers\Priority::cases() as $priority)
                            <option value="{{ $priority->value }}"
                                @selected(old('priority', $programmeChoice->priority->value ?? '') == $priority->value)>
                                {{ $priority->value }}
                            </option>
                        @endforeach
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="study_mode" class="form-label">Study Mode</label>
                    <select name="study_mode" id="study_mode" class="form-select @error('study_mode') is-invalid @enderror">
                        <option value="">-- Select --</option>
                        @foreach (\App\Helpers\StudyMode::cases() as $mode)
                            <option value="{{ $mode->value }}"
                                @selected(old('study_mode', $programmeChoice->study_mode->value ?? '') == $mode->value)>
                                {{ $mode->value }}
                            </option>
                        @endforeach
                    </select>
                    @error('study_mode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('applications.show', $application) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($programmeChoice) ? 'Update Choice' : 'Add Choice' }}
            </button>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    // Sort matching-level programmes to the top of the list, since this
    // application's type is already fixed by this point in the flow.
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('programme_id');
        const wantedLevel = @json($application->application_type->value === 'Postgraduate' ? 'Postgraduate' : null);

        if (!wantedLevel) return;

        const options = [...select.options].filter(o => o.value);
        options.sort((a, b) => (b.dataset.level === wantedLevel) - (a.dataset.level === wantedLevel));
        options.forEach(o => select.appendChild(o));
    });
</script>
@endsection
