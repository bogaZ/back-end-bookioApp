<?php

use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiStudioController;
use App\Http\Controllers\Api\ApiTransaksiController;
use App\Http\Controllers\Api\ApiWithdrawController;
use App\Http\Controllers\ApiJadwalController;
use App\Http\Controllers\ApiPemesananController;
use App\Http\Controllers\ApiRegisterController;
use App\Http\Controllers\ApiUsersController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware(['guest'])->group(function () {
    // REST API LOGIN
    Route::controller(ApiLoginController::class)->group(function () {
        Route::post('/login/penyewa', 'authenticatePenyewa');

        Route::post('/login/penyedia', 'authenticatePenyedia');

        
    });

    // REST API REGISTER
    Route::controller(ApiRegisterController::class)->group(function () {
        Route::post('/register/penyewa', 'registerPenyewa');

        Route::post('/register/penyedia',  'registerPenyedia');
    });
});

Route::middleware(['auth:api', 'level:penyedia,penyewa'])->group(function () {
    // RET API KELOLA AKUN USER PENYEDIA
    Route::controller(ApiUsersController::class)->group(function () {
        Route::get('/akun/show', 'show');

        Route::put('/akun/update', 'update');

        Route::put('/change/password','changePassword');
    });

    Route::controller(ApiPemesananController::class)->group(function(){
        Route::post('/pemesanan/studio/{studio_id}','showPemesananStudio');
    });

    Route::get('/logout',[ApiLoginController::class,'logout']);
});

// REST API AKUN PENYEWA
Route::middleware(['auth:api', 'level:penyedia'])->group(function () {

    // REST API CRUD AKUN PEMBAYARAN
    Route::controller(PembayaranController::class)->group(function () {
        Route::get('/pembayaran/penyedia', 'pembayaranPenyedia');

        Route::post('/pembayaran/penyedia/add',  'add');

        Route::put('/pembayaran/penyedia/update', 'update');
    });


    // REST API CRUD DATA STUDIO
    Route::controller(ApiStudioController::class)->group(function () {
        Route::post('/studio/create', 'create');

        Route::get('/studio/show', 'show');

        Route::put('/studio/update', 'update');

        Route::post('/studio/image/add','addImage');

        Route::get('/studio/image/delete/{id}', 'deleteImage');
    });


    // REST API CRUD DATA FASILITAS
    Route::controller(FasilitasController::class)->group(function () {
        Route::post('/studio/fasilitas/add',  'add');

        Route::get('/studio/fasilitas/show', 'show');

        Route::get('/studio/fasilitas/detail/{id}', 'detail');

        Route::put('/studio/fasilitas/update/{id}', 'update');

        Route::delete('/studio/fasilitas/delete/{id}', 'delete');
    });


    // REST API PEMESANAN
    Route::controller(ApiPemesananController::class)->group(function () {
        Route::get('/pemesanan/penyedia/show', 'showFromPenyedia');

        Route::get('/pemesanan/penyedia/show/detail/{id}', 'DetailFromPenyedia');

        Route::get('/pemesanan/langsung/penyedia/show/detail/{id}', 'DetailPemesananLangsungPenyedia');

        Route::post('/pemesanan/penyedia/add','addFromPenyedia');

        Route::get('/pemesanan/langsung/penyedia/show','showPemesananLangsung');
        
    });

    // REST API WITHDRAW
    Route::controller(ApiWithdrawController::class)->group(function () {
        Route::post('/withdraw', 'store');
        Route::get('/withdraw/show','show');
    });

    Route::controller(ApiJadwalController::class)->group(function () {
        // REAT API PENGATURAN JADWAL
        Route::post('/jadwal/add', 'add');

        Route::get('/jadwal/show', 'show');

        Route::put('/jadwal/edit/{id}', 'edit');
    });

    Route::controller(ApiTransaksiController::class)->group(function(){
        Route::get('/transaksi/penyedia','getTransaksiPenyedia');
    });
});


Route::middleware(['auth:api', 'level:penyewa'])->group(function () {
    // REST API PEMESANAN
    Route::controller(ApiPemesananController::class)->group(function () {
        Route::post('/pemesanan/penyewa/add',  'add');

        Route::get('/pemesanan/penyewa/show',  'show');

        Route::get('/pemesanan/penyewa/show/detail/{id}', 'detail');

       

        Route::post('/pemesanan/penyewa/show/detail','detailPemesananPenyewa');

        Route::post('/pemesanan/upload/buktipembayaran','uploadBuktiPembayaran');
    });

    Route::controller(ApiStudioController::class)->group(function(){
        Route::get('/penyewa/studio/show','allStudio');
        Route::get('/penyewa/studio/allshow','allShow');
        Route::get('/penyewa/studio/show/{id}','showDetail');
    });
    
});
