<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiTbmProvinsiController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "tbm";        
        $this->permalink = "tbm_provinsi";    
        $this->method_type = "get";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        $dataLokasi = DB::table('tbm')
                    ->join('propinsi', 'tbm.provinsi', '=', 'propinsi.id')
                    ->select('propinsi.id as id_provinsi','propinsi.propinsi as provinsi',DB::raw('count(tbm.id) as jumlah'))
                    ->where('setujui',1)
                    ->groupBy('tbm.provinsi')
                    ->orderby('propinsi.propinsi','ASC')
                    ->get();

		$result['api_status']  = 1;
		$result['api_message'] = 'success';
		$result['total_tbm']   = total_tbm('all');
		$result['data']        = $dataLokasi;
		$res                   = response()->json($result);
        $res->send();
        exit;

    }

    public function hook_query(&$query) {
        //You can custom the api query 

    }

    public function hook_after($postdata,&$result) {
        //Code here if you want execute some action after API Query Called

    }

}