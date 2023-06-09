<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentService extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function review(){
        return $this->hasMany(Review::class, 'agent_service_id');
    }

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }
}
