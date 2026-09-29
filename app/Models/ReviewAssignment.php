<?php

// meow meow meow

namespace App\Models;

use App\Helpers\ReviewAssignmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'faculty_id',
        'officer_id',
        'assigned_by',
        'status',
        'assigned_at',
        'completed_at',
    ];

    protected $casts = [
        'status' => ReviewAssignmentStatus::class,
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
