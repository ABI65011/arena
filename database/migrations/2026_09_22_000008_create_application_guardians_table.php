<?php

// meow meow meow

use App\Helpers\ApplicationGuardianType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->enum('type', array_column(ApplicationGuardianType::cases(), 'value'));
            $table->string('name')->nullable();
            $table->string('po_box')->nullable();
            $table->string('town')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();

            $table->unique(['application_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_guardians');
    }
};
