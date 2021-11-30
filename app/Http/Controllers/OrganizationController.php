<?php

namespace App\Http\Controllers;

use App\Models\DepartmentUser;
use App\Models\Organization;
use App\Models\OrganizationAdmin;
use App\Models\OrganizationUser;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        if (!Gate::allows('access_organization')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }

        $org = OrganizationUser::whereHas('organization', function($query){
            $query->where('department_id', auth('api')->user()->userinfo->department->id);
        })->with(['user', 'user.userinfo', 'organization', 'user.userinfo.role', 'user.posts', 'user.posts.postcontent', 'organization.adviser.userinfo:id,first_name,last_name'])->paginate(8);
        
        return response()->json($org);
    }

    public function searchOrgMembers(Request $request){
        $account = OrganizationUser::whereHas('user.userinfo', function($query){
            $query->where('first_name', 'like', '%'.request()->get('search').'%');
            $query->orWhere('last_name', 'like', '%'.request()->get('search').'%');
        })->whereHas('organization', function($query){
            $query->where('department_id', auth('api')->user()->userinfo->department->id);
        })->with(['user.userinfo', 'organization', 'user.userinfo.role', 'user.posts', 'user.posts.postcontent', 'organization.adviser.userinfo:id,first_name,last_name'])
        ->paginate(8);
        
        return response()->json($account);
    }

    public function setAdviser(Request $request){
        if(auth()->user()->type == 'Department'){
            $doesExist = OrganizationAdmin::where('organization_id', $request->organization_id)->delete();
            if(empty($doesExist)){
                OrganizationAdmin::create([
                    'organization_id' => $request->organization_id,
                    'user_account_id' => $request->user_id,
                ]);
    
                return response()->json(['msg' => 'Adviser has been set successfully!'], 200);
            }
            else {
                OrganizationAdmin::create([
                    'organization_id' => $request->organization_id,
                    'user_account_id' => $request->user_id,
                ]);
                return response()->json(['msg' => 'Adviser for this organization has been updated'], 200);
            }
        }
    }

    public function retrieveAdviser(){
        if(auth()->user()->type == 'Department'){
            $account = DepartmentUser::where('department_id', auth()->user()->userinfo->department->id)
            ->with(['user.userinfo:id,first_name,last_name', 'user.userinfo.role:id,role'])
            ->where('user_account_id', '<>', auth()->user()->id)
            ->get();

            return response()->json($account);
        }
    }
    
    public function destroy($id){
        $orgadmin = OrganizationAdmin::where('user_account_id', $id)->first();

        if (!Gate::allows('delete_user') || auth('api')->user()->id != $orgadmin->id) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }

        UserAccount::destroy($id);
        OrganizationUser::where('user_account_id', $id)->delete();

        return response()->json(['msg' => 'User account deleted successfully!'], 200); 
    }



}
