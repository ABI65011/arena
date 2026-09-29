<?php

// meow meow meow

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'institution_name',
        'institution_address',
        'from_year',
        'to_year',
        'qualification',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
