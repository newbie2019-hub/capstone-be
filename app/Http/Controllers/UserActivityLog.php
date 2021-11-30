<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class UserActivityLog extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        return response()->json(Activity::where('log_name', 'not like', '%Admin%')->where('causer_id', auth()->user()->id)->with(['user:id,email,type,user_info_id', 'user.userinfo:id,first_name,middle_name,last_name'])->latest()->paginate(10));
    }

    public function summary(){
        return response()->json(Activity::where('causer_id', auth()->user()->id)->with(['user:id,email,type,user_info_id', 'user.userinfo:id,first_name,middle_name,last_name'])->latest()->take(4)->get());
    }

    public function search(Request $request){
        $activity = Activity::where('causer_id', auth()->user()->id)->where('log_name', 'like', '%'.$request->search.'%')->orWhere('event', 'like', '%'.$request->search.'%')->with(['user:id,email,type,user_info_id', 'user.userinfo:id,first_name,middle_name,last_name'])->latest()->paginate(10);
        return response()->json($activity);
    }
}
