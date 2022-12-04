<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class ApiRegisterController extends Controller
{   
    
    //
    public function registerPenyewa(Request $request){
        $request['level'] = 'penyewa';
        $validateData = $request->validate([
            'level' => 'required',
            'name' => 'required',
            'email' => 'required|email:dns',
            'nomor_hp' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        $validateData['password'] = bcrypt($validateData['password']);
        $user = User::create($validateData);
        $token = 'Bearer '.$user->createToken('user')->accessToken;
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
            'messagge' => 'Register successfully!',
        ]);
    }

    public function registerPenyedia(Request $request){
        $request['level'] = 'penyedia';
        $validateData = $request->validate([
            'level' => 'required',
            'name' => 'required',
            'email' => 'required|email:dns|unique:users',
            'nomor_hp' => 'required',
            'password' => 'required|min:8|confirmed',
            
        ]);
        $validateData['password'] = bcrypt($validateData['password']);
        $user = User::create($validateData);
        $token = 'Bearer '.$user->createToken('user')->accessToken;
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
            'messagge' => 'Register successfully!',
        ]);
    }
}
