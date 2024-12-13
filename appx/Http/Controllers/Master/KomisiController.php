<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\Master\Komisi;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class KomisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // ganti 3
        return view('master_komisi.index');
    }

    // ganti 4
    public function browse(Request $request)
    {
        $komisi = DB::SELECT("SELECT NO_ID, TYPE, KOM
                            FROM komisi
                            ORDER BY TYPE");

        return response()->json($komisi);
    }




    public function getKomisi()
    {
        // ganti 5

        $komisi = Komisi::query();

        // ganti 6

        return Datatables::of($komisi)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if (Auth::user()->divisi=="programmer" || Auth::user()->divisi=="owner" || Auth::user()->divisi=="sales") 
                {   
                    // url untuk delete di index
                    $url = "'".url("komisi/delete/" . $row->NO_ID )."'";
                    // batas

                    $btnDelete = ' onclick="deleteRow('.$url.')"';

                    $btnPrivilege =
                        '
                                <a class="dropdown-item" href="komisi/edit/?idx=' . $row->NO_ID . '&tipx=edit";
                                <i class="fas fa-edit"></i>
                                    Edit
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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
                'TYPE'       => 'required'
            ]
        );





        // Insert Header

        // ganti 10

        $komisi = Komisi::create(
            [
                'TYPE'         => ($request['TYPE'] == null) ? "" : $request['TYPE'],
                'KOM'            => (float) str_replace(',', '', $request['KOM']),
                'USRNM'          => Auth::user()->username,
                'TG_SMP'         => Carbon::now()
            ]
        );

        //  ganti 11

	    $kodex = $request['TYPE'];
		
		$komisi = Komisi::where('TYPE', $kodex )->first();
					       
        return redirect('/komisi')->with('statusInsert', 'Data baru berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 12



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 15

	public function edit(Request $request ,  Komisi $komisi)
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
		   
		   $bingco = DB::SELECT("SELECT NO_ID, ACNO from komisi 
		                 where TYPE = '$kodex'						 
		                 ORDER BY TYPE ASC  LIMIT 1" );
						 
			
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
			
		   $bingco = DB::SELECT("SELECT NO_ID, TYPE from komisi      
		                 ORDER BY TYPE ASC  LIMIT 1" );
					 
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
			
		   $bingco = DB::SELECT("SELECT NO_ID, TYPE from komisi      
		             where TYPE < 
					 '$kodex' ORDER BY TYPE DESC LIMIT 1" );
			

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
	   
		   $bingco = DB::SELECT("SELECT NO_ID, TYPE from komisi    
		             where TYPE > 
					 '$kodex' ORDER BY TYPE ASC LIMIT 1" );
					 
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
		  
    		$bingco = DB::SELECT("SELECT NO_ID, TYPE from komisi     
		              ORDER BY TYPE DESC  LIMIT 1" );
					 
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
			$komisi = Komisi::where('NO_ID', $idx )->first();	
	     }
		 else
		 {
             $komisi = new Komisi;			 
		 }

		 $data = [
                    'header' => $komisi,
                ];				
			return view('master_komisi.edit', $data)->with(['tipx' => $tipx, 'idx' => $idx ]);
		 
	 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 18

    public function update(Request $request, Komisi $komisi)
    {

        $this->validate(
            $request,
            [

                // ganti 19

                'TYPE'       => 'required',
                'KOM'      => 'required'
            ]
        );

        // ganti 20
		$tipx = 'edit';
		$idx = $request->idx;

        $komisi->update(
            [

                'KOM'            => (float) str_replace(',', '', $request['KOM']),
                'USRNM'          => Auth::user()->username,
                'TG_SMP'         => Carbon::now()
            ]
        );


        //  ganti 21

        return redirect('/komisi')->with('statusInsert', 'Data baru berhasil diupdate');
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

    // ganti 22

    public function destroy( Request $request , Komisi $komisi)
    {

        // ganti 23
        $deleteKomisi = Komisi::find($komisi->NO_ID);

        // ganti 24

        $deleteKomisi->delete();

        // ganti 
        return redirect('/komisi')->with('status', 'Data berhasil dihapus');
    }

    public function cekkomisi(Request $request)
    {
        $getItem = DB::SELECT('select count(*) as ADA from komisi where TYPE ="' . $request->TYPE . '"');

        return $getItem;
    }
}
