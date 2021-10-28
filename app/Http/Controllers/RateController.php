<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RateController extends Controller
{
    
    public function index(){
        return response()->json(Rating::latest()->paginate(5));
    }

    public function store(Request $request){
        Rating::create([
            'emoji' => $request->emoji,
            'suggestion' => $request->suggestion
        ]);
        return response()->json(['msg' => 'success'], 200);
    }
}
