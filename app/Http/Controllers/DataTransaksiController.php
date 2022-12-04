<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class DataTransaksiController extends Controller
{
    //
    public function index(){
        return view('dataTransaksi',[
            'title' => 'Data Transaksi & Keuangan',
            'transaksis' => Transaksi::all()->where('jenis','Melalui Aplikasi')->sortDesc(),
        ]);
    }

    public function cetakTransaksi($tglawal,$tglakhir){
        return view('cetakTransaksi',[
            'transaksis'=> Transaksi::all()->where('jenis','Melalui Aplikasi')->whereBetween('created_at',[$tglawal,$tglakhir]),
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
        ]);
    }
}
