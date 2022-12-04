<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiTransaksiController extends Controller
{
    //
    public function getTransaksiPenyedia(){
        $user = auth()->user();
        $transaksi = $user->transaksi->sortDesc();
        if(count($transaksi) == 1){
            $transaksi = [$transaksi->first()];
        }
        return response()->json([
            'success' => true,
            'data' => $transaksi,
        ]);
    }
}
