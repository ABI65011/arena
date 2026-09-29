<?php

// meow meow meow

namespace App\Models;

use App\Helpers\RuleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntryRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'programme_id',
        'rule_type',
        'subject',
        'operator',
        'value',
        'description',
        'is_active',
    ];

    protected $casts = [
        'rule_type' => RuleType::class,
        'is_active' => 'boolean',
    ];

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }
}
