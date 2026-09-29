<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // 'password' is cast to 'hashed' on the model, so it's hashed
            // automatically on save - no Hash::make() needed here.
            $user = User::create($validator->validated());

            DB::commit();
            Log::info('User created', ['user_id' => $user->id]);

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to create user: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while creating the user.')->withInput();
        }
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // blank = keep current password
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        DB::beginTransaction();

        try {
            $user->update($data);

            DB::commit();
            Log::info('User updated', ['user_id' => $user->id]);

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update user ' . $user->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating the user.')->withInput();
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {
            $user->delete(); // soft delete - sets deleted_at, row stays in the table

            DB::commit();
            Log::info('User soft-deleted', ['user_id' => $user->id]);

            return redirect()->route('users.index')->with('success', 'User moved to trash.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete user ' . $user->id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting the user.');
        }
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->latest('deleted_at')->paginate(20);

        return view('users.trashed', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        DB::beginTransaction();

        try {
            $user->restore();

            DB::commit();
            Log::info('User restored', ['user_id' => $user->id]);

            return redirect()->route('users.trashed')->with('success', 'User restored successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to restore user ' . $id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while restoring the user.');
        }
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        DB::beginTransaction();

        try {
            $user->forceDelete();

            DB::commit();
            Log::info('User permanently deleted', ['user_id' => $id]);

            return redirect()->route('users.trashed')->with('success', 'User permanently deleted.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to permanently delete user ' . $id . ': ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while permanently deleting the user.');
        }
    }
}