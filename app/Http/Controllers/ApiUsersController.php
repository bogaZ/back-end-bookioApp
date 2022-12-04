<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiUsersController extends Controller
{
    public function show(){
        return response()->json([
            'success' => true,
            'data' => auth()->user(),
            'data_bank' => Pembayaran::all()->firstWhere('user_id',auth()->user()->id),
            'message' => 'Berhasil mengambil data anda!',
        ]);
    }

    public function update(Request $request){
        $user = auth()->user();
        $email = $request['email'];
        $rules = [
            'name' => 'required|max:255',
            'nomor_hp' => 'required|max:20',
        ];
        if($email != $user->email){
            $rules['email'] ='required|unique:users|email:dns';
        }
        $validateData = $request->validate($rules);
        //return $validateData;
        User::all()->find($user->id)->update($validateData);

        return response()->json([
            'success' => true,
            'data' => User::all()->find($user->id),
            'message' => 'Update profile berhasil!',
        ]);
    }


    public function changePassword(Request $request){
        $validateData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',  
        ]);

        $currentPassword = auth()->user()->password;
        $old_password = $validateData['old_password'];
        if(Hash::check($old_password,$currentPassword)){
            auth()->user()->update([
                'password' => bcrypt($validateData['password']),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'update password berhasil!',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Password lama salah!!',
            ]);
        }
    }
}
