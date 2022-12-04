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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id');
            $table->foreignId('user_id');
            $table->string('invoice');
            $table->string('nama_penyewa');
            $table->string('nama_studio');
            $table->string('nama_pemilik');
            $table->bigInteger('total');
            $table->integer('biaya_admin');
            $table->enum('jenis',['Pemesanan Langsung','Melalui Aplikasi']);
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
        Schema::dropIfExists('transaksis');
    }
};
