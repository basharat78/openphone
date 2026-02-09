<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dispatcher;
use App\Models\QcScore;

class Call extends Model
{
    protected $fillable = [
        'dispatcher_id',
        'openphone_call_id',
        'from_number',
        'to_number',
        'direction',
        'status',
        'recording_url',
        'duration',
        'called_at',
    ];

    protected $casts = [
        'called_at' => 'datetime',
    ];

    public function dispatcher()
    {
        return $this->belongsTo(Dispatcher::class);
    }

    public function qcScore()
    {
        return $this->hasOne(QcScore::class);
    }
}
