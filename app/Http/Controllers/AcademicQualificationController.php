<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Models\AcademicQualification;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AcademicQualificationController extends Controller
{
    public function index(Application $application)
    {
        $academicQualifications = $application->academicQualifications;

        return view('admin.academic-qualifications.index', compact('application', 'academicQualifications'));
    }

    public function create(Application $application)
    {
        return view('admin.academic-qualifications.form', compact('application'));
    }

    public function store(Request $request, Application $application)
    {
        $validator = Validator::make($request->all(), [
            'institution_name' => 'required|string|max:255',
            'institution_address' => 'nullable|string|max:255',
            'from_year' => 'required|string|max:10',
            'to_year' => 'required|string|max:10',
            'qualification' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $qualification = $application->academicQualifications()->create($validator->validated());

            DB::commit();
            Log::info('Academic qualification added', ['application_id' => $application->id, 'qualification_id' => $qualification->id]);

            return redirect()->route('applications.academic-qualifications.index', $application)
                ->with('success', 'Academic qualification added successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to add academic qualification for application ' . $application->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while adding the qualification.')->withInput();
        }
    }

    public function show(Application $application, AcademicQualification $academicQualification)
    {
        return view('admin.academic-qualifications.show', compact('application', 'academicQualification'));
    }

    public function edit(Application $application, AcademicQualification $academicQualification)
    {
        return view('admin.academic-qualifications.form', compact('application', 'academicQualification'));
    }

    public function update(Request $request, Application $application, AcademicQualification $academicQualification)
    {
        $validator = Validator::make($request->all(), [
            'institution_name' => 'required|string|max:255',
            'institution_address' => 'nullable|string|max:255',
            'from_year' => 'required|string|max:10',
            'to_year' => 'required|string|max:10',
            'qualification' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $academicQualification->update($validator->validated());

            DB::commit();
            Log::info('Academic qualification updated', ['qualification_id' => $academicQualification->id]);

            return redirect()->route('applications.academic-qualifications.index', $application)
                ->with('success', 'Academic qualification updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update academic qualification ' . $academicQualification->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating the qualification.')->withInput();
        }
    }

    public function destroy(Application $application, AcademicQualification $academicQualification)
    {
        DB::beginTransaction();

        try {
            $academicQualification->delete();

            DB::commit();
            Log::info('Academic qualification deleted', ['qualification_id' => $academicQualification->id]);

            return redirect()->route('applications.academic-qualifications.index', $application)
                ->with('success', 'Academic qualification deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete academic qualification ' . $academicQualification->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting the qualification.');
        }
    }
}
