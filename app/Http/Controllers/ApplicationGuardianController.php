<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Helpers\ApplicationGuardianType;
use App\Models\Application;
use App\Models\ApplicationGuardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApplicationGuardianController extends Controller
{
    public function index(Application $application)
    {
        $guardians = $application->guardians;

        return view('admin.application-guardians.index', compact('application', 'guardians'));
    }

    public function create(Application $application)
    {
        return view('admin.application-guardians.form', compact('application'));
    }

    public function store(Request $request, Application $application)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', Rule::enum(ApplicationGuardianType::class), Rule::unique('application_guardians', 'type')->where('application_id', $application->id)],
            'name' => 'nullable|string|max:255',
            'po_box' => 'nullable|string|max:100',
            'town' => 'nullable|string|max:100',
            'telephone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $guardian = $application->guardians()->create($validator->validated());

            DB::commit();
            Log::info('Guardian added', ['application_id' => $application->id, 'guardian_id' => $guardian->id]);

            return redirect()->route('applications.guardians.index', $application)
                ->with('success', 'Guardian added successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to add guardian for application ' . $application->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while adding the guardian.')->withInput();
        }
    }

    public function show(Application $application, ApplicationGuardian $guardian)
    {
        return view('admin.application-guardians.show', compact('application', 'guardian'));
    }

    public function edit(Application $application, ApplicationGuardian $guardian)
    {
        return view('admin.application-guardians.form', compact('application', 'guardian'));
    }

    public function update(Request $request, Application $application, ApplicationGuardian $guardian)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', Rule::enum(ApplicationGuardianType::class), Rule::unique('application_guardians', 'type')->where('application_id', $application->id)->ignore($guardian->id)],
            'name' => 'nullable|string|max:255',
            'po_box' => 'nullable|string|max:100',
            'town' => 'nullable|string|max:100',
            'telephone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $guardian->update($validator->validated());

            DB::commit();
            Log::info('Guardian updated', ['guardian_id' => $guardian->id]);

            return redirect()->route('applications.guardians.index', $application)
                ->with('success', 'Guardian updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update guardian ' . $guardian->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating the guardian.')->withInput();
        }
    }

    public function destroy(Application $application, ApplicationGuardian $guardian)
    {
        DB::beginTransaction();

        try {
            $guardian->delete();

            DB::commit();
            Log::info('Guardian deleted', ['guardian_id' => $guardian->id]);

            return redirect()->route('applications.guardians.index', $application)
                ->with('success', 'Guardian deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete guardian ' . $guardian->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting the guardian.');
        }
    }
}
