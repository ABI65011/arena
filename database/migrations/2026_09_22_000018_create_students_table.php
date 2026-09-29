<?php

// meow meow meow

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_number')->unique();
            $table->foreignId('application_id')->constrained('applications')->restrictOnDelete();
            $table->foreignId('programme_id')->constrained('programmes')->restrictOnDelete();
            $table->foreignId('intake_id')->constrained('intakes')->restrictOnDelete();
            $table->timestamp('admitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
