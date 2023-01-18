<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Saldo;
use App\Models\Studio;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // //USER PENYEDIA
        // User::create([
        //     'name' => 'green',
        //     'email' => 'green@gmail.com',
        //     'nomor_hp' => '456787656',
        //     'level' => 'penyedia',
        //     'password' => bcrypt('123'),
        // ]);

        // // USER PENYEWA
        // User::create([
        //     'name' => 'bagus',
        //     'email' => 'bagus@gmail.com',
        //     'nomor_hp' => '456787656',
        //     'level' => 'penyewa',
        //     'password' => bcrypt('123'),
        // ]);


        // USER ADMIN
        User::create([
            'name' => 'admin',
            'email' => 'adminbookio@gmail.com',
            'nomor_hp' => '456787656',
            'level' => 'Admin',
            'password' => bcrypt('12345678'),
        ]);

        // PEMBAYARAN PENYEDIA
        Pembayaran::create([
            'user_id' => 2,
            'nama_bank' => 'BNI',
            'nomer_rekening' => '567876567',
            'nama_pemilik' => 'Budianto',
        ]);

        // SALDO
        Saldo::create([
            'pembayaran_id' => 1,
            'jumlah' => 5000000,
        ]);

        // STUDIO PENYEDIA
        Studio::create([
            'user_id' => 2,
            'nama_studio' => 'Green',
            'alamat' => 'Banyuwangi',
            'deskripsi' => 'keren',
            'tarif_minimal' => 10000,
            'tarif_maksimal' => 20000,
        ]);

        // FASILITAS 
        Fasilitas::create([
            'studio_id' => 1,
            'nama_fasilitas' => 'Ruang Platinum',
            'tarif' => 10000,
        ]);

        Fasilitas::create([
            'studio_id' => 1,
            'nama_fasilitas' => 'Ruang Premium',
            'tarif' => 20000,
        ]);

        Fasilitas::create([
            'studio_id' => 1,
            'nama_fasilitas' => 'Ruang Gold',
            'tarif' => 30000,
        ]);

        // WITHDRAW
        Withdraw::create([
            'user_id' => 2,
            'Jumlah' => 300000,
        ]);

        Withdraw::create([
            'user_id' => 2,
            'Jumlah' => 700000,
        ]);

        $hari = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        for ($i = 0; $i < count($hari); $i++) {
            $validateData['studio_id'] = 1;
            $validateData['nama_hari'] = $hari[$i];
            Jadwal::create($validateData);
        }

    }
}