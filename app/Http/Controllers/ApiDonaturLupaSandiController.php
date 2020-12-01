<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiDonaturLupaSandiController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "donatur";        
        $this->permalink = "donatur_lupa_sandi";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        $email       = $postdata['email'];  
        $check_email = DB::table('donatur')->where('email',$email)->first();

        if (!$check_email) { 
            $result['api_status']  = 0;
            $result['api_message'] = 'Email yang anda masukan tidak terdaftar';
            $res                   = response()->json($result);
            $res->send();
            exit;
            
        }
        $password        = uniqid();
        $p['password']   = \Hash::make($password);
        $p['updated_at'] = date('Y-m-d H:i:s');

        DB::table('donatur')->where('id',$check_email->id)->update($p);

        $email = show_value($check_email->id,'donatur','email');
        $html  = "<h2>Kemendikbud - TBM, Lupa Sandi</h2>
                <p>Silahkan Login ke akun Donatur dengan email dan password di bawah ini :</p>
                <p>Email : ".$email."</p>
                <p>Password : ".$password."</p>";
        send_email($email,'Kemendikbud - TBM, Lupa Sandi',$html);

        $result['api_status']  = 1;
        $result['api_message'] = 'Lupa Sandi Berhasil, Silahkan cek email anda';
        $res                   = response()->json($result);
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