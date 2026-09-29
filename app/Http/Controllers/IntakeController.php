<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Helpers\Month;
use App\Models\Intake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class IntakeController extends Controller
{
    public function index()
    {
        $intakes = Intake::latest('application_open_date')->paginate(20);

        return view('intakes.index', compact('intakes'));
    }

    public function create()
    {
        return view('intakes.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'month' => ['required', Rule::enum(Month::class)],
            'academic_year' => 'required|string|max:20',
            'application_open_date' => 'required|date',
            'application_close_date' => 'required|date|after_or_equal:application_open_date',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $intake = Intake::create($validator->validated());

            DB::commit();
            Log::info('Intake created', ['intake_id' => $intake->id]);

            return redirect()->route('intakes.index')->with('success', 'Intake created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to create intake: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while creating the intake.')->withInput();
        }
    }

    public function show(Intake $intake)
    {
        $intake->load('applications');

        return view('intakes.show', compact('intake'));
    }

    public function edit(Intake $intake)
    {
        return view('intakes.form', compact('intake'));
    }

    public function update(Request $request, Intake $intake)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'month' => ['required', Rule::enum(Month::class)],
            'academic_year' => 'required|string|max:20',
            'application_open_date' => 'required|date',
            'application_close_date' => 'required|date|after_or_equal:application_open_date',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $intake->update($validator->validated());

            DB::commit();
            Log::info('Intake updated', ['intake_id' => $intake->id]);

            return redirect()->route('intakes.index')->with('success', 'Intake updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update intake ' . $intake->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating the intake.')->withInput();
        }
    }

    public function destroy(Intake $intake)
    {
        DB::beginTransaction();

        try {
            $intake->delete();

            DB::commit();
            Log::info('Intake deleted', ['intake_id' => $intake->id]);

            return redirect()->route('intakes.index')->with('success', 'Intake deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error('Failed to delete intake ' . $intake->id . ' (FK constraint): ' . $e->getMessage());

            return back()->with('error', 'This intake has applications attached and cannot be deleted.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete intake ' . $intake->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting the intake.');
        }
    }
}
