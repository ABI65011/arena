{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Application Details')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Application Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
                <li class="breadcrumb-item active">{{ $application->application_no }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
@php
    $statusColors = [
        'Draft' => 'secondary',
        'Submitted' => 'info',
        'Under Review' => 'warning',
        'Accepted' => 'success',
        'Rejected' => 'danger',
        'Waitlisted' => 'dark',
    ];
@endphp

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-file-earmark-text-fill me-2"></i> {{ $application->application_no }}
            <span class="badge bg-{{ $statusColors[$application->status->value] ?? 'secondary' }} ms-2">
                {{ $application->status->value }}
            </span>
        </h3>
        <div class="ms-auto">
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#moveStatusModal">
                <i class="bi bi-arrow-repeat"></i> Move Status
            </button>
            <a href="{{ route('applications.edit', $application) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('applications.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Applicant</dt>
            <dd class="col-sm-9">
                <a href="{{ route('applicants.show', $application->applicant) }}">
                    {{ $application->applicant->surname }} {{ $application->applicant->other_name }}
                </a>
                ({{ $application->applicant->user->email }})
            </dd>

            <dt class="col-sm-3">Intake</dt>
            <dd class="col-sm-9">{{ $application->intake->name }} ({{ $application->intake->academic_year }})</dd>

            <dt class="col-sm-3">Application Type</dt>
            <dd class="col-sm-9">{{ $application->application_type->value }}</dd>

            <dt class="col-sm-3">Submitted At</dt>
            <dd class="col-sm-9">{{ $application->submitted_at?->format('d M Y, H:i') ?? 'No information provided' }}</dd>
        </dl>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="bi bi-globe me-2"></i> Background</h3>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Country of Residence</dt>
            <dd class="col-sm-9">{{ $application->country_of_residence }}</dd>

            @if ($application->region)
                <dt class="col-sm-3">Region</dt>
                <dd class="col-sm-9">{{ $application->region }}</dd>

                <dt class="col-sm-3">District</dt>
                <dd class="col-sm-9">{{ $application->district ?: 'No information provided' }}</dd>
            @endif

            <dt class="col-sm-3">Home Diocese</dt>
            <dd class="col-sm-9">{{ $application->home_diocese ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Religious Affiliation</dt>
            <dd class="col-sm-9">{{ $application->religious_affiliation ?: 'No information provided' }}</dd>

            <dt class="col-sm-3">Marital Status</dt>
            <dd class="col-sm-9">{{ $application->marital_status?->value ?? 'No information provided' }}</dd>

            @if ($application->marriage_type)
                <dt class="col-sm-3">Type of Marriage</dt>
                <dd class="col-sm-9">{{ $application->marriage_type }}</dd>
            @endif

            @if ($application->spouse_name)
                <dt class="col-sm-3">Spouse Name</dt>
                <dd class="col-sm-9">{{ $application->spouse_name }}</dd>
            @endif
        </dl>
    </div>
</div>

@if ($application->has_disability || $application->referral_source)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-info-circle-fill me-2"></i> Additional Information</h3>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                @if ($application->has_disability)
                    <dt class="col-sm-3">Disability</dt>
                    <dd class="col-sm-9">{{ $application->disability_type ?: 'No information provided' }}</dd>
                @endif

                @if ($application->referral_source)
                    <dt class="col-sm-3">Heard About Us Via</dt>
                    <dd class="col-sm-9">{{ $application->referral_source->value }}</dd>

                    <dt class="col-sm-3">Referrer Name</dt>
                    <dd class="col-sm-9">{{ $application->referrer_name ?: 'No information provided' }}</dd>
                @endif
            </dl>
        </div>
    </div>
@endif

{{-- Programme Choices --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-mortarboard-fill me-2"></i> Programme Choices
            <span class="badge bg-info ms-2">{{ $application->programmeChoices->count() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.programme-choices.create', $application) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add
            </a>
        </div>
    </div>
    @if ($application->programmeChoices->isNotEmpty())
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Programme</th>
                        <th>Study Mode</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($application->programmeChoices as $choice)
                        <tr>
                            <td>{{ $choice->priority->value }}</td>
                            <td>{{ $choice->programme->name }}</td>
                            <td>{{ $choice->study_mode->value }}</td>
                            <td class="text-end">
                                <a href="{{ route('applications.programme-choices.edit', [$application, $choice]) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="delData({{ $choice->id }}, '{{ route('applications.programme-choices.destroy', [$application, $choice]) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card-body text-center text-muted py-4">No information provided</div>
    @endif
</div>

{{-- Academic Qualifications --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-journal-bookmark-fill me-2"></i> Academic Qualifications
            <span class="badge bg-info ms-2">{{ $application->academicQualifications->count() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.academic-qualifications.create', $application) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add
            </a>
        </div>
    </div>
    @if ($application->academicQualifications->isNotEmpty())
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Institution</th>
                        <th>Qualification</th>
                        <th>From</th>
                        <th>To</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($application->academicQualifications as $qualification)
                        <tr>
                            <td>{{ $qualification->institution_name }}</td>
                            <td>{{ $qualification->qualification }}</td>
                            <td>{{ $qualification->from_year }}</td>
                            <td>{{ $qualification->to_year }}</td>
                            <td class="text-end">
                                <a href="{{ route('applications.academic-qualifications.edit', [$application, $qualification]) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="delData({{ $qualification->id }}, '{{ route('applications.academic-qualifications.destroy', [$application, $qualification]) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card-body text-center text-muted py-4">No information provided</div>
    @endif
</div>

{{-- Guardians --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
            <i class="bi bi-people-fill me-2"></i> Guardians
            <span class="badge bg-info ms-2">{{ $application->guardians->count() }}</span>
        </h3>
        <div class="ms-auto">
            <a href="{{ route('applications.guardians.create', $application) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add
            </a>
        </div>
    </div>
    @if ($application->guardians->isNotEmpty())
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($application->guardians as $guardian)
                        <tr>
                            <td>{{ $guardian->type->value }}</td>
                            <td>{{ $guardian->name ?: 'No information provided' }}</td>
                            <td>{{ $guardian->telephone ?: 'No information provided' }}</td>
                            <td>{{ $guardian->email ?: 'No information provided' }}</td>
                            <td class="text-end">
                                <a href="{{ route('applications.guardians.edit', [$application, $guardian]) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="delData({{ $guardian->id }}, '{{ route('applications.guardians.destroy', [$application, $guardian]) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card-body text-center text-muted py-4">No information provided</div>
    @endif
</div>

{{-- Status History --}}
@if ($application->statusHistories->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-clock-history me-2"></i> Status History</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Changed By</th>
                        <th>Remarks</th>
                        <th>When</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($application->statusHistories->sortByDesc('created_at') as $history)
                        <tr>
                            <td>{{ $history->from_status ?? '—' }}</td>
                            <td>{{ $history->to_status }}</td>
                            <td>{{ $history->changedBy->name ?? 'System' }}</td>
                            <td>{{ $history->remarks ?: 'No information provided' }}</td>
                            <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- Move Status modal --}}
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
