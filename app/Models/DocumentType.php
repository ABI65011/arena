<?php

// meow meow meow

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'allowed_mimes',
        'max_size_kb',
        'is_required',
    ];

    protected $casts = [
        'allowed_mimes' => 'array',
        'is_required' => 'boolean',
    ];

    public function applicationDocuments(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }
}
