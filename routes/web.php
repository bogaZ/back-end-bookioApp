<?php

use App\Models\Kategori;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DataUserPenyewa;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DataUserPenyedia;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AkunAdminController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\DataStudioController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DataWithdrawController;
use App\Http\Controllers\DataPemesananController;
use App\Http\Controllers\DataTransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/







Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index']);

    Route::get('/register', [RegisterController::class, 'index']);

    Route::post('/register', [RegisterController::class, 'store']);

    Route::post('/login', [LoginAdminController::class, 'authenticate'])->name('login');
});

Route::middleware(['auth','level:admin'])->group(function () {
    Route::get('/', function () {
        return view('home', [
            'title' => 'Home',
            'kategoris' => Kategori::all(),
        ]);
    });

    Route::get('/home', [HomeController::class, 'index']);

    Route::get('/userMember', [UserAdminController::class, 'index']);

    Route::post('/userMember/add', [UserAdminController::class, 'add']);

    Route::put('/change/password/admin',[UserAdminController::class,'changePassword']);

    Route::get('/ubahPassword',[UserAdminController::class,'ubahPassword']);

    Route::put('/pemesanan/konfirmasi/{id}', [DataPemesananController::class, 'konfirmasi']);

    Route::put('/pemesanan/batalkan/{id}', [DataPemesananController::class, 'batalkan']);

    Route::resource('/detailKategori',KategoriController::class);

    Route::get('/akunAdmin', [AkunAdminController::class, 'index']);

    Route::get('/pembayaran', [PembayaranController::class, 'index']);
    
    Route::put('/pembayaran', [PembayaranController::class, 'process']);

    Route::put('/akunAdmin/update', [AkunAdminController::class, 'update']);

    Route::get('/dataWithdraw', [DataWithdrawController::class, 'index']);

    Route::post('/dataWithdraw/upload', [DataWithdrawController::class, 'upload']);

    Route::get('/userPenyewa', [DataUserPenyewa::class, 'index']);

    Route::get('/userPenyedia', [DataUserPenyedia::class, 'index']);

    Route::get('/dataStudio', [DataStudioController::class, 'index']);

    Route::get('/detailStudio/{id}',[DataStudioController::class, 'detailMyStudio']);

    Route::put('/update/status/tempat/{id}',[DataStudioController::class,'updateStatusTerverifikasi']);

    Route::put('/update/status/tempat/belum/{id}',[DataStudioController::class,'updateStatusBelumTerverifikasi']);

    Route::put('/update/status/transaksi/nonaktif/{id}',[DataStudioController::class,'updateTransaksiNonaktif']);

    Route::put('/update/status/transaksi/aktif/{id}',[DataStudioController::class,'updateTransaksiAktif']);

    Route::get('/dataPemesanan', [DataPemesananController::class, 'index']);

    Route::get('/dataTransaksi', [DataTransaksiController::class, 'index']);

    Route::post('/logout', [LoginAdminController::class, 'logout']);

    Route::get('/cetak/transaksi/{tglAwal}/{tglAkhir}',[DataTransaksiController::class,'cetakTransaksi']);

    Route::get('/cetak/withdraw/{tglAwal}/{tglAkhir}',[DataWithdrawController::class,'cetakWithdraw']);
    //Route::get('/storage/bukti-transfer',[PictureController::class, 'getImage']);
});



