{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Faculty Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Faculty Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('faculties.index') }}">Faculties</a></li>
                <li class="breadcrumb-item active">{{ $faculty->name }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-diagram-3-fill me-2"></i> {{ $faculty->name }}
        </h3>
        <div class="ms-auto">
            <a href="{{ route('faculties.edit', $faculty) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('faculties.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $faculty->name ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Code</dt>
            <dd class="col-sm-9">{{ $faculty->code ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Created</dt>
            <dd class="col-sm-9">{{ $faculty->created_at->format('d M Y, h:i A') }}</dd>
        </dl>
    </div>
</div>

@if ($faculty->programmes->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-mortarboard-fill me-2"></i> Programmes
                <span class="badge bg-info ms-2">{{ $faculty->programmes->count() }}</span>
            </h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($faculty->programmes as $programme)
                        <tr>
                            <td><a href="{{ route('programmes.show', $programme) }}">{{ $programme->name }}</a></td>
                            <td>{{ $programme->code }}</td>
                            <td>{{ $programme->level->value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
