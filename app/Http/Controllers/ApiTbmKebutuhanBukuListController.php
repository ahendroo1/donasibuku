<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiTbmKebutuhanBukuListController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
		$this->table       = "req_buku";        
		$this->permalink   = "tbm_kebutuhan_buku_list";    
		$this->method_type = "get";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        if ($postdata['search_']) {
			$data              = DB::table('req_buku')
								->select('req_buku.*','tbm.nama as tbm_nama','kategori_buku.nama as kategori_buku_nama')
								->where('judul','LIKE','%'.$postdata['search_'].'%');
			if ($postdata['id_kategori_buku']) {
				$data->where('id_kategori_buku',$postdata['id_kategori_buku']);
			}
			if ($postdata['id_tbm']) {
				$data->where('id_tbm',$postdata['id_tbm']);
			}
            $data = $data->join('tbm', function ($join) {
                $join->on('req_buku.id_tbm', '=', 'tbm.id');
            });

            $data = $data->join('kategori_buku', function ($join) {
                $join->on('req_buku.id_kategori_buku', '=', 'kategori_buku.id');
            });

            $data = $data->get();

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