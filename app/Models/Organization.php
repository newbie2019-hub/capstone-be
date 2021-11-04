<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Organization extends Model
{
    use HasFactory;
    public $guarded = [];

    public function department(){
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function members(){
        return $this->hasManyThrough(UserAccount::class, OrganizationUser::class, 'organization_id', 'id', 'id', 'user_account_id');
    }

    public function adviser(){
        return $this->hasOneThrough(UserAccount::class, OrganizationAdmin::class, 'organization_id', 'id', 'id', 'user_account_id');
    }
}
