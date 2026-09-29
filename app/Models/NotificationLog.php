<?php

// meow meow meow

namespace App\Models;

use App\Helpers\Channel;
use App\Helpers\NotificationLogStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'channel',
        'template',
        'recipient',
        'message',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'channel' => Channel::class,
        'status' => NotificationLogStatus::class,
        'sent_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
