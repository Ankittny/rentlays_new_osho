<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Auth, Validator, Socialite, DateTime, Hash, DB, Session, Common;
use App\Http\{
    Controllers\Controller,
    Controllers\EmailController,

};

use App\Models\{
    User,
    UserDetails,
    UsersVerification,
    Settings,
    Wallet
};

class LoginController extends Controller
{
    // response status set
    const HTTP_STATUS_OK = 200;
    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function create(Request $request, EmailController $email_controller)
    {
        $validator = Validator::make($request->all(), [
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'country'           => 'required',
            'phone'             => 'required',
            'formatted_phone'   => 'required',   
            'date_of_birth'     => 'required',     
            'password'          => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }
        try{
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->country = $request->country;
            $user->phone = $request->phone;
            $user->status = 'Inactive';
            $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
            $user->formatted_phone = $request->formatted_phone;
            $user->password = Hash::make($request->password);
            if($user->save()){
                $user_details             = new UserDetails;
                $user_details->user_id    = $user->id;
                $user_details->field      = 'date_of_birth';
                $user_details->value      = $request->date_of_birth;
                $user_details->save();

                $user_verification           = new UsersVerification;
                $user_verification->user_id  = $user->id;
                $user_verification->save();
                $this->wallet($user->id);
                try {
                    $email_controller->welcome_email($user);
                } catch (\Exception $e) {
                    return response(['status' => false, 'message' => $e->getMessage()], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
                }
                return response(['status' => true, 'message' => 'User is inactive. Please check your email send verification link'], self::HTTP_STATUS_OK);
            } else {
                return response(['status' => false, 'message' => 'User not created'], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    
    public function profileUpdate(Request $request, EmailController $email_controller)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'country'           => 'required',
            'gender'            => 'required',
            'phone'             => 'required',
            'formatted_phone'   => 'required',   
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }
        try{
            $user = User::find(Auth::user()->id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->country = $request->country;
            $user->phone = $request->phone;
            $user->formatted_phone = $request->formatted_phone;
            $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
            if($user->save()){
                $temp_details = $request->details;
                foreach ($temp_details as $key => $value) {
                    if (!is_null($value) && $value != '') {
                        UserDetails::updateOrCreate(['user_id' => Auth::user()->id, 'field' => $key], ['value' => $value]);
                    }
                }
                return response(['status' => true, 'message' => 'Profile updated'], self::HTTP_STATUS_OK);
            } else {
                return response(['status' => false, 'message' => 'Profile not updated'], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }
    

    public function login(Request $request, EmailController $email_controller)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response(['message' => 'User does not exist'], 404);
        }
        if ($user->status == "Inactive") {
            try {
                $email_controller->welcome_email($user);
                return response(['status' => false, 'message' => 'User is inactive. Please check your email for a verification link'], 200);
            } catch (\Exception $e) {
                return response(['status' => false, 'message' => $e->getMessage()], 500);
            }
        }
        if (!Hash::check($request->password, $user->password)) {
            return response(['message' => 'Password mismatch'], 401);
        }
        $token = $user->createToken('authToken')->accessToken;
        $response = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'country' => $user->country,
            'phone' => $user->phone,
            'carrier_code' => $user->carrier_code,
            'default_country' => $user->default_country,
            'balance' => $user->balance,
            'formatted_phone' => $user->formatted_phone,
            'token' => $token,
        ];
        return response($response, 200);
    }

    public function profilemedia(Request $request){

        $validator = Validator::make($request->all(), [
            'photos' => 'required', 
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }
        $data['result'] = $user = User::find(Auth::user()->id);
        if (isset($_FILES["photos"]["name"])) {
                $tmp_name     = $_FILES["photos"]["tmp_name"];
                $name         = str_replace(' ', '_', $_FILES["photos"]["name"]);
                $ext          = pathinfo($name, PATHINFO_EXTENSION);
                $name         = 'profile_'.time().'.'.$ext;
                $path         = 'public/images/profile/'.Auth::user()->id;
                $oldImagePath =  public_path('images/profile').'/'.Auth::user()->id.'/'.$data['result']->profile_image;
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext=='webp') {
                    if (!empty($user->profile_image) && file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    if (move_uploaded_file($tmp_name, $path."/".$name)) {
                        $user->profile_image  = $name;
                        $user->save();
                        return response()->json(['status'=>true,'message'=>'Profile picture changed successfully.'],self::HTTP_STATUS_OK);
                    }
                }
        }
        
    }

    public function security(Request $request){
        $rules = array(
            'old_password'          => 'required',
            'new_password'          => 'required|min:6|max:30|different:old_password',
            'password_confirmation' => 'required|same:new_password|different:old_password'
        );

        $fieldNames = array(
            'old_password'          => 'Old Password',
            'new_password'          => 'New Password',
            'password_confirmation' => 'Confirm Password'
        );
        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($fieldNames);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::find(Auth::user()->id);
        if (!Hash::check($request->old_password, $user->password)) {
            return response(['message' => 'Password mismatch'], 401);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(['status'=>true,'message'=>'Password changed successfully.'],self::HTTP_STATUS_OK);
    }

    

    //wallet method 
    public function wallet($userId){
           $defaultCurrencyId    = Settings::getAll()->where('name', 'default_currency')->first();
           $wallet               = new Wallet();
           $wallet->user_id      = $userId;
           $wallet->currency_id  = (int)$defaultCurrencyId->value;
           $wallet->save();
    }
}
