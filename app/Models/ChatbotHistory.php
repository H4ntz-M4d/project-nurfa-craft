<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotHistory extends Model
{
    protected $table = 'chatbot_histories';

    public $timestamps = true;

    protected $fillable =
    [
        'id',
        'chatbot_session_id',
        'role',
        'message',
    ];
}
