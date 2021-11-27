<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;

class UserAccount extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    protected $cascadeDeletes = ['userinfo', 'posts'];
    public $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function userinfo(){
        return $this->belongsTo(UserInfo::class, 'user_info_id', 'id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'user_account_id', 'id');
    }
    
    public function logs(){
        return $this->hasMany(Activity::class, 'causer_id', 'id')->latest();
    }
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

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
