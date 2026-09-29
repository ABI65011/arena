<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Helpers\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentApplicantController extends Controller
{
    public function show()
    {
        $applicant = auth()->user()->applicant()->with('applications')->firstOrFail();

        return view('student.applicants.show', compact('applicant'));
    }

    public function edit()
    {
        $applicant = auth()->user()->applicant()->firstOrFail();

        return view('student.applicants.edit', compact('applicant'));
    }

    public function update(Request $request)
    {
        $applicant = auth()->user()->applicant()->firstOrFail();

        $validator = Validator::make($request->all(), [
            'surname' => 'required|string|max:255',
            'other_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'gender' => ['required', Rule::enum(Gender::class)],
            'phone' => 'required|string|max:30',
            'nationality' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $applicant->update($validator->safe()->except(['email', 'password', 'password_confirmation']));

            $userUpdates = ['email' => $request->email];
            if ($request->filled('password')) {
                $userUpdates['password'] = $request->password; // hashed by the 'password' => 'hashed' cast
            }
            auth()->user()->update($userUpdates);

            DB::commit();
            Log::info('Applicant updated own profile', ['applicant_id' => $applicant->id]);

            return redirect()->route('my-profile.show')->with('success', 'Profile updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update own profile for applicant ' . $applicant->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating your profile.')->withInput();
        }
    }
}
