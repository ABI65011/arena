{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Applicants')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Applicants</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applicants.index') }}">Applicants</a></li>
                <li class="breadcrumb-item active">All Applicants</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-person-vcard-fill me-2"></i> Applicants
            <span class="badge bg-info ms-2">{{ $applicants->total() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> New Application
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Applications</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applicants as $applicant)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $applicant->surname }} {{ $applicant->other_name }}</td>
                        <td>{{ $applicant->user->email }}</td>
                        <td>{{ $applicant->phone }}</td>
                        <td><span class="badge bg-secondary">{{ $applicant->applications->count() }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('applicants.show', $applicant) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('applicants.edit', $applicant) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="delData({{ $applicant->id }}, '{{ route('applicants.destroy', $applicant) }}')">
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
        {{ $applicants->links() }}
    </div>
</div>
@endsection
