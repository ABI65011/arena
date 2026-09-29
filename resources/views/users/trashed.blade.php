{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Trashed Users')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Trashed Users</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">Trashed</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-trash-fill me-2"></i> Trashed Users
            <span class="badge bg-danger ms-2">{{ $users->total() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Deleted</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->deleted_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-success"
                                onclick="activateUser({{ $user->id }}, '{{ route('users.restore', $user->id) }}')">
                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="delData({{ $user->id }}, '{{ route('users.force-delete', $user->id) }}')">
                                <i class="bi bi-trash"></i> Delete Forever
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No information provided</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>
@endsection
