<?php

// meow meow meow

use App\Helpers\RuleType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entry_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programme_id')->constrained('programmes')->cascadeOnDelete();
            $table->enum('rule_type', array_column(RuleType::cases(), 'value'));
            $table->string('subject')->nullable();
            $table->string('operator')->nullable(); // e.g. >=, ==, in
            $table->string('value');
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entry_requirements');
    }
};
