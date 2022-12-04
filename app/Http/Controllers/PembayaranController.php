<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Saldo;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    //
    public function index()
    {

        // $data = User::first();
        // return $data->pembayaran;
        //return Pembayaran::firstWhere('id_user', auth()->user()->id);
        return view('pembayaran ', [
            'title' => 'Akun Pembayaran',
            'pembayaran' => Pembayaran::firstWhere('user_id', auth()->user()->id),
        ]);
    }

    public function process(Request $request)
    {
        $user = auth()->user();

        $request['user_id'] = auth()->user()->id;

        $validateData = $request->validate([
            'user_id' => 'required',
            'nama_bank' => 'required',
            'nomer_rekening' => 'required',
            'nama_pemilik' => 'required',
        ]);

        $cek = Pembayaran::firstWhere('user_id', auth()->user()->id);

        if ($cek != null) {
            Pembayaran::where('user_id', auth()->user()->id)->update($validateData);
            return redirect('/pembayaran');
        }

        Pembayaran::create($validateData);

        // return $pembayaran = Pembayaran::all()->firstWhere('user_id',$user->id);

        // $validateData = $request->validate();     
        
        // $validateData['pemesanan_id'] = $pembayaran->id;

        // Saldo::create($validateData);
        
        return redirect('/pembayaran');
    }

    // Show akun pembayaran penyedia
    public function pembayaranPenyedia()
    {
        $user = auth()->user();
        $pembayaran = $user->pembayaran;
        if ($pembayaran == null) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum menambahakan akun pembayaran'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $pembayaran,
            'saldo' => $pembayaran->saldo->jumlah,
        ]);
    }

     // REST API menambahkan akun pembayaran
    public function add(Request $request)
    {
        $user_id = auth()->user()->id;
        $check = Pembayaran::all()->firstWhere('user_id', $user_id);
        if ($check != null) {
            return response()->json([
                'message' => 'Anda sudah menambahkan akun pembayaran'
            ]);
        }
        $request['user_id'] = $user_id;
        $validateData = $request->validate([
            'user_id' => 'required',
            'nama_bank' => 'required',
            'nomer_rekening' => 'required|integer',
            'nama_pemilik' => 'required',
        ]);
        Pembayaran::create($validateData);

        $pembayaran = Pembayaran::all()->firstWhere('user_id',$user_id);    
        
        $validateData['pembayaran_id'] = $pembayaran->id;

        Saldo::create($validateData);

        return response()->json([
            'success' => true,
            'data' => auth()->user()->pembayaran,
            'message' => 'Akun pembayaran berhasil ditambahkan!',
        ]);
    }

    // REST API Update akun pembayaran
    public function update(Request $request){
        $user_id = auth()->user()->id;
        $check = Pembayaran::all()->firstWhere('user_id',$user_id);
        if($check == null){
            return response()->json([
                'message' => 'Anda belum menambahkan akun Pembayaran',
            ]);
        }
        $validateData = $request->validate([
            'nama_bank' => 'required',
            'nomer_rekening' => 'required|integer',
            'nama_pemilik' => 'required',
        ]);
        $check->update($validateData);
        return response()->json([
            'success' => true,
            'data' => $validateData,
            'dataRekening' => auth()->user()->pembayaran,
            'message' => 'Berhasil melakukan update akun pembayaran!',
        ]);
    }
}
