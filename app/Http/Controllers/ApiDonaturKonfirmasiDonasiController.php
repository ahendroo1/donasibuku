<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiDonaturKonfirmasiDonasiController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "konfirmasi_donasi";        
        $this->permalink = "donatur_konfirmasi_donasi";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        $check = DB::table('konfirmasi_donasi')->where('id_donasi',$postdata['id_donasi'])->first();
        if ($check) {
            $result['api_status']  = 0;
            $result['api_message'] = 'Donasi sudah di Konfirmasi';
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
        
        $p['ke_bank']  = show_value($postdata['id_donasi'],'donasi','bank');
        $p['nominal']  = total($postdata['id_donasi']);
        $p['datetime'] = date('Y-m-d H:i:s');

        DB::table('konfirmasi_donasi')->where('id',$result['id'])->update($p);

    }

}