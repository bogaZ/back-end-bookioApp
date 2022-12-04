<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    //
    public function show($id)
    {
        return view('kategori.detailKategori', [
            'title' => Kategori::all()->find($id)->name,
            'kategoris' => Kategori::all(),
        ]);
        
    }

    
}
