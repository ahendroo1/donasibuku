<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiTokoBukuController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "toko_buku";        
        $this->permalink = "toko_buku";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        if ($postdata['search_']) {
            $data = DB::table('toko_buku')
                    ->where('nama','LIKE','%'.$postdata['search_'].'%')
                    ->orWhere('desk','LIKE','%'.$postdata['search_'].'%')
                    ->get();

            if (!$data) {
                $result['api_status']  = 0;
                $result['api_message'] = 'Data yang anda cari tidak tersedia';
                $res = response()->json($result);
                $res->send();
                exit;
            }

            $result['api_status']  = 1;
            $result['api_message'] = 'success';
            $result['data']        = $data;
            $res = response()->json($result);
            $res->send();
            exit;

        }

    }

    public function hook_query(&$query) {
        //You can custom the api query 

    }

    public function hook_after($postdata,&$result) {
        //Code here if you want execute some action after API Query Called

    }

}