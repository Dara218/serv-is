<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userPhoto(){
        return $this->belongsTo(UserPhoto::class, 'user_id');
    }

    public function sentRequest(){
        return $this->hasOne(SentRequest::class, 'request_to', 'user_id');
    }
}
