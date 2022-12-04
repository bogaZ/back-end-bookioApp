<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {

        return view('home', [
            'title' => 'Home',
            'kategoris' => Kategori::all(),
        ]);
    }
}
