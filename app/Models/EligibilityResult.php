<?php

// meow meow meow

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EligibilityResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'programme_choice_id',
        'is_eligible',
        'checks',
        'failure_reasons',
        'checked_at',
    ];

    protected $casts = [
        'is_eligible' => 'boolean',
        'checks' => 'array',
        'failure_reasons' => 'array',
        'checked_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function programmeChoice(): BelongsTo
    {
        return $this->belongsTo(ApplicationProgrammeChoice::class, 'programme_choice_id');
    }
}
