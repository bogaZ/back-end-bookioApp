<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunAdminController extends Controller
{
    //
    public function index()
    {
        return view('akunAdmin ', [
            'title' => 'Akun Admin',
        ]);
    }


    public function update(Request $request, User $user)
    {

        $rules = [
            'name' => 'required|max:255',   
            'nomor_hp' => 'required',
        ];
        
        if($request['email'] != auth()->user()->email ){
            $rules['email'] = 'required|unique:users|email:dns';
        }

        $validateData = $request->validate($rules);

        User::where('id',auth()->user()->id)->update($validateData);
        
        return redirect('/akunAdmin');
    }
}
