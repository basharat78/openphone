<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispatcher extends Model
{
    protected $fillable = ['name', 'email', 'openphone_id'];

    public function calls()
    {
        return $this->hasMany(Call::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
