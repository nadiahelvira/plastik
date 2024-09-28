<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\OTransaksi\Pp;
use App\Models\OTransaksi\PpDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

include_once base_path() . "/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

// ganti 2
class PpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resppnse
     */
	 
    var $judul = '';
    var $FLAGZ = '';
    var $GOLZ = '';
	
    function setFlag(Request $request)
    {
        if ( $request->flagz == 'PP' && $request->golz == 'B' ) {
            $this->judul = "Purchase Request Bahan Baku";
        } else if ( $request->flagz == 'PP' && $request->golz == 'J' ) {
            $this->judul = "Purchase Request Bahan Jadi";
        } 
		
        $this->FLAGZ = $request->flagz;
        $this->GOLZ = $request->golz;


    }
		
    public function index(Request $request)
    {


	    $this->setFlag($request);
        // ganti 3
        return view('otransaksi_pp.index')->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ , 'golz' => $this->GOLZ]);
	
		
    }
	

	public function index_posting(Request $request)
    {
 
        return view('otransaksi_pp.post');
    }

    public function browse(Request $request)
    {
        $golz = $request->GOL;

		$CBG = Auth::user()->CBG;

        $pp = DB::SELECT("SELECT distinct pp.NO_BUKTI , pp.KODEC, pp.NAMAC, 
		                  pp.ALAMAT, pp.KOTA, pp.PKP from pp, ppd 
                          WHERE pp.NO_BUKTI = ppD.NO_BUKTI AND pp.FLAG='PP' 
                          AND pp.GOL ='$golz'
                          AND pp.CBG = '$CBG'");
        return response()->json($pp);
    }
	
	
    public function browseuang(Request $request)
    {
        //	$pp = DB::table('pp')->select('NO_BUKTI', 'TGL', 'KODEC','NAMAC', 'ALAMAT','KOTA', 'PERB','PERBB', 'SISA' )->where('PERB', '<>' ,'PERBB')->where('LNS', '<>',1)->where('GOL', 'Y')->orderBy('KODEC', 'ASC')->get();
        $filterkodes = '';
	   
		$CBG = Auth::user()->CBG;

		if($request->KODEC)
		{
	
			// $filterkodes = " WHERE SISA <> 0 AND KODEC='".$request->KODEC."' ";
			$filterkodec = " WHERE KODEC='".$request->KODEC."' ";
		}
		
		$pp = DB::SELECT("SELECT NO_BUKTI, TGL, KODEC, 
		            NAMAC, TOTAL, BAYAR, SISA from pp
		            $filterkodec 
                    AND pp.CBG = '$CBG'
                    ORDER BY NO_BUKTI ");
 
        return response()->json($pp);
    }
	//SHELVI
	
	
    // ganti 4



    public function getPp(Request $request)
    {
        // ganti 5

       if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

		$this->setFlag($request);	
        
		$CBG = Auth::user()->CBG;

        $pp = DB::SELECT("SELECT * from pp  WHERE PER='$periode' and FLAG = '$this->FLAGZ' 
                and GOL = '$this->GOLZ' AND CBG='$CBG' ORDER BY NO_BUKTI ");
	  
	   
        // ganti 6

        return Datatables::of($pp)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->divisi=="programmer" ) 
				{
                    //CEK POSTED di index dan edit

                    $btnEdit =   ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="pp/edit/?idx=' . $row->NO_ID . '&tipx=edit&flagz=' . $row->FLAG . '&judul=' . $this->judul . '&golz=' . $row->GOL . '"';					
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="pp/delete/' . $row->NO_ID . '/?flagz=' . $row->FLAG . '&golz=' . $row->GOL .'" ';


                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="pp/cetak/' . $row->NO_ID . '">
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
                        <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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


//////////////////////////////////////////////////////////////////////////////////


			
			
			
			
///            ->rawColumns(['action'])
 //           ->make(true);
//    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate(
            $request,
            // GANTI 9

            [
 //               'NO_ORDER'       => 'required',
                'TGL'      => 'required',
                'KODEC'       => 'required'

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

        $query = DB::table('pp')->select('NO_BUKTI')->where('PER', $periode)->where('FLAG', $FLAGZ )->where('GOL', $GOLZ )->where('CBG', $CBG)->orderByDesc('NO_BUKTI')->limit(1)->get();

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
                $no_bukti = $this->FLAGZ . $CBG .  $tahun . $bulan . '-' . $query;
            } else {
                $no_bukti = $this->FLAGZ . $CBG .  $tahun . $bulan . '-0001';
            }

        } elseif($GOLZ=='N') {

            if ($query != '[]') {
                $query = substr($query[0]->NO_BUKTI, -4);
                $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                $no_bukti = $this->FLAGZ . $this->GOLZ . $CBG . $tahun . $bulan . '-' . $query;
            } else {
                $no_bukti = $this->FLAGZ . $this->GOLZ . $CBG . $tahun . $bulan . '-0001';
            }

        }
        

		
//////////////////////////////////////////////////////////////////////////
       

        // Insert Header

        // ganti 10

        $pp = Pp::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'PER'              => $periode,
				'NO_ORDER'            => ($request['NO_ORDER'] == null) ? "" : $request['NO_ORDER'],
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'ALAMAT'           => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'             => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'FLAG'             => $FLAGZ,					
                'GOL'              => $GOLZ,					
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
				'PKP'               => (float) str_replace(',', '', $request['PKP']),
                'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'created_by'       => Auth::user()->username,
                'CBG'              => $CBG,
            ]
        );


		$REC        = $request->input('REC');
		$KD_BHN     = $request->input('KD_BHN');
        $NA_BHN     = $request->input('NA_BHN');
        $SATUAN     = $request->input('SATUAN');
        $QTY        = $request->input('QTY');

        // Check jika value detail ada/tidak
        if ($REC) {
            foreach ($REC as $key => $value) {
                // Declare new data di Model
                $detail    = new PpDetail;

                // Insert ke Database
                $detail->NO_BUKTI    = $no_bukti;
                $detail->REC         = $REC[$key];
                $detail->PER         = $periode;
                $detail->FLAG        = $FLAGZ;		
                $detail->GOL         = $GOLZ;		
               
                $detail->KD_BHN      = ($KD_BHN[$key] == null) ? "" :  $KD_BHN[$key];
                $detail->NA_BHN      = ($NA_BHN[$key] == null) ? "" :  $NA_BHN[$key];
                $detail->SATUAN      = ($SATUAN[$key] == null) ? "" :  $SATUAN[$key];				
                $detail->QTY         = (float) str_replace(',', '', $QTY[$key]);			
                $detail->save();
            }
        }	
		
		


        //  ganti 11
       $variablell = DB::select('call ppins(?)', array($no_bukti));
		$no_buktix = $no_bukti;
		
		$pp = Pp::where('NO_BUKTI', $no_buktix )->first();


        DB::SELECT("UPDATE pp,  ppd
                            SET  ppd.ID = pp.NO_ID  WHERE  pp.NO_BUKTI =  ppd.NO_BUKTI 
							AND  pp.NO_BUKTI='$no_buktix';");

		
					 
        return redirect('/pp/edit/?idx=' . $pp->NO_ID . '&tipx=edit&flagz=' . $FLAGZ . '&judul=' . $this->judul . '&golz=' . $this->GOLZ . '');

					
    }


    // ganti 15

   
   public function edit( Request $request , Pp $pp)
    {


		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
		
				
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect('/pp')
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
		   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from pp
		                 where PER ='$per' and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ' 
						 and NO_BUKTI = '$buktix'						 
		                 and CBG = '$CBG' ORDER BY NO_BUKTI ASC  LIMIT 1" );
						 
			
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
			

		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from pp 
		                 where PER ='$per' 
						 and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ'    
		                 and CBG = '$CBG' ORDER BY NO_BUKTI ASC  LIMIT 1" );
						 
		
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
			
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from pp     
		             where PER ='$per' 
					 and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ'  and NO_BUKTI < 
					 '$buktix' and CBG = '$CBG' ORDER BY NO_BUKTI DESC LIMIT 1" );
			

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
	   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from pp    
		             where PER ='$per'  
					 and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ' and NO_BUKTI > 
					 '$buktix' and CBG = '$CBG' ORDER BY NO_BUKTI ASC LIMIT 1" );
					 
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
		  
    		$bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from pp
						where PER ='$per'
						and FLAG ='$this->FLAGZ' and GOL ='$this->GOLZ'   
		                and CBG = '$CBG' ORDER BY NO_BUKTI DESC  LIMIT 1" );
					 
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
			$pp = Pp::where('NO_ID', $idx )->first();	
	     }
		 else
		 {
				$pp = new Pp;
                $pp->TGL = Carbon::now();
				
				
		 }

        $no_bukti = $pp->NO_BUKTI;
        $ppDetail = DB::table('ppd')->where('NO_BUKTI', $no_bukti)->orderBy('REC')->get();
		
		$data = [
            'header'        => $pp,
			'detail'        => $ppDetail

        ];
 
         
         return view('otransaksi_pp.edit', $data)
		 ->with(['tipx' => $tipx, 'idx' => $idx, 'flagz' =>$this->FLAGZ, 'judul', $this->judul, 'golz' =>$this->GOLZ ]);
      
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 18

    public function update(Request $request, Pp $pp)
    {

        $this->validate(
            $request,
            [

                // ganti 19

 //               'NO_ORDER'       => 'required',
                'TGL'      => 'required',
                'KODEC'       => 'required'


            ]
        );

        // ganti 20
        $variablell = DB::select('call ppdel(?)', array($pp['NO_BUKTI']));

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
        $CBG = Auth::user()->CBG;
		
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];

        // ganti 20

        $pp->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'NO_ORDER'            => ($request['NO_ORDER'] == null) ? "" : $request['NO_ORDER'],
                'KODEC'            => ($request['KODEC'] == null) ? "" : $request['KODEC'],
                'NAMAC'            => ($request['NAMAC'] == null) ? "" : $request['NAMAC'],
                'ALAMAT'           => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'             => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL_QTY'        => (float) str_replace(',', '', $request['TTOTAL_QTY']),
                'FLAG'             => $FLAGZ,					
                'GOL'              => $GOLZ,					
				'USRNM'            => Auth::user()->username,
                'TG_SMP'           => Carbon::now(),
				'updated_by'       => Auth::user()->username,
                'CBG'              => $CBG,
            ]
        );

		$no_buktix = $pp->NO_BUKTI;
		
        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');

        $REC    = $request->input('REC');

        $KD_BHN     = $request->input('KD_BHN');
        $NA_BHN     = $request->input('NA_BHN');
        $SATUAN     = $request->input('SATUAN');		
        $QTY        = $request->input('QTY');		

        $query = DB::table('ppd')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i = 0; $i < $length; $i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = PpDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
                        'PER'        => $periode,
                        'FLAG'       => $this->FLAGZ,
                        'GOL'        => $this->GOLZ,
                        'KD_BHN'     => ($KD_BHN[$i] == null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i] == null) ? "" :  $NA_BHN[$i],
                        'SATUAN'     => ($SATUAN[$i] == null) ? "" :  $SATUAN[$i],						
                        'QTY'        => (float) str_replace(',', '', $QTY[$i]),
						
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $upsert = PpDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],

                    [
                        'REC'        => $REC[$i],

                        'KD_BHN'     => ($KD_BHN[$i] == null) ? "" :  $KD_BHN[$i],
                        'NA_BHN'     => ($NA_BHN[$i] == null) ? "" :  $NA_BHN[$i],
                        'SATUAN'     => ($SATUAN[$i] == null) ? "" :  $SATUAN[$i],						
                        'QTY'        => (float) str_replace(',', '', $QTY[$i]),	
                        'FLAG'       => $this->FLAGZ,
                        'GOL'        => $this->GOLZ,						
                    ]
                );
            }
        }


        //  ganti 21
        $variablell = DB::select('call NAMACins(?)', array($pp['NO_BUKTI']));

 		$pp = Pp::where('NO_BUKTI', $no_buktix )->first();

        $no_bukti = $pp->NO_BUKTI;

        DB::SELECT("UPDATE pp,  ppd
                    SET  ppd.ID =  pp.NO_ID  WHERE  pp.NO_BUKTI =  ppd.NO_BUKTI 
                    AND  pp.NO_BUKTI='$no_bukti';");
					 
        return redirect('/pp/edit/?idx=' . $pp->NO_ID . '&tipx=edit&flagz=' . $this->FLAGZ . '&judul=' . $this->judul . '');	
		
	   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 22

    public function destroy(Request $request, Pp $pp)
    {

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect()->route('pp')
                ->with('status', 'Maaf Periode sudah ditutup!')
                ->with(['judul' => $this->judul, 'flagz' => $this->FLAGZ, 'golz' => $this->GOLZ]);
        }
		
		
       $variablell = DB::select('call ppdel(?)', array($pp['NO_BUKTI']));//


        // ganti 23
		
        $deletePp = Pp::find($pp->NO_ID);

        // ganti 24

        $deletePp->delete();

        // ganti 

       return redirect('/pp?flagz='.$FLAGZ.'&golz='.$GOLZ)->with(['judul' => $judul, 'flagz' => $FLAGZ, 'golz' => $GOLZ ])->with('statusHapus', 'Data '.$pp->NO_BUKTI.' berhasil dihapus');


    }
    
    
    public function cetak(Pp $pp)
    {
        $no_pp = $pp->NO_BUKTI;

        $file     = 'ppc';
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->load_xml_file(base_path() . ('/app/reportc01/phpjasperxml/' . $file . '.jrxml'));

        $query = DB::SELECT("SELECT pp.NO_BUKTI, pp.TGL, pp.KODEC, pp.NAMAC, pp.TOTAL_QTY, pp.NOTES, pp.ALAMAT, 
                                    pp.KOTA, ppd.KD_BRG, ppd.NA_BRG, ppd.SATUAN, ppd.QTY, 
                                    ppd.HARGA, ppd.TOTAL, ppd.KET, pp.PPN, pp.NETT, pp.NO_ORDER
                            FROM pp, ppd 
                            WHERE pp.NO_BUKTI='$no_pp' AND pp.NO_BUKTI = ppd.NO_BUKTI 
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
                'KET'    => $query[$key]->KET,
                'NO_ORDER'    => $query[$key]->NO_ORDER
            ));
        }
		
        $PHPJasperXML->setData($data);
        ob_end_clean();
        $PHPJasperXML->outpage("I");
       
    }
	
	 public function posting(Request $request)
    {
      

    }
	
	
	
	
	
	
	
}
