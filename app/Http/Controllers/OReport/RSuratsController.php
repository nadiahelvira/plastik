<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use App\Models\Master\Cbg;
// ganti 1
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Cust;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

// ganti 2
class RSuratsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  	public function report()
    {
		$cbg = Cbg::groupBy('CBG')->get();
		session()->put('filter_cbg', '');

		$kodec = Cust::orderBy('KODEC')->get();
	
        return view('oreport_surats.report')->with(['kodec' => $kodec])->with(['cbg' => $cbg])->with(['hasil' => []]);
		
    }
	
		public function getSuratsReport(Request $request)
    {
        $query = DB::table('surats')
			->select('NO_BUKTI','TGL','NO_SO','KODEC','NAMAC','TOTAL','NOTES','GOL')
			->get();
			
		if ($request->ajax())
		{
			// Ganti format tanggal input agar sama dengan database
			$tglDrD = date("Y-m-d", strtotime($request['tglDr']));
            $tglSmpD = date("Y-m-d", strtotime($request['tglSmp']));
			
			// Convert tanggal agar ambil start of day/end of day
			//$tglDr = Carbon::parse($request->tglDr)->startOfDay();
            $tglSmp = Carbon::parse($request->tglSmp)->endOfDay();
			
			// Check Filter
			if (!empty($request->gol))
			{
				$query = $query->where('GOL', $request->gol);
			}
			
			if (!empty($request->KODEC))
			{
				$query = $query->where('KODEC', $request->kodec);
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$query = $query->whereBetween('TGL', [$tglDrD, $tglSmp]);
			}
			
			return Datatables::of($query)->addIndexColumn()->make(true);
		}
		
    }	  


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

	public function jasperSuratsReport(Request $request) 
	{
		$file 	= 'suratsn';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
			// Check Filter
			if($request['cbg'])
			{
				$cbg = $request['cbg'];
			}

			if (!empty($request->gol))
			{
				$filtergol = " and a.GOL='".$request->gol."' ";
			}
			
			if (!empty($request->kodec))
			{
				$filterkodec = " and a.KODEC='".$request->kodec."' ";
			}
			
			if (!empty($request->tglDr) && !empty($request->tglSmp))
			{
				$tglDrD = date("Y-m-d", strtotime($request->tglDr));
				$tglSmpD = date("Y-m-d", strtotime($request->tglSmp));
				$filtertgl = " WHERE a.TGL between '".$tglDrD."' and '".$tglSmpD."' ";
			}
			
			if (!empty($request->cbg))
			{
				$filtercbg = " and a.CBG='".$request->cbg."' ";
			}
			

			session()->put('filter_cbg', $request->cbg);
			
		$query = DB::SELECT("
			SELECT a.NO_BUKTI, a.TGL, a.NO_SO, a.KODEC, a.NAMAC, a.TOTAL, a.NOTES, a.GOL, a.TRUCK,
			b.NA_BRG, b.QTY 
			from surats a, suratsd b 
			$filtertgl $filtergol $filterkodec $filtercbg
			ORDER BY NO_BUKTI;
		");

		
		if($request->has('filter'))
		{
			$cbg = Cbg::groupBy('CBG')->get();

			return view('oreport_surats.report')->with(['cbg' => $cbg])->with(['hasil' => $query]);
		}
        
		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'NO_SO' => $query[$key]->NO_SO,
				'KODEC' => $query[$key]->KODEC,
				'NAMAC' => $query[$key]->NAMAC,
				'TOTAL' => $query[$key]->TOTAL,
				'NOTES' => $query[$key]->NOTES,
				'GOL' => $query[$key]->GOL,
				'NA_BRG' => $query[$key]->NA_BRG,
				'TRUCK' => $query[$key]->TRUCK,
				'QTY' => $query[$key]->QTY,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
	

	
}
