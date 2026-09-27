<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceivedEmail extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'message_id',
        'from_email',
        'from_name',
        'subject',
        'body',
        'received_at',
        'is_read',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'is_read' => 'boolean',
    ];
}
