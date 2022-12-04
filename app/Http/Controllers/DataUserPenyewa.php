<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class DataUserPenyewa extends Controller
{
    //

    public function index(){
        return view('userPenyewa',[
            'title' => 'Data User Penyewa',
            'users' => User::all()->where('level','penyewa'), 
            
        ]);
    }
}
