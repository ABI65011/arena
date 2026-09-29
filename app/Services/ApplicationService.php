<?php

// meow meow meow

namespace App\Services;

use App\Helpers\ApplicationStatus;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Shared create/update logic for applications, so both the admin form
 * and (later) an applicant-facing form can call the same code instead
 * of duplicating the user -> applicant -> application sequence.
 */
class ApplicationService
{
    /**
     * Create a user (optional), an applicant (if the user doesn't have
     * one yet), and an application, plus its programme choices, academic
     * qualifications and guardians — all in one transaction.
     *
     * @param  array  $data  Validated form data. Expected keys:
     *   account_type: 'existing'|'new'
     *   user_id: required when account_type = existing
     *   email, password: required when account_type = new
     *   surname, other_name, title, date_of_birth, gender, phone, nationality
     *   intake_id, application_type
     *   country_of_residence, region, district, home_diocese, religious_affiliation,
     *   marital_status, marriage_type, spouse_name
     *   has_disability, disability_type, referral_source, referrer_name
     *   programme_choices: array keyed by priority ('1st'/'2nd'), each ['programme_id','study_mode']
     *   academic_qualifications: array of ['institution_name','institution_address','from_year','to_year','qualification']
     *   guardians: array keyed by type, each ['name','po_box','town','telephone','email']
     */
    public function createApplication(array $data): Application
    {
        return DB::transaction(function () use ($data) {
            $user = $this->resolveUser($data);
            $applicant = $this->resolveApplicant($user, $data);

            $application = $applicant->applications()->create([
                'application_no' => $this->generateApplicationNo(),
                'intake_id' => $data['intake_id'],
                'application_type' => $data['application_type'],
                'status' => ApplicationStatus::Draft,
                'country_of_residence' => $data['country_of_residence'],
                'region' => $data['region'] ?? null,
                'district' => $data['district'] ?? null,
                'home_diocese' => $data['home_diocese'] ?? null,
                'religious_affiliation' => $data['religious_affiliation'] ?? null,
                'marital_status' => $data['marital_status'] ?? null,
                'marriage_type' => $data['marriage_type'] ?? null,
                'spouse_name' => $data['spouse_name'] ?? null,
                'has_disability' => $data['has_disability'] ?? false,
                'disability_type' => $data['disability_type'] ?? null,
                'referral_source' => $data['referral_source'] ?? null,
                'referrer_name' => $data['referrer_name'] ?? null,
            ]);

            // First status-history row, so Draft shows up in the trail from the start.
            $application->statusHistories()->create([
                'from_status' => null,
                'to_status' => ApplicationStatus::Draft->value,
                'changed_by' => auth()->id(),
                'created_at' => now(),
            ]);

            foreach ($data['programme_choices'] ?? [] as $priority => $choice) {
                if (empty($choice['programme_id'])) {
                    continue;
                }

                $application->programmeChoices()->create([
                    'programme_id' => $choice['programme_id'],
                    'priority' => $priority,
                    'study_mode' => $choice['study_mode'],
                ]);
            }

            foreach ($data['academic_qualifications'] ?? [] as $qualification) {
                if (empty($qualification['institution_name'])) {
                    continue;
                }

                $application->academicQualifications()->create($qualification);
            }

            foreach ($data['guardians'] ?? [] as $type => $guardian) {
                if (empty($guardian['name'])) {
                    continue;
                }

                $application->guardians()->create(array_merge($guardian, ['type' => $type]));
            }

            Log::info('Application created', [
                'application_id' => $application->id,
                'applicant_id' => $applicant->id,
            ]);

            return $application;
        });
    }

    /**
     * Move an application to a new status, writing a row to
     * application_status_histories so the change is never silent.
     */
    public function changeStatus(Application $application, string $toStatus, ?string $remarks = null): Application
    {
        return DB::transaction(function () use ($application, $toStatus, $remarks) {
            $fromStatus = $application->status?->value;

            $application->update(['status' => $toStatus]);

            $application->statusHistories()->create([
                'from_status' => $fromStatus,
                'to_status' => $toStatus,
                'changed_by' => auth()->id(),
                'remarks' => $remarks,
                'created_at' => now(),
            ]);

            Log::info('Application status changed', [
                'application_id' => $application->id,
                'from' => $fromStatus,
                'to' => $toStatus,
            ]);

            return $application->fresh();
        });
    }

    /**
     * Create the user record when the admin chose "Create new account",
     * or fetch the selected existing user otherwise.
     */
    protected function resolveUser(array $data): User
    {
        if ($data['account_type'] === 'existing') {
            return User::findOrFail($data['user_id']);
        }

        return User::create([
            'name' => trim($data['other_name'] . ' ' . $data['surname']),
            'email' => $data['email'],
            'password' => $data['password'], // hashed by the model's 'password' => 'hashed' cast
        ]);
    }

    /**
     * Reuse the user's existing applicant record if there is one,
     * otherwise create it from the identity fields on the form.
     */
    protected function resolveApplicant(User $user, array $data): Applicant
    {
        if ($existing = $user->applicant) {
            return $existing;
        }

        return $user->applicant()->create([
            'surname' => $data['surname'],
            'other_name' => $data['other_name'],
            'title' => $data['title'] ?? null,
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'nationality' => $data['nationality'],
        ]);
    }

    /**
     * Format: APP/{year}/{sequence, zero-padded to 6}. Sequence resets each
     * calendar year and counts applications created so far that year.
     */
    protected function generateApplicationNo(): string
    {
        $year = now()->year;
        $count = Application::whereYear('created_at', $year)->lockForUpdate()->count();

        return sprintf('APP/%d/%06d', $year, $count + 1);
    }
}
