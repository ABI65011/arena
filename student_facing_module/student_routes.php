<?php

// meow meow meow — for reference; merge into routes/web.php

use App\Http\Controllers\StudentApplicantController;
use App\Http\Controllers\StudentApplicationController;
use App\Http\Middleware\EnsureUserIsApplicant;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Student-facing routes
|--------------------------------------------------------------------------
| Reads auth()->user() but never establishes a session — login itself is
| built and owned elsewhere. These do nothing until a real session exists,
| which they will once this is merged into the combined system.
*/

// Open to any authenticated user, student or not — this is the route
// that CREATES the applicant record, so it can't require one to exist yet.
Route::middleware(['auth'])->group(function () {
    Route::get('apply', [StudentApplicationController::class, 'create'])->name('apply');
    Route::post('apply', [StudentApplicationController::class, 'store'])->name('apply.store');
});

// Everything else assumes the applicant record already exists.
Route::middleware(['auth', EnsureUserIsApplicant::class])->group(function () {
    Route::get('my-applications', [StudentApplicationController::class, 'index'])->name('my-applications.index');
    Route::get('my-applications/{application}', [StudentApplicationController::class, 'show'])->name('my-applications.show');
    Route::patch('my-applications/{application}/submit', [StudentApplicationController::class, 'submit'])->name('my-applications.submit');

    Route::get('my-profile', [StudentApplicantController::class, 'show'])->name('my-profile.show');
    Route::get('my-profile/edit', [StudentApplicantController::class, 'edit'])->name('my-profile.edit');
    Route::put('my-profile', [StudentApplicantController::class, 'update'])->name('my-profile.update');
});
