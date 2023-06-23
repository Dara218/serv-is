<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function role(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ["customer", "agent", "admin"][$value],
        );
    }

    public function validDocuments(){
        return $this->hasOne(ValidDocument::class, 'user_id');
    }

    public function transaction(){
        return $this->hasMany(Transaction::class, 'id');
    }

    public function userPhoto(){
        return $this->hasOne(UserPhoto::class, 'user_id');
    }

    public function messageFromSender(){
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messageFromReceiver(){
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function chat(){
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function chatFromAgent(){
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    public function agenda(){
        return $this->hasMany(Agenda::class, 'id');
    }

    public function notification(){
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function agentService(){
        return $this->hasOne(AgentService::class, 'user_id');
    }

    public function review(){
        return $this->hasMany(Review::class, 'user_id');
    }

    public function adminRequest(){
        return $this->hasOne(AdminRequest::class, 'request_by');
    }

    public function serviceAddress(){
        return $this->hasOne(ServiceAddress::class, 'user_id');
    }

    public function availedPricingPlan(){
        return $this->hasMany(AvailedPricingPlan::class, 'availed_by_id');
    }
}
