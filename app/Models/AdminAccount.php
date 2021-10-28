<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class AdminAccount extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    
    public $fillable = ['email', 'password'];
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function admininfo(){
        return $this->belongsTo(AdminAccountInfo::class, 'admin_account_info_id', 'id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
