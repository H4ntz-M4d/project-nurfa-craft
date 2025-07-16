<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotSession extends Model
{
    protected $table = 'chatbot_sessions';

    public $timestamps = true;

    protected $fillable =
    [
        'id',
        'session_id',
    ];

}
