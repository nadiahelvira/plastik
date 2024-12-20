<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//ganti 1
class Brg extends Model
{
    use HasFactory;

// ganti 2
    protected $table = 'brg';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

//ganti 3
    protected $fillable = 
    [
        "KD_BRG", "NA_BRG","MERK",  "JENIS", "SATUAN","GOL", "USRNM", "TG_SMP", "PN", "KODES", "NAMAS",
        "SATUAN_BELI", "KALI", "ACNOA", "NACNOA", "ACNOB","NACNOB", "BERAT", "HJUAL", "SMIN", "SMAX",
        "created_by", "created_at", "updated_by", "updated_at", "KD_GRUP","NA_GRUP","PANJANG",
        "LEBAR", "VOLUME", "DIMENSI", "TYPE_KOM", "KOM"
		
    ];
}
