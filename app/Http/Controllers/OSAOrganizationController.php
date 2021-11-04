<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OSAOrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $accounts = Organization::with(['members', 'members.userinfo', 'members.userinfo.role', 'members.posts', 'members.posts.postcontent'])->paginate(8);
        return response()->json($accounts);
    }
}
