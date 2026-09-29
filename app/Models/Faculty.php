<?php

// meow meow meow

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    public function programmes(): HasMany
    {
        return $this->hasMany(Programme::class);
    }

    public function facultyOfficers(): HasMany
    {
        return $this->hasMany(FacultyOfficer::class);
    }

    public function reviewAssignments(): HasMany
    {
        return $this->hasMany(ReviewAssignment::class);
    }
}
