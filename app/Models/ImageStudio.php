<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageStudio extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function studio(){
        return $this->belongsTo(Studio::class);
    }
        
}
