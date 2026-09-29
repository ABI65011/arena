<?php

use App\Http\Controllers\AcademicQualificationController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationGuardianController;
use App\Http\Controllers\ApplicationProgrammeChoiceController;
use App\Http\Controllers\ApplicationStatusHistoryController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('users', UserController::class);

// Faculties route group
Route::controller(FacultyController::class)->prefix('faculties')->group(function () {
    Route::get('', 'index')->name('faculties.index');
    Route::get('create', 'create')->name('faculties.create');
    Route::post('', 'store')->name('faculties.store');
    Route::get('{faculty}', 'show')->name('faculties.show');
    Route::get('{faculty}/edit', 'edit')->name('faculties.edit');
    Route::put('{faculty}', 'update')->name('faculties.update');
    Route::delete('{faculty}', 'destroy')->name('faculties.destroy');
});

// Programmes route group
Route::controller(ProgrammeController::class)->prefix('programmes')->group(function () {
    Route::get('', 'index')->name('programmes.index');
    Route::get('create', 'create')->name('programmes.create');
    Route::post('', 'store')->name('programmes.store');
    Route::get('{programme}', 'show')->name('programmes.show');
    Route::get('{programme}/edit', 'edit')->name('programmes.edit');
    Route::put('{programme}', 'update')->name('programmes.update');
    Route::delete('{programme}', 'destroy')->name('programmes.destroy');
});

// Intakes route group
Route::controller(IntakeController::class)->prefix('intakes')->group(function () {
    Route::get('', 'index')->name('intakes.index');
    Route::get('create', 'create')->name('intakes.create');
    Route::post('', 'store')->name('intakes.store');
    Route::get('{intake}', 'show')->name('intakes.show');
    Route::get('{intake}/edit', 'edit')->name('intakes.edit');
    Route::put('{intake}', 'update')->name('intakes.update');
    Route::delete('{intake}', 'destroy')->name('intakes.destroy');
});

// Applicants route group (Except create & store)
Route::controller(ApplicantController::class)->prefix('applicants')->group(function () {
    Route::get('', 'index')->name('applicants.index');
    Route::get('{applicant}', 'show')->name('applicants.show');
    Route::get('{applicant}/edit', 'edit')->name('applicants.edit');
    Route::put('{applicant}', 'update')->name('applicants.update');
    Route::delete('{applicant}', 'destroy')->name('applicants.destroy');
});

// Applications route group
Route::controller(ApplicationController::class)->prefix('applications')->group(function () {
    Route::get('', 'index')->name('applications.index');
    Route::get('create', 'create')->name('applications.create');
    Route::post('', 'store')->name('applications.store');

    Route::get('{application}', 'show')->name('applications.show');
    Route::get('{application}/edit', 'edit')->name('applications.edit');
    Route::put('{application}', 'update')->name('applications.update');

    // Custom move-status route
    Route::put('{application}/move-status', 'moveStatus')->name('applications.move-status');

    Route::delete('{application}', 'destroy')->name('applications.destroy');
});

// ----------------------------------------------------------------------
// Nested Application Route Groups
// ----------------------------------------------------------------------

// Application Programme Choices route group
Route::controller(ApplicationProgrammeChoiceController::class)->prefix('applications/{application}/programme-choices')->group(function () {
        Route::get('', 'index')->name('applications.programme-choices.index');
        Route::get('create', 'create')->name('applications.programme-choices.create');
        Route::post('', 'store')->name('applications.programme-choices.store');

        Route::get('{programmeChoice}', 'show')->name('applications.programme-choices.show');
        Route::get('{programmeChoice}/edit', 'edit')->name('applications.programme-choices.edit');
        Route::put('{programmeChoice}', 'update')->name('applications.programme-choices.update');
        Route::delete('{programmeChoice}', 'destroy')->name('applications.programme-choices.destroy');
});

// Application Academic Qualifications route group
Route::controller(AcademicQualificationController::class)->prefix('applications/{application}/academic-qualifications')->group(function () {
        Route::get('', 'index')->name('applications.academic-qualifications.index');
        Route::get('create', 'create')->name('applications.academic-qualifications.create');
        Route::post('', 'store')->name('applications.academic-qualifications.store');

        Route::get('{academicQualification}', 'show')->name('applications.academic-qualifications.show');
        Route::get('{academicQualification}/edit', 'edit')->name('applications.academic-qualifications.edit');
        Route::put('{academicQualification}', 'update')->name('applications.academic-qualifications.update');
        Route::delete('{academicQualification}', 'destroy')->name('applications.academic-qualifications.destroy');
});

// Application Guardians route group
Route::controller(ApplicationGuardianController::class)->prefix('applications/{application}/guardians')->group(function () {
        Route::get('', 'index')->name('applications.guardians.index');
        Route::get('create', 'create')->name('applications.guardians.create');
        Route::post('', 'store')->name('applications.guardians.store');

        Route::get('{guardian}', 'show')->name('applications.guardians.show');
        Route::get('{guardian}/edit', 'edit')->name('applications.guardians.edit');
        Route::put('{guardian}', 'update')->name('applications.guardians.update');
        Route::delete('{guardian}', 'destroy')->name('applications.guardians.destroy');
});

// Application Status Histories route group
Route::controller(ApplicationStatusHistoryController::class)->prefix('applications/{application}/status-histories')->group(function () {
    Route::get('', 'index')->name('applications.status-histories.index');
    Route::get('{statusHistory}', 'show')->name('applications.status-histories.show');
});
