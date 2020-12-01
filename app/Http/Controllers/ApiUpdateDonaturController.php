<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiUpdateDonaturController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "donatur";        
        $this->permalink = "update_donatur";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        if ($postdata['password']) {
            $password_lama_sqllite = $postdata['password_lama_sqllite'];
            $password_lama         = $postdata['password_lama'];
            $donatur               = DB::table('donatur')->where('id',$postdata['id'])->first();
            if(\Hash::check($password_lama_sqllite,$donatur->password)) {
                if(\Hash::check($password_lama,$donatur->password)){                
                }else{      
                    $result['api_status']  = 0;
                    $result['api_message'] = 'Maaf Password Lama Salah';
                    $res                   = response()->json($result);
                    $res->send();
                    exit;
                }
            }else{     
                $result['api_status']  = 2;
                $result['api_message'] = 'Password Sudah Di Ganti, Harap Login Kembali';
                $res                   = response()->json($result);
                $res->send();
                exit;
            }
            unset($postdata['password_lama_sqllite']);
            unset($postdata['password_lama']);
        }
        $postdata['updated_at'] = date('Y-m-d H:i:s');

    }

    public function hook_query(&$query) {
        //You can custom the api query 

    }

    public function hook_after($postdata,&$result) {
        //Code here if you want execute some action after API Query Called

    }

}