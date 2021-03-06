<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiProvinsiController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table       = "propinsi";        
        $this->permalink   = "provinsi";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        //
        
        $data = DB::table('propinsi')->where('deleted_at',NULL)->get();
        
        $result['api_status']  = 1;
        $result['api_message'] = 'success';
        $result['data']        = $data;
        $res = response()->json($result);
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