<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLoginController extends Controller
{
    public function authenticatePenyewa(Request $request)
    {
        $request['level'] = 'penyewa';
        $credentials = $request->validate([
            'level' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'Login not successfully!',
            ]);
        }
        $user = User::all()->firstWhere('email', $credentials['email']);
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => 'Bearer ' . $user->createToken('user')->accessToken,
            'message' => 'Login successfully!',
        ]);
    }

    public function authenticatePenyedia(Request $request)
    {
        $request['level'] = 'penyedia';
        $credentials = $request->validate([
            'level' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'Login not successfully!',
            ]);
        }
        $user = User::all()->firstWhere('email', $credentials['email']);
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => 'Bearer ' . $user->createToken('user')->accessToken,
            'message' => 'Login successfully!',
        ]);
    }

    public function logout()
    {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();
            return response()->json([
                'success' => true,
                'message' => 'Logout successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to Logout',
            ]);
        }
    }

}
