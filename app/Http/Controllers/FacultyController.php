<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::withCount('programmes')->latest()->paginate(20);

        return view('faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('faculties.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:faculties,code',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $faculty = Faculty::create($validator->validated());

            DB::commit();
            Log::info('Faculty created', ['faculty_id' => $faculty->id]);

            return redirect()->route('faculties.index')->with('success', 'Faculty created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to create faculty: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while creating the faculty.')->withInput();
        }
    }

    public function show(Faculty $faculty)
    {
        $faculty->load('programmes');

        return view('faculties.show', compact('faculty'));
    }

    public function edit(Faculty $faculty)
    {
        return view('faculties.form', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:faculties,code,' . $faculty->id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $faculty->update($validator->validated());

            DB::commit();
            Log::info('Faculty updated', ['faculty_id' => $faculty->id]);

            return redirect()->route('faculties.index')->with('success', 'Faculty updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update faculty ' . $faculty->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating the faculty.')->withInput();
        }
    }

    public function destroy(Faculty $faculty)
    {
        DB::beginTransaction();

        try {
            $faculty->delete();

            DB::commit();
            Log::info('Faculty deleted', ['faculty_id' => $faculty->id]);

            return redirect()->route('faculties.index')->with('success', 'Faculty deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete faculty ' . $faculty->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting the faculty.');
        }
    }
}
