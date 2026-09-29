<?php

// meow meow meow

namespace App\Models;

use App\Helpers\Month;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Intake extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'month',
        'academic_year',
        'application_open_date',
        'application_close_date',
        'is_active',
    ];

    protected $casts = [
        'month' => Month::class,
        'application_open_date' => 'date',
        'application_close_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
