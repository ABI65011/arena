{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Programme Choices')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Programme Choices</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item active">Programme Choices</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-mortarboard-fill me-2"></i> Programme Choices — {{ $application->application_no }}
            <span class="badge bg-info ms-2">{{ $programmeChoices->count() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.programme-choices.create', $application) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Priority</th>
                    <th>Programme</th>
                    <th>Study Mode</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($programmeChoices as $choice)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $choice->priority->value }}</td>
                        <td>{{ $choice->programme->name }}</td>
                        <td>{{ $choice->study_mode->value }}</td>
                        <td class="text-end">
                            <a href="{{ route('applications.programme-choices.show', [$application, $choice]) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('applications.programme-choices.edit', [$application, $choice]) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="delData({{ $choice->id }}, '{{ route('applications.programme-choices.destroy', [$application, $choice]) }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No information provided</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <a href="{{ route('applications.show', $application) }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Application
        </a>
    </div>
</div>
@endsection
