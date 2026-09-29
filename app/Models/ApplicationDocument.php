<?php

// meow meow meow

namespace App\Models;

use App\Helpers\ValidationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'document_type_id',
        'original_name',
        'file_path',
        'mime_type',
        'size_kb',
        'validation_status',
        'validation_message',
    ];

    protected $casts = [
        'validation_status' => ValidationStatus::class,
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
