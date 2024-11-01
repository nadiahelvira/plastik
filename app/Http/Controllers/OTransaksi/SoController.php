<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\So;
use App\Models\OTransaksi\SoDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

include_once base_path() . "/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

// ganti 2
class SoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resbelinse
     */
	 
    var $judul = '';
    var $FLAGZ = '';
    var $GOLZ = '';
	
    function setFlag(Request $request)
    {
        if ( $request->flagz == 'SO' && $request->golz == 'B') {
            $this->judul = "Sales Order Bahan Baku";
        } else if ( $request->flagz == 'SO' && $request->golz == 'J') {
            $this->judul = "Sales Order Barang";
        }
		
        $this->FLAGZ = $request->flagz;
        $this->GOLZ = $request->golz;


    }
		
    public function index(Request $request)
    {


	    $this->setFlag($request);
        // ganti 3
        return view('otransaksi_so.index')->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ ]);
	
		
    }
	
	public function browse(Request $request)
    {
        $golz = $request->GOL;
        $kodec = $request->KODEC;

        $CBG = Auth::user()->CBG;
		
        $so = DB::SELECT("SELECT distinct SO.NO_BUKTI , SO.TGL, SO.KODEC, SO.NAMAC, 
                                SO.ALAMAT, SO.KOTA, SOD.KD_BRG, SOD.NA_BRG, SOD.QTY, SOD.HARGA, 
                                SOD.TOTAL, SOD.PPN, SOD.DPP, SOD.DISK, SOD.SATUAN  from so, sod 
                          WHERE SO.NO_BUKTI = SOD.NO_BUKTI AND SO.GOL ='$golz' 
                          AND SOD.SISA > 0
                        --   AND CBG = '$CBG' 
                          AND POSTED = 1");
        return response()->json($so);
    }

    public function browseuang()
    {
        $CBG = Auth::user()->CBG;
		
		$so = DB::SELECT("SELECT NO_BUKTI,TGL, KODEC, NAMAC, TOTAL, BAYAR, (TOTAL-BAYAR) AS SISA ,
                             ALAMAT, KOTA from so
		                WHERE LNS <> 1 AND CBG = '$CBG' ORDER BY NO_BUKTI; ");

        return response()->json($so);
    }


	public function browse_detail(Request $request)
    {
		$filterbukti = '';
		if($request->NO_SO)
		{
	
			$filterbukti = " WHERE a.NO_BUKTI='".$request->NO_SO."' AND a.KD_BHN = b.KD_BHN ";
		}
		$sod = DB::SELECT("SELECT a.REC, a.KD_BHN, a.NA_BHN, a.SATUAN , a.QTY, a.HARGA, a.KIRIM, a.SISA,
                             b.SATUAN AS SATUANX , a.DPP, a.PPN
                            from sod a, bhn b 
                            $filterbukti ORDER BY NO_BUKTI ");
	

		return response()->json($sod);
	}


    public function browse_detail2(Request $request)
    {
		$filterbukti = '';
		if($request->NO_SO)
		{
	
			$filterbukti = " WHERE NO_BUKTI='".$request->NO_SO."' AND a.KD_BRG = b.KD_BRG ";
		}
		$sod = DB::SELECT("SELECT a.REC, a.KD_BRG, a.NA_BRG, a.SATUAN , a.QTY, a.HARGA, a.KIRIM, a.SISA, 
                            b.SATUAN AS SATUANX, a.DPP AS DPP, a.PPN AS PPN
                            from sod a, brg b
                            $filterbukti AND a.KD_BRG = b.KD_BRG
                            ORDER BY NO_BUKTI ");
	

		return response()->json($sod);
	}
	
	public function index_posting(Request $request)
    {
 
        return view('otransaksi_so.post');
    }
	
    public function getSo(Request $request)
    {
        // ganti 5

       if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

        $CBG = Auth::user()->CBG;
		
		$this->setFlag($request);	
        $so = DB::SELECT("SELECT NO_ID, NO_BUKTI, TGL, NAMAC, TOTAL, TOTAL_QTY, NOTES, USRNM, POSTED, FLAG, GOL 
                        from so  WHERE PER='$periode' and FLAG ='$this->FLAGZ' 
                        AND GOL ='$this->GOLZ' AND CBG = '$CBG' ORDER BY NO_BUKTI ");
	  
	   
        // ganti 6

        return Datatables::of($so)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->divisi=="programmer" ) 
				{
                    //CEK POSTED di index dan edit

                    $btnEdit =   ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="so/edit/?idx=' . $row->NO_ID . '&tipx=edit&flagz=' . $row->FLAG . '&judul=' . $this->judul . '&golz=' . $row->GOL .'"';					
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="so/delete/' . $row->NO_ID . '/?flagz=' . $row->FLAG . '&golz=' . $row->GOL .'" ';


                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="so/cetak/' . $row->NO_ID . '">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                    Print
                                </a>									
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" ' . $btnDelete . '>
   
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Delete
                                </a> 
                        ';
                } else {
                    $btnPrivilege = '';
                }

                $actionBtn =
                    '
                    <div class="dropdown show" style="text-align: center">
                        <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-hasbelipup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            

                            ' . $btnPrivilege . '
                        </div>
                    </div>
                    ';

                return $actionBtn;
            })
			
	
			->addColumn('cek', function ($row) {
                return
                    '
                    <input type="checkbox" name="cek[]" class="form-control cek" ' . (($row->POSTED == 1) ? "checked" : "") . '  value="' . $row->NO_ID . '" ' . (($row->POSTED == 2) ? "disabled" : "") . '></input> 				
                    ';
            
            })			
			
            ->rawColumns(['action','cek'])
            ->make(true);
    }
			
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resbelinse
     */
    public function store(Request $request)
    {


        $this->validate(
            $request,
            // GANTI 9

            [
 //               'NO_PO'       => 'required',
                'TGL'      => 'required',

            ]
        );

        //////     nomer otomatis
		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
        $CBG = Auth::user()->CBG;
		
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);

	    $query = DB::table('so')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', 'SO')->where('CBG', $CBG)
                    ->where('GOL', $this->GOLZ)->orderByDesc('NO_BUKTI')->limit(1)->get();

        if( $GOLZ=='B'){

            if ($query != '[]') {
                $query = substr($query[0]->NO_BUKTI, -4);
                $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti = $this->FLAGZ . $this->GOLZ . $CBG . $tahun . $bulan . '-' . $query;
            } else {
                $no_bukti = $this->FLAGZ . $this->GOLZ . $CBG . $tahun . $bulan . '-0001';
            }

        } elseif($GOLZ=='J') {

            if ($query != '[]') {
                $query = substr($query[0]->NO_BUKTI, -4);
                $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti = $this->FLAGZ . $CBG . $tahun . $bulan . '-' . $query;
            } else {
                $no_bukti = $this->FLAGZ . $CBG . $tahun . $bulan . '-0001';
            }

        }

        
	
//////////////////////////////////////////////////////////////////////////

        $so = So::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'JTEMPO'              => date('Y-m-d', strtotime($request['JTEMPO'])),
                'PER'              => $periode,
				'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'ALAMAT'            => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'            => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'FLAG'             => 'SO',						
                'GOL'              => $GOLZ,
                'CBG'              => $CBG,
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
                'KOM'            => (float) str_replace(',', '', $request['KOM']),
                'PPN'            => (float) str_replace(',', '', $request['PPN']),
                'NETT'            => (float) str_replace(',', '', $request['NETT']),
                'TDISK'            => (float) str_replace(',', '', $request['TDISK']),
                'HARI'            => (float) str_replace(',', '', $request['HARI']),
                'KODEP'            => ($request['KODEP'] == null) ? "" : $request['KODEP'],
                'NAMAP'            => ($request['NAMAP'] == null) ? "" : $request['NAMAP'],
                'RING'            => ($request['RING'] == null) ? "" : $request['RING'],
				'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'created_by'       => Auth::user()->username,
            ]
        );


		$REC        = $request->input('REC');
		$KD_BRG     = $request->input('KD_BRG');
		$KD_GRUP     = $request->input('KD_GRUP');
        $NA_BRG     = $request->input('NA_BRG');
		$KD_BHN     = $request->input('KD_BHN');
        $NA_BHN     = $request->input('NA_BHN');
        $SATUAN     = $request->input('SATUAN');
        $QTY        = $request->input('QTY');
        $HARGA      = $request->input('HARGA');		
        $TOTAL      = $request->input('TOTAL');	
        $KET        = $request->input('KET');  
        $PPNX        = $request->input('PPNX');  
        $DPP        = $request->input('DPP');  
        $DISK        = $request->input('DISK');  

        $HARGA1        = $request->input('HARGA1');  
        $HARGA2        = $request->input('HARGA2');  
        $HARGA3        = $request->input('HARGA3');  
        $HARGA4        = $request->input('HARGA4');  
        $HARGA5        = $request->input('HARGA5');  
        $HARGA6        = $request->input('HARGA6');  
        $HARGA7        = $request->input('HARGA7');  

        // Check jika value detail ada/tidak
        if ($REC) {
            foreach ($REC as $key => $value) {
                // Declare new data di Model
                $detail    = new SoDetail;

                // Insert ke Database
                $detail->NO_BUKTI    = $no_bukti;
                $detail->REC         = $REC[$key];
                $detail->PER         = $periode;
                $detail->FLAG        = $FLAGZ;		
                $detail->GOL 	     = $GOLZ;    	
               
                $detail->KD_BRG      = ($KD_BRG[$key] == null) ? "" :  $KD_BRG[$key];
                $detail->KD_GRUP     = ($KD_GRUP[$key] == null) ? "" :  $KD_GRUP[$key];
                $detail->NA_BRG      = ($NA_BRG[$key] == null) ? "" :  $NA_BRG[$key];
                $detail->KD_BHN      = ($KD_BHN[$key] == null) ? "" :  $KD_BHN[$key];
                $detail->NA_BHN      = ($NA_BHN[$key] == null) ? "" :  $NA_BHN[$key];
                $detail->SATUAN      = ($SATUAN[$key] == null) ? "" :  $SATUAN[$key];				
                $detail->QTY         = (float) str_replace(',', '', $QTY[$key]);
                $detail->SISA         = (float) str_replace(',', '', $QTY[$key]);
 
                $detail->HARGA       = (float) str_replace(',', '', $HARGA[$key]);
                $detail->TOTAL       = (float) str_replace(',', '', $TOTAL[$key]); 
                $detail->PPN       = (float) str_replace(',', '', $PPNX[$key]); 
                $detail->DPP       = (float) str_replace(',', '', $DPP[$key]); 
                $detail->DISK       = (float) str_replace(',', '', $DISK[$key]); 

                $detail->HARGA1       = (float) str_replace(',', '', $HARGA1[$key]); 
                $detail->HARGA2       = (float) str_replace(',', '', $HARGA2[$key]); 
                $detail->HARGA3       = (float) str_replace(',', '', $HARGA3[$key]); 
                $detail->HARGA4       = (float) str_replace(',', '', $HARGA4[$key]); 
                $detail->HARGA5       = (float) str_replace(',', '', $HARGA5[$key]); 
                $detail->HARGA6       = (float) str_replace(',', '', $HARGA6[$key]); 
                $detail->HARGA7       = (float) str_replace(',', '', $HARGA7[$key]); 

				$detail->KET         = ($KET[$key] == null) ? "" :  $KET[$key];				
                $detail->save();
            }
        }	
		
		$no_buktix = $no_bukti;
		
		$so = So::where('NO_BUKTI', $no_buktix )->first();


        DB::SELECT("UPDATE so, sod
                            SET  sod.ID =  so.NO_ID  WHERE  so.NO_BUKTI =  sod.NO_BUKTI 
							AND  so.NO_BUKTI='$no_buktix';");

		
					 
        return redirect('/so/edit/?idx=' . $so->NO_ID . '&tipx=edit&flagz=' . $this->FLAGZ . '&judul=' . $this->judul . '&golz=' . $this->GOLZ . '');

		
		
    }


    // ganti 15

   
   public function edit( Request $request , So $so)
    {


		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
		
				
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect('/so')
			       ->with('status', 'Maaf Periode sudah ditutup!')
                   ->with(['judul' => $judul, 'flagz' => $FLAGZ, 'golz' => $GOLZ]);
        }
		
		$this->setFlag($request);
		
        $tipx = $request->tipx;

		$idx = $request->idx;
		
        $CBG = Auth::user()->CBG;
		
		if ( $idx =='0' && $tipx=='undo'  )
	    {
			$tipx ='top';
			
		   }
		   
		 
		   
		if ($tipx=='search') {
			
		   	
    	   $buktix = $request->buktix;
		   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from so
		                 where PER ='$per' and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ' 
						 and NO_BUKTI = '$buktix'
                         AND CBG = '$CBG'						 
		                 ORDER BY NO_BUKTI ASC  LIMIT 1" );
						 
			
			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = 0; 
			  }
		
					
		}
		
		if ($tipx=='top') {
			

		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from so
		                 where PER ='$per' 
						 and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ'
                         AND CBG = '$CBG'     
		                 ORDER BY NO_BUKTI ASC  LIMIT 1" );
						 
		
			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = 0; 
			  }
		
					
		}
		
		
		if ($tipx=='prev' ) {
			
    	   $buktix = $request->buktix;
			
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from so     
		             where PER ='$per' 
					 and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ' 
                     AND CBG = '$CBG' and NO_BUKTI < 
					 '$buktix' ORDER BY NO_BUKTI DESC LIMIT 1" );
			

			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = $idx; 
			  }
			  
		}
		
		
		if ($tipx=='next' ) {
			
				
      	   $buktix = $request->buktix;
	   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from so    
		             where PER ='$per'  
					 and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ' 
                     AND CBG = '$CBG' and NO_BUKTI > 
					 '$buktix' ORDER BY NO_BUKTI ASC LIMIT 1" );
					 
			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = $idx; 
			  }
			  
			
		}

		if ($tipx=='bottom') {
		  
    		$bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from so
						where PER ='$per'
						and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ' 
                        AND CBG = '$CBG'   
		                ORDER BY NO_BUKTI DESC  LIMIT 1" );
					 
			if(!empty($bingco)) 
			{
				$idx = $bingco[0]->NO_ID;
			  }
			else
			{
				$idx = 0; 
			  }
			  
			
		}

        
		if ( $tipx=='undo' || $tipx=='search' )
	    {
        
			$tipx ='edit';
			
		   }
		
		

       	if ( $idx != 0 ) 
		{
			$so = So::where('NO_ID', $idx )->first();	
	     }
		 else
		 {
				$so = new So;
                $so->TGL = Carbon::now();
                $so->JTEMPO = Carbon::now();
				
				
		 }

        $no_bukti = $so->NO_BUKTI;
        $soDetail = DB::table('sod')->where('NO_BUKTI', $no_bukti)->get();
		
		$data = [
            'header'        => $so,
			'detail'        => $soDetail

        ];
 
         
         return view('otransaksi_so.edit', $data)
		 ->with(['tipx' => $tipx, 'idx' => $idx, 'flagz' =>$this->FLAGZ, 'golz' =>$this->GOLZ, 'judul' => $this->judul ]);
			 
 
      
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Resbelinse
     */

    // ganti 18

    public function update(Request $request, So $so)
    {

        $this->validate(
            $request,
            [
                'TGL'      => 'required',
            ]
        );

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
        $CBG = Auth::user()->CBG;
		
		
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        // ganti 20

        $so->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'JTEMPO'              => date('Y-m-d', strtotime($request['JTEMPO'])),
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'ALAMAT'            => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'            => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'TOTAL'            => (float) str_replace(',', '', $request['TTOTAL']),
                'KOM'            => (float) str_replace(',', '', $request['KOM']),
                'PPN'            => (float) str_replace(',', '', $request['PPN']),
                'NETT'            => (float) str_replace(',', '', $request['NETT']),
                'TDISK'            => (float) str_replace(',', '', $request['TDISK']),
                'HARI'            => (float) str_replace(',', '', $request['HARI']),
                'KODEP'            => ($request['KODEP'] == null) ? "" : $request['KODEP'],
                'NAMAP'            => ($request['NAMAP'] == null) ? "" : $request['NAMAP'],
                'RING'            => ($request['RING'] == null) ? "" : $request['RING'],
				'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'updated_by'       => Auth::user()->username,
                'FLAG'             => 'SO',						
                'GOL'              => $GOLZ,
                'CBG'              => $CBG,
            ]
        );

		$no_buktix = $so->NO_BUKTI;
		
        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');

        $REC    = $request->input('REC');

        $KD_BRG = $request->input('KD_BRG');
        $KD_GRUP = $request->input('KD_GRUP');
        $NA_BRG = $request->input('NA_BRG');
        $KD_BHN = $request->input('KD_BHN');
        $NA_BHN = $request->input('NA_BHN');
        $SATUAN = $request->input('SATUAN');		
        $QTY    = $request->input('QTY');
        $HARGA    = $request->input('HARGA');
        $TOTAL    = $request->input('TOTAL');
        $KET = $request->input('KET');			
        $PPNX = $request->input('PPNX');			
        $DPP = $request->input('DPP');	
        $DISK = $request->input('DISK');	

        $HARGA1        = $request->input('HARGA1');  
        $HARGA2        = $request->input('HARGA2');  
        $HARGA3        = $request->input('HARGA3');  
        $HARGA4        = $request->input('HARGA4');  
        $HARGA5        = $request->input('HARGA5');  
        $HARGA6        = $request->input('HARGA6');  
        $HARGA7        = $request->input('HARGA7');  

        $query = DB::table('sod')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i = 0; $i < $length; $i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = SoDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
                        'PER'        => $periode,
                        'FLAG'       => $this->FLAGZ,
                        'GOL'        => $this->GOLZ,
                        'KD_BHN'     => ($KD_BHN[$i] == null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i] == null) ? "" :  $NA_BHN[$i],
                        'KD_BRG'     => ($KD_BRG[$i] == null) ? "" :  $KD_BRG[$i],
                        'KD_GRUP'     => ($KD_GRUP[$i] == null) ? "" :  $KD_GRUP[$i],
                        'NA_BRG'     => ($NA_BRG[$i] == null) ? "" :  $NA_BRG[$i],
                        'SATUAN'     => ($SATUAN[$i] == null) ? "" :  $SATUAN[$i],						
                        'QTY'        => (float) str_replace(',', '', $QTY[$i]),
                        'SISA'        => (float) str_replace(',', '', $QTY[$i]),

                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'PPN'      => (float) str_replace(',', '', $PPNX[$i]),
                        'DPP'      => (float) str_replace(',', '', $DPP[$i]),
                        'DISK'      => (float) str_replace(',', '', $DISK[$i]),

                        'HARGA1'      => (float) str_replace(',', '', $HARGA1[$i]),
                        'HARGA2'      => (float) str_replace(',', '', $HARGA2[$i]),
                        'HARGA3'      => (float) str_replace(',', '', $HARGA3[$i]),
                        'HARGA4'      => (float) str_replace(',', '', $HARGA4[$i]),
                        'HARGA5'      => (float) str_replace(',', '', $HARGA5[$i]),
                        'HARGA6'      => (float) str_replace(',', '', $HARGA6[$i]),
                        'HARGA7'      => (float) str_replace(',', '', $HARGA7[$i]),

                        'KET'        => ($KET[$i] == null) ? "" :  $KET[$i],	
						
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $upsert = SoDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],

                    [
                        'REC'        => $REC[$i],

                        'KD_BHN'     => ($KD_BHN[$i] == null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i] == null) ? "" :  $NA_BHN[$i],
                        'KD_BRG'     => ($KD_BRG[$i] == null) ? "" :  $KD_BRG[$i],
                        'KD_GRUP'     => ($KD_GRUP[$i] == null) ? "" :  $KD_GRUP[$i],
                        'NA_BRG'     => ($NA_BRG[$i] == null) ? "" :  $NA_BRG[$i],
                        'SATUAN'     => ($SATUAN[$i] == null) ? "" :  $SATUAN[$i],						
                        'QTY'        => (float) str_replace(',', '', $QTY[$i]),
                        'SISA'        => (float) str_replace(',', '', $QTY[$i]),
                        'FLAG'       => $this->FLAGZ,
                        'GOL'        => $this->GOLZ,
                        'PER'        => $periode,

                        'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
                        'TOTAL'      => (float) str_replace(',', '', $TOTAL[$i]),
                        'PPN'      => (float) str_replace(',', '', $PPNX[$i]),
                        'DPP'      => (float) str_replace(',', '', $DPP[$i]),
                        'DISK'      => (float) str_replace(',', '', $DISK[$i]),

                        'HARGA1'      => (float) str_replace(',', '', $HARGA1[$i]),
                        'HARGA2'      => (float) str_replace(',', '', $HARGA2[$i]),
                        'HARGA3'      => (float) str_replace(',', '', $HARGA3[$i]),
                        'HARGA4'      => (float) str_replace(',', '', $HARGA4[$i]),
                        'HARGA5'      => (float) str_replace(',', '', $HARGA5[$i]),
                        'HARGA6'      => (float) str_replace(',', '', $HARGA6[$i]),
                        'HARGA7'      => (float) str_replace(',', '', $HARGA7[$i]),

                        'KET'        => ($KET[$i] == null) ? "" :  $KET[$i],							
                    ]
                );
            }
        }

 		$so = So::where('NO_BUKTI', $no_buktix )->first();

        $no_bukti = $so->NO_BUKTI;

        DB::SELECT("UPDATE so,  sod
                    SET  sod.ID =  so.NO_ID  WHERE  so.NO_BUKTI =  sod.NO_BUKTI 
                    AND  so.NO_BUKTI='$no_bukti';");
					 
        return redirect('/so/edit/?idx=' . $so->NO_ID . '&tipx=edit&flagz=' . $this->FLAGZ . '&judul=' . $this->judul . '&golz=' . $this->GOLZ . '');	
		
	   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Resbelinse
     */

    // ganti 22

    public function destroy(Request $request, So $so)
    {

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $judul = $this->judul;
		
		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect()->route('so')
                ->with('status', 'Maaf Periode sudah ditutup!')
                ->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ]);
        }
		
		
        $deleteSo = So::find($so->NO_ID);

        $deleteSo->delete();

       return redirect('/so?flagz='.$FLAGZ.'&golz='.$GOLZ)->with(['judul' => $judul, 'flagz' => $FLAGZ, 'golz' => $GOLZ ])->with('statusHapus', 'Data '.$beli_bh->NO_BUKTI.' berhasil dihapus');


    }
    
    
    
    public function cetak(So $so)
    {
        $no_so = $so->NO_BUKTI;

        $file     = 'soc';
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->load_xml_file(base_path() . ('/app/reportc01/phpjasperxml/' . $file . '.jrxml'));

        $query = DB::SELECT("SELECT so.NO_BUKTI, so.TGL, so.KODEC, so.NAMAC, so.TOTAL_QTY, so.NOTES, so.ALAMAT, 
                                    so.KOTA, sod.KD_BRG, sod.NA_BRG, sod.SATUAN, sod.QTY, 
                                    sod.HARGA, sod.TOTAL, sod.KET, so.PPN, so.NETT
                            FROM so, sod 
                            WHERE so.NO_BUKTI='$no_so' AND so.NO_BUKTI = sod.NO_BUKTI 
                            ;
		");

        
        $data = [];

        foreach ($query as $key => $value) {
            array_push($data, array(
                'NO_BUKTI' => $query[$key]->NO_BUKTI,
                'TGL'      => $query[$key]->TGL,
                'KODEC'    => $query[$key]->KODEC,
                'NAMAC'    => $query[$key]->NAMAC,
                'ALAMAT'    => $query[$key]->ALAMAT,
                'KOTA'    => $query[$key]->KOTA,
                'KG'       => $query[$key]->KG,
                'HARGA'    => $query[$key]->HARGA,
                'TOTAL'    => $query[$key]->TOTAL,
                'BAYAR'    => $query[$key]->BAYAR,
                'NOTES'    => $query[$key]->NOTES,
                'KD_BRG'    => $query[$key]->KD_BRG,
                'NA_BRG'    => $query[$key]->NA_BRG,
                'SATUAN'    => $query[$key]->SATUAN,
                'QTY'    => $query[$key]->QTY,
                'PPN'    => $query[$key]->PPN,
                'NETT'    => $query[$key]->NETT,
                'KET'    => $query[$key]->KET
            ));
        }
		
        $PHPJasperXML->setData($data);
        ob_end_clean();
        $PHPJasperXML->outpage("I");
       
        DB::SELECT("UPDATE SO SET POSTED = 1 WHERE SO.NO_BUKTI='$no_so';");
    }
	
	
	
	 public function posting(Request $request)
    {
      

    }
	
	public function jtempo ( Request $request)
    {
		//$tgl = $request->TGL;
		//$hari_ini = Carbon::createFromFormat('Y.m.d', $tgl);
		//dd($hari_ini);
		//$harix = $request->HARI;
		//$jtempo = $hari_ini->addDays($harix);
		//dd($jtempo);
		
		//Return Carbon::createFromFormat('d/m/Y',$jtempo);
		
	}
	
	
	
	
	
	
	
}
