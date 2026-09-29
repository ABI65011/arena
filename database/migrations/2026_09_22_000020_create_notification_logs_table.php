<?php

// meow meow meow

use App\Helpers\Channel;
use App\Helpers\NotificationLogStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->enum('channel', array_column(Channel::cases(), 'value'));
            $table->string('template');
            $table->string('recipient');
            $table->text('message')->nullable();
            $table->enum('status', array_column(NotificationLogStatus::cases(), 'value'))->default(NotificationLogStatus::Pending->value);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
