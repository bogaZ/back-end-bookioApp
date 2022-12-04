<?php

namespace App\Http\Controllers;

use App\Models\BuktiPembayaran;
use App\Models\Fasilitas;
use App\Models\Notification;
use App\Models\Pemesanan;
use App\Models\Studio;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiPemesananController extends Controller
{
    // MENAMBAH PEMESANAN
    public function add(Request $request)
    {
        $jam =  ['00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00','24:00'];

        date_default_timezone_set('Asia/Jakarta');

        $user = auth()->user();

        $request['invoice'] =  $this->autoInvoice();

        $request['user_id'] = $user->id;
        $request['status'] = 'Menunggu Pembayaran';
        $validateData = $request->validate([
            'user_id' => 'required',
            'studio_id' => 'required',
            'invoice' => 'required',
            'tanggal' => 'required',
            'status' => 'required',
            'fasilitas_dipesan' => 'required|array',
            'fasilitas_dipesan.*.fasilitas_id' =>  'required|integer',
            'fasilitas_dipesan.*.jam_awal' =>  'required',
            'fasilitas_dipesan.*.jam_akhir' =>  'required',
            'fasilitas_dipesan.*.durasi' =>  'required|integer',
        ]);




        $validateData['total_tarif'] = 0;

        for ($i = 0; $i < count($validateData['fasilitas_dipesan']); $i++) {
            $id = $validateData['fasilitas_dipesan'][$i]['fasilitas_id'];
            $fasilitas = Fasilitas::all()->find($id);
            $tarif = $fasilitas->tarif;
            $validateData['fasilitas_dipesan'][$i]['total'] = $tarif * $validateData['fasilitas_dipesan'][$i]['durasi'];
            $validateData['fasilitas_dipesan'][$i]['nama_fasilitas'] = $fasilitas->nama_fasilitas;
            $validateData['total_tarif'] = $validateData['total_tarif'] +  $validateData['fasilitas_dipesan'][$i]['total'];
        }        

        $validateData['invoice'] =  $this->autoInvoice();

        $validateData['dedline'] = Carbon::now()->addMinute(2);
        
        // Validasi Sebelum Data Disimpan
        $dataPemesanan = Studio::find($request['studio_id'])->pemesanan->where('tanggal',$request['tanggal'])->sortDesc();
        //return $dataPemesanan[0];
        
        if(count($dataPemesanan) == 1){
            $dataPemesanan = [Studio::find($request['studio_id'])->pemesanan->firstWhere('tanggal',$request['tanggal'])];
            
            
            for($i = 0;$i<count($validateData['fasilitas_dipesan']);$i++){
                for($k = 0 ; $k<count(json_decode($dataPemesanan[0]['fasilitas_dipesan']));$k++){
                    
                    $indexJamAwal = array_search($validateData['fasilitas_dipesan'][$i]['jam_awal'],$jam);
                    $indexJamAkhir = array_search($validateData['fasilitas_dipesan'][$i]['jam_akhir'],$jam);
                    if($dataPemesanan[0]->status != 'Kadaluarsa' && $dataPemesanan[0]->status != 'Dibatalkan' ){
                        
                        if($validateData['fasilitas_dipesan'][$i]['fasilitas_id'] == json_decode($dataPemesanan[0]['fasilitas_dipesan'])[$k]->fasilitas_id ){
                            if($indexJamAwal >= array_search(json_decode($dataPemesanan[0]['fasilitas_dipesan'])[$k]->jam_awal, $jam) && $indexJamAwal < array_search(json_decode($dataPemesanan[0]['fasilitas_dipesan'])[$k]->jam_akhir, $jam) ){
                                
                                if($dataPemesanan[0]['dedline'] > Carbon::now()){
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'Jadwal Tidak Tersedia!',
                                    ]);
                                }
    
                            }else if($indexJamAkhir > array_search(json_decode($dataPemesanan[0]['fasilitas_dipesan'])[$k]->jam_awal, $jam) && $indexJamAkhir <= array_search(json_decode($dataPemesanan[0]['fasilitas_dipesan'])[$k]->jam_akhir, $jam)  ){
    
                                if($dataPemesanan[0]['dedline'] > Carbon::now()){
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'Jadwal Tidak Tersedia!',
                                    ]);
                                }
    
                            }else if($indexJamAwal < array_search(json_decode($dataPemesanan[0]['fasilitas_dipesan'])[$k]->jam_awal, $jam) && $indexJamAkhir >=  array_search(json_decode($dataPemesanan[0]['fasilitas_dipesan'])[$k]->jam_akhir, $jam)  ){
    
                                if($dataPemesanan[0]['dedline'] > Carbon::now()){
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'Jadwal Tidak Tersedia!',
                                    ]);
                                }
                            
                            }
                        }
                    }
                }
            }

        }else{
            $keys = array_keys(json_decode($dataPemesanan, true));
     
            for($i = 0;$i<count($validateData['fasilitas_dipesan']);$i++){
    
                for($j=0;$j<count($keys);$j++){
    
                    for($k = 0 ; $k<count(json_decode($dataPemesanan[$keys[$j]]['fasilitas_dipesan']));$k++){
                        $indexJamAwal = array_search($validateData['fasilitas_dipesan'][$i]['jam_awal'],$jam);
                        $indexJamAkhir = array_search($validateData['fasilitas_dipesan'][$i]['jam_akhir'],$jam);
                        if($dataPemesanan[$keys[$j]]['status'] != 'Kadaluarsa' && $dataPemesanan[$keys[$j]]['status'] != 'Dibatalkan'){
                            if($validateData['fasilitas_dipesan'][$i]['fasilitas_id'] == json_decode($dataPemesanan[$keys[$j]]['fasilitas_dipesan'])[$k]->fasilitas_id ){
                                if($indexJamAwal >= array_search(json_decode($dataPemesanan[$keys[$j]]['fasilitas_dipesan'])[$k]->jam_awal, $jam) && $indexJamAwal < array_search(json_decode($dataPemesanan[$keys[$j]]['fasilitas_dipesan'])[$k]->jam_akhir, $jam) ){
                                    if($dataPemesanan[$keys[$j]]['dedline'] > Carbon::now()){
                                        return response()->json([
                                            'success' => false,
                                            'message' => 'Jadwal Tidak Tersedia!',
                                        ]);
                                    }
                                    
        
                                }else if($indexJamAkhir > array_search(json_decode($dataPemesanan[$keys[$j]]['fasilitas_dipesan'])[$k]->jam_awal, $jam) && $indexJamAkhir <= array_search(json_decode($dataPemesanan[$keys[$j]]['fasilitas_dipesan'])[$k]->jam_akhir, $jam)  ){
        
                                    if($dataPemesanan[$keys[$j]]['dedline'] > Carbon::now()){
                                        return response()->json([
                                            'success' => false,
                                            'message' => 'Jadwal Tidak Tersedia!',
                                        ]);
                                    }
        
                                }else if($indexJamAwal < array_search(json_decode($dataPemesanan[$keys[$j]]['fasilitas_dipesan'])[$k]->jam_awal, $jam) && $indexJamAkhir >=  array_search(json_decode($dataPemesanan[$keys[$j]]['fasilitas_dipesan'])[$k]->jam_akhir, $jam)  ){
        
                                    if($dataPemesanan[$keys[$j]]['dedline'] > Carbon::now()){
                                        return response()->json([
                                            'success' => false,
                                            'message' => 'Jadwal Tidak Tersedia!',
                                        ]);
                                    }
                                
                                }
                            }
                        }
                        
                        
                    }
                
                }
                
            }
        }
      
        
        // Tambah Data Pemesanan
        $validateData['fasilitas_dipesan'] = json_encode($validateData['fasilitas_dipesan']);
        Pemesanan::create($validateData);

        $studio = Studio::all()->firstWhere('id', $validateData['studio_id']);

        $judulNotifPenyewa = 'Booking ' . $studio->nama_studio;
        $judulNotifPenyedia = 'Booking dari ' . $user->name;
        $userPenyedia = $studio->user;

        // METHODD NOTIFIKASI OTOMATIS SAAT BERHASIL MELAKUKAN PEMESANAN
        $this->sendNotifPenyewa($request, $user, $judulNotifPenyewa);

        $this->sendNotifPenyedia($request, $userPenyedia, $judulNotifPenyedia);

        $this->sendNotifAdmin($request, $studio, $user);

        // $pemesanan = Pemesanan::all()->firstWhere('invoice',)

        return response()->json([
            'success' => true,
            'data' => $validateData['invoice'],
            'message' => 'Berhasil melakukan Pemesanan!',
        ]);
    }

    public function addFromPenyedia(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');

        $user = auth()->user();
        // $fasilitas_dipesan = Pemesanan::all()->where('user_id',$user->id)->first()->fasilitas_dipesan;
        // $data = json_decode($fasilitas_dipesan);
        // return $data[0]->durasi;

        $request['invoice'] =  $this->autoInvoice();

        
        $request['status'] = 'Berhasil Dipesan';
        $validateData = $request->validate([
            'nama_user' => 'required',
            'nomor_hp' => 'required',
            'studio_id' => 'required',
            'invoice' => 'required',
            'tanggal' => 'required',
            'status' => 'required',
            'fasilitas_dipesan' => 'required|array',
            'fasilitas_dipesan.*.fasilitas_id' =>  'required|integer',
            'fasilitas_dipesan.*.jam_awal' =>  'required',
            'fasilitas_dipesan.*.jam_akhir' =>  'required',
            'fasilitas_dipesan.*.durasi' =>  'required|integer',
            //'fasilitas_dipesan.*.total' =>  'required|integer',
            //'total_tarif' => 'required|integer',
        ]);




        $validateData['total_tarif'] = 0;

        for ($i = 0; $i < count($validateData['fasilitas_dipesan']); $i++) {
            $id = $validateData['fasilitas_dipesan'][$i]['fasilitas_id'];
            $fasilitas = Fasilitas::all()->find($id);
            $tarif = $fasilitas->tarif;
            $validateData['fasilitas_dipesan'][$i]['total'] = $tarif * $validateData['fasilitas_dipesan'][$i]['durasi'];
            $validateData['fasilitas_dipesan'][$i]['nama_fasilitas'] = $fasilitas->nama_fasilitas;
            $validateData['total_tarif'] = $validateData['total_tarif'] +  $validateData['fasilitas_dipesan'][$i]['total'];
        }

        $validateData['fasilitas_dipesan'] = json_encode($validateData['fasilitas_dipesan']);
        //return $validateData['fasilitas_dipesan'];
        // $myData = auth()->user()->pemesanan->first()->studio;
        // return $myData;
        $validateData['invoice'] =  $this->autoInvoice();

        $validateData['dedline'] = Carbon::now()->addMinute(2);

        $addData = Pemesanan::create($validateData);

        $this->simpanTransaksi($request,$addData);

        return response()->json([
            'success' => true,
            'data' => $addData,
            'message' => 'Berhasil melakukan Pemesanan!',
        ]);
    }

    public function simpanTransaksi(Request $request, $pemesanan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $request['pemesanan_id'] = $pemesanan->id;
        $request['user_id'] = $pemesanan->studio->user->id;
        $request['invoice'] = $pemesanan->invoice;
        $request['nama_penyewa'] = $pemesanan->nama_user;
        $request['nama_studio'] = $pemesanan->studio->nama_studio;
        $request['nama_pemilik'] = $pemesanan->studio->user->name;
        $request['total'] = $pemesanan->total_tarif;
        $request['biaya_admin'] = 0;
        $request['jenis'] = 'Pemesanan Langsung';


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
    }

    public function timer($jamSekarang , $baru){
         
    }


    // MEMBUAT KODE INVOICE ATAU KODE PEMESANAN OTOMATIS
    public function autoInvoice()
    {
        $tanggal = Carbon::now();
        $cek = Pemesanan::all()->count();
        if ($cek == 0) {
            $kode = 10000001;
            $invoice = 'BKO' . $tanggal->year . $tanggal->month . $tanggal->day . $kode;
            return $request['invoice'] = $invoice;
        } else {
            $pemesanan = Pemesanan::all()->last();
            $str = (int)substr($pemesanan->invoice, -8) + 1;
            $invoice = 'BKO' . $tanggal->year . $tanggal->month . $tanggal->day . $str;
            return $request['invoice'] = $invoice;
        }
    }

    // METHODD NOTIFIKASI OTOMATIS SAAT BERHASIL MELAKUKAN PEMESANAN
    public function sendNotifPenyewa(Request $request, $user, $judulNotifPenyewa)
    {
        $request['user_id'] = $user->id;
        $request['judul'] = $judulNotifPenyewa;
        $request['deskripsi'] = 'Booking diterima segera lakukan pembayaran!';
        $request['link'] = '/detailPemesananPenyewa';
        $validateData = $request->validate([
            'user_id' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'link' => 'required',
        ]);
        Notification::create($validateData);
    }

    // METHODD NOTIFIKASI OTOMATIS SAAT BERHASIL MELAKUKAN PEMESANAN
    public function sendNotifPenyedia(Request $request, $userPenyedia, $judulNotifPenyedia)
    {
        $request['user_id'] = $userPenyedia->id;
        $request['judul'] = $judulNotifPenyedia;
        $request['deskripsi'] = 'Pemesanan dalam status menunggu Pembayaran!';
        $request['link'] = '/detailPemesananPenyedia';
        $validateData = $request->validate([
            'user_id' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'link' => 'required',
        ]);
        Notification::create($validateData);
    }

    // METHODD NOTIFIKASI OTOMATIS SAAT BERHASIL MELAKUKAN PEMESANAN
    public function sendNotifAdmin(Request $request, $studio, $user)
    {
        $request['user_id'] = User::all()->firstWhere('level', 'admin')->id;
        $request['judul'] = 'Booking ' . $studio->nama_studio;
        $request['deskripsi'] = 'Pemesanan studio ' . $studio->nama_studio . ' dari ' . $user->name . ' dalam status menunggu pembayaran';
        $request['link'] = '/dataPemesanan';
        $validateData = $request->validate([
            'user_id' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'link' => 'required',
        ]);
        Notification::create($validateData);
    }

    // Method Show data Pemesanan dari sisi penyewa
    public function show()
    {
        $user = auth()->user();
        $pemesanan = $user->pemesanan;
        return response()->json([
            'success' => true,
            'data' => $pemesanan->sortDesc(),
        ]);
    }

    // Methos Show detaiL data pemesanan dari sisi penyewa
    public function detail($id)
    {
        $user = auth()->user();
        //return Pemesanan::all();
        $pemesanan = Pemesanan::all()->where('user_id', $user->id)->firstWhere('id', $id);
        $fasilitas_dipesan = json_decode($pemesanan->fasilitas_dipesan);

        return response()->json([
            'id' => $pemesanan->id,
            'user_id' => $pemesanan->user_id,
            'studio_id' => $pemesanan->studio_id,
            'tanggal' => $pemesanan->tanggal,
            'status' => $pemesanan->status,
            'fasilitas_dipesan' => $fasilitas_dipesan,
        ]);
    }

    // Method Show data Pemesanan dari sisi Penyedia
    public function showFromPenyedia()
    {
        $user = auth()->user();

        $pemesanan = $user->studio->pemesanan->where('user_id','!=',null)->sortDesc();
      if(count($pemesanan) == 1){
            $pemesanan =  [$user->studio->pemesanan->firstWhere('user_id','!=',null)];
        }
        return response()->json([
            'success' => true,
            'data' => $pemesanan,
            'user_data' => User::all(),
            'image_studio' => $user->studio->imageStudio
        ]);
    }

    public function showPemesananLangsung(){
        $user = auth()->user();

        $pemesanan = $user->studio->pemesanan->where('user_id','==',null)->sortDesc();
        if(count($pemesanan) == 1){
            $pemesanan =  [$user->studio->pemesanan->firstWhere('user_id','==',null)];
        }
        return response()->json([
            'success' => true,
            'data' => $pemesanan,
            'user_data' => User::all(),
            'image_studio' => $user->studio->imageStudio
        ]);
    }

    // Methos Show detail data pemesanan dari sisi penyewa
    public function detailFromPenyedia($id)
    {
        $user = auth()->user();
       
        //return Pemesanan::all();
        $pemesanan = $user->studio->pemesanan->find($id);
        $fasilitas_dipesan = json_decode($pemesanan->fasilitas_dipesan);
        //return response()->json($fasilitas_dipesan);
        return response()->json([
            'id' => $pemesanan->id,
            'invoice' => $pemesanan->invoice,
            'user_id' => $pemesanan->user->id,
            'name' => User::all()->find($pemesanan->user_id)->name,
            'nomor_hp' => User::all()->find($pemesanan->user_id)->nomor_hp,
            'studio_id' => $pemesanan->studio->id,
            'nama_studio' => $user->studio->nama_studio,
            'alamat_studio' => $user->studio->alamat,
            'total' => $pemesanan->total_tarif,
            'tanggal' => $pemesanan->tanggal,
            'status' => $pemesanan->status,
            'dedline' => $pemesanan->dedline,
            'fasilitas_dipesan' => $fasilitas_dipesan,
        ]);
    }

    public function DetailPemesananLangsungPenyedia($id){
        $user = auth()->user();
       
        //return Pemesanan::all();
        $pemesanan = $user->studio->pemesanan->find($id);
        $fasilitas_dipesan = json_decode($pemesanan->fasilitas_dipesan);
        //return response()->json($fasilitas_dipesan);
        return response()->json([
            'id' => $pemesanan->id,
            'invoice' => $pemesanan->invoice,
            'user_id' => null,
            'name' => $pemesanan->nama_user,
            'nomor_hp' => $pemesanan->nomor_hp,
            'studio_id' => $pemesanan->studio->id,
            'nama_studio' => $user->studio->nama_studio,
            'alamat_studio' => $user->studio->alamat,
            'total' => $pemesanan->total_tarif,
            'tanggal' => $pemesanan->tanggal,
            'status' => $pemesanan->status,
            'dedline' => $pemesanan->dedline,
            'fasilitas_dipesan' => $fasilitas_dipesan,
        ]);
    }

    // METHODD NOTIFIKASI OTOMATIS SAAT BERHASIL MELAKUKAN PEMESANAN
    public function sendNotification(Request $request, $user, $judul, $deskripsi, $link)
    {
        $request['user_id'] = $user->id;
        $request['judul'] = $judul;
        $request['deskripsi'] = $deskripsi;
        $request['link'] = $link;
        $validateData = $request->validate([
            'user_id' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'link' => 'required',
        ]);
        Notification::create($validateData);
    }

    public function showPemesananStudio(Request $request, $studio_id){
        $dataPemesanan = Studio::find($studio_id)->pemesanan->where('tanggal',$request['tanggal'])->sortDesc();

        if(count($dataPemesanan) == 1){
            $dataPemesanan = [Studio::find($studio_id)->pemesanan->firstWhere('tanggal',$request['tanggal'])];
        }
     
            return response()->json([
                'success' => true,
                'data' =>  $dataPemesanan,
            ]);
    }

    public function detailPemesananPenyewa(Request $request){
        
        $dataPemesanan = Pemesanan::all()->firstWhere('invoice', $request['invoice']);
      
        return response()->json([
            'success' => true,
            'data' => $dataPemesanan,
            'data_bank' => User::all()->firstWhere('level','admin')->pembayaran
        ]);
    }

    // UPLOAD BUKTI PEMBAYARAN
    public function uploadBuktiPembayaran(Request $request){
        $buktipembayaran = BuktiPembayaran::all()->firstWhere('pemesanan_id',$request['pemesanan_id']);
        if($buktipembayaran != null){
            $this->update($request);
            Storage::delete($buktipembayaran->image);
            return response()->json([
                'success' => true,
                'message' => 'Update Bukti Pembayaran berhasil!'
            ]);
        }
        $validateData = $request->validate([
            'pemesanan_id' => 'required',
            'image' => 'required|image',
        ]);
        $validateData['image'] = $request->file('image')->store('bukti-pembayaran');
        BuktiPembayaran::create($validateData);
        $id = $validateData['pemesanan_id'];
        $this->konfirmasi($request,$id);
        return response()->json([
            'success' => true,
            'data' => $validateData['image']
        ]);
    }

    // MELAKUKAN KONFIRMASI WITHDRAW
    public function konfirmasi(Request $request, $id)
    {
        $request['status'] = 'Menunggu Konfirmasi';

        $validateData = $request->validate([
            'status' => 'required'
        ]);

        Pemesanan::all()->find($id)->update($validateData);
    }

    public function update(Request $request)
    {
        $pembayaran_id = $request['pembayaran_id'];
        $validateData = $request->validate([
            'image' => 'image|required',
        ]);
        $validateData['image'] = $request->file('image')->store('bukti-pembayaran');
        BuktiPembayaran::all()->firstWhere('pembayaran_id', $pembayaran_id)->update($validateData);
    }

    
}
