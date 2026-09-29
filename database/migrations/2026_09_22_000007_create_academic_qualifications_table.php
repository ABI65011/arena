<?php

// meow meow meow

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->string('institution_name');
            $table->string('institution_address')->nullable();
            $table->string('from_year');
            $table->string('to_year');
            $table->string('qualification');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_qualifications');
    }
};
