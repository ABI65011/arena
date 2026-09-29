<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Helpers\ApplicationStatus;
use App\Helpers\ApplicationType;
use App\Helpers\Gender;
use App\Helpers\MaritalStatus;
use App\Helpers\ReferralSource;
use App\Helpers\StudyMode;
use App\Models\Application;
use App\Models\Intake;
use App\Models\Programme;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * The applicant-facing side. Apply is reachable by any authenticated user
 * (it's what creates their applicant record) — everything else here sits
 * behind EnsureUserIsApplicant, see the routes file.
 */
class StudentApplicationController extends Controller
{
    public function __construct(protected ApplicationService $applicationService)
    {
    }

    public function index()
    {
        $applications = auth()->user()->applicant->applications()->with('intake')->latest()->get();

        return view('student.applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        abort_unless($application->applicant->user_id === auth()->id(), 403);

        $application->load('intake', 'programmeChoices.programme', 'academicQualifications', 'guardians', 'statusHistories');

        return view('student.applications.show', compact('application'));
    }

    public function create()
    {
        // Null on a first application — the view uses this to decide
        // whether to ask for identity fields at all.
        $applicant = auth()->user()->applicant;

        $intakes = Intake::where('is_active', true)->get();
        $programmes = Programme::orderBy('name')->get();
        $regionsAndDistricts = config('uganda_regions_districts');
        $nationalities = config('nationalities');

        return view('student.applications.create', compact(
            'applicant', 'intakes', 'programmes', 'regionsAndDistricts', 'nationalities'
        ));
    }

    public function store(Request $request)
    {
        $isFirstApplication = ! auth()->user()->applicant;

        $rules = [
            'intake_id' => 'required|exists:intakes,id',
            'application_type' => ['required', Rule::enum(ApplicationType::class)],

            'country_of_residence' => 'required|string|max:100',
            'region' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'home_diocese' => 'nullable|string|max:150',
            'religious_affiliation' => 'nullable|string|max:150',
            'marital_status' => ['nullable', Rule::enum(MaritalStatus::class)],
            'marriage_type' => 'nullable|string|max:100',
            'spouse_name' => 'nullable|string|max:255',

            'has_disability' => 'boolean',
            'disability_type' => 'nullable|string|max:255',
            'referral_source' => ['nullable', Rule::enum(ReferralSource::class)],
            'referrer_name' => 'nullable|string|max:255',

            'programme_choices.1st.programme_id' => 'required|exists:programmes,id',
            'programme_choices.1st.study_mode' => ['required', Rule::enum(StudyMode::class)],
            'programme_choices.2nd.programme_id' => 'nullable|different:programme_choices.1st.programme_id|exists:programmes,id',
            'programme_choices.2nd.study_mode' => ['nullable', 'required_with:programme_choices.2nd.programme_id', Rule::enum(StudyMode::class)],

            'academic_qualifications' => 'required|array|min:1',
            'academic_qualifications.*.institution_name' => 'required|string|max:255',
            'academic_qualifications.*.institution_address' => 'nullable|string|max:255',
            'academic_qualifications.*.from_year' => 'required|string|max:10',
            'academic_qualifications.*.to_year' => 'required|string|max:10',
            'academic_qualifications.*.qualification' => 'required|string|max:255',

            'guardians.*.name' => 'nullable|string|max:255',
            'guardians.*.po_box' => 'nullable|string|max:100',
            'guardians.*.town' => 'nullable|string|max:100',
            'guardians.*.telephone' => 'nullable|string|max:30',
            'guardians.*.email' => 'nullable|email|max:255',
        ];

        // Identity is only asked for — and only required — on someone's
        // very first application. ApplicationService::resolveApplicant()
        // ignores these entirely once an applicant record already exists.
        if ($isFirstApplication) {
            $rules = array_merge($rules, [
                'surname' => 'required|string|max:255',
                'other_name' => 'required|string|max:255',
                'title' => 'nullable|string|max:20',
                'date_of_birth' => 'required|date|before:today',
                'gender' => ['required', Rule::enum(Gender::class)],
                'phone' => 'required|string|max:30',
                'nationality' => 'required|string|max:100',
            ]);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // No account choice here — the account is whoever is logged in.
        $data = array_merge($validator->validated(), [
            'account_type' => 'existing',
            'user_id' => auth()->id(),
        ]);

        try {
            $application = $this->applicationService->createApplication($data);

            return redirect()->route('my-applications.show', $application)
                ->with('success', 'Application saved as a draft. Review it, then submit when ready.');
        } catch (\Throwable $e) {
            Log::error('Failed to create student application: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while saving your application.')->withInput();
        }
    }

    /**
     * Locks the application in by moving it from Draft to Submitted.
     * Everything before this point can still change; nothing after can.
     */
    public function submit(Application $application)
    {
        abort_unless($application->applicant->user_id === auth()->id(), 403);
        abort_unless($application->status === ApplicationStatus::Draft, 400);

        try {
            $this->applicationService->changeStatus($application, ApplicationStatus::Submitted->value);
            $application->update(['submitted_at' => now()]);

            return redirect()->route('my-applications.show', $application)
                ->with('success', 'Application submitted successfully.');
        } catch (\Throwable $e) {
            Log::error('Failed to submit application ' . $application->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while submitting your application.');
        }
    }
}
