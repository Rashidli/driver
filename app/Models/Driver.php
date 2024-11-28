<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    protected $fillable = ['surname', 'name', 'middlename', 'phone', 'password', 'status'];

    protected $hidden = ['password'];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class)->withTimestamps()->withTrashed();
    }
    
}
