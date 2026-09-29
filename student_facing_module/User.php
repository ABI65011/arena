<?php

// meow meow meow

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function applicant(): HasOne
    {
        return $this->hasOne(Applicant::class);
    }

    /**
     * "Is this user a student" — checked by EnsureUserIsApplicant, not a
     * role. True the moment their first application creates an applicant
     * record; false before that, including for a user who is only an
     * admin/staff account.
     */
    public function isStudent(): bool
    {
        return $this->applicant()->exists();
    }
}
