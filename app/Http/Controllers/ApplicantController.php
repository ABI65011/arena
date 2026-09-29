<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Helpers\Gender;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * No create()/store() here — an applicant record is only ever created
 * as part of submitting an application, via ApplicationService. This
 * controller only lists, shows and edits identity details, or removes
 * an applicant entirely.
 */
class ApplicantController extends Controller
{
    public function index()
    {
        $applicants = Applicant::with('user', 'applications')->latest()->paginate(20);

        return view('applicants.index', compact('applicants'));
    }

    public function show(Applicant $applicant)
    {
        $applicant->load('user', 'applications.intake');

        return view('applicants.show', compact('applicant'));
    }

    public function edit(Applicant $applicant)
    {
        return view('applicants.form', compact('applicant'));
    }

    public function update(Request $request, Applicant $applicant)
    {
        $validator = Validator::make($request->all(), [
            'surname' => 'required|string|max:255',
            'other_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'gender' => ['required', Rule::enum(Gender::class)],
            'phone' => 'required|string|max:30',
            'nationality' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $applicant->update($validator->validated());

            DB::commit();
            Log::info('Applicant updated', ['applicant_id' => $applicant->id]);

            return redirect()->route('applicants.index')->with('success', 'Applicant updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update applicant ' . $applicant->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating the applicant.')->withInput();
        }
    }

    public function destroy(Applicant $applicant)
    {
        DB::beginTransaction();

        try {
            $applicant->delete();

            DB::commit();
            Log::info('Applicant deleted', ['applicant_id' => $applicant->id]);

            return redirect()->route('applicants.index')->with('success', 'Applicant deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete applicant ' . $applicant->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting the applicant.');
        }
    }
}
