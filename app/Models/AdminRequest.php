<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRequest extends Model
{
    use HasFactory;

    public function validDocument(){
        return $this->hasOne(ValidDocument::class, 'user_id', 'request_by');
    }

    // public function notification(){
    //     return $this->hasOne(Notification::class, 'from_user_id');
    // }
}
