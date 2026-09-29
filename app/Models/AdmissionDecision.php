<?php

// meow meow meow

namespace App\Models;

use App\Helpers\Decision;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdmissionDecision extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'programme_choice_id',
        'reviewer_id',
        'decision',
        'waitlist_position',
        'remarks',
        'decided_at',
    ];

    protected $casts = [
        'decision' => Decision::class,
        'decided_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function programmeChoice(): BelongsTo
    {
        return $this->belongsTo(ApplicationProgrammeChoice::class, 'programme_choice_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function admissionLetter(): HasOne
    {
        return $this->hasOne(AdmissionLetter::class);
    }
}
