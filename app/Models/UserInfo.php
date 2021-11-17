<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
    use SoftDeletes, HasFactory;
    public $guarded = [];

    public function organization(){
        return $this->hasOneThrough(Organization::class, OrganizationUser::class, 'user_account_id', 'id', 'id', 'organization_id');
    }

    public function department(){
        return $this->hasOneThrough(Department::class, DepartmentUser::class, 'user_account_id', 'id', 'id', 'department_id');
    }

    public function role(){
        return $this->belongsTo(OrgUnitRole::class, 'org_unit_role_id', 'id');
    }
}
