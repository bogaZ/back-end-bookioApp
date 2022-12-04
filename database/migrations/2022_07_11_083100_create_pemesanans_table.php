<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->nullable();
            $table->string('nama_user')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->foreignId('studio_id');
            $table->string('invoice');
            $table->date('tanggal');
            $table->enum('status',['Menunggu Pembayaran','Berhasil Dipesan','Kadaluarsa','Dibatalkan','Menunggu Konfirmasi']);
            $table->json('fasilitas_dipesan');
            $table->bigInteger('total_tarif');
            $table->dateTime('dedline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanans');
    }
};
