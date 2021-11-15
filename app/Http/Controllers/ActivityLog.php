<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return response()->json(Activity::with(['user:id,email,type,user_info_id', 'user.userinfo:id,first_name,middle_name,last_name'])->latest()->paginate(10));
    }
    
}
