<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    //
    public function index()
    {
        return view(
            'dataMember',
            [
                'title' => 'Data User Member',
                'users' => User::all()->where('level', 'member'),
            ]
        );
    }

    public function add(Request $request)
    {
        $request->validate(
            ['retype_password' => 'required|min:3|same:password']
        );

        $request['level'] = 'member';

        $validateData = $request->validate([
            'level' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email:dns',
            'nomor_hp' => 'required|max:20',
            'password' => 'required|min:3',
        ]);

        $validateData['password'] = Hash::make($validateData['password']);

        User::create($validateData);

        return redirect('/userMember');
    }

    public function changePassword(Request $request){
        
        $validateData = $request->validate([
            'old_password' => 'required|min:3',
            'password' => 'required|min:3|confirmed',  
        ]);
        
        $currentPassword = auth()->user()->password;
        $old_password = $validateData['old_password'];
        if(Hash::check($old_password,$currentPassword)){
            auth()->user()->update([
                'password' => bcrypt($validateData['password']),
            ]);
            return back()->with('success','Ubah password berhasil!');
        }else{
            return back()->withErrors(['old_password' => 'Password lama salah!']);
        }
    }

    public function ubahPassword(){
        return view('ubahPassword',[
            'title' => 'Ubah Password',
        ]);
    }
}
