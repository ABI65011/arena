<?php

// meow meow meow

use App\Helpers\Priority;
use App\Helpers\StudyMode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_programme_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->foreignId('programme_id')->constrained('programmes')->restrictOnDelete();
            $table->enum('priority', array_column(Priority::cases(), 'value'));
            $table->enum('study_mode', array_column(StudyMode::cases(), 'value'));
            $table->timestamps();

            $table->unique(['application_id', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_programme_choices');
    }
};
