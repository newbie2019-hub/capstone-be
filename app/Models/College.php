<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    public $guarded = [];

    public function courses(){
        return $this->hasMany(Course::class, 'college_id', 'id');
    }

    public function goals(){
        return $this->hasMany(Goal::class, 'college_id', 'id');
    }

    public function objectives(){
        return $this->hasMany(Objective::class, 'college_id', 'id');
    }
}
