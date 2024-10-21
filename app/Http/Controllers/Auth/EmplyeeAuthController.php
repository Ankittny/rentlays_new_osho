<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emplyoee;
use Illuminate\Support\Facades\Auth;
class EmplyeeAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('employee')->attempt($credentials)) {
            $employee = Auth::guard('employee')->user();
            $token = $employee->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
