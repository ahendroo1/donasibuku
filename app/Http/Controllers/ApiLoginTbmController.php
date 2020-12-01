<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiLoginTbmController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "tbm";        
        $this->permalink = "login_tbm";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        $email = $postdata['email'];
        $check_email = DB::table('tbm')->where('email',$email)->first();
        if ($check_email) { 
            if ($check_email->setujui == 0) {
                $result['api_status']  = 0;
                $result['api_message'] = 'TBM Belum Disetujui Anda Belum Dapat Melakukan Login';
                $res                   = response()->json($result);
                $res->send();
                exit;
            }
        }

    }

    public function hook_query(&$query) {
        //You can custom the api query 

    }

    public function hook_after($postdata,&$result) {
        //Code here if you want execute some action after API Query Called
        $provinsi            = $result['provinsi'];
        $kabupaten           = $result['kota'];
        $result['id_provinsi'] = $provinsi;
        $result['provinsi']    = show_value($provinsi,'propinsi','propinsi');
        $result['id_kota']     = $kabupaten;
        $result['kota']        = show_value($provinsi,'kabupaten','kabupaten');

    }

}