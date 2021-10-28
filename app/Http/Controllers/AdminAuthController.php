<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
use App\Models\AdminAccountInfo;
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

        if (! $token = auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        $user = AdminAccount::with(['admininfo'])->where('id', auth()->guard('admin')->user()->id)->first();
        return response()->json($user);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User logged out successfully!']);
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

            if($request->image){
                $data['image'] = $request->image;
            }

            $account_info = AdminAccountInfo::where('id', auth('admin')->user()->id)->first();
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

    protected function respondWithToken($token)
    {
        $user = AdminAccountInfo::where('id', auth('admin')->user()->id)->first();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL() * 60,
            'user_info' => $user,
            'user_account' => auth('admin')->user(),
        ]);
    }
}
