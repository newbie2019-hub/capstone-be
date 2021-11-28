<?php

namespace App\Http\Controllers;

use App\Models\DepartmentUser;
use App\Models\Faqs;
use App\Models\Organization;
use App\Models\OrganizationUser;
use App\Models\OrgUnitRole;
use App\Models\Post;
use App\Models\TelephoneDirectory;
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
            if(auth()->user()->userinfo->role['role'] == 'OSA'){
                $org = Organization::count();
                $faqs = Faqs::count();
                $tel = TelephoneDirectory::count();
                $post = Post::whereHas('useraccount', function($query){
                    $query->where('type', 'Organization');
                })->count();

                return response()->json(['post' => $post,'faqs' => $faqs, 'org' => $org, 'tel' => $tel]);
            }
            else {
                $post = Post::whereRelation('useraccount.userinfo.organization', 'id', auth()->user()->userinfo->organization->id)
                ->with(['useraccount.userinfo.organization'])->count();
    
                $members = OrganizationUser::where('organization_id', auth()->user()->userinfo->organization->id)->count();
            }
        }
        
        if(auth()->user()->type == 'Department'){
            $post = Post::whereHas('useraccount.userinfo.department', function($query){
                $query->where('id', auth()->user()->userinfo->department->id);
            })->with(['userinfo', 'userinfo.department', 'userinfo.role'])->count();

            $members = DepartmentUser::where('department_id', auth()->user()->userinfo->department->id)->count();
        }

        $faqs = Faqs::count();

        return response()->json(['post' => $post, 'members' => $members]);
    }

}
