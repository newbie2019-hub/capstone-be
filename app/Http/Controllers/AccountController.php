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
        // $unitaccount = UserAccount::with(['userinfo', 'userinfo.department', 'userinfo.role'])->where('type', 'Department')->paginate(8);
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
            })->whereHas('user', function ($query) {
                $query->where('type', 'Organization');
            })->with(['user', 'user.userinfo', 'organization', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($orgaccount);
        }
        else {
            $orgaccount = OrganizationUser::whereHas('user', function ($query) {
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
            $unitaccount = DepartmentUser::whereHas('user.userinfo', function ($query) {
                $query->where('first_name', 'like', '%'.request()->get('search').'%')->orWhere('middle_name', 'like', '%'.request()->get('search').'%')
                ->orWhere('last_name',  'like', '%'.request()->get('search').'%');
            })->whereHas('user', function ($query) {
                $query->where('type', 'Department');
            })->with(['user.userinfo', 'department', 'user.userinfo.role'])->paginate(8);
            
            return response()->json($unitaccount);
        }
        else {
            $unitaccount = DepartmentUser::whereHas('user', function ($query) {
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

        if($user) {
            $user->update(['status' => 'Approved']);
            Mail::to($user->email)->send(new ApprovedAccountMail($data));
            
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
            'org_unit_id' => $request->org_unit_id,
            'org_unit_role_id' => $request->role_id,
        ];

        if($request->image){
            $info['image'] = $request->image;
        }

        $userinfo->update($info);
        
        $useraccount = UserAccount::find($id);
        $useraccount->update(['email' => $request->email, 'status' => $request->status]);
        $info['email'] = $request->email;
        
        if($request->emailNotif){
            Mail::to($useraccount->email)->send(new UpdatedAccountMail($info));
        }

        return response()->json(['msg' => 'Account updated successfully!'], 200);
    }

    public function destroy($id){
        UserAccount::destroy($id);
        return response()->json(['msg' => 'User account deleted successfully!'], 200); 
    }

    public function uploadAccountImage(Request $request){
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

}
