<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgUnit extends Model
{
    use HasFactory;
    public $guarded = [];

    public function accounts(){
        return $this->hasMany(UserInfo::class, 'org_unit_id', 'id');
    }
}
