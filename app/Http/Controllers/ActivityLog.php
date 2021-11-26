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
        return response()->json(Activity::with(['subject', 'user'  => function($query){
            $query->withTrashed();
        }, 'user.userinfo'  => function($query){
            $query->withTrashed();
        }])->latest()->paginate(10));
    }

    public function search(Request $request){
        $activity = Activity::where('log_name', 'like', '%'.$request->search.'%')
        ->orWhere('event', 'like', '%'.$request->search.'%')
        ->with(['subject', 'user'  => function($query){
            $query->withTrashed();
        }, 'user.userinfo' => function($query){
            $query->withTrashed();
        }])->latest()->paginate(10);

        return response()->json($activity);
    }
    
}
