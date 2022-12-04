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
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique();
            $table->string('nama_studio');
            $table->string('alamat');
            $table->string('deskripsi');
            $table->double('rating')->default(0);
            $table->bigInteger('tarif_minimal');
            $table->bigInteger('tarif_maksimal');
            $table->enum('status_tempat',['Belum Terverifikasi','Terverifikasi'])->default('Belum Terverifikasi');
            $table->enum('status_transaksi',['Nonaktif','Aktif'])->default('Nonaktif');
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
        Schema::dropIfExists('studios');
    }
};
