{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Academic Qualifications')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Academic Qualifications</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item active">Academic Qualifications</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-journal-bookmark-fill me-2"></i> Academic Qualifications — {{ $application->application_no }}
            <span class="badge bg-info ms-2">{{ $academicQualifications->count() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.academic-qualifications.create', $application) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Institution</th>
                    <th>Qualification</th>
                    <th>From</th>
                    <th>To</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($academicQualifications as $qualification)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $qualification->institution_name }}</td>
                        <td>{{ $qualification->qualification }}</td>
                        <td>{{ $qualification->from_year }}</td>
                        <td>{{ $qualification->to_year }}</td>
                        <td class="text-end">
                            <a href="{{ route('applications.academic-qualifications.show', [$application, $qualification]) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('applications.academic-qualifications.edit', [$application, $qualification]) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="delData({{ $qualification->id }}, '{{ route('applications.academic-qualifications.destroy', [$application, $qualification]) }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No information provided</td>
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
