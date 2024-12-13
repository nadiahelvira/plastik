<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrgDetail2 extends Model
{
    use HasFactory;

    protected $table = 'brgd';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

    protected $fillable =
    [
        "ID", "NO_ID", "KD_BRG", "CBG", "KODE", "LOKASI", "REC", "NO_IDY", "RECY"
    ];
}
