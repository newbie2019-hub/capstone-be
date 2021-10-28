<?php

namespace App\Http\Controllers;

use App\Models\DepartmentUser;
use App\Models\OrganizationUser;
use App\Models\OrgUnitRole;
use App\Models\Post;
use App\Models\UserAccount;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function accountMembers(){
        if(auth()->user()->type == 'Organization'){
            $account = OrganizationUser::where('organization_id', auth()->user()->userinfo->organization->id)
            ->with(['user.userinfo', 'organization', 'user.userinfo.role'])
            ->where('user_account_id', '<>', auth()->user()->id)
            ->latest()->take(6)->get();
        }
        if(auth()->user()->type == 'Department'){
            $account = DepartmentUser::where('department_id', auth()->user()->userinfo->department->id)
            ->with(['user.userinfo', 'department', 'user.userinfo.role'])
            ->where('user_account_id', '<>', auth()->user()->id)
            ->latest()->take(6)->get();
        }

        return response()->json($account, 200);
    }

    public function summary(){
        if(auth()->user()->type == 'Organization'){
            $post = Post::whereHas('useraccount.userinfo.organization', function($query){
                $query->where('id', auth()->user()->userinfo->organization->id);
            })->with(['userinfo', 'userinfo.organization', 'userinfo.role'])->count();

            $members = OrganizationUser::where('organization_id', auth()->user()->userinfo->organization->id)->count();
        }
        
        if(auth()->user()->type == 'Department'){
            $post = Post::whereHas('useraccount.userinfo.department', function($query){
                $query->where('id', auth()->user()->userinfo->department->id);
            })->with(['userinfo', 'userinfo.department', 'userinfo.role'])->count();

            $members = DepartmentUser::where('department_id', auth()->user()->userinfo->department->id)->count();
        }

        return response()->json(['post' => $post, 'members' => $members]);
    }
}
