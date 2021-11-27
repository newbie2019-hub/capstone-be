<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AdminActivityLog extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return response()->json(Activity::where('log_name', 'like', '%Admin%')->with(['subject', 'admin', 'admin.admininfo'])->latest()->paginate(10));
    }

    public function search(Request $request){
        $activity = Activity::where('log_name', 'like', '%Admin%')->where('log_name', 'like', '%'.$request->search.'%')
        ->where('event', 'like', '%'.$request->search.'%')
        ->with(['subject', 'admin', 'admin.admininfo'])->latest()->paginate(10);

        return response()->json($activity);
    }
    
}
