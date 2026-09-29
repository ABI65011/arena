<?php

namespace App\Http\Controllers;

use App\Helpers\ApplicationStatus;
use App\Helpers\ApplicationType;
use App\Helpers\Gender;
use App\Helpers\MaritalStatus;
use App\Helpers\ReferralSource;
use App\Helpers\StudyMode;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\Intake;
use App\Models\Programme;
use App\Models\User;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
      public function __construct(protected ApplicationService $applicationService)
    {
    }

    public function index()
    {
        $applications = Application::with('applicant', 'intake')->latest()->paginate(20);

        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        // Keyed by user_id so the form's JS can pre-fill/lock the identity
        // fields when an existing applicant is picked.
        $applicants = Applicant::all()->keyBy('user_id');
        $intakes = Intake::where('is_active', true)->get();
        $programmes = Programme::orderBy('name')->get();
        $regionsAndDistricts = config('uganda_regions_districts');
        $nationalities = config('nationalities');

        return view('applications.create', compact(
            'users', 'applicants', 'intakes', 'programmes', 'regionsAndDistricts', 'nationalities'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->createRules());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $application = $this->applicationService->createApplication($validator->validated());

            return redirect()->route('applications.show', $application)
                ->with('success', 'Application created successfully.');
        } catch (\Throwable $e) {
            Log::error('Failed to create application: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while creating the application.')->withInput();
        }
    }

    public function show(Application $application)
    {
        $application->load(
            'applicant.user',
            'intake',
            'programmeChoices.programme',
            'academicQualifications',
            'guardians',
            'documents',
            'statusHistories.changedBy',
            'admissionDecisions',
            'student'
        );

        return view('applications.show', compact('application'));
    }

    public function edit(Application $application)
    {
        $application->load('applicant.user');

        $intakes = Intake::where('is_active', true)->get();
        $regionsAndDistricts = config('uganda_regions_districts');
        $nationalities = config('nationalities');

        return view('applications.edit', compact('application', 'intakes', 'regionsAndDistricts', 'nationalities'));
    }

    public function update(Request $request, Application $application)
    {
        $validator = Validator::make($request->all(), [
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
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $application->update($validator->validated());

            DB::commit();
            Log::info('Application updated', ['application_id' => $application->id]);

            return redirect()->route('applications.show', $application)->with('success', 'Application updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update application ' . $application->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating the application.')->withInput();
        }
    }

    /**
     * Move an application to a new status from its show page. Status is
     * never set from the create/edit form — see ApplicationService::changeStatus().
     */
    public function moveStatus(Request $request, Application $application)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::enum(ApplicationStatus::class)],
            'remarks' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'moveStatus')->withInput();
        }

        try {
            $this->applicationService->changeStatus($application, $request->status, $request->remarks);

            return redirect()->route('applications.show', $application)->with('success', 'Application status updated.');
        } catch (\Throwable $e) {
            Log::error('Failed to change status for application ' . $application->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while changing the status.');
        }
    }

    public function destroy(Application $application)
    {
        DB::beginTransaction();

        try {
            $application->delete();

            DB::commit();
            Log::info('Application deleted', ['application_id' => $application->id]);

            return redirect()->route('applications.index')->with('success', 'Application deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete application ' . $application->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting the application.');
        }
    }

    protected function createRules(): array
    {
        return [
            'account_type' => 'required|in:existing,new',
            'user_id' => 'required_if:account_type,existing|nullable|exists:users,id',
            'email' => 'required_if:account_type,new|nullable|email|unique:users,email',
            'password' => 'required_if:account_type,new|nullable|string|min:8|confirmed',

            'surname' => 'required|string|max:255',
            'other_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'gender' => ['required', Rule::enum(Gender::class)],
            'phone' => 'required|string|max:30',
            'nationality' => 'required|string|max:100',

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
    }
}
