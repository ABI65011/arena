<?php

// meow meow meow

namespace App\Models;

use App\Helpers\AdmissionLetterType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdmissionLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_decision_id',
        'type',
        'reference_no',
        'pdf_path',
        'generated_by',
        'generated_at',
    ];

    protected $casts = [
        'type' => AdmissionLetterType::class,
        'generated_at' => 'datetime',
    ];

    public function admissionDecision(): BelongsTo
    {
        return $this->belongsTo(AdmissionDecision::class);
    }

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
