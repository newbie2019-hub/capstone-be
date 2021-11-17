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
        return response()->json(Activity::with(['subject', 'user:id,email,type,user_info_id', 'user.userinfo:id,first_name,middle_name,last_name'])->latest()->paginate(10));
    }

    public function search(Request $request){
        $activity = Activity::where('log_name', 'like', '%'.$request->search.'%')->orWhere('event', 'like', '%'.$request->search.'%')->with(['subject', 'user:id,email,type,user_info_id', 'user.userinfo:id,first_name,middle_name,last_name'])->latest()->paginate(10);
        return response()->json($activity);
    }
    
}
