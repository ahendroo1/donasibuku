<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiDonaturDonasiDetailController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "donasi";        
        $this->permalink = "donatur_donasi_detail";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called

    }

    public function hook_query(&$query) {
        //You can custom the api query 

    }

    public function hook_after($postdata,&$result) {
        //Code here if you want execute some action after API Query Called
        $id = $result['id'];
        $donasi_item = DB::table('donasi_item')->where('id_donasi',$id)->get();
        $konfirmasi  = DB::table('konfirmasi_donasi')->where('id_donasi',$id)->first();
        if ($konfirmasi) {
            $konfirmasi_pembayaran = 1;
        }else{
            $konfirmasi_pembayaran = 0;
        }

        $result['total']                        = total($id);
        $result['donasi_item']                  = $donasi_item;
        $result['konfirmasi_pembayaran']        = $konfirmasi_pembayaran;
        $result['detail_konfirmasi_pembayaran'] = $konfirmasi;

    }

}