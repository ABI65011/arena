{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Faculties')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Faculties</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('faculties.index') }}">Faculties</a></li>
                <li class="breadcrumb-item active">All Faculties</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-diagram-3-fill me-2"></i> Faculties
            <span class="badge bg-info ms-2">{{ $faculties->total() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('faculties.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add Faculty
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Programmes</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($faculties as $faculty)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $faculty->name }}</td>
                        <td>{{ $faculty->code }}</td>
                        <td>{{ $faculty->programmes_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('faculties.show', $faculty) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('faculties.edit', $faculty) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="delData({{ $faculty->id }}, '{{ route('faculties.destroy', $faculty) }}')">
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
        {{ $faculties->links() }}
    </div>
</div>
@endsection
