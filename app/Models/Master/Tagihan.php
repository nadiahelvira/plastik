<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//ganti 1
class Tagihan extends Model
{
    use HasFactory;

// ganti 2
    protected $table = 'tagihan';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

//ganti 3
    protected $fillable = 
    [
        
        "NOINDUK",
        "NAMA",
        "BAGIAN",
        "PER",
        "KET",
        "HUTANG",
        "BAZNAS",
        "SPTP",
        "TOTAL",
        "USRNM",
        "TG_SMP",
        "POSTED",
        "FLAG"
        
		
    ];
}
