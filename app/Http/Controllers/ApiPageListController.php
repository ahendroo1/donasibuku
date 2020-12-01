<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiPageListController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "cms_pages";        
        $this->permalink = "page_list";    
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
        $p['id']      = 100;
        $p['slug']    = "http://donasibuku.kemdikbud.go.id";
        $p['title']   = 'Unduh Dokumen Pengembangan Budaya Baca';
        $p['content'] = 'Anda Dapat Mengundul File dengan Klik Button Di Bawah Ini <div style="text-align:center">
                            <a href="http://donasibuku.kemdikbud.go.id/'.get_setting('pdf_manual_book').'" style="display:inline-block;background:#f77551;padding:7px 10px;color:#fff;text-decoration:none;margin-top:20px;">Klik disini untuk mengunduh File</a>
                        </div>';
        array_push($result['data'],$p);


    }

}