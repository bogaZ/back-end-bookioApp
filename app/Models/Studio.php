<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function fasilitas(){
        return $this->hasMany(Fasilitas::class);
    }

    public function pemesanan(){
        return $this->hasMany(Pemesanan::class);
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class);
    }

    public function imageStudio(){
        return $this->hasMany(ImageStudio::class);
    }
}
