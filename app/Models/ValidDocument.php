<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidDocument extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasOne(User::class, 'id');
    }

    public function notification(){
        return $this->hasOne(Notification::class, 'from_user_id', 'user_id');
    }
}
