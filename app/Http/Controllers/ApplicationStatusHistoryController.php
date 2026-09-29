<?php

// meow meow meow

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatusHistory;

/**
 * Read-only: rows are written by ApplicationService::changeStatus()
 * (the Move Status action on the application's show page), not
 * created directly by an admin.
 */
class ApplicationStatusHistoryController extends Controller
{
    public function index(Application $application)
    {
        $statusHistories = $application->statusHistories()->with('changedBy')->latest('created_at')->get();

        return view('admin.application-status-histories.index', compact('application', 'statusHistories'));
    }

    public function show(Application $application, ApplicationStatusHistory $statusHistory)
    {
        $statusHistory->load('changedBy');

        return view('admin.application-status-histories.show', compact('application', 'statusHistory'));
    }
}
