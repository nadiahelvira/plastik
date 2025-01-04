<?php

namespace App\Http\Controllers\OTransaksi;

use App\Http\Controllers\Controller;

use App\Models\OTransaksi\Beli;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

include_once base_path() . "/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";

use PHPJasperXML;

class UtbeliController extends Controller
{

    var $judul = '';
    var $FLAGZ = '';
    var $GOLZ = '';


    function setFlag(Request $request)
    {
		
        if ( $request->flagz == 'TH' && $request->golz == 'J' ) {
            $this->judul = "Transaksi Hutang";
        } else if ( $request->flagz == 'UM' && $request->golz == 'J'  ) {
            $this->judul = "Uang Muka Pembelian ";
        }
		
		
        $this->FLAGZ = $request->flagz;
        $this->GOLZ = $request->golz;    
		

    }	 


    public function index(Request $request)
    {

        // ganti 3
        $this->setFlag($request);
        // ganti 3
        return view('otransaksi_utbeli.index')->with(['judul' => $this->judul, 'golz' => $this->GOLZ , 'flagz' => $this->FLAGZ ]);
    }




    public function browse(Request $request)
    {

    }

    public function browseuang(Request $request)
    {


    }

    public function getUtbeli(Request $request)
    {
        if ($request->session()->has('periode')) {
            $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];
        } else {
            $periode = '';
        }

        $this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
        $CBG = Auth::user()->CBG;
        $PPN = Auth::user()->PPN;
		
        $utbeli = DB::SELECT("SELECT * from beli 
                            where PER ='$periode' and FLAG ='$this->FLAGZ' 
                                AND GOL ='$this->GOLZ' AND CBG = '$CBG'
                            ORDER BY NO_BUKTI ");
		    
         return Datatables::of($utbeli)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->divisi=="programmer" || Auth::user()->divisi=="owner" || Auth::user()->divisi=="assistant") 
                {

                    // url untuk delete di index

                    $url = "'".url("utbeli/delete/" . $row->NO_ID . "/?flagz=" . $row->FLAG . "&golz=" . $row->GOL)."'";

                    // batas
                    
                    $btnEdit =   ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="utbeli/edit/?idx
					=' . $row->NO_ID . '&tipx=edit&flagz=' . $row->FLAG . '&golz=' . $row->GOL . '&judul=' . $this->judul . '"';
					
                    // $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)"  href="utbeli/delete/' . $row->NO_ID . '/?flagz=' . $row->FLAG . '&golz=' . $row->GOL . '" ';
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' onclick="deleteRow('.$url.')"';


                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="jsutbelic/' . $row->NO_ID . '">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
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
            ->rawColumns(['action'])
            ->make(true);
    }



    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
           //     'NO_PO'       => 'required',
                'TGL'      => 'required',
            ]
        );


	
	    $kodesx = $request->KODES;
        
        $xxx= DB::table('sup')->select('PKP')->where('KODES', $kodesx)->get();

        $PPN = $xxx[0]->PKP ;
        
		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;	
		
        $CBG = Auth::user()->CBG;

		
        // Generate Nomor Bukti
        $periode = $request->session()->get('periode')['bulan'] . '/' . $request->session()->get('periode')['tahun'];


        $bulan    = session()->get('periode')['bulan'];
        $tahun    = substr(session()->get('periode')['tahun'], -2);

        $no_bukti ='';
        $no_bukti2 ='';
		



        if ( $request->flagz == 'TH') {

            $query = DB::table('beli')->select(DB::raw("TRIM(NO_BUKTI) AS NO_BUKTI"))->where('PER', $periode)
			         ->where('FLAG', 'TH')->where('CBG', $CBG)->where('PKP', $PPN)->orderByDesc('NO_BUKTI')->limit(1)->get();
			
            if( $GOLZ =='J' ){

                if( $PPN =='1' ){
        
                    if ($query != '[]') {
                        $query = substr($query[0]->NO_BUKTI, -4);
                        $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                        $no_bukti = 'THY'  . $CBG . $tahun . $bulan . '-' . $query;
                    } else {
                        $no_bukti = 'THY'  . $CBG . $tahun . $bulan . '-0001';
                    }

                } else {

                    if ($query != '[]') {
                        $query = substr($query[0]->NO_BUKTI, -4);
                        $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                        $no_bukti = 'THZ'  . $CBG . $tahun . $bulan . '-' . $query;
                    } else {
                        $no_bukti = 'THZ'  . $CBG . $tahun . $bulan . '-0001';
                    }
                    
                }
            }

        } else if ( $request->flagz == 'UM') {
 
            $query = DB::table('beli')->select(DB::raw("TRIM(NO_BUKTI) AS NO_BUKTI"))->where('PER', $periode)
			         ->where('FLAG', 'UM')->where('CBG', $CBG)->where('PKP', $PPN)->orderByDesc('NO_BUKTI')->limit(1)->get();

            if( $GOLZ =='J' ){
            
                if( $PPN =='1' ){
        
                    if ($query != '[]') {
                        $query = substr($query[0]->NO_BUKTI, -4);
                        $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                        $no_bukti = 'UMY'  . $CBG . $tahun . $bulan . '-' . $query;
                    } else {
                        $no_bukti = 'UMY'  . $CBG . $tahun . $bulan . '-0001';
                    }

                } else {

                    if ($query != '[]') {
                        $query = substr($query[0]->NO_BUKTI, -4);
                        $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
                        $no_bukti = 'UMZ'  . $CBG . $tahun . $bulan . '-' . $query;
                    } else {
                        $no_bukti = 'UMZ'  . $CBG . $tahun . $bulan . '-0001';
                    }
                    
                }
            }
			
			
            // $type1 = substr( $request['BNAMA'],0,3);
            $type1 = $request['TYPE'];
		
		
		    if( $PPN == '1' ){

                if ( $type1 == 'KAS' )
                {          
                            $bulan    = session()->get('periode')['bulan'];
                            $tahun    = substr(session()->get('periode')['tahun'], -2);
                            $query2 = DB::table('kas')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BKK')->where('CBG', $CBG)->orderByDesc('NO_BUKTI')->limit(1)->get();
                    
                            if ($query2 != '[]') {
                                $query2 = substr($query2[0]->NO_BUKTI, -4);
                                $query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
                                $no_bukti2 = 'BKKY' . $CBG . $tahun . $bulan . '-' . $query2;
                            } else {
                                $no_bukti2 = 'BKKY' . $CBG . $tahun . $bulan . '-0001';
                            }
                            
                }
                else
                {
        
                            $bulan    = session()->get('periode')['bulan'];
                            $tahun    = substr(session()->get('periode')['tahun'], -2);
                            $query2 = DB::table('bank')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BBK')->where('CBG', $CBG)->orderByDesc('NO_BUKTI')->limit(1)->get();
                    
                            if ($query2 != '[]') {
                                $query2 = substr($query2[0]->NO_BUKTI, -4);
                                $query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
                                $no_bukti2 = 'BBKY' . $CBG . $tahun . $bulan . '-' . $query2;
                            } else {
                                $no_bukti2 = 'BBKY' . $CBG . $tahun . $bulan . '-0001';
                            }
                            
                    
                }
    
            } else {
    
                if ( $type1 == 'KAS' )
                {          
                            $bulan    = session()->get('periode')['bulan'];
                            $tahun    = substr(session()->get('periode')['tahun'], -2);
                            $query2 = DB::table('kas')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BKK')->where('CBG', $CBG)->orderByDesc('NO_BUKTI')->limit(1)->get();
                    
                            if ($query2 != '[]') {
                                $query2 = substr($query2[0]->NO_BUKTI, -4);
                                $query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
                                $no_bukti2 = 'BKKZ' . $CBG . $tahun . $bulan . '-' . $query2;
                            } else {
                                $no_bukti2 = 'BKKZ' . $CBG . $tahun . $bulan . '-0001';
                            }
                            
                }
                else
                {
        
                            $bulan    = session()->get('periode')['bulan'];
                            $tahun    = substr(session()->get('periode')['tahun'], -2);
                            $query2 = DB::table('bank')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BBK')->where('CBG', $CBG)->orderByDesc('NO_BUKTI')->limit(1)->get();
                    
                            if ($query2 != '[]') {
                                $query2 = substr($query2[0]->NO_BUKTI, -4);
                                $query2 = str_pad($query2 + 1, 4, 0, STR_PAD_LEFT);
                                $no_bukti2 = 'BBKZ' . $CBG . $tahun . $bulan . '-' . $query2;
                            } else {
                                $no_bukti2 = 'BBKZ' . $CBG . $tahun . $bulan . '-0001';
                            }
                            
                    
                }
    
            }
			
			
			
			
				
 
        } 

        
           $ACNOB ='';
           $NACNOB ='';
           
           if ( $FLAGZ =='Y' )
           {
              $ACNOB =  '211101';
              $NACNOB = 'HUTANG DAGANG';
               
           }

           if ( $GOLZ =='Z' )
           {
               
              $ACNOB =  '211103';
              $NACNOB = 'HUTANG NON';
              
           }
           

        // Insert Header
        $utbeli = beli::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),
                'PER'              => $periode,

                'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'ALAMAT'           => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'             => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'FLAG'             =>  $FLAGZ,
                'GOL'              =>  $GOLZ,
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL']),
                'NETT'             => ($FLAGZ == 'UM') ? (float) str_replace(',', '', $request['TOTAL'] ) * -1  : (float) str_replace(',', '', $request['TOTAL'] ),     
                'SISA'             => ($FLAGZ == 'UM') ? (float) str_replace(',', '', $request['TOTAL'] ) * -1  : (float) str_replace(',', '', $request['TOTAL'] ),      
                'ACNOA'            => ($request['ACNOA'] == null) ? "" : $request['ACNOA'],
                'NACNOA'           => ($request['NACNOA'] == null) ? "" : $request['NACNOA'],
                'ACNOB'            => '211101',
                'NACNOB'           => 'HUTANG DAGANG',
                'BACNO'            => ($request['BACNO'] == null) ? "" : $request['BACNO'],
                'BNAMA'            => ($request['BNAMA'] == null) ? "" : $request['BNAMA'],
                'TYPE'             => ($request['TYPE'] == null) ? "" : $request['TYPE'],
                'NOTES'             => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'NO_BANK'          => $no_bukti2,				
                'USRNM'            => Auth::user()->username,
                'created_by'       => Auth::user()->username,
                'CBG'              => $CBG,
                'PKP'              => $PPN,
                'TG_SMP'           => Carbon::now()
            ]
        );



	    $no_buktix = $no_bukti;
		
		
	    DB::SELECT("UPDATE beli, sup
                            SET beli.NAMAS = sup.NAMAS, beli.ALAMAT = sup.ALAMAT, beli.KOTA = sup.KOTA  WHERE beli.KODES = sup.KODES 
							AND beli.NO_BUKTI='$no_buktix';");

        DB::SELECT("UPDATE beli, account
                            SET beli.BNAMA = account.NAMA  WHERE beli.BACNO = account.ACNO 
							AND beli.NO_BUKTI='$no_buktix';");
							
        DB::SELECT("UPDATE beli, account
                            SET beli.NACNOA = account.NAMA  WHERE beli.ACNOA = account.ACNO 
							AND beli.NO_BUKTI='$no_buktix';");
						
		
		if ( $FLAGZ == 'UM' ) {
			 $variablell = DB::select('call umins(?,?)', array($no_bukti, $no_bukti2));

        } else if ( $FLAGZ == 'TH' ) {
             $variablell = DB::select('call thutins(?)', array($no_bukti));
        }
		
		
		
		$utbeli = beli::where('NO_BUKTI', $no_buktix )->first();
					 
		return redirect('/utbeli?flagz='.$FLAGZ.'&golz='.$GOLZ)
	   ->with(['judul' => $judul, 'golz' => $GOLZ, 'flagz' => $FLAGZ ]);

    }


   public function edit( Request $request , Beli $utbeli)
    {


		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
		
				
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect('/utbeli')
			       ->with('status', 'Maaf Periode sudah ditutup!')
                   ->with(['judul' => $judul, 'flagz' => $FLAGZ]);
        }
		
		$this->setFlag($request);
		
        $tipx = $request->tipx;

		$idx = $request->idx;
		
        $CBG = Auth::user()->CBG;
        $PPN = Auth::user()->PPN;
		
		if ( $idx =='0' && $tipx=='undo'  )
	    {
			$tipx ='top';
			
		   }
		   
		 
		   
		if ($tipx=='search') {
			
		   	
    	   $buktix = $request->buktix;
		   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli
		                 where PER ='$per' and FLAG ='$this->FLAGZ' 
						 and GOL ='$this->GOLZ' and NO_BUKTI = '$buktix'
                         AND CBG = '$CBG'						 
                         AND PKP = '$PPN'						 
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
			

		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli 
		                 where PER ='$per' and GOL ='$this->GOLZ'
						 and FLAG ='$this->FLAGZ' 
                         AND CBG = '$CBG'  
                         AND PKP = '$PPN'						 
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
			
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli     
		             where PER ='$per' and GOL ='$this->GOLZ' 
					 and FLAG ='$this->FLAGZ' AND CBG = $CBG
                     AND PKP = '$PPN'						 
                     and NO_BUKTI < 
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
	   
		   $bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli    
		             where PER ='$per' and GOL ='$this->GOLZ' 
					 and FLAG ='$this->FLAGZ' AND CBG = '$CBG'
                     AND PKP = '$PPN'						 
                     and NO_BUKTI > 
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
		  
    		$bingco = DB::SELECT("SELECT NO_ID, NO_BUKTI from beli
						where PER ='$per' and GOL ='$this->GOLZ' 
						and FLAG ='$this->FLAGZ' AND CBG = '$CBG'  
                        AND PKP = '$PPN'						 
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
			$utbeli = Beli::where('NO_ID', $idx )->first();	
	     }
		 else
		 {
				$utbeli = new Beli;
                $utbeli->TGL = Carbon::now();
      
				
		 }

        $no_bukti = $utbeli->NO_BUKTI;
				
		$data = [
            'header'        => $utbeli,

        ];
 
         
         return view('otransaksi_utbeli.edit', $data)
		 ->with(['tipx' => $tipx, 'idx' => $idx, 'golz' =>$this->GOLZ, 'flagz' =>$this->FLAGZ, 'judul', $this->judul ]);
			 
    
      
    }




    public function update(Request $request, beli $utbeli)
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
		
		if ( $FLAGZ == 'UM' ) {

             $variablell = DB::select('call umdel(?,?)', array($utbeli['NO_BUKTI'], '0'));


        } else if ( $FLAGZ == 'TH' ) {
             $variablell = DB::select('call thutdel(?)', array($utbeli['NO_BUKTI']));

        }
		
		

        $utbeli->update(
            [
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),

                'KODES'            => ($request['KODES'] == null) ? "" : $request['KODES'],
                'NAMAS'            => ($request['NAMAS'] == null) ? "" : $request['NAMAS'],
                'ALAMAT'           => ($request['ALAMAT'] == null) ? "" : $request['ALAMAT'],
                'KOTA'             => ($request['KOTA'] == null) ? "" : $request['KOTA'],
                'NOTES'            => ($request['NOTES'] == null) ? "" : $request['NOTES'],
                'TOTAL'            => (float) str_replace(',', '', $request['TOTAL']),
                'NETT'             => ( $FLAGZ == 'UM') ? (float) str_replace(',', '', $request['TOTAL'] ) * -1  : (float) str_replace(',', '', $request['TOTAL'] ),      
				'SISA'             => ( $FLAGZ == 'UM') ? (float) str_replace(',', '', $request['TOTAL'] ) * -1  : (float) str_replace(',', '', $request['TOTAL'] ),      
                'ACNOA'            => ($request['ACNOA'] == null) ? "" : $request['ACNOA'],				
				'NACNOA'           => ($request['NACNOA'] == null) ? "" : $request['NACNOA'],
                'BACNO'            => ($request['BACNO'] == null) ? "" : $request['BACNO'],
                'BNAMA'            => ($request['BNAMA'] == null) ? "" : $request['BNAMA'],				
                'TYPE'             => ($request['TYPE'] == null) ? "" : $request['TYPE'],				
                'NOTES'             => ($request['NOTES'] == null) ? "" : $request['NOTES'],	
                'ACNOB'            => '211101',
                'NACNOB'           => 'HUTANG DAGANG',			
                'USRNM'            => Auth::user()->username,
                'updated_by'       => Auth::user()->username,
                'CBG'              => $CBG,
                'FLAG'              => $FLAGZ,
                'GOL'              => $GOLZ,
                'PKP'              => $PPN,
                'TGL_BL'           => date('Y-m-d', strtotime($request['TGL_BL'])),
                'TG_SMP'           => Carbon::now()
            ]
        );

		$no_buktix = $utbeli->NO_BUKTI;
		
	
	   DB::SELECT("UPDATE beli, sup
                            SET beli.NAMAS = sup.NAMAS, beli.ALAMAT = sup.ALAMAT, beli.KOTA = sup.KOTA  WHERE beli.KODES = sup.KODES 
							AND beli.NO_BUKTI='$no_buktix';");

        DB::SELECT("UPDATE beli, account
                            SET beli.BNAMA = account.NAMA  WHERE beli.BACNO = account.ACNO 
							AND beli.NO_BUKTI='$no_buktix';");
							
        DB::SELECT("UPDATE beli, account
                            SET beli.NACNOA = account.NAMA  WHERE beli.ACNOA = account.ACNO 
							AND beli.NO_BUKTI='$no_buktix';");
	

		if ( $FLAGZ == 'UM' ) {
          
    	     $variablell = DB::select('call umins(?,?)', array($utbeli['NO_BUKTI'], 'X'));

        } else if ( $FLAGZ == 'TH' ) {
             $variablell = DB::select('call thutins(?)', array($utbeli['NO_BUKTI']));
        }
		
	
		$utbeli = beli::where('NO_BUKTI', $no_buktix )->first();
	
	
	 
						
		return redirect('/utbeli?flagz='.$FLAGZ.'&golz='.$GOLZ)
	   ->with(['judul' => $judul, 'golz' => $GOLZ, 'flagz' => $FLAGZ ]);

    }

    public function destroy( Request $request, beli $utbeli)
    {

		$this->setFlag($request);
        $FLAGZ = $this->FLAGZ;
        $GOLZ = $this->GOLZ;
        $judul = $this->judul;
		
		$per = session()->get('periode')['bulan'] . '/' . session()->get('periode')['tahun'];
        $cekperid = DB::SELECT("SELECT POSTED from perid WHERE PERIO='$per'");
        if ($cekperid[0]->POSTED==1)
        {
            return redirect()->route('utbeli')
                ->with('status', 'Maaf Periode sudah ditutup!')
                ->with(['judul' => $judul, 'golz' => $GOLZ, 'flagz' => $FLAGZ]);
				
        }
				
				
				
				
				
		if ( $FLAGZ == 'UM' ) {
           
		     $variablell = DB::select('call umdel(?,?)', array($utbeli['NO_BUKTI'], '1'));

        } else if ( $FLAGZ == 'TH' ) {
             $variablell = DB::select('call thutdel(?)', array($utbeli['NO_BUKTI']));
        }
		
        $deletebeli = beli::find($utbeli->NO_ID);
        $deletebeli->delete();

		return redirect('/utbeli?flagz='.$FLAGZ.'&golz='.$GOLZ)
		       ->with(['judul' => $judul, 'golz' => $GOLZ, 'flagz' => $FLAGZ ])
			   ->with('statusHapus', 'Data '.$utbeli->NO_BUKTI.' berhasil dihapus');



    }

    public function repost(beli $utbeli)
    {
        DB::SELECT("UPDATE utbeli SET POSTED=0 WHERE NO_ID=".$utbeli->NO_ID." AND FLAG in ('BD','BN')");
        return redirect('/utbelin')->with('status', 'Data '.$utbeli->NO_BUKTI.' berhasil dibuka posting');
    }
	
	
	public function jsutbelic(beli $utbeli)
    {
       
       
        $no_beli = $utbeli->NO_BUKTI;

        $file     = 'utbelic';

        $flagz1 = $utbeli->FLAG;
        $judul ='';
        
        if ( $flagz1 =='TH')
        {
                $judul ='Transaksi Hutang';
        
        }
        
        if ( $flagz1 =='UM')
        {
                $judul ='Uang Muka Pembelian';    
        }
        
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->load_xml_file(base_path() . ('/app/reportc01/phpjasperxml/' . $file . '.jrxml'));

        $query = DB::SELECT("SELECT beli.NO_BUKTI, beli.TGL, beli.KODES, beli.NAMAS, beli.TOTAL,
                             IF(beli.FLAG ='TH', ACNOA, BACNO ) AS ACNO, IF ( beli.FLAG ='TH', NACNOA, BNAMA ) AS NACNO,
                             beli.NOTES, beli.USRNM
                            FROM beli
                            WHERE beli.NO_BUKTI='$no_beli' 
                            ;
		");

                DB::SELECT("UPDATE beli SET POSTED = 1 WHERE NO_BUKTI='$no_beli';");
                
        $data = [];

        foreach ($query as $key => $value) {
            array_push($data, array(
                'NO_BUKTI' => $query[$key]->NO_BUKTI,
                'TGL'      => $query[$key]->TGL,
                'KODES'    => $query[$key]->KODES,
                'NAMAS'    => $query[$key]->NAMAS,
                'TOTAL'    => $query[$key]->TOTAL,
                'NOTES'    => $query[$key]->NOTES,
                'ACNO'    => $query[$key]->ACNO,
                'NACNO'    => $query[$key]->NACNO,
                'JUDUL'    => $judul,
                'USRNM'    => $query[$key]->USRNM
            ));
        }
		
        $PHPJasperXML->setData($data);
        ob_end_clean();
        $PHPJasperXML->outpage("I");
       
       
       
       
       
       
    }
}