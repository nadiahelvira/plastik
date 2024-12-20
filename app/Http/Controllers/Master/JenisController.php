<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\Master\Jenis;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

// ganti 2
class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('master_jenis.index');
    }



	
    public function getJenis()
    {
// ganti 5

        $jenis = Jenis::query();
		
// ganti 6
		
        return Datatables::of($jenis)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->divisi=="programmer" || Auth::user()->divisi=="owner" || Auth::user()->divisi=="purchase")
                    {
                        $btnPrivilege = 
                        '
                                <a class="dropdown-item" href="jenis/edit/?idx=' . $row->NO_ID . '&tipx=edit";
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <hr></hr>
                                <a hidden class="dropdown-item btn btn-danger" onclick="return confirm(&quot; Apakah anda yakin ingin hapus? &quot;)" href="jenis/delete/'. $row->NO_ID .'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Delete
                                </a> 
                        ';
                    } 
                    else
                    {
                        $btnPrivilege = '';
                    }

                    $actionBtn = 
                    '
                    <div class="dropdown show" style="text-align: center">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
 

                            '.$btnPrivilege.'
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

        
        $this->validate($request,
// GANTI 9

        [
                'KODE'       => 'required'
            ]
        );

        // Insert Header

// ganti 10

        $jenis = Jenis::create(
            [
                'KODE'         => ($request['KODE']==null) ? "" : $request['KODE'],	
				'USRNM'          => Auth::user()->username,
				'TG_SMP'         => Carbon::now()
            ]
        );

//  ganti 11

        return redirect('/jenis')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Request $request , Jenis $jenis)
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
            
            $bingco = DB::SELECT("SELECT NO_ID, KODE from jenis
                            where KODE = '$kodex'						 
                            ORDER BY KODE ASC  LIMIT 1" );
                            
                
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
                
            $bingco = DB::SELECT("SELECT NO_ID, KODE from jenis      
                            ORDER BY KODE ASC  LIMIT 1" );
                        
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
                
            $bingco = DB::SELECT("SELECT NO_ID, KODE from jenis     
                        where KODE < 
                        '$kodex' ORDER BY KODE DESC LIMIT 1" );
                

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

                $bingco = DB::SELECT("SELECT NO_ID, KODE from jenis   
                        where KODE > 
                        '$kodex' ORDER BY KODE ASC LIMIT 1" );
                        
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
            
                $bingco = DB::SELECT("SELECT NO_ID, KODE from jenis    
                        ORDER BY KODE DESC  LIMIT 1" );
                        
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
                $jenis = Jenis::where('NO_ID', $idx )->first();	
            }
            else
            {
                $jenis = new Jenis;			 
            }

            $data = [
                        'header' => $jenis,
                    ];				
            return view('master_jenis.edit', $data)->with(['tipx' => $tipx, 'idx' => $idx ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18

    public function update(Request $request, Jenis $jenis )
    {
		

        return redirect('/jenis')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Jenis $jenis)
    {

// ganti 23
        $deleteJenis = Jenis::find($jenis->NO_ID);

// ganti 24

        $deleteJenis->delete();

// ganti 
        return redirect('/jenis')->with('status', 'Data berhasil dihapus');
		
		
    }


    public function cekJenis(Request $request)
    {
        $getItem = DB::SELECT('select count(*) as ADA from jenis where KODE ="' . $request->KODE . '"');

        return $getItem;
    }
	
}
