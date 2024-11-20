<?php

namespace App\Http\Controllers\OReport;

use App\Http\Controllers\Controller;
use App\Models\Master\Cbg;
use App\Models\Master\Bhn;
use App\Models\Master\Perid;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

use \koolreport\laravel\Friendship;
use \koolreport\bootstrap4\Theme;

class RBhnController extends Controller
{
	
   public function report()
    {
		$cbg = Cbg::groupBy('CBG')->get();
		session()->put('filter_cbg', '');

		$kd_bhn = Bhn::query()->get();
		$per = Perid::query()->get();
		session()->put('filter_per', '');

        return view('oreport_bhn.report')->with(['kd_bhn' => $kd_bhn])->with(['per' => $per])->with(['cbg' => $cbg])->with(['hasil' => []]);
    }
	
   
	public function jasperBhnReport(Request $request) 
	{
		$file 	= 'bhnpr';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
		
        	if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}
		
		if($request['perio'])
		{
			$periode = $request['perio'];
		}
		
		if($request['cbg'])
		{
			$cbg = $request['cbg'];
		}
			
		if (!empty($request->cbg))
		{
			$filtercbg = " and bhnd.CBG='".$request->cbg."' ";
		}
		

		$bulan = substr($periode,0,2);
		$tahun = substr($periode,3,4);
		
		$queryakum = DB::SELECT("SET @akum:=0;");
		$query = DB::SELECT("
		SELECT bhn.KD_BHN,bhn.NA_BHN,bhnd.AW$bulan as AW, bhnd.MA$bulan as MA, 
		    bhnd.KE$bulan as KE,bhnd.LN$bulan as LN,bhnd.AK$bulan as AK, 
			bhnd.HRT$bulan as HRT,bhnd.NIW$bulan as NIW,bhnd.NIM$bulan as NIM,bhnd.NIK$bulan as NIK,
		bhnd.NIL$bulan as NIL,bhnd.NIR$bulan as NIR
		FROM bhn,bhnd
		WHERE bhn.KD_BHN=bhnd.KD_BHN and bhnd.YER='$tahun' 
		$filtercbg
		order by KD_BHN;
		");


		session()->put('filter_per', $periode);
		session()->put('filter_cbg', $request->cbg);

		if($request->has('filter'))
		{
			$per = Perid::query()->get();
			$cbg = Cbg::groupBy('CBG')->get();

			return view('oreport_bhn.report')->with(['per' => $per])->with(['cbg' => $cbg])->with(['hasil' => $query]);
		}

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'KD_BHN' => $query[$key]->KD_BHN,
				'NA_BHN' => $query[$key]->NA_BHN,
				'AW' => $query[$key]->AW,
				'MA' => $query[$key]->MA,
				'KE' => $query[$key]->KE,
				'LN' => $query[$key]->LN,
				'AK' => $query[$key]->AK,
				'HRT' => $query[$key]->HRT,
				'HRT_2' => $query[$key]->HRT_2,
				'NIW' => $query[$key]->NIW,
				'NIM' => $query[$key]->NIM,
				'NIK' => $query[$key]->NIK,
				'NIL' => $query[$key]->NIL,
				'NIR' => $query[$key]->NIR,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
	}
	
}
