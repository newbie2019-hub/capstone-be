<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
use App\Models\AdminAccountInfo;
use App\Models\DepartmentUser;
use App\Models\OrganizationUser;
use App\Models\UserAccount;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login']]);
    }
    
    public function login(Request $request)
    {

        $isAdmin = AdminAccount::where('email', $request->email)->first();

        if($isAdmin){
            $type = 'admin';
            $loggeduser = AdminAccount::where('email', $request->email)->first();
            if (! $token = auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                activity('User Login')->causedBy($loggeduser)->withProperties(['email' => $request->email, 'ip' => request()->ip()])->event('login failed')
                ->log('User attempted to login');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            activity('Admin Login')->withProperties(['email' => $request->email, 'ip' => request()->ip()])
            ->causedBy($loggeduser)
            ->event('login success')
            ->log('Admin successfully logged in');

            $route = 'home/dashboard';
        }
        else {
            $user = UserAccount::where('email', $request->email)->where('status', 'Pending')->first();
            
            if($user) {
                return response()->json(['msg' => 'Your account is still on Pending state'], 422);
            }
            else{
                if (! $token = auth()->guard('api')->attempt(['email' => $request->email, 'password' => $request->password])) {

                    $loggeduser = UserAccount::where('email', $request->email)->first();
                    activity('User Login')->causedBy($loggeduser->id)->withProperties(['email' => $request->email, 'ip' => request()->ip()])->event('login failed')
                    ->log('User attempted to login');

                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                activity('User Login')->withProperties(['email' => $request->email, 'ip' => request()->ip()])
                ->causedBy(auth('api')->user()->id)
                ->event('login success')
                ->log('User successfully logged in');

                $type = 'user';
                $route = 'user/dashboard';
            }
        }

        return $this->respondWithToken($token, $type, $route);
    }

    public function me()
    {
        $user = AdminAccount::with(['admininfo'])->where('id', auth()->guard('admin')->user()->id)->first();
        return response()->json($user);
    }

    public function logout()
    {
        activity('Admin Logout')->withProperties(['email' => auth('admin')->user()->email, 'ip' => request()->ip()])
        ->causedBy(auth('admin')->user()->id)
        ->event('logout')
        ->log('Admin has logged out');
        return response()->json(['message' => 'Admin account has logged out successfully!']);
    }

    public function update(Request $request){
        if(!Hash::check($request->confirm_password, $request->user('admin')->password)){
            return response()->json(['msg' => 'Incorrect Password'], 422);
        }
        else {
            $data = [
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'contact_number' => $request->contact_number,
            ];

            $account_info = AdminAccountInfo::where('id', auth('admin')->user()->id)->first();
            
            if($request->image){
                $data['image'] = $request->image;
                if($account_info->image){
                    $this->deleteFileFromServer($account_info->image);
                }
            }

            $account_info->update($data);

            $account = AdminAccount::where('id', auth('admin')->user()->id)->first();
            $account->update(['email' => $request->email]);
            
            return response()->json(['msg' => 'Account Information updated']);
        }
    }

    public function changePassword(Request $request){
        if(!Hash::check($request->current_password, $request->user('admin')->password)){
            return response()->json(['msg' => 'Incorrect Password'], 422);
        }
        else {
            $account = AdminAccount::where('id', auth('admin')->user()->id)->first();
            $account->update(['password' => Hash::make($request->new_password)]);

            return response()->json(['msg' => 'Account password changed successfully']);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token, $type, $route)
    {
        
        if($type == 'admin'){
            $user = AdminAccountInfo::where('id', auth('admin')->user()->id)->first();
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('admin')->factory()->getTTL() * 60,
                'user_info' => $user,
                'route' => $route,
                'type' => $type,
                'user_account' => auth('admin')->user(),
            ]);
        }
        else {
            $user = UserInfo::where('id', auth()->guard('api')->user()->id)->first();
            
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'route' => $route,
                'user_info' => $user,
                'user_account' => auth('api')->user(),
            ]);
        }
    }

    public function restore($id){
        $acc = UserAccount::onlyTrashed()->where('id', $id)->first();
        // return response()->json($acc);
        if($acc->type == 'Organization'){
            OrganizationUser::where('user_account_id', $id)->restore();
        }
        else {
            DepartmentUser::where('user_account_id', $id)->restore();
        }
        UserAccount::where('id',$id)->restore();
        UserInfo::where('id', $id)->restore();

        return response()->json(['success' => 'Account restored successfully']);
    }
}
