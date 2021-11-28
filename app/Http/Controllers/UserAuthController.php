<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAccountRequest;
use App\Mail\NewAccountMail;
use App\Mail\PasswordResetMail;
use App\Models\DepartmentUser;
use App\Models\Organization;
use App\Models\OrganizationAccount;
use App\Models\OrganizationUser;
use App\Models\UnitAccount;
use App\Models\UserAccount;
use App\Models\UserInfo;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'store', 'reset', 'checkResetRequest', 'saveResetRequest']]);
    }

    public function permissions(){
        $permission = auth()->user()->userinfo->role->permission->pluck('permission')->toArray();
        return response()->json($permission);
    }

    public function login(Request $request)
    {
        $user = UserAccount::where('email', $request->email)->where('status', 'Pending')->first();

        if($user) {
            return response()->json(['msg' => 'Your account is still on Pending state'], 403);
        }
        else
        {
            if (! $token = auth()->guard('api')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->respondWithToken($token);
        }

    }

    public function store(UserAccountRequest $request)
    {
        if($request->account_type == 'Organization'){
           $orgUserExist = OrganizationUser::whereHas('user.userinfo', function($query){
            $query->where('org_unit_role_id', request()->get('role_id'));
           })->where('organization_id', $request->organization_id)
           ->with(['user.userinfo'])->first();

           if($orgUserExist){
               if($orgUserExist->user->userinfo->org_unit_role_id != 8){
                   return response()->json(['msg' => ['Error! Selected position on the organization already exist']], 422);
               }
           }
           
        }
        if($request->account_type == 'Department'){
           $depUserExist = DepartmentUser::whereHas('user.userinfo', function($query){
            $query->where('org_unit_role_id', request()->get('role_id'));
           })->where('department_id', $request->unit_id)
           ->with(['user.userinfo'])->first();

           if($depUserExist){
             if($depUserExist->user->userinfo->org_unit_role_id != 12){
                return response()->json(['msg' => ['Error! Selected position on the department already exist']], 422);
             }    
           }
           
        }

        $data = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'contact_number' => $request->contact_number,
            'org_unit_role_id' => $request->role_id,
        ];

        if($request->image){
            $data['image'] = $request->image;
        }

        $userinfo = UserInfo::create($data);

        $useraccount = UserAccount::create([
            'user_info_id' => $userinfo->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->account_type,
            'status' => $request->status == 'Approved' ? 'Approved' : 'Pending',
        ]);

        if($request->account_type == 'Organization'){
            OrganizationUser::create([
                'user_account_id' => $useraccount->id,
                'organization_id' => $request->organization_id
            ]);
        }

        if($request->account_type == 'Department'){
            DepartmentUser::create([
                'user_account_id' => $useraccount->id,
                'department_id' => $request->unit_id
            ]);
        } 


        if($request->emailNotif){
            Mail::to($useraccount->email)->send(new NewAccountMail($request->all()));
        }

        return response()->json(['msg' => 'Account created successfully!'], 200);
  
    }


    public function me()
    {
        if(auth()->user()->type == 'Organization'){
            $user = UserAccount::with(['userinfo', 'userinfo.organization', 'userinfo.role'])->where('id', auth()->guard('api')->user()->id)->first();
        }
        else {
            $user = UserAccount::with(['userinfo', 'userinfo.department', 'userinfo.role'])->where('id', auth()->guard('api')->user()->id)->first();
        }
        return response()->json($user);
    }

    public function logout()
    {
        activity('User Logout')->withProperties(['email' => auth()->user()->email, 'ip' => request()->ip()])
        ->causedBy(auth('api')->user()->id)
        ->event('logout')
        ->log('User has logged out');

        auth('api')->logout();
        return response()->json(['message' => 'User logged out successfully!']);
    }

    public function update(Request $request){
        if(!Hash::check($request->confirm_password, $request->user('api')->password)){
            return response()->json(['msg' => 'Incorrect Password'], 422);
        }
        else {
            $account_info = UserInfo::where('id', auth()->guard('api')->user()->id)->first();

            $data = [
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'contact_number' => $request->contact_number,
            ];

            if($request->image){
                $data['image'] = $request->image;
                if($account_info->image){
                    $this->deleteFileFromServer($account_info->image);
                }
            }
            
            $account_info->update($data);

            $account = UserAccount::where('id', auth()->guard('api')->user()->id)->first();
            $account->update(['email' => $request->email]);
            
            return response()->json(['msg' => 'Account Information updated']);
        }
    }

    public function changePassword(Request $request){
        if(!Hash::check($request->current_password, $request->user('api')->password)){
            return response()->json(['msg' => 'Incorrect Password'], 422);
        }
        else {
            $account = UserAccount::where('id', auth()->guard('api')->user()->id)->first();
            $account->update(['password' => Hash::make($request->new_password)]);

            return response()->json(['msg' => 'Account password changed successfully']);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        $user = UserInfo::where('id', auth()->guard('api')->user()->id)->first();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user_info' => $user,
            'user_account' => auth('api')->user(),
        ]);
    }

    public function reset(Request $request){
        $user = UserAccount::where('email', $request->email)->first();

        $data = [
            'token' => Hash::make($request->email),
            'email' => $request->email,
        ];

        if($user){
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $data['token']
            ]);

            Mail::to($request->email)->send(new PasswordResetMail($data));

            return response()->json(['msg' => 'Password reset has been sent to your email address'], 200);
        }
        else {
            return response()->json(['msg' => 'Email address doesn\'t exist'], 404);
        }
        return response()->json(['msg' => 'Password reset has been sent to your email address'], 200);

    }

    public function checkResetRequest(Request $request){
        $password_reset = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if($password_reset){
            return response()->json(['msg' => 'You can reset your password'], 200);
        }
        else {
            return response()->json(['msg' => 'Error password reset request not found'], 404);
        }

    }

    public function saveResetRequest(Request $request){
        $password_reset = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if($password_reset){
            $user = UserAccount::where('email', $request->email)->first();
            $user->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where([
                'email' => $request->email,
                'token' => $request->token
            ])->delete();
            
            return response()->json(['msg' => 'Password updated successfully'], 200);
        }
        else {
            return response()->json(['msg' => 'Error reset password request not valid'], 404);
        }
    }

    public function uploadUserImage(Request $request){
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

   
}
