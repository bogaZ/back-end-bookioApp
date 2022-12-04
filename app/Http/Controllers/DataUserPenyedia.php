<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Withdraw;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DataUserPenyedia extends Controller
{
    //
    public function index(){
        return view('userPenyedia',[
            'title' => 'Data User Penyedia',
            'users' => User::all()->where('level','penyedia'),
            'withdraws' => Withdraw::all()
        ]);
    }
}
