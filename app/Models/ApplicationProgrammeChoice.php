<?php

// meow meow meow

namespace App\Models;

use App\Helpers\Priority;
use App\Helpers\StudyMode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationProgrammeChoice extends Model
{
    use HasFactory;

    protected $table = 'application_programme_choices';

    protected $fillable = [
        'application_id',
        'programme_id',
        'priority',
        'study_mode',
    ];

    protected $casts = [
        'priority' => Priority::class,
        'study_mode' => StudyMode::class,
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }

    public function eligibilityResults(): HasMany
    {
        return $this->hasMany(EligibilityResult::class, 'programme_choice_id');
    }

    public function admissionDecisions(): HasMany
    {
        return $this->hasMany(AdmissionDecision::class, 'programme_choice_id');
    }
}
