<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\Master\Brg;
use App\Models\Master\BrgDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class BrgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {

        // ganti 3
        return view('master_brg.index');
    }


    // ganti 4

    // ganti 4
    // public function browse(Request $request)
	
    // {

    //     $brg = DB::table('brg')->select('KD_BRG', 'NA_BRG', 'SATUAN')->where('GOL', $request['GOL'])->orderBy('KD_BRG', 'ASC')->get();
    //     return response()->json($brg); 
    
	// }

    public function browse(Request $request)
    {   
		$kd_brgx = $request->KD_BRG;
		$pkpx = $request->PKP;
		$ringx = $request->RING;
        $golz = $request->GOL;

		$filter_kd_brg='';

        if( $pkpx == '0' ){

            if (!empty($request->KD_BRG)) {
			
                $filter_kd_brg = " WHERE brg.KD_BRG ='".$request->KD_BRG."' ";
            } 
                
                $brg = DB::SELECT("SELECT brg.KD_BRG, TRIM(REPLACE(REPLACE(REPLACE(brg.NA_BRG, '\n', ' '), '\r', ' '), '\t', ' ')) as NA_BRG,
                                brg.SATUAN, brgdx.HARGA AS HARGA1, brgdx.HARGA2, brgdx.HARGA3, brgdx.HARGA4, brgdx.HARGA5
                                FROM brg, brgdx
                                $filter_kd_brg and brg.KD_BRG = brgdx.KD_BRG
                                AND brg.PN='0' AND brgdx.RING = '$ringx'
                                AND brg. GOL='$golz'
                                ORDER BY brg.KD_BRG  ");
                            
            if	( empty($brg) ) {
                
                $brg = DB::SELECT("SELECT brg.KD_BRG, TRIM(REPLACE(REPLACE(REPLACE(brg.NA_BRG, '\n', ' '), '\r', ' '), '\t', ' ')) as NA_BRG,
                                        brg.SATUAN, brgdx.HARGA AS HARGA1, brgdx.HARGA2, brgdx.HARGA3, brgdx.HARGA4, brgdx.HARGA5
                                FROM brg, brgdx
                                WHERE brg.KD_BRG = brgdx.KD_BRG
                                AND brg.PN='0' AND brgdx.RING = '$ringx'
                                AND brg. GOL='$golz'
                                ORDER BY brg.KD_BRG ");			
            }

        } elseif ($pkpx =! '0')  {

            if (!empty($request->KD_BRG)) {
			
                $filter_kd_brg = " WHERE brg.KD_BRG ='".$request->KD_BRG."' ";
            } 
                
                $brg = DB::SELECT("SELECT brg.KD_BRG, TRIM(REPLACE(REPLACE(REPLACE(brg.NA_BRG, '\n', ' '), '\r', ' '), '\t', ' ')) as NA_BRG,
                                        brg.SATUAN, brgdx.HARGA AS HARGA1, brgdx.HARGA2, brgdx.HARGA3, brgdx.HARGA4, brgdx.HARGA5
                                FROM brg, brgdx
                                $filter_kd_brg AND brg.KD_BRG = brgdx.KD_BRG
                                AND brg.PN<>'0' AND brgdx.RING = '$ringx'
                                AND brg.GOL='$golz'
                                ORDER BY brg.KD_BRG  ");
                            
            if	( empty($brg) ) {
                
                $brg = DB::SELECT("SELECT brg.KD_BRG, TRIM(REPLACE(REPLACE(REPLACE(brg.NA_BRG, '\n', ' '), '\r', ' '), '\t', ' ')) as NA_BRG,
                                        brg.SATUAN, brgdx.HARGA AS HARGA1, brgdx.HARGA2, brgdx.HARGA3, brgdx.HARGA4, brgdx.HARGA5
                                FROM brg, brgdx
                                WHERE brg.PN<>'0' AND brg.KD_BRG = brgdx.KD_BRG
                                AND brg.GOL='$golz' AND brgdx.RING = '$ringx'
                                ORDER BY brg.KD_BRG ");			
            }

        } else {

            if (!empty($request->KD_BRG)) {
			
                $filter_kd_brg = " WHERE brg.KD_BRG ='".$request->KD_BRG."' ";
            } 
                
                $brg = DB::SELECT("SELECT brg.KD_BRG, TRIM(REPLACE(REPLACE(REPLACE(brg.NA_BRG, '\n', ' '), '\r', ' '), '\t', ' ')) as NA_BRG,
                                        brg.SATUAN, brgdx.HARGA AS HARGA1, brgdx.HARGA2, brgdx.HARGA3, brgdx.HARGA4, brgdx.HARGA5
                                FROM brg, brgdx
                                $filter_kd_brg AND brg.KD_BRG = brgdx.KD_BRG
                                AND brg.GOL='$golz'
                                ORDER BY brg.KD_BRG  ");
                            
            if	( empty($brg) ) {
                
                $brg = DB::SELECT("SELECT brg.KD_BRG, TRIM(REPLACE(REPLACE(REPLACE(brg.NA_BRG, '\n', ' '), '\r', ' '), '\t', ' ')) as NA_BRG,
                                        brg.SATUAN, brgdx.HARGA AS HARGA1, brgdx.HARGA2, brgdx.HARGA3, brgdx.HARGA4, brgdx.HARGA5
                                FROM brg, brgdx AND brg.KD_BRG = brgdx.KD_BRG
                                AND brg.GOL='$golz'
                                ORDER BY brg.KD_BRG ");			
            }

        }
		
        

		
        return response()->json($brg);
    }

    public function getBrg( Request $request )
    {
        // ganti 5

        $brg = DB::SELECT("SELECT * from brg  ORDER BY KD_BRG ");
	

        // ganti 6

        return Datatables::of($brg)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->divisi=="programmer" || Auth::user()->divisi=="owner" || Auth::user()->divisi=="sales") 
                {
                    $btnPrivilege =
                        '
                                <a class="dropdown-item" href="brg/edit/?idx=' . $row->NO_ID . '&tipx=edit";
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="brg/delete/' . $row->NO_ID . '">
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
                            <a class="dropdown-item" href="brg/show/' . $row->NO_ID . '">
                            <i class="fas fa-eye"></i>
                                Lihat
                            </a>

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
            // GANTI 9

            [
                'KD_BRG'       => 'required'

            ]

        );

        // Insert Header

        // ganti 10

        $brg = Brg::create(
            [
                'KD_BRG'            => ($request['KD_BRG'] == null) ? "" : $request['KD_BRG'],
                'NA_BRG'            => ($request['NA_BRG'] == null) ? "" : $request['NA_BRG'],
                'GOL'               => ($request['GOL'] == null) ? "" : $request['GOL'],
                'SATUAN'            => ($request['SATUAN'] == null) ? "" : $request['SATUAN'],
                'SATUAN_BELI'       => ($request['SATUAN_BELI'] == null) ? "" : $request['SATUAN_BELI'],
                'ACNOA'             => ($request['ACNOA'] == null) ? "" : $request['ACNOA'],
                'NACNOA'            => ($request['NACNOA'] == null) ? "" : $request['NACNOA'],
                'ACNOB'             => ($request['ACNOB'] == null) ? "" : $request['ACNOB'],
                'NACNOB'            => ($request['NACNOB'] == null) ? "" : $request['NACNOB'],
                'KALI'              => (float) str_replace(',', '', $request['KALI']),
                'ROP'               => (float) str_replace(',', '', $request['ROP']),
                'HJUAL'             => (float) str_replace(',', '', $request['HJUAL']),
                'PN'                => ($request['PN'] == null) ? "" : $request['PN'],
                'MERK'              => ($request['MERK'] == null) ? "" : $request['MERK'],
                'JENIS'             => ($request['JENIS'] == null) ? "" : $request['JENIS'],
                'PANJANG'           => (float) str_replace(',', '', $request['PANJANG']),
                'LEBAR'             => (float) str_replace(',', '', $request['LEBAR']),
                'DIMENSI'           => (float) str_replace(',', '', $request['DIMENSI']),
                'VOLUME'            => (float) str_replace(',', '', $request['VOLUME']),
                'USRNM'             => Auth::user()->username,
                'created_at'        => Carbon::now(),
				'created_by'        => Auth::user()->username,
                'TG_SMP'            => Carbon::now()
            ]
        );
        
        
        $REC	= $request->input('REC');
		$RING	= $request->input('RING');
		$HARGA	= $request->input('HARGA');
		$HARGA2	= $request->input('HARGA2');
		$HARGA3	= $request->input('HARGA3');
		$HARGA4	= $request->input('HARGA4');
		$HARGA5	= $request->input('HARGA5');
        
        // Check jika value detail ada/tidak
        if ($REC) {
            foreach ($REC as $key => $value) {
                // Declare new data di Model
                $detail    = new BrgDetail;

                // Insert ke Database
                $detail->KD_BRG     = ($request['KD_BRG'] == null) ? "" : $request['KD_BRG'];			
                $detail->NA_BRG     = ($request['NA_BRG'] == null) ? "" : $request['NA_BRG'];			
                $detail->REC	    = $REC[$key];
                $detail->RING	    = ($RING[$key]==null) ? "" :  $RING[$key];
                $detail->HARGA	    = (float) str_replace(',', '', $HARGA[$key]);		
                $detail->HARGA2	    = (float) str_replace(',', '', $HARGA2[$key]);		
                $detail->HARGA3	    = (float) str_replace(',', '', $HARGA3[$key]);		
                $detail->HARGA4	    = (float) str_replace(',', '', $HARGA4[$key]);		
                $detail->HARGA5	    = (float) str_replace(',', '', $HARGA5[$key]);		
                $detail->created_at	= Carbon::now();		
                $detail->created_by	= Auth::user()->username;		
                $detail->save();
            }
        }	

        //  ganti 11

	    $kd_brgx = $request['KD_BRG'];
		
		$brg = Brg::where('KD_BRG', $kd_brgx )->first();

        DB::SELECT("UPDATE brg,  brgdx
                            SET  brgdx.ID =  brg.NO_ID  WHERE  brg.KD_BRG =  brgdx.KD_BRG 
							AND  brg.KD_BRG='$kd_brgx';");
					       
        //return redirect('/brg/edit/?idx=' . $brg->NO_ID . '&tipx=edit')->with('statusInsert', 'Data baru berhasil ditambahkan');
		return redirect('/brg')->with('statusInsert', 'Data baru berhasil ditambahkan');	
		
		}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    

    // ganti 15

    public function edit(Request $request , Brg $brg)
    {

        // ganti 16
        $tipx = $request->tipx;

		$idx = $request->idx;
					

		
		if ( $idx =='0' && $tipx=='undo'  )
	    {
			$tipx ='top';
			
		   }
		   
		if ($tipx=='search') {
			
		   	
    	   $kodex = $request->kodex;
		   
		   $bingco = DB::SELECT("SELECT NO_ID, KD_BRG from brg
		                 where KD_BRG = '$kodex'						 
		                 ORDER BY KD_BRG ASC  LIMIT 1" );
						 
			
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
			
		   $bingco = DB::SELECT("SELECT NO_ID, KD_BRG from brg      
		                 ORDER BY KD_BRG ASC  LIMIT 1" );
					 
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
			
    	   $kodex = $request->kodex;
			
		   $bingco = DB::SELECT("SELECT NO_ID, KD_BRG from BRG      
		             where KD_BRG < 
					 '$kodex' ORDER BY KD_BRG DESC LIMIT 1" );
			

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
			
				
      	   $kodex = $request->kodex;
	   
		   $bingco = DB::SELECT("SELECT NO_ID, KD_BRG from BRG   
		             where KD_BRG > 
					 '$kodex' ORDER BY KD_BRG ASC LIMIT 1" );
					 
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
		  
    		$bingco = DB::SELECT("SELECT NO_ID, KD_BRG from BRG     
		              ORDER BY KD_BRG DESC  LIMIT 1" );
					 
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
			$brg = Brg::where('NO_ID', $idx )->first();	
	     }
		 else
		 {
             $brg = new Brg;			 
		 }

        $kd_brg = $brg->KD_BRG;
        $brgDetail = DB::table('brgdx')->where('KD_BRG', $kd_brg)->get();


		 $data = [
                    'header'        => $brg,
                    'detail'        => $brgDetail,
                ];				
        return view('master_brg.edit', $data)->with(['tipx' => $tipx, 'idx' => $idx ]);
		 
 
       
		
		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 18

    public function update(Request $request, Brg $brg)
    {

        $this->validate(
            $request,
            [

                // ganti 19

                'KD_BRG'       => 'required',
                'NA_BRG'      => 'required'
            ]
        );

        // ganti 20
		
        $tipx = 'edit';
		$idx = $request->idx;

        $brg->update(
            [

                'NA_BRG'            => ($request['NA_BRG'] == null) ? "" : $request['NA_BRG'],
                'SATUAN'            => ($request['SATUAN'] == null) ? "" : $request['SATUAN'],			 
                'SATUAN_BELI'       => ($request['SATUAN_BELI'] == null) ? "" : $request['SATUAN_BELI'],			 
                'PN'                => ($request['PN'] == null) ? "" : $request['PN'],			 
                'GOL'               => ($request['GOL'] == null) ? "" : $request['GOL'],
                'ACNOA'             => ($request['ACNOA'] == null) ? "" : $request['ACNOA'],
                'NACNOA'            => ($request['NACNOA'] == null) ? "" : $request['NACNOA'],
                'ACNOB'             => ($request['ACNOB'] == null) ? "" : $request['ACNOB'],
                'NACNOB'            => ($request['NACNOB'] == null) ? "" : $request['NACNOB'],
                'KALI'              => (float) str_replace(',', '', $request['KALI']),			 
                'ROP'               => (float) str_replace(',', '', $request['ROP']),			 
                'HJUAL'             => (float) str_replace(',', '', $request['HJUAL']),			 
                'SMIN'              => (float) str_replace(',', '', $request['SMIN']),			 
                'SMAX'              => (float) str_replace(',', '', $request['SMAX']),			 
                'SMIN'              => (float) str_replace(',', '', $request['SMIN']),			 
                'SMAX'              => (float) str_replace(',', '', $request['SMAX']),	
                'MERK'              => ($request['MERK'] == null) ? "" : $request['MERK'],
                'JENIS'             => ($request['JENIS'] == null) ? "" : $request['JENIS'],
                'PANJANG'           => (float) str_replace(',', '', $request['PANJANG']),
                'LEBAR'             => (float) str_replace(',', '', $request['LEBAR']),
                'DIMENSI'           => (float) str_replace(',', '', $request['DIMENSI']),
                'VOLUME'            => (float) str_replace(',', '', $request['VOLUME']),		 
				'USRNM'             => Auth::user()->username,
                'updated_at'        => Carbon::now(),
				'updated_by'        => Auth::user()->username,
                'TG_SMP'            => Carbon::now()


            ]
        );

		$kd_brgx = $brg->KD_BRG;
		
        // Update Detail
        $length = sizeof($request->input('REC'));
        $NO_ID  = $request->input('NO_ID');

        $REC	= $request->input('REC');
		$RING	= $request->input('RING');
		$HARGA	= $request->input('HARGA');
		$HARGA2	= $request->input('HARGA2');
		$HARGA3	= $request->input('HARGA3');
		$HARGA4	= $request->input('HARGA4');
		$HARGA5	= $request->input('HARGA5');		

        $query = DB::table('brgdx')->where('KD_BRG', $request->KD_BRG)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i = 0; $i < $length; $i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = BrgDetail::create(
                    [
                        'KD_BRG'     => $request->KD_BRG,
                        'REC'        => $REC[$i],				
						'NA_BRG'     => ($request['NA_BRG'] == null) ? "" : $request['NA_BRG'],		
						'RING'       => ($RING[$i]==null) ? "" :  $RING[$i],		
						'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
						'HARGA2'     => (float) str_replace(',', '', $HARGA2[$i]),
						'HARGA3'     => (float) str_replace(',', '', $HARGA3[$i]),
						'HARGA4'     => (float) str_replace(',', '', $HARGA4[$i]),
						'HARGA5'     => (float) str_replace(',', '', $HARGA5[$i]),
						'updated_by' => Auth::user()->username,
						'updated_at' => Carbon::now(),
						
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $upsert = BrgDetail::updateOrCreate(
                    [
                        'KD_BRG'  => ($request['KD_BRG'] == null) ? "" : $request['KD_BRG'],
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])
                    ],

                    [
                        'REC'        => $REC[$i],
                        				
						'NA_BRG'     => ($request['NA_BRG'] == null) ? "" : $request['NA_BRG'],		
						'RING'       => ($RING[$i]==null) ? "" :  $RING[$i],				
						'HARGA'      => (float) str_replace(',', '', $HARGA[$i]),
						'HARGA2'     => (float) str_replace(',', '', $HARGA2[$i]),
						'HARGA3'     => (float) str_replace(',', '', $HARGA3[$i]),
						'HARGA4'     => (float) str_replace(',', '', $HARGA4[$i]),
						'HARGA5'     => (float) str_replace(',', '', $HARGA5[$i]),
						'updated_by' => Auth::user()->username,
						'updated_at' => Carbon::now(),					
                    ]
                );
            }
        }

        ////////////////////////////////////////////////////

        $brg = Brg::where('KD_BRG', $kd_brgx )->first();

        //  ganti 21

        //return redirect('/brg/edit/?idx=' . $brg->NO_ID . '&tipx=edit');
		return redirect('/brg')->with('status', 'Data berhasil diupdate');
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 22

    public function destroy(Request $request , Brg $brg)
    {

        // ganti 23
        $deleteBrg = Brg::find($brg->NO_ID);

        // ganti 24

        $deleteBrg->delete();

        // ganti 
        return redirect('/brg')->with('status', 'Data berhasil dihapus');
    }


    public function cekbarang(Request $request)
    {
        $getItem = DB::SELECT('select count(*) as ADA from brg where KD_BRG ="' . $request->KDBRG . '"');

        return $getItem;
    }
	
    public function getSelectKdbrg(Request $request)
    {
        $search = $request->search;
        $page = $request->page;
        if ($page == 0) {
            $xa = 0;
        } else {
            $xa = ($page - 1) * 10;
        }
        $perPage = 10;
        
        $hasil = DB::SELECT("SELECT KD_BRG, NA_BRG, SATUAN from brg WHERE (KD_BRG LIKE '%$search%' or NA_BRG LIKE '%$search%') ORDER BY KD_BRG LIMIT $xa,$perPage ");
        $selectajax = array();
        foreach ($hasil as $row => $value) {
            $selectajax[] = array(
                'id' => $hasil[$row]->KD_BRG,
                'text' => $hasil[$row]->KD_BRG,
                'na_brg' => $hasil[$row]->NA_BRG,
                'satuan' => $hasil[$row]->SATUAN,
            );
        }
        $select['total_count'] =  count($selectajax);
        $select['items'] = $selectajax;
        return response()->json($select);
    }
}
