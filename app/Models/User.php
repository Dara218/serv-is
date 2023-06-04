<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        return $this->hasMany(Chat::class, 'id');
    }

    public function agenda(){
        return $this->hasMany(Agenda::class, 'id');
    }

    public function notification(){
        return $this->hasMany(Notification::class, 'user_id');
    }
}
