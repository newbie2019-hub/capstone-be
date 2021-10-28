<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    use HasFactory;
    public $guarded = [];

    public function college(){
        return $this->belongsTo(College::class,'college_id', 'id');
    }
}
