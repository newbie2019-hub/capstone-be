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
        $orgaccount = OrganizationUser::onlyTrashed()->with(['user', 'user.userinfo' => function($query){
            $query->withTrashed();
        }, 'organization', 'user.userinfo.role', 'user.posts'  => function($query){
            $query->withTrashed();
        }, 'user.posts.postcontent' => function($query){
            $query->withTrashed();
        }, 'user.logs', 'user.logs.subject'])->paginate(8);

        return response()->json($orgaccount);
    }

    public function unitAccounts(){
        $depaccount = DepartmentUser::onlyTrashed()->with(['user', 'user.userinfo' => function($query){
            $query->withTrashed();
        }, 'department', 'user.userinfo.role', 'user.posts'  => function($query){
            $query->withTrashed();
        }, 'user.posts.postcontent' => function($query){
            $query->withTrashed();
        }, 'user.logs', 'user.logs.subject'])->paginate(8);
        return response()->json($depaccount);
    }

    public function searchOrganizationAccounts(){

        $orgaccount = OrganizationUser::onlyTrashed()->whereHas('user.userinfo', function ($query) {
            $query->withTrashed()->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
            ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
        })->whereHas('user', function ($query) {
            $query->where('type', 'Organization');
        })->with(['user', 'user.userinfo' => function($query){
            $query->withTrashed();
        }, 'organization', 'user.userinfo.role', 'user.logs', 'user.logs.subject'])->paginate(8);
        
        return response()->json($orgaccount);

    }

    public function searchDepartmentAccounts(){

        $unitaccount = DepartmentUser::onlyTrashed()->whereHas('user.userinfo', function ($query) {
            $query->withTrashed()->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
            ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
        })->whereHas('user', function ($query) {
            $query->where('type', 'Department');
        })->with(['user.userinfo' => function($query){
            $query->withTrashed();
        }, 'department', 'user.userinfo.role', 'user.logs', 'user.logs.subject'])->paginate(8);
        
        return response()->json($unitaccount);
      
    }



}
