<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailedUser extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'availed_to');
    }

    public function availedBy(){
        return $this->belongsTo(User::class, 'availed_by');
    }
}
