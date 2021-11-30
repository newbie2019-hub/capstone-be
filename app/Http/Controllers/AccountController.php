<?php

namespace App\Http\Controllers;

use App\Mail\ApprovedAccountMail;
use App\Mail\UpdatedAccountMail;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\Organization;
use App\Models\OrganizationAccount;
use App\Models\OrganizationUser;
use App\Models\OrgUnit;
use App\Models\UnitAccount;
use App\Models\UserAccount;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function accounts(){
        $unitaccount = DepartmentUser::with(['user', 'user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
        $orgaccount = OrganizationUser::with(['user', 'user.userinfo', 'organization', 'user.userinfo.role'])->paginate(8);
        return response()->json(['unit' => $unitaccount, 'org' => $orgaccount]);
    }

    public function orgAccounts(){
        $orgaccount = OrganizationUser::with(['user', 'user.userinfo', 'organization', 'user.userinfo.role'])->paginate(8);
        return response()->json($orgaccount);
    }

    public function approvedOrgAccounts(){
        $orgaccount = OrganizationUser::whereHas('user', function ($query){
            $query->where('status', 'Approved');
        })->with(['user', 'user.userinfo', 'organization', 'user.userinfo.role'])->paginate(8);
        return response()->json($orgaccount);
    }

    public function pendingOrgAccounts(){
        $orgaccount = OrganizationUser::whereHas('user', function ($query){
            $query->where('status', 'Pending');
        })->with(['user', 'user.userinfo', 'organization', 'user.userinfo.role'])->paginate(8);
        return response()->json($orgaccount);
    }

    public function unitAccounts(){
        $unitaccount = DepartmentUser::with(['user', 'user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
        return response()->json($unitaccount);
    }

    public function approvedUnitAccounts(){
        $unitaccount = DepartmentUser::whereHas('user', function ($query){
            $query->where('status', 'Approved');
        })->with(['user', 'user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
        return response()->json($unitaccount);
    }

    public function pendingUnitAccounts(){
        $unitaccount = DepartmentUser::whereHas('user', function ($query){
            $query->where('status', 'Pending');
        })->with(['user', 'user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
        return response()->json($unitaccount);
    }

    public function searchOrganizationAccounts(){
        if(request()->get('status') == 'All Accounts'){
            $orgaccount = OrganizationUser::whereHas('user.userinfo', function ($query) {
                $query->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
            })->orWhereHas('organization', function($query){
                $query->where('name', 'like', '%'.request()->get('search').'%')
                ->orWhere('abbreviation', 'like', '%'.request()->get('search').'%');
            })->whereHas('user', function ($query) {
                $query->where('type', 'Organization');
            })->with(['user', 'user.userinfo', 'organization', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($orgaccount);
        }
        else {
            $orgaccount = OrganizationUser::whereHas('user', function ($query) {
                $query->where('status', request()->get('status'));
                $query->where('type', 'Organization');
            })->orWhereHas('organization', function($query){
                $query->where('name', 'like', '%'.request()->get('search').'%')
                ->orWhere('abbreviation', 'like', '%'.request()->get('search').'%');
            })->whereHas('user.userinfo', function ($query) {
                $query->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
            })->with(['user', 'user.userinfo', 'organization', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($orgaccount);
        }
    }

    public function searchDepartmentAccounts(){
        if(request()->get('status') == 'All Accounts'){
            $unitaccount = DepartmentUser::whereHas('user.userinfo', function ($query) {
                $query->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
            })->orWhereHas('department', function($query){
                $query->where('name', 'like', '%'.request()->get('search').'%')
                ->orWhere('abbreviation', 'like', '%'.request()->get('search').'%');
            })->whereHas('user', function ($query) {
                $query->where('type', 'Department');
            })->with(['user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($unitaccount);
        }
        else {
            $unitaccount = DepartmentUser::whereHas('user', function ($query) {
                $query->where('status', request()->get('status'));
                $query->where('type', 'Department');
            })->orWhereHas('department', function($query){
                $query->where('name', 'like', '%'.request()->get('search').'%')
                ->orWhere('abbreviation', 'like', '%'.request()->get('search').'%');
            })->whereHas('user.userinfo', function ($query) {
                $query->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
            })->with(['user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($unitaccount);
        }
    }

    public function recentAccounts(){
        $useraccounts = UserAccount::with(['userinfo'])->where('status', 'Pending')->latest()->take(4)->get(['id','user_info_id','email', 'status']);
        return response()->json($useraccounts);
    }

    public function approveAccount($id) {
        $user = UserAccount::with(['userinfo'])->where('id', $id)->first();

        $data = [
            'first_name' => $user->userinfo->first_name,
            'middle_name' => $user->userinfo->middle_name,
            'last_name' => $user->userinfo->last_name,
            'email' => $user->email,
        ];

        Mail::to($user->email)->send(new ApprovedAccountMail($data));

        if($user) {
            $user->update(['status' => 'Approved']);
            //IF user role is not representative or faculty member then delete others with the same role
            if($user->userinfo->org_unit_role_id != 8 && $user->userinfo->org_unit_role_id != 11){
                if($user->type == 'Organization'){
                    $approvedUser = OrganizationUser::where('user_account_id', $id)->first();
                } 
                else {
                    $approvedUser = DepartmentUser::where('user_account_id', $id)->first();
                } 
                   
                // GET ALL ACCOUNTS WITH THE SAME ROLE 
                // AND THE SAME ORG OR DEP
                $usersWithSameRole = UserAccount::where('type', $user->type)->whereRelation('userinfo', 'org_unit_role_id', $user->userinfo->org_unit_role_id)
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
                            $depuser = DepartmentUser::where('user_account_id', $user->id)->delete();
                        }
                    }
                }
            }
            
            return response()->json(['msg' => 'Account has been approved'], 200);
        }
        else {
            return response()->json(['msg' => 'Something went wrong'], 404);
        }
    
    }

    public function update(Request $request, $id){
        $userinfo = UserInfo::find($id);

        $info = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'contact_number' => $request->contact_number,
            'org_unit_role_id' => $request->role_id,
        ];

        if($request->image){
            $info['image'] = $request->image;
        }

        $userinfo->update($info);
        
        $useraccount = UserAccount::find($id);
        $useraccount->update(['email' => $request->email]);
        $info['email'] = $request->email;

        if($request->account_type == 'Organization'){
            OrganizationUser::where('user_account_id', $id)->forceDelete();
            OrganizationUser::create(['user_account_id' => $id, 'organization_id' => $request->org_unit_id]);
        }

        if($request->account_type == 'Department'){
            DepartmentUser::where('user_account_id', $id)->forceDelete();
            DepartmentUser::create(['user_account_id' => $id, 'department_id' => $request->org_unit_id]);
        }
        
        if($request->emailNotif){
            Mail::to($useraccount->email)->send(new UpdatedAccountMail($info));
        }

        return response()->json(['msg' => 'Account updated successfully!'], 200);
    }

    public function destroy($id){
        $acc = UserAccount::with(['userinfo'])->where('id', $id)->first();

        UserAccount::destroy($id);
        $orguser = OrganizationUser::where('user_account_id', $id)->first();

        if($orguser){
            OrganizationUser::where('user_account_id', $id)->delete();
        }
        
        $depuser = DepartmentUser::where('user_account_id', $id)->first();

        if($depuser){
            DepartmentUser::where('user_account_id', $id)->delete();
        }

        activity('Admin - Account Deletion')->withProperties(['ip' => request()->ip()])
        ->causedBy(auth('admin')->user()->id)
        ->performedOn($acc)
        ->event('account deletion')
        ->log( $acc->userinfo->first_name .' '. $acc->userinfo->last_name .'\'s account was deleted by the administrator');

        return response()->json(['msg' => 'User account deleted successfully!'], 200); 
    }

    public function uploadAccountImage(Request $request){
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

}
