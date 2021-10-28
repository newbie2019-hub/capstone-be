<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationUser extends Model
{
    use HasFactory;
    public $guarded = [];

    public function user(){
        return $this->belongsTo(UserAccount::class, 'user_account_id', 'id');
    }

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    // public function userinfo(){
    //     return $this->belongsTo(UserInfo::class, 'user_account_id', 'id');
    // }
}
