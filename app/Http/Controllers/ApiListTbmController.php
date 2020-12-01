<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiListTbmController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "tbm";        
        $this->permalink = "list_tbm";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        if ($postdata['search_']) {
            $data = DB::table('tbm')
                    ->where('nama','LIKE','%'.$postdata['search_'].'%')
                    ->orWhere('nama_ketua','LIKE','%'.$postdata['search_'].'%')
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
        foreach ($result['data'] as &$item) {
            $id                = $item->id;
            $provinsi          = $item->provinsi;
            $kabupaten         = $item->kota;
            $item->id_provinsi = $provinsi;
            $item->provinsi    = show_value($provinsi,'propinsi','propinsi');
            $item->id_kota     = $kabupaten;
            $item->kota        = show_value($kabupaten,'kabupaten','kabupaten');
            if (!$item->latitude) {
                $item->latitude = 0;
                $item->longitude = 0;
            }
        }

    }

}