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
        return response()->json(Activity::where('log_name', 'not like', '%Admin%')->with(['subject', 'user'  => function($query){
            $query->withTrashed();
        }, 'user.userinfo'  => function($query){
            $query->withTrashed();
        }])->latest()->get());
    }
    
}
