<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentRequest extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'request_by');
    }

    public function agenda(){
        return $this->hasOne(Agenda::class, 'user_id', 'request_to');
    }
}
