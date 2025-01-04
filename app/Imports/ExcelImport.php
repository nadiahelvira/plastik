<?php

namespace App\Imports;

use App\Models\Master\Sup;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Sup ([
           'KODES' => $row[1],
           'NAMAS' => $row[2],
           'ALAMAT' => $row[3],
           'KOTA' => $row[4],
           'HP' => $row[5],
        ]);
    }
}
