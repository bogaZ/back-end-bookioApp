<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class RegisterController extends Controller
{
    //
    public function index()
    {
        // $users = User::all();
        // if ($users != '[]' ) {
        //     return view('login', [
        //         "title" => "Login",
        //     ]);
        // }
        return view('register', [
            "title" => "Register",
        ]);
    }

    public function store(Request $request)
    {

        $request['level'] = 'admin';

        $data = User::all()->firstWhere('level', 'admin');

        if ($data != null) {
            $request['level'] = 'member';
        }

        $request->validate(
            [
                'retype_password' => 'required|min:3|same:password',
            ]
        );

        $validateData = $request->validate([
            'level' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email:dns',
            'nomor_hp' => 'required|max:20',
            'password' => 'required|min:3',
        ]);

        
        $validateData['password'] = Hash::make($validateData['password']);


        User::create($validateData);

        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();

        //     return redirect()->intended('/home');
        // }
        return redirect('/login')->with('success', 'Register successfully!');
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');


    }

    public function registerPenyewa(Request $request){

 
        $request['level'] = 'penyewa';
        $request->validate([
            'retype_password' => 'required|same:password'
        ]);
        $validateData = $request->validate([
            'level' => 'required',
            'name' => 'required',
            'email' => 'required|email:dns',
            'nomor_hp' => 'required|integer',
            'password' => 'required|min:3',
        ]);

        User::create($validateData);

        return response()->json([
            'success' => true,
            'data' => $validateData,
            'message' => 'Registrasi Penyewa berhasil!',
        ]);
    }
}
