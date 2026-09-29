{{-- meow meow meow --}}

@extends('layout.student_layout')

@section('title', 'Apply')

@section('content')
@php
    $needsIdentity = is_null($applicant);
    $stepLabels = $needsIdentity
        ? ['Identity', 'Application', 'Background', 'Additional', 'Programmes', 'Qualifications', 'Guardians']
        : ['Application', 'Background', 'Additional', 'Programmes', 'Qualifications', 'Guardians'];
@endphp

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="bi bi-file-earmark-plus-fill me-2"></i> Apply</h3>
    </div>

    {{-- Step indicator --}}
    <div class="card-body border-bottom">
        <div class="stepper d-flex align-items-center" id="stepIndicator">
            @foreach ($stepLabels as $i => $label)
                @php $n = $i + 1; @endphp
                <div class="stepper-step" data-step-dot="{{ $n }}">
                    <span class="stepper-circle">
                        <i class="bi bi-check-lg"></i><span class="stepper-number">{{ $n }}</span>
                    </span>
                    <span class="stepper-label">{{ $label }}</span>
                </div>
                @if (! $loop->last)
                    <div class="stepper-line" data-step-line="{{ $n }}"></div>
                @endif
            @endforeach
        </div>
    </div>

    <form action="{{ route('apply.store') }}" method="POST" id="applicationForm">
        @csrf

        <div class="card-body">

            @if ($needsIdentity)
                {{-- Step: Identity --}}
                <div class="form-step" data-step="1">
                    <p class="text-muted">This is your first application, so we need a few identity details first.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" name="surname" id="surname"
                                class="form-control @error('surname') is-invalid @enderror"
                                value="{{ old('surname') }}">
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="other_name" class="form-label">Other Name</label>
                            <input type="text" name="other_name" id="other_name"
                                class="form-control @error('other_name') is-invalid @enderror"
                                value="{{ old('other_name') }}">
                            @error('other_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="title" class="form-label">Title <small class="text-muted">(optional)</small></label>
                            <input type="text" name="title" id="title" placeholder="e.g. Mr, Mrs, Rev, Dr"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">-- Select --</option>
                                @foreach (\App\Helpers\Gender::cases() as $g)
                                    <option value="{{ $g->value }}" @selected(old('gender') == $g->value)>{{ $g->value }}</option>
                                @endforeach
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nationality" class="form-label">Nationality</label>
                        <select name="nationality" id="nationality" class="form-select @error('nationality') is-invalid @enderror">
                            <option value="">-- Select --</option>
                            @foreach ($nationalities as $demonym => $country)
                                <option value="{{ $demonym }}" @selected(old('nationality') == $demonym)>{{ $demonym }}</option>
                            @endforeach
                        </select>
                        @error('nationality')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- Step: Application details --}}
            <div class="form-step {{ $needsIdentity ? 'd-none' : '' }}" data-step="{{ $needsIdentity ? 2 : 1 }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="intake_id" class="form-label">Intake</label>
                        <select name="intake_id" id="intake_id" class="form-select @error('intake_id') is-invalid @enderror">
                            <option value="">-- Select Intake --</option>
                            @foreach ($intakes as $intake)
                                <option value="{{ $intake->id }}" @selected(old('intake_id') == $intake->id)>
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
                            <option value="">-- Select --</option>
                            @foreach (\App\Helpers\ApplicationType::cases() as $type)
                                <option value="{{ $type->value }}" @selected(old('application_type') == $type->value)>
                                    {{ $type->value }}
                                </option>
                            @endforeach
                        </select>
                        @error('application_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Step: Background --}}
            <div class="form-step d-none" data-step="{{ $needsIdentity ? 3 : 2 }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="country_of_residence" class="form-label">Country of Residence</label>
                        <select name="country_of_residence" id="country_of_residence" class="form-select @error('country_of_residence') is-invalid @enderror">
                            <option value="">-- Select --</option>
                            @foreach (array_unique($nationalities) as $country)
                                <option value="{{ $country }}" @selected(old('country_of_residence') == $country)>{{ $country }}</option>
                            @endforeach
                        </select>
                        @error('country_of_residence')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="ugandaLocationFields" class="row d-none">
                    <div class="col-md-6 mb-3">
                        <label for="region" class="form-label">Region</label>
                        <select name="region" id="region" class="form-select @error('region') is-invalid @enderror">
                            <option value="">-- Select Region --</option>
                            @foreach (array_keys($regionsAndDistricts) as $regionName)
                                <option value="{{ $regionName }}" @selected(old('region') == $regionName)>{{ $regionName }}</option>
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
                            value="{{ old('home_diocese') }}">
                        @error('home_diocese')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="religious_affiliation" class="form-label">Religious Affiliation <small class="text-muted">(optional)</small></label>
                        <input type="text" name="religious_affiliation" id="religious_affiliation"
                            class="form-control @error('religious_affiliation') is-invalid @enderror"
                            value="{{ old('religious_affiliation') }}">
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
                            <option value="{{ $status->value }}" @selected(old('marital_status') == $status->value)>
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
                            value="{{ old('marriage_type') }}">
                        @error('marriage_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="spouse_name" class="form-label">Spouse Name</label>
                        <input type="text" name="spouse_name" id="spouse_name"
                            class="form-control @error('spouse_name') is-invalid @enderror"
                            value="{{ old('spouse_name') }}">
                        @error('spouse_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Step: Additional Info --}}
            <div class="form-step d-none" data-step="{{ $needsIdentity ? 4 : 3 }}">
                <div class="form-check mb-3">
                    <input type="hidden" name="has_disability" value="0">
                    <input type="checkbox" name="has_disability" id="has_disability" value="1"
                        class="form-check-input" @checked(old('has_disability'))>
                    <label for="has_disability" class="form-check-label">I have a disability</label>
                </div>

                <div id="disabilityField" class="mb-3 d-none">
                    <label for="disability_type" class="form-label">Disability Type</label>
                    <input type="text" name="disability_type" id="disability_type"
                        class="form-control @error('disability_type') is-invalid @enderror"
                        value="{{ old('disability_type') }}">
                    @error('disability_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="referral_source" class="form-label">How did you hear about us? <small class="text-muted">(optional)</small></label>
                    <select name="referral_source" id="referral_source" class="form-select @error('referral_source') is-invalid @enderror">
                        <option value="">-- Select --</option>
                        @foreach (\App\Helpers\ReferralSource::cases() as $source)
                            <option value="{{ $source->value }}" @selected(old('referral_source') == $source->value)>
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
                        value="{{ old('referrer_name') }}">
                    @error('referrer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Step: Programme Choices --}}
            <div class="form-step d-none" data-step="{{ $needsIdentity ? 5 : 4 }}">
                <h5 class="mb-3">1st Choice</h5>
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="choice1_programme" class="form-label">Programme</label>
                        <select name="programme_choices[1st][programme_id]" id="choice1_programme"
                            class="form-select programme-select @error('programme_choices.1st.programme_id') is-invalid @enderror">
                            <option value="">-- Select Programme --</option>
                            @foreach ($programmes as $programme)
                                <option value="{{ $programme->id }}" data-level="{{ $programme->level->value }}"
                                    @selected(old('programme_choices.1st.programme_id') == $programme->id)>
                                    {{ $programme->name }} ({{ $programme->level->value }})
                                </option>
                            @endforeach
                        </select>
                        @error('programme_choices.1st.programme_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="choice1_mode" class="form-label">Study Mode</label>
                        <select name="programme_choices[1st][study_mode]" id="choice1_mode"
                            class="form-select @error('programme_choices.1st.study_mode') is-invalid @enderror">
                            <option value="">-- Select --</option>
                            @foreach (\App\Helpers\StudyMode::cases() as $mode)
                                <option value="{{ $mode->value }}" @selected(old('programme_choices.1st.study_mode') == $mode->value)>
                                    {{ $mode->value }}
                                </option>
                            @endforeach
                        </select>
                        @error('programme_choices.1st.study_mode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="button" id="addSecondChoiceBtn" class="btn btn-sm btn-outline-primary mb-3">
                    <i class="bi bi-plus-lg"></i> Add 2nd Choice
                </button>

                <div id="secondChoiceBlock" class="d-none">
                    <h5 class="mb-3">2nd Choice <small class="text-muted">(optional)</small></h5>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="choice2_programme" class="form-label">Programme</label>
                            <select name="programme_choices[2nd][programme_id]" id="choice2_programme"
                                class="form-select programme-select @error('programme_choices.2nd.programme_id') is-invalid @enderror">
                                <option value="">-- Select Programme --</option>
                                @foreach ($programmes as $programme)
                                    <option value="{{ $programme->id }}" data-level="{{ $programme->level->value }}"
                                        @selected(old('programme_choices.2nd.programme_id') == $programme->id)>
                                        {{ $programme->name }} ({{ $programme->level->value }})
                                    </option>
                                @endforeach
                            </select>
                            @error('programme_choices.2nd.programme_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="choice2_mode" class="form-label">Study Mode</label>
                            <select name="programme_choices[2nd][study_mode]" id="choice2_mode"
                                class="form-select @error('programme_choices.2nd.study_mode') is-invalid @enderror">
                                <option value="">-- Select --</option>
                                @foreach (\App\Helpers\StudyMode::cases() as $mode)
                                    <option value="{{ $mode->value }}" @selected(old('programme_choices.2nd.study_mode') == $mode->value)>
                                        {{ $mode->value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('programme_choices.2nd.study_mode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-1 mb-3 d-flex align-items-end">
                            <button type="button" id="removeSecondChoiceBtn" class="btn btn-outline-danger" title="Remove 2nd choice">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step: Academic Qualifications --}}
            <div class="form-step d-none" data-step="{{ $needsIdentity ? 6 : 5 }}">
                <div id="qualificationRows"></div>
                <button type="button" id="addQualificationBtn" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus-lg"></i> Add Institution
                </button>
                @error('academic_qualifications')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Step: Guardians --}}
            <div class="form-step d-none" data-step="{{ $needsIdentity ? 7 : 6 }}">
                @foreach (['Father', 'Mother', 'Sponsor'] as $type)
                    <h5 class="mb-3">{{ $type }} <small class="text-muted">(optional)</small></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="guardians[{{ $type }}][name]"
                                class="form-control @error('guardians.' . $type . '.name') is-invalid @enderror"
                                value="{{ old('guardians.' . $type . '.name') }}">
                            @error('guardians.' . $type . '.name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">P.O. Box</label>
                            <input type="text" name="guardians[{{ $type }}][po_box]"
                                class="form-control @error('guardians.' . $type . '.po_box') is-invalid @enderror"
                                value="{{ old('guardians.' . $type . '.po_box') }}">
                            @error('guardians.' . $type . '.po_box')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Town</label>
                            <input type="text" name="guardians[{{ $type }}][town]"
                                class="form-control @error('guardians.' . $type . '.town') is-invalid @enderror"
                                value="{{ old('guardians.' . $type . '.town') }}">
                            @error('guardians.' . $type . '.town')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Telephone</label>
                            <input type="text" name="guardians[{{ $type }}][telephone]"
                                class="form-control @error('guardians.' . $type . '.telephone') is-invalid @enderror"
                                value="{{ old('guardians.' . $type . '.telephone') }}">
                            @error('guardians.' . $type . '.telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="guardians[{{ $type }}][email]"
                                class="form-control @error('guardians.' . $type . '.email') is-invalid @enderror"
                                value="{{ old('guardians.' . $type . '.email') }}">
                            @error('guardians.' . $type . '.email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('my-applications.index') }}" class="btn btn-secondary">Cancel</a>
            <div>
                <button type="button" id="prevBtn" class="btn btn-outline-secondary d-none">
                    <i class="bi bi-arrow-left"></i> Previous
                </button>
                <button type="button" id="nextBtn" class="btn btn-primary">
                    Next <i class="bi bi-arrow-right"></i>
                </button>
                <button type="submit" id="submitBtn" class="btn btn-primary d-none">
                    Save Application
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<style>
    .stepper-step {
        display: flex;
        align-items: center;
        gap: .5rem;
        white-space: nowrap;
        color: #6c757d;
    }
    .stepper-circle {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: .85rem;
        transition: all .2s ease;
    }
    .stepper-circle .bi-check-lg { display: none; }
    .stepper-line {
        flex: 1 1 auto;
        height: 2px;
        margin: 0 .5rem;
        background: #dee2e6;
        transition: background .2s ease;
    }
    .stepper-line.is-filled { background: var(--bs-primary); }

    .stepper-step.is-active .stepper-circle {
        border-color: var(--bs-primary);
        color: var(--bs-primary);
        box-shadow: 0 0 0 4px rgba(var(--bs-primary-rgb), .25);
    }
    .stepper-step.is-active .stepper-label,
    .stepper-step.is-complete .stepper-label { color: #212529; }

    .stepper-step.is-complete .stepper-circle {
        background: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #fff;
    }
    .stepper-step.is-complete .stepper-circle .bi-check-lg { display: inline; }
    .stepper-step.is-complete .stepper-number { display: none; }

    @media (max-width: 767.98px) {
        .stepper-step:not(.is-active) .stepper-label { display: none; }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.form-step');
    const totalSteps = steps.length; // computed, not hardcoded — varies with $needsIdentity
    let currentStep = Number(steps[0].dataset.step);

    const stepEls = document.querySelectorAll('[data-step-dot]');
    const lineEls = document.querySelectorAll('[data-step-line]');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    const stepValues = [...steps].map(el => Number(el.dataset.step)).sort((a, b) => a - b);
    const firstStep = stepValues[0];
    const lastStep = stepValues[stepValues.length - 1];

    function indicatorPosition(step) {
        return stepValues.indexOf(step) + 1; // 1-based, matches data-step-dot
    }

    function updateIndicator(step) {
        const pos = indicatorPosition(step);
        stepEls.forEach(el => {
            const n = Number(el.dataset.stepDot);
            el.classList.toggle('is-complete', n < pos);
            el.classList.toggle('is-active', n === pos);
        });
        lineEls.forEach(el => el.classList.toggle('is-filled', Number(el.dataset.stepLine) < pos));
    }

    function showStep(step) {
        steps.forEach(el => el.classList.toggle('d-none', Number(el.dataset.step) !== step));
        updateIndicator(step);

        prevBtn.classList.toggle('d-none', step === firstStep);
        nextBtn.classList.toggle('d-none', step === lastStep);
        submitBtn.classList.toggle('d-none', step !== lastStep);

        currentStep = step;
    }

    function stepIndex(step) { return stepValues.indexOf(step); }

    nextBtn.addEventListener('click', () => showStep(stepValues[Math.min(stepIndex(currentStep) + 1, stepValues.length - 1)]));
    prevBtn.addEventListener('click', () => showStep(stepValues[Math.max(stepIndex(currentStep) - 1, 0)]));

    const firstErrorStep = document.querySelector('.form-step .is-invalid')?.closest('.form-step');
    showStep(firstErrorStep ? Number(firstErrorStep.dataset.step) : firstStep);

    // --- Background: country -> region/district, marital status ---
    const districtsByRegion = @json($regionsAndDistricts);
    const countrySelect = document.getElementById('country_of_residence');
    const ugandaFields = document.getElementById('ugandaLocationFields');
    const regionSelect = document.getElementById('region');
    const districtSelect = document.getElementById('district');

    function toggleUgandaFields() {
        const isUganda = countrySelect.value === 'Uganda';
        ugandaFields.classList.toggle('d-none', !isUganda);
        if (!isUganda) {
            regionSelect.value = '';
            districtSelect.innerHTML = '<option value="">-- Select Region First --</option>';
        }
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
    if (regionSelect.value) populateDistricts(@json(old('district')));

    const maritalStatus = document.getElementById('marital_status');
    const marriageFields = document.getElementById('marriageFields');
    function toggleMarriageFields() {
        marriageFields.classList.toggle('d-none', maritalStatus.value !== 'Married');
    }
    maritalStatus.addEventListener('change', toggleMarriageFields);
    toggleMarriageFields();

    // --- Additional info ---
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

    // --- Programme filtering by application type ---
    const applicationType = document.getElementById('application_type');
    const programmeSelects = document.querySelectorAll('.programme-select');
    function filterProgrammes() {
        const wantsPostgrad = applicationType.value === 'Postgraduate';
        programmeSelects.forEach(select => {
            [...select.options].forEach(opt => {
                if (!opt.value) return;
                const isPostgrad = opt.dataset.level === 'Postgraduate';
                opt.hidden = wantsPostgrad ? !isPostgrad : isPostgrad;
            });
        });
    }
    applicationType.addEventListener('change', filterProgrammes);
    filterProgrammes();

    // --- Optional 2nd choice ---
    const addSecondChoiceBtn = document.getElementById('addSecondChoiceBtn');
    const secondChoiceBlock = document.getElementById('secondChoiceBlock');
    const removeSecondChoiceBtn = document.getElementById('removeSecondChoiceBtn');

    addSecondChoiceBtn.addEventListener('click', () => {
        secondChoiceBlock.classList.remove('d-none');
        addSecondChoiceBtn.classList.add('d-none');
    });
    removeSecondChoiceBtn.addEventListener('click', () => {
        secondChoiceBlock.classList.add('d-none');
        addSecondChoiceBtn.classList.remove('d-none');
        document.getElementById('choice2_programme').value = '';
        document.getElementById('choice2_mode').value = '';
    });
    if (document.getElementById('choice2_programme').value) {
        secondChoiceBlock.classList.remove('d-none');
        addSecondChoiceBtn.classList.add('d-none');
    }

    // --- Repeating academic qualification rows ---
    const qualificationRows = document.getElementById('qualificationRows');
    const addQualificationBtn = document.getElementById('addQualificationBtn');
    let qualificationIndex = 0;

    function addQualificationRow(values = {}) {
        const i = qualificationIndex++;
        const row = document.createElement('div');
        row.className = 'row align-items-end qualification-row mb-2';
        row.innerHTML = `
            <div class="col-md-3 mb-2">
                <label class="form-label">Institution Name</label>
                <input type="text" name="academic_qualifications[${i}][institution_name]" class="form-control" value="${values.institution_name || ''}">
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">Institution Address <small class="text-muted">(optional)</small></label>
                <input type="text" name="academic_qualifications[${i}][institution_address]" class="form-control" value="${values.institution_address || ''}">
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label">From Year</label>
                <input type="text" name="academic_qualifications[${i}][from_year]" class="form-control" value="${values.from_year || ''}">
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label">To Year</label>
                <input type="text" name="academic_qualifications[${i}][to_year]" class="form-control" value="${values.to_year || ''}">
            </div>
            <div class="col-md-1 mb-2">
                <label class="form-label">Qualification</label>
                <input type="text" name="academic_qualifications[${i}][qualification]" class="form-control" value="${values.qualification || ''}">
            </div>
            <div class="col-md-1 mb-2">
                <button type="button" class="btn btn-outline-danger remove-qualification-row" title="Remove"><i class="bi bi-trash"></i></button>
            </div>
        `;
        qualificationRows.appendChild(row);
        row.querySelector('.remove-qualification-row').addEventListener('click', () => row.remove());
    }

    addQualificationBtn.addEventListener('click', () => addQualificationRow());

    const oldQualifications = @json(old('academic_qualifications', []));
    if (oldQualifications.length) {
        oldQualifications.forEach(q => addQualificationRow(q));
    } else {
        addQualificationRow();
    }
});
</script>
@endsection
