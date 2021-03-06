<?php

namespace App\Http\Controllers;

use App\Models\DepartmentUser;
use Illuminate\Http\Request;
use App\Models\OrganizationAccount;
use App\Models\OrganizationUser;
use App\Models\UnitAccount;
use App\Models\Post;
use App\Models\UserAccount;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Gate;

class UserMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        if (!Gate::allows('retrieve_users')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }

        if(auth()->user()->type == 'Organization'){
            $account = OrganizationUser::where('organization_id', auth()->user()->userinfo->organization->id)
            ->with(['user.userinfo', 'organization', 'user.userinfo.role', 'user.posts', 'user.posts.postcontent'])
            ->where('user_account_id', '<>', auth()->user()->id)
            ->paginate(8);
        }
        if(auth()->user()->type == 'Department'){
            $account = DepartmentUser::where('department_id', auth()->user()->userinfo->department->id)
            ->with(['user.userinfo', 'department', 'user.userinfo.role', 'user.posts', 'user.posts.postcontent'])
            ->where('user_account_id', '<>', auth()->user()->id)
            ->paginate(8);
        }

        return response()->json($account, 200);
    }

    public function searchMember(){
        if (!Gate::allows('retrieve_users')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }
        if(auth()->user()->type == 'Organization'){
            $account = OrganizationUser::whereHas('user.userinfo', function($query){
                $query->where('first_name', 'like', '%'.request()->get('search').'%');
                $query->orWhere('last_name', 'like', '%'.request()->get('search').'%');
            })->where('organization_id', auth()->user()->userinfo->organization->id)
            ->with(['user.userinfo', 'organization', 'user.userinfo.role', 'user.posts', 'user.posts.postcontent'])
            ->where('user_account_id', '<>', auth()->user()->id)
            ->paginate(8);
        }
        if(auth()->user()->type == 'Department'){
            $account = DepartmentUser::whereHas('user.userinfo', function($query){
                $query->where('first_name', 'like', '%'.request()->get('search').'%');
                $query->orWhere('last_name', 'like', '%'.request()->get('search').'%');
            })->where('department_id', auth()->user()->userinfo->department->id)
            ->with(['user.userinfo', 'department', 'user.userinfo.role', 'user.posts', 'user.posts.postcontent'])
            ->where('user_account_id', '<>', auth()->user()->id)
            ->paginate(8);
        }

        return response()->json($account, 200);
    }

    public function approveMember($id){
        if (!Gate::allows('approve_user')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }

        $member = UserAccount::where('id', $id)->with(['userinfo'])->first();

        if($member){

           $member->update(['status' => 'Approved']);
           
           if($member->userinfo->org_unit_role_id != 8 && $member->userinfo->org_unit_role_id != 11){
                if($member->type == 'Organization'){
                    $approvedUser = OrganizationUser::where('user_account_id', $id)->first();
                } 
                else {
                    $approvedUser = DepartmentUser::where('user_account_id', $id)->first();
                } 
                
                // GET ALL ACCOUNTS WITH THE SAME ROLE 
                // AND THE SAME ORG OR DEP
                $usersWithSameRole = UserAccount::where('type', $member->type)->whereRelation('userinfo', 'org_unit_role_id', $member->userinfo->org_unit_role_id)
                ->where('id', '<>', $id)->with(['userinfo'])->get();

                foreach($usersWithSameRole as $user){
                    if($user->type == 'Organization'){
                        $orguser = OrganizationUser::where('user_account_id', $user->id)->first();
                        if($orguser->organization_id == $approvedUser->organization_id) {
                            $orguser->user->delete();
                            OrganizationUser::where('user_account_id', $user->id)->delete();
                        }
                    }
                    else {
                        $depuser = DepartmentUser::where('user_account_id', $user->id)->first();
                        if($depuser->department_id == $approvedUser->department_id) {
                            $depuser->user->delete();
                            DepartmentUser::where('user_account_id', $user->id)->delete();
                        }
                    }
                }
            }

            activity('Account approval')->withProperties(['ip' => request()->ip()])
            ->causedBy(auth('api')->user())
            ->performedOn($member)
            ->event('approval')
            ->log( $member->userinfo->first_name .' '. $member->userinfo->last_name .'\'s account was approved');
        
            return response()->json(['msg' => 'Member account approved successfully!'], 200);
        }
        else {
            return response()->json(['msg' => 'Member account not found'], 422);
        }
    }

    public function approveOrgMember($id){
        $member = UserAccount::find($id);

        if($member){
            $member->update(['status' => 'Approved']);

            activity('Organization account approval')->withProperties(['ip' => request()->ip()])
            ->causedBy(auth('api')->user())
            ->performedOn($member)
            ->event('approval')
            ->log( $member->userinfo->first_name .' '. $member->userinfo->last_name .'\'s account was approved');

            return response()->json(['msg' => 'Member account approved successfully!'], 200);
        }
        else {
            return response()->json(['msg' => 'Member account not found'], 422);
        }
    }

    public function accPosts()
    {
        $post = Post::with('postcontent')->where('user_account_id', auth()->user()->id)->paginate(5);
        return response()->json($post);
    }

    public function destroy($id){
        $user = UserAccount::where('id', $id)->first();
        UserAccount::destroy($id);
        $orguser = OrganizationUser::where('user_account_id', $id)->first();
        if($orguser){
            OrganizationUser::where('user_account_id', $id)->delete();
        }
        
        $depuser = DepartmentUser::where('user_account_id', $id)->first();
        if($depuser){
            DepartmentUser::where('user_account_id', $id)->delete();
        }

        activity('Account Deletion')->withProperties($user)
        ->causedBy(auth('api')->user()->id)
        ->event('deleted account')
        ->log('User account has been deleted');

        return response()->json(['msg' => 'User account deleted successfully!'], 200); 
    }
}
