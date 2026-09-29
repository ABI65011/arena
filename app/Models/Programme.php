<?php

// meow meow meow

namespace App\Models;

use App\Helpers\ProgrammeLevels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Programme extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'name',
        'code',
        'level',
    ];

    protected $casts = [
        'level' => ProgrammeLevels::class,
    ];

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function programmeChoices(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeChoice::class);
    }

    public function entryRequirements(): HasMany
    {
        return $this->hasMany(EntryRequirement::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
