<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Helpers\Priority;
use App\Helpers\StudyMode;
use App\Models\Application;
use App\Models\ApplicationProgrammeChoice;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApplicationProgrammeChoiceController extends Controller
{
    public function index(Application $application)
    {
        $programmeChoices = $application->programmeChoices()->with('programme')->get();

        return view('admin.application-programme-choices.index', compact('application', 'programmeChoices'));
    }

    public function create(Application $application)
    {
        $programmes = Programme::orderBy('name')->get();

        return view('admin.application-programme-choices.form', compact('application', 'programmes'));
    }

    public function store(Request $request, Application $application)
    {
        $validator = Validator::make($request->all(), [
            'programme_id' => 'required|exists:programmes,id',
            'priority' => ['required', Rule::enum(Priority::class)],
            'study_mode' => ['required', Rule::enum(StudyMode::class)],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $choice = $application->programmeChoices()->create($validator->validated());

            DB::commit();
            Log::info('Programme choice added', ['application_id' => $application->id, 'choice_id' => $choice->id]);

            return redirect()->route('applications.programme-choices.index', $application)
                ->with('success', 'Programme choice added successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to add programme choice for application ' . $application->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while adding the programme choice.')->withInput();
        }
    }

    public function show(Application $application, ApplicationProgrammeChoice $programmeChoice)
    {
        $programmeChoice->load('programme', 'eligibilityResults', 'admissionDecisions');

        return view('admin.application-programme-choices.show', compact('application', 'programmeChoice'));
    }

    public function edit(Application $application, ApplicationProgrammeChoice $programmeChoice)
    {
        $programmes = Programme::orderBy('name')->get();

        return view('admin.application-programme-choices.form', compact('application', 'programmeChoice', 'programmes'));
    }

    public function update(Request $request, Application $application, ApplicationProgrammeChoice $programmeChoice)
    {
        $validator = Validator::make($request->all(), [
            'programme_id' => 'required|exists:programmes,id',
            'priority' => ['required', Rule::enum(Priority::class)],
            'study_mode' => ['required', Rule::enum(StudyMode::class)],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $programmeChoice->update($validator->validated());

            DB::commit();
            Log::info('Programme choice updated', ['choice_id' => $programmeChoice->id]);

            return redirect()->route('applications.programme-choices.index', $application)
                ->with('success', 'Programme choice updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update programme choice ' . $programmeChoice->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating the programme choice.')->withInput();
        }
    }

    public function destroy(Application $application, ApplicationProgrammeChoice $programmeChoice)
    {
        DB::beginTransaction();

        try {
            $programmeChoice->delete();

            DB::commit();
            Log::info('Programme choice deleted', ['choice_id' => $programmeChoice->id]);

            return redirect()->route('applications.programme-choices.index', $application)
                ->with('success', 'Programme choice deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete programme choice ' . $programmeChoice->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting the programme choice.');
        }
    }
}
