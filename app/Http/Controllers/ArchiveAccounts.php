<?php

namespace App\Http\Controllers;

use App\Models\DepartmentUser;
use App\Models\OrganizationUser;
use Illuminate\Http\Request;

class ArchiveAccounts extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function orgAccounts(){
        $orgaccount = OrganizationUser::onlyTrashed()->with(['user', 'user.userinfo', 'organization', 'user.userinfo.role' ])->paginate(8);

        return response()->json($orgaccount);
    }

    public function unitAccounts(){
        $depaccount = DepartmentUser::onlyTrashed()->with(['user', 'user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
        return response()->json($depaccount);
    }

    public function searchOrganizationAccounts(){
        if(request()->get('status') == 'All Accounts'){
            $orgaccount = OrganizationUser::onlyTrashed()->whereHas('user.userinfo', function ($query) {
                $query->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
            })->whereHas('user', function ($query) {
                $query->where('type', 'Organization');
            })->with(['user', 'user.userinfo', 'organization', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($orgaccount);
        }
        else {
            $orgaccount = OrganizationUser::onlyTrashed()->whereHas('user', function ($query) {
                $query->where('status', request()->get('status'));
                $query->where('type', 'Organization');
            })
            ->whereHas('user.userinfo', function ($query) {
                $query->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
            })->with(['user', 'user.userinfo', 'organization', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($orgaccount);
        }
    }

    public function searchDepartmentAccounts(){
        if(request()->get('status') == 'All Accounts'){
            $unitaccount = DepartmentUser::onlyTrashed()->whereHas('user.userinfo', function ($query) {
                $query->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
            })->whereHas('user', function ($query) {
                $query->where('type', 'Department');
            })->with(['user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($unitaccount);
        }
        else {
            $unitaccount = DepartmentUser::onlyTrashed()->whereHas('user', function ($query) {
                $query->where('status', request()->get('status'));
                $query->where('type', 'Department');
            })
            ->whereHas('user.userinfo', function ($query) {
                $query->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
            })->with(['user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($unitaccount);
        }
    }



}
