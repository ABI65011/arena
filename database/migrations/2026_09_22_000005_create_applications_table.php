<?php

// meow meow meow

use App\Helpers\ApplicationStatus;
use App\Helpers\ApplicationType;
use App\Helpers\MaritalStatus;
use App\Helpers\ReferralSource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->unique();
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->foreignId('intake_id')->constrained('intakes')->restrictOnDelete();
            $table->enum('application_type', array_column(ApplicationType::cases(), 'value'));
            $table->enum('status', array_column(ApplicationStatus::cases(), 'value'))->default(ApplicationStatus::Draft->value);
            $table->string('current_step')->nullable();
            $table->timestamp('submitted_at')->nullable();

            // Background (moved from applicants — can change between applications)
            $table->string('country_of_residence');
            $table->string('region')->nullable();
            $table->string('district')->nullable();
            $table->string('home_diocese')->nullable();
            $table->string('religious_affiliation')->nullable();
            $table->enum('marital_status', array_column(MaritalStatus::cases(), 'value'))->nullable();
            $table->string('marriage_type')->nullable();
            $table->string('spouse_name')->nullable();

            // Additional info (moved from applicants)
            $table->boolean('has_disability')->default(false);
            $table->string('disability_type')->nullable();
            $table->enum('referral_source', array_column(ReferralSource::cases(), 'value'))->nullable();
            $table->string('referrer_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
