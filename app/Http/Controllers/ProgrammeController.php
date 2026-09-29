<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Helpers\ProgrammeLevels;
use App\Models\Faculty;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProgrammeController extends Controller
{
    public function index()
    {
        $programmes = Programme::with('faculty')->latest()->paginate(20);

        return view('programmes.index', compact('programmes'));
    }

    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        $levels = ProgrammeLevels::cases();

        return view('programmes.form', compact('faculties', 'levels'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programmes,code',
            'level' => ['required', Rule::enum(ProgrammeLevels::class)],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $programme = Programme::create($validator->validated());

            DB::commit();
            Log::info('Programme created', ['programme_id' => $programme->id]);

            return redirect()->route('programmes.index')->with('success', 'Programme created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to create programme: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while creating the programme.')->withInput();
        }
    }

    public function show(Programme $programme)
    {
        $programme->load('faculty');

        return view('programmes.show', compact('programme'));
    }

    public function edit(Programme $programme)
    {
        $faculties = Faculty::orderBy('name')->get();
        $levels = ProgrammeLevels::cases();

        return view('programmes.form', compact('programme', 'faculties', 'levels'));
    }

    public function update(Request $request, Programme $programme)
    {
        $validator = Validator::make($request->all(), [
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programmes,code,' . $programme->id,
            'level' => ['required', Rule::enum(ProgrammeLevels::class)],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $programme->update($validator->validated());

            DB::commit();
            Log::info('Programme updated', ['programme_id' => $programme->id]);

            return redirect()->route('programmes.index')->with('success', 'Programme updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update programme ' . $programme->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating the programme.')->withInput();
        }
    }

    public function destroy(Programme $programme)
    {
        DB::beginTransaction();

        try {
            $programme->delete();

            DB::commit();
            Log::info('Programme deleted', ['programme_id' => $programme->id]);

            return redirect()->route('programmes.index')->with('success', 'Programme deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete programme ' . $programme->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting the programme.');
        }
    }
}
