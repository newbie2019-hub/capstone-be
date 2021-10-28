<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgUnitRole extends Model
{
    use HasFactory;
    public $guarded = [];

    public function accounts(){
        return $this->hasMany(UserInfo::class, 'org_unit_role_id', 'id');
    }

    public function permission(){
        return $this->hasManyThrough(Permission::class, PermissionRole::class, 'org_unit_role_id', 'id', 'id', 'permission_id');
    }
}
