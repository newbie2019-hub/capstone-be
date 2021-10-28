<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model
{
    use HasFactory;
    public $guarded = [];

    public function user(){
        return $this->belongsTo(UserAccount::class, 'user_account_id', 'id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
