<?php

// meow meow meow

namespace App\Models;

use App\Helpers\ApplicationStatus;
use App\Helpers\ApplicationType;
use App\Helpers\MaritalStatus;
use App\Helpers\ReferralSource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_no',
        'applicant_id',
        'intake_id',
        'application_type',
        'status',
        'current_step',
        'submitted_at',
        'country_of_residence',
        'region',
        'district',
        'home_diocese',
        'religious_affiliation',
        'marital_status',
        'marriage_type',
        'spouse_name',
        'has_disability',
        'disability_type',
        'referral_source',
        'referrer_name',
    ];

    protected $casts = [
        'application_type' => ApplicationType::class,
        'status' => ApplicationStatus::class,
        'submitted_at' => 'datetime',
        'marital_status' => MaritalStatus::class,
        'has_disability' => 'boolean',
        'referral_source' => ReferralSource::class,
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function intake(): BelongsTo
    {
        return $this->belongsTo(Intake::class);
    }

    public function programmeChoices(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeChoice::class);
    }

    public function academicQualifications(): HasMany
    {
        return $this->hasMany(AcademicQualification::class);
    }

    public function guardians(): HasMany
    {
        return $this->hasMany(ApplicationGuardian::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ApplicationStatusHistory::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ApplicationPayment::class);
    }

    public function eligibilityResults(): HasMany
    {
        return $this->hasMany(EligibilityResult::class);
    }

    public function reviewAssignments(): HasMany
    {
        return $this->hasMany(ReviewAssignment::class);
    }

    public function admissionDecisions(): HasMany
    {
        return $this->hasMany(AdmissionDecision::class);
    }

    public function notificationLogs(): HasMany
    {
        return $this->hasMany(NotificationLog::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }
}
