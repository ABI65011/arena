{{-- meow meow meow --}}

@extends('layout.main_layout')

@section('title', 'Edit Application')

@section('page_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Application</h1>
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
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="bi bi-pencil-square me-2"></i> Edit {{ $application->application_no }}</h3>
    </div>

    <form action="{{ route('applications.update', $application) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">
            <h5 class="mb-3">Account &amp; Identity</h5>
            <div class="mb-3">
                <label class="form-label">Applicant</label>
                <input type="text" class="form-control" disabled
                    value="{{ $application->applicant->title ? $application->applicant->title . ' ' : '' }}{{ $application->applicant->surname }} {{ $application->applicant->other_name }} ({{ $application->applicant->user->email }})">
                <small class="text-muted">
                    Edited from the <a href="{{ route('applicants.edit', $application->applicant) }}">Applicant's page</a>, not here.
                </small>
            </div>

            <hr>

            <h5 class="mb-3">Application Details</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="intake_id" class="form-label">Intake</label>
                    <select name="intake_id" id="intake_id" class="form-select @error('intake_id') is-invalid @enderror">
                        @foreach ($intakes as $intake)
                            <option value="{{ $intake->id }}" @selected(old('intake_id', $application->intake_id) == $intake->id)>
                                {{ $intake->name }} ({{ $intake->academic_year }})
                            </option>
                        @endforeach
                    </select>
                    @error('intake_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="application_type" class="form-label">Application Type</label>
                    <select name="application_type" id="application_type" class="form-select @error('application_type') is-invalid @enderror">
                        @foreach (\App\Helpers\ApplicationType::cases() as $type)
                            <option value="{{ $type->value }}" @selected(old('application_type', $application->application_type->value) == $type->value)>
                                {{ $type->value }}
                            </option>
                        @endforeach
                    </select>
                    @error('application_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <small class="text-muted d-block mb-3">
                Status is changed from the <a href="{{ route('applications.show', $application) }}">application's page</a>, not here — it's currently
                <span class="badge bg-secondary">{{ $application->status->value }}</span>.
            </small>

            <hr>

            <h5 class="mb-3">Background</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="country_of_residence" class="form-label">Country of Residence</label>
                    <select name="country_of_residence" id="country_of_residence" class="form-select @error('country_of_residence') is-invalid @enderror">
                        @foreach (array_unique($nationalities) as $country)
                            <option value="{{ $country }}" @selected(old('country_of_residence', $application->country_of_residence) == $country)>{{ $country }}</option>
                        @endforeach
                    </select>
                    @error('country_of_residence')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="ugandaLocationFields" class="row">
                <div class="col-md-6 mb-3">
                    <label for="region" class="form-label">Region</label>
                    <select name="region" id="region" class="form-select @error('region') is-invalid @enderror">
                        <option value="">-- Select Region --</option>
                        @foreach (array_keys($regionsAndDistricts) as $regionName)
                            <option value="{{ $regionName }}" @selected(old('region', $application->region) == $regionName)>{{ $regionName }}</option>
                        @endforeach
                    </select>
                    @error('region')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="district" class="form-label">District</label>
                    <select name="district" id="district" class="form-select @error('district') is-invalid @enderror">
                        <option value="">-- Select Region First --</option>
                    </select>
                    @error('district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="home_diocese" class="form-label">Home Diocese <small class="text-muted">(optional)</small></label>
                    <input type="text" name="home_diocese" id="home_diocese"
                        class="form-control @error('home_diocese') is-invalid @enderror"
                        value="{{ old('home_diocese', $application->home_diocese) }}">
                    @error('home_diocese')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="religious_affiliation" class="form-label">Religious Affiliation <small class="text-muted">(optional)</small></label>
                    <input type="text" name="religious_affiliation" id="religious_affiliation"
                        class="form-control @error('religious_affiliation') is-invalid @enderror"
                        value="{{ old('religious_affiliation', $application->religious_affiliation) }}">
                    @error('religious_affiliation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="marital_status" class="form-label">Marital Status <small class="text-muted">(optional)</small></label>
                <select name="marital_status" id="marital_status" class="form-select @error('marital_status') is-invalid @enderror">
                    <option value="">-- Select --</option>
                    @foreach (\App\Helpers\MaritalStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(old('marital_status', $application->marital_status?->value) == $status->value)>
                            {{ $status->value }}
                        </option>
                    @endforeach
                </select>
                @error('marital_status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="marriageFields" class="row d-none">
                <div class="col-md-6 mb-3">
                    <label for="marriage_type" class="form-label">Type of Marriage</label>
                    <input type="text" name="marriage_type" id="marriage_type"
                        class="form-control @error('marriage_type') is-invalid @enderror"
                        value="{{ old('marriage_type', $application->marriage_type) }}">
                    @error('marriage_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="spouse_name" class="form-label">Spouse Name</label>
                    <input type="text" name="spouse_name" id="spouse_name"
                        class="form-control @error('spouse_name') is-invalid @enderror"
                        value="{{ old('spouse_name', $application->spouse_name) }}">
                    @error('spouse_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Additional Info</h5>
            <div class="form-check mb-3">
                <input type="hidden" name="has_disability" value="0">
                <input type="checkbox" name="has_disability" id="has_disability" value="1"
                    class="form-check-input" @checked(old('has_disability', $application->has_disability))>
                <label for="has_disability" class="form-check-label">Applicant has a disability</label>
            </div>

            <div id="disabilityField" class="mb-3 d-none">
                <label for="disability_type" class="form-label">Disability Type</label>
                <input type="text" name="disability_type" id="disability_type"
                    class="form-control @error('disability_type') is-invalid @enderror"
                    value="{{ old('disability_type', $application->disability_type) }}">
                @error('disability_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="referral_source" class="form-label">How did they hear about us? <small class="text-muted">(optional)</small></label>
                <select name="referral_source" id="referral_source" class="form-select @error('referral_source') is-invalid @enderror">
                    <option value="">-- Select --</option>
                    @foreach (\App\Helpers\ReferralSource::cases() as $source)
                        <option value="{{ $source->value }}" @selected(old('referral_source', $application->referral_source?->value) == $source->value)>
                            {{ $source->value }}
                        </option>
                    @endforeach
                </select>
                @error('referral_source')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="referrerField" class="mb-3 d-none">
                <label for="referrer_name" class="form-label">Referrer Name</label>
                <input type="text" name="referrer_name" id="referrer_name"
                    class="form-control @error('referrer_name') is-invalid @enderror"
                    value="{{ old('referrer_name', $application->referrer_name) }}">
                @error('referrer_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('applications.show', $application) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Application</button>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const districtsByRegion = @json($regionsAndDistricts);
    const oldDistrict = @json(old('district', $application->district));

    const countrySelect = document.getElementById('country_of_residence');
    const ugandaFields = document.getElementById('ugandaLocationFields');
    const regionSelect = document.getElementById('region');
    const districtSelect = document.getElementById('district');

    function toggleUgandaFields() {
        ugandaFields.classList.toggle('d-none', countrySelect.value !== 'Uganda');
    }
    countrySelect.addEventListener('change', toggleUgandaFields);
    toggleUgandaFields();

    function populateDistricts(selected) {
        const districts = districtsByRegion[regionSelect.value] || [];
        districtSelect.innerHTML = districts.length
            ? '<option value="">-- Select District --</option>'
            : '<option value="">-- Select Region First --</option>';
        districts.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d;
            opt.textContent = d;
            if (d === selected) opt.selected = true;
            districtSelect.appendChild(opt);
        });
    }
    regionSelect.addEventListener('change', () => populateDistricts(null));
    if (regionSelect.value) populateDistricts(oldDistrict);

    const maritalStatus = document.getElementById('marital_status');
    const marriageFields = document.getElementById('marriageFields');
    function toggleMarriageFields() {
        marriageFields.classList.toggle('d-none', maritalStatus.value !== 'Married');
    }
    maritalStatus.addEventListener('change', toggleMarriageFields);
    toggleMarriageFields();

    const hasDisability = document.getElementById('has_disability');
    const disabilityField = document.getElementById('disabilityField');
    function toggleDisabilityField() {
        disabilityField.classList.toggle('d-none', !hasDisability.checked);
    }
    hasDisability.addEventListener('change', toggleDisabilityField);
    toggleDisabilityField();

    const referralSource = document.getElementById('referral_source');
    const referrerField = document.getElementById('referrerField');
    function toggleReferrerField() {
        referrerField.classList.toggle('d-none', referralSource.value === '');
    }
    referralSource.addEventListener('change', toggleReferrerField);
    toggleReferrerField();
});
</script>
@endsection
