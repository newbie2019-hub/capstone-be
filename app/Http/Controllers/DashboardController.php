<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faqs;
use App\Models\Organization;
use App\Models\OrgUnit;
use App\Models\Post;
use App\Models\Unit;
use App\Models\UserAccount;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function summary() {
        $usercount = UserAccount::count();
        $unitcount = Department::count();
        $orgcount = Organization::count();
        $post = Post::count();
        return response()->json(['users' => $usercount, 'unit' => $unitcount, 'org' => $orgcount, 'post' => $post]);
    }
}
