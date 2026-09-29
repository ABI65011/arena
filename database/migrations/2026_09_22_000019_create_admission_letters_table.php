<?php

// meow meow meow

use App\Helpers\AdmissionLetterType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admission_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_decision_id')->constrained('admission_decisions')->cascadeOnDelete();
            $table->enum('type', array_column(AdmissionLetterType::cases(), 'value'));
            $table->string('reference_no')->unique();
            $table->string('pdf_path');
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_letters');
    }
};
