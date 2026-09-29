<?php

// meow meow meow

namespace App\Models;

use App\Helpers\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'surname',
        'other_name',
        'title',
        'date_of_birth',
        'gender',
        'phone',
        'nationality',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'gender' => Gender::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
