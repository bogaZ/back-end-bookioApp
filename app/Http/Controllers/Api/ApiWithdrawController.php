<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Saldo;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class ApiWithdrawController extends Controller
{
    //
    public function store(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $user = auth()->user();
        $saldo = $user->pembayaran->saldo;
        $request['user_id'] = $user->id;
        $validateData = $request->validate([
            'user_id' => 'required',
            'jumlah' => 'required',
        ]);
        $jumlah = $validateData['jumlah'];
        if(  $jumlah > $saldo->jumlah){
            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi dari saldo yang anda miliki!',
            ]);
        }
        $updateData['jumlah'] = $saldo->jumlah - $validateData['jumlah'];
        Saldo::all()->find($user->pembayaran->saldo->id)->update($updateData);
        Withdraw::create($validateData);
        // MEMGIRIM NOTIFIKASI KE USERS TERKAIT
        $apiWithdrawController = new NotificationController();

        // NOTIFIKASI KE USER PENYEDIA
        $judul = 'Withdraw dalam status menunngu';

        $deskripsi = 'Kami akan segera mengkonfirmasi withdraw yang anada lakukan!';

        $link = '/withdraw';

        $apiWithdrawController->sendNotification($request, $user, $judul,$deskripsi,$link);

        // NOTIFIKASI KE USER ADMIN
        $userAdmin = User::all()->firstWhere('level','admin');

        $judul = 'Withdraw dari '.$user->name;

        $deskripsi = 'Segera lakukan transfer ke rekening penyedia studio!';

        $link = '/withdraw';

        $apiWithdrawController->sendNotification($request, $userAdmin, $judul,$deskripsi,$link);

        return response()->json([
            'success' => true,
            'message' => 'Withdraw successfully!',
        ]);
    }

    // Menampilkan data withdraw
    public function show(){
        $user = auth()->user();
        $withdraw = $user->withdraw->sortDesc();
        return response()->json([
            'success' => true,
            'data' => $withdraw,
        ]);
    }
}
