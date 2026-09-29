{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Intakes')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Intakes</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('intakes.index') }}">Intakes</a></li>
                <li class="breadcrumb-item active">All Intakes</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-calendar-event-fill me-2"></i> Intakes
            <span class="badge bg-info ms-2">{{ $intakes->total() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('intakes.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add Intake
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Month</th>
                    <th>Academic Year</th>
                    <th>Opens</th>
                    <th>Closes</th>
                    <th>Active</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($intakes as $intake)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $intake->name }}</td>
                        <td>{{ $intake->month->value }}</td>
                        <td>{{ $intake->academic_year }}</td>
                        <td>{{ $intake->application_open_date->format('d M Y') }}</td>
                        <td>{{ $intake->application_close_date->format('d M Y') }}</td>
                        <td>
                            @if ($intake->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('intakes.show', $intake) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('intakes.edit', $intake) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="delData({{ $intake->id }}, '{{ route('intakes.destroy', $intake) }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No information provided</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $intakes->links() }}
    </div>
</div>
@endsection
