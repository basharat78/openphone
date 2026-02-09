<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'dispatcher_id',
        'openphone_message_id',
        'direction',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function dispatcher()
    {
        return $this->belongsTo(Dispatcher::class);
    }
}
