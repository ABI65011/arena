{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Programmes')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Programmes</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('programmes.index') }}">Programmes</a></li>
                <li class="breadcrumb-item active">All Programmes</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-mortarboard-fill me-2"></i> Programmes
            <span class="badge bg-info ms-2">{{ $programmes->total() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('programmes.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add Programme
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
                    <th>Level</th>
                    <th>Faculty</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($programmes as $programme)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $programme->name }}</td>
                        <td>{{ $programme->code }}</td>
                        <td>{{ $programme->level->value }}</td>
                        <td>{{ $programme->faculty->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('programmes.show', $programme) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('programmes.edit', $programme) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="delData({{ $programme->id }}, '{{ route('programmes.destroy', $programme) }}')">
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
        {{ $programmes->links() }}
    </div>
</div>
@endsection
