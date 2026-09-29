<?php

// meow meow meow

namespace App\Models;

use App\Helpers\ApplicationGuardianType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationGuardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'type',
        'name',
        'po_box',
        'town',
        'telephone',
        'email',
    ];

    protected $casts = [
        'type' => ApplicationGuardianType::class,
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
