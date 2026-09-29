{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Status History')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Status History</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('applications.show', $application) }}">{{ $application->application_no }}</a></li>
                <li class="breadcrumb-item active">Status History</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-clock-history me-2"></i> Status History — {{ $application->application_no }}
            <span class="badge bg-info ms-2">{{ $statusHistories->count() }}</span>
        </h3>
        <div class="ms-auto">
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#moveStatusModal">
                <i class="bi bi-arrow-repeat"></i> Move Status
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Changed By</th>
                    <th>Remarks</th>
                    <th>When</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($statusHistories as $history)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $history->from_status ?? '—' }}</td>
                        <td>{{ $history->to_status }}</td>
                        <td>{{ $history->changedBy->name ?? 'System' }}</td>
                        <td>{{ $history->remarks ?: 'No information provided' }}</td>
                        <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('applications.status-histories.show', [$application, $history]) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No information provided</td>
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

{{-- Same Move Status modal as the application's show page --}}
<div class="modal fade" id="moveStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('applications.move-status', $application) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Move Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">New Status</label>
                        <select name="status" id="status" class="form-select @error('status', 'moveStatus') is-invalid @enderror">
                            @foreach (\App\Helpers\ApplicationStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected($application->status->value == $status->value)>
                                    {{ $status->value }}
                                </option>
                            @endforeach
                        </select>
                        @error('status', 'moveStatus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks <small class="text-muted">(optional)</small></label>
                        <textarea name="remarks" id="remarks" class="form-control @error('remarks', 'moveStatus') is-invalid @enderror" rows="3"></textarea>
                        @error('remarks', 'moveStatus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
