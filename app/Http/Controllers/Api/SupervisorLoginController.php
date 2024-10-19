<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Validator;
use Hash;
use Common;
class SupervisorLoginController extends Controller
{
    private $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = Admin::where('email', $request->email)->first();
        if (!$user) {
            return response(['message' => 'User does not exist'], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response(['message' => 'Password mismatch'], 401);
        }

        $check_type_user = Common::get_roles($user->id);
        if($check_type_user != "supervisor" && $check_type_user != "sitemanager"){
            return response(['message' => 'You dont have permission to access this page'], 401);
        }
        
        $token = $user->createToken('authToken')->accessToken;
        
        $response = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'pincode' => $user->pincode,
            'status' => $user->status,
            'token' => $token,
        ];
        return response($response, 200);
    }
}
