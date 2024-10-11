<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupervisorLoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);        

        if (auth()->guard('supervisor')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json(['success' => true, 'data' => auth()->guard('supervisor')->user()]);
        } else {
            return response()->json(['success' => false, 'data' => []]);            
        }
    }
}
