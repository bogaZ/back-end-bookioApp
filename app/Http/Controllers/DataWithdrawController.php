<?php

namespace App\Http\Controllers;

use App\Models\BuktiTransfer;
use App\Models\Saldo;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataWithdrawController extends Controller
{
    // MENAMPILKAN TAMPILAN HALAMAN WITHDRAW
    public function index()
    {
        return view('dataWithdraw', [
            'title' => 'Data Withdraw',
            'withdraws' => Withdraw::all()->sortDesc(),
            'saldos' => Saldo::all(),
        ]);
    }

    // MENGUPLOAD BUKTI TRANSFER
    public function upload(Request $request)
    {
        //return BuktiTransfer::all()->firstWhere('withdraw_id',$request['withdraw_id']);
        date_default_timezone_set('Asia/Jakarta');
        $buktiTransfer = BuktiTransfer::all()->firstWhere('withdraw_id', $request['withdraw_id']);
        if ($buktiTransfer != null) {
            $this->update($request);
            // MELAKUKAN DELETE IMAGE
            Storage::delete($buktiTransfer->image);
            return redirect()->intended('/dataWithdraw');
        }

        
        $validateData = $request->validate([
            'withdraw_id' => 'required',
            'image' => 'image|required',
        ]);
        $validateData['image'] = $request->file('image')->store('bukti-transfer');
        
        BuktiTransfer::create($validateData);

        $id = $request['withdraw_id'];

        $this->konfirmasi($request, $id);
        
        // SEND NOTIFIKASI SAAT DATA DIKONFIRMASI ADMIN
        $apiPemesananController = new ApiPemesananController();

        $userPenyedia = Withdraw::find($id)->user;

        $judulNotifPenyedia = 'Withdraw telah dikonfirmasi';

        $apiPemesananController->sendNotifPenyedia($request,$userPenyedia,$judulNotifPenyedia);

        return redirect()->intended('/dataWithdraw');
    }

    // MELAKUKAN KONFIRMASI WITHDRAW
    public function konfirmasi(Request $request, $id)
    {
        $request['status'] = 'Lunas';

        $validateData = $request->validate([
            'status' => 'required'
        ]);

        Withdraw::all()->find($id)->update($validateData);
    }

    // METHOD UPDATE BUKTI TRRANSFER
    public function update(Request $request)
    {
        $withdraw_id = $request['withdraw_id'];
        $validateData = $request->validate([
            'image' => 'image|required',
        ]);
        $validateData['image'] = $request->file('image')->store('bukti-transfer');
        BuktiTransfer::all()->firstWhere('withdraw_id', $withdraw_id)->update($validateData);
    }

    public function cetakWithdraw($tglawal,$tglakhir){
        return view('cetakWithdraw',[
            'withdraws' => Withdraw::all()->where('status','Lunas')->whereBetween('updated_at',[$tglawal,$tglakhir]),
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
            'saldos' => Saldo::all(),
            'allWithdraw' => Withdraw::all(),
        ]);
    }


}
