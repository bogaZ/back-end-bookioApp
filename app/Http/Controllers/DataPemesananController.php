<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\BuktiPembayaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;

class DataPemesananController extends Controller
{
    // METHOD MENAMPILKAN HALAMAN PEMESANAN
    public function index()
    {    
        date_default_timezone_set('Asia/Jakarta');
 
        return view('dataPemesanan', [
            'title' => 'Data Pemesanan',
            'pemesanans' => Pemesanan::all()->where('user_id','!=',null)->sortDesc(),

        ]);
    }

    // METHOD MELAKUKAN KONFIRMASI
    public function konfirmasi(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $validateData = $request->validate([]);

        $validateData['status'] = 'Berhasil Dipesan';

        $pemesanan = Pemesanan::all()->find($id);

        //return $pemesanan->user->name;
        $transaksi = Transaksi::all()->firstWhere('pemesanan_id', $pemesanan->id);

        if ($transaksi != null) {
            return redirect('/dataPemesanan');
        }

        // MELAKUKAN UPDATE PADA TABEL PEMESANAN
        Pemesanan::all()->find($id)->update($validateData);
        
        $data = Pemesanan::all()->find($id);
        // MENNGIRIM NOTIFIKASI OTOMATIS SETELAH PEMESANAN DIKONFIRAMSI KEPADA PENYEWA
        $apiPemesananController = new ApiPemesananController();

        $userPenyewa = Pemesanan::all()->find($id)->user;

        $judulNotif = 'Booking '.$data->invoice.' Dikonfirmasi';

        $deskripsi = 'Booking dalam status berhasil dipesan';

        $link = '/dataPemesanan';

        $apiPemesananController->sendNotification($request, $userPenyewa, $judulNotif, $deskripsi, $link);


        // MENNGIRIM NOTIFIKASI OTOMATIS SETELAH PEMESANAN DIKONFIRAMSI KEPADA PENYEDIA

        $userPenyedia = Pemesanan::all()->find($id)->studio->user;

        $judulNotif = 'Booking '.$data->invoice.' Dikonfirmasi';

        $deskripsi = 'Booking dalam status berhasil dipesan';

        $link = '/dataPemesanan';

        $apiPemesananController->sendNotification($request, $userPenyedia, $judulNotif, $deskripsi, $link);

        // MENYIMPAN TRANSAKSU SUCCESS SETELAH ADMIN MELAKUKAN KONFIRMASI
        $this->simpanTransaksi($request, $pemesanan);

        return redirect('/dataPemesanan');
    }

      // METHOD MELAKUKAN KONFIRMASI
      public function batalkan(Request $request, $id)
      {
          
          $validateData = $request->validate([]);
  
          $validateData['status'] = 'Dibatalkan';
  
          $pemesanan = Pemesanan::all()->find($id);
  
          // MELAKUKAN UPDATE PADA TABEL PEMESANAN
          Pemesanan::all()->find($id)->update($validateData);
          $buktipembayaran = BuktiPembayaran::all()->firstWhere('pemesanan_id',$pemesanan->id);
          Storage::delete($buktipembayaran->image);
          $buktipembayaran->delete();
          return redirect('/dataPemesanan');
      }
  

    // METHOD SIMPAN TRANSAKSI PEMESANAN BERHASIL
    public function simpanTransaksi(Request $request, $pemesanan)
    {

        $request['pemesanan_id'] = $pemesanan->id;
        $request['user_id'] = $pemesanan->studio->user->id;
        $request['invoice'] = $pemesanan->invoice;
        $request['nama_penyewa'] = $pemesanan->user->name;
        $request['nama_studio'] = $pemesanan->studio->nama_studio;
        $request['nama_pemilik'] = $pemesanan->studio->user->name;
        $request['total'] = $pemesanan->total_tarif;
        $request['biaya_admin'] = ($pemesanan->total_tarif * 5) / 100;
        $request['jenis'] = 'Melalui Aplikasi';


        $validateData = $request->validate([
            'pemesanan_id' => 'required',
            'user_id' => 'required',
            'invoice' => 'required',
            'nama_penyewa' => 'required',
            'nama_studio' => 'required',
            'nama_pemilik' => 'required',
            'total' => 'required',
            'biaya_admin' => 'required',
            'jenis' => 'required',
        ]);

        Transaksi::create($validateData);

        // MELAKUKAN UPDATE SALDO PENYEDIA SETELAH PEMESANAN DIKONFIRAMSI ADMIN
        $saldo = Saldo::all()->firstWhere('pembayaran_id',$pemesanan->studio->user->pembayaran->id);

        $validateData['jumlah'] =$saldo->jumlah + ($pemesanan->total_tarif - (($pemesanan->total_tarif * 5) / 100));

        Saldo::all()->firstWhere('id',$saldo->id)->update($validateData);
    }
}
