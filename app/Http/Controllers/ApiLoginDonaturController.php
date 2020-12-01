<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiLoginDonaturController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "donatur";        
        $this->permalink = "login_donatur";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        $email = $postdata['email'];
        $check_email = DB::table('donatur')->where('email',$email)->first();
        if ($check_email) { 
            if ($check_email->aktif == 0) {
                $result['api_status']  = 0;
                $result['api_message'] = 'Akun Anda Tidak Aktif, Silahkan Cek Email Anda Untuk Aktifasi';
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

    }

}