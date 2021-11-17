<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationUser extends Model
{
    use SoftDeletes, HasFactory;
    public $guarded = [];

    public function user(){
        return $this->belongsTo(UserAccount::class, 'user_account_id', 'id')->withTrashed();
    }

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    // public function userinfo(){
    //     return $this->belongsTo(UserInfo::class, 'user_account_id', 'id');
    // }
}
