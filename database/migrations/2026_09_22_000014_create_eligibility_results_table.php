<?php

// meow meow meow

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eligibility_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->foreignId('programme_choice_id')->constrained('application_programme_choices')->cascadeOnDelete();
            $table->boolean('is_eligible')->default(false);
            $table->json('checks')->nullable();
            $table->json('failure_reasons')->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eligibility_results');
    }
};
