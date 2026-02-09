<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Call;
use App\Models\User;

class QcScore extends Model
{
    protected $fillable = [
        'call_id',
        'qc_agent_id',
        'communication_score',
        'confidence_score',
        'professionalism_score',
        'closing_score',
        'remarks',
        'is_locked'
    ];

    public function call()
    {
        return $this->belongsTo(Call::class);
    }

    public function qcAgent()
    {
        return $this->belongsTo(User::class, 'qc_agent_id');
    }
}
