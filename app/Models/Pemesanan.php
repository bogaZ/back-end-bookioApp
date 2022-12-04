<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function studio(){
        return $this->belongsTo(Studio::class);
    }

    public function transaksi(){
        return $this->hasOne(Transaksi::class);
    }

    public function buktiPembayaran(){
        return $this->hasOne(BuktiPembayaran::class);
    }
}
