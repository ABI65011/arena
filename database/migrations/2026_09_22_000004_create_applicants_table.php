<?php

// meow meow meow

use App\Helpers\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('surname');
            $table->string('other_name');
            $table->string('title')->nullable(); // Rev., Dr., Mr., Mrs., Miss
            $table->date('date_of_birth');
            $table->enum('gender', array_column(Gender::cases(), 'value'));
            $table->string('phone');
            $table->string('nationality');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
