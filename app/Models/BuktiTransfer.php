<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiTransfer extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function withdraw(){
        return $this->belongsTo(Withdraw::class);
    }

}
