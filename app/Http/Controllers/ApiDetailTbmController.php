<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiDetailTbmController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table       = "tbm";        
        $this->permalink   = "detail_tbm";    
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
        $setujui = show_value($postdata['id'],'tbm','setujui');
        if ($setujui == 1) {
            $result['tbm_dokumen'] = array();
            $tbm_dokumen = DB::table('tbm_dokumen')->where('id_tbm',$postdata['id'])->get();
            foreach ($tbm_dokumen as $item) {
                $result['tbm_dokumen'][] = array('id'=>$item->id,'id_tbm'=>$item->id_tbm,'upload'=>asset($item->upload),'original_name_file'=>substr($item->upload, 48));
            }
        }

        
        $provinsi              = $result['provinsi'];
        $kabupaten             = $result['kota'];
        $result['id_provinsi'] = $provinsi;
        $result['provinsi']    = show_value($provinsi,'propinsi','propinsi');
        $result['id_kota']     = $kabupaten;
        $result['kota']        = show_value($kabupaten,'kabupaten','kabupaten');

        if (!$result['latitude']) {
            $result['latitude'] = 0;
            $result['longitude'] = 0;
        }

    }

}