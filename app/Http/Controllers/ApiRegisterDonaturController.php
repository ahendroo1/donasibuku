<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;
use Crypt;

class ApiRegisterDonaturController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "donatur";        
        $this->permalink = "register_donatur";        
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        $email = $postdata['email'];
        $check_email = DB::table('donatur')->where('email',$email)->first();
        if ($check_email) { 
            $result['api_status']  = 0;
            $result['api_message'] = 'Email yang anda gunakan sudah terdaftar';
            $res                   = response()->json($result);
            $res->send();
            exit;
        }
        $postdata['created_at']    = date('Y-m-d H:i:s');
    }

    public function hook_after($postdata,&$result) {
        //Code here if you want execute some action after API Query Called
        $email = show_value($result['id'],'donatur','email');
        $html = "<h2>Kemendikbud - TBM, Aktivasi Akun Donatur</h2>
                <p>Silahkan klik link di bawah ini untuk aktivasi akun anda</p>
                <p><a href='".url('/aktivasi/'.Crypt::encrypt($result['id']))."'>".url('/aktivasi/'.Crypt::encrypt($result['id']))."</a></p>";
        send_email($email,'Kemendikbud - TBM, Aktivasi Akun Donatur',$html);
        $result['api_message'] = 'Registrasi Donatur Berhasil, Silahkan cek email anda untuk aktivasi akun';
    }

    public function hook_query_list(&$data) {
        //Code here if you want execute some action while API Database Query especially for Listing Type of API
    }

    public function hook_query_detail(&$data) {
        //Code here if you want execute some action while API Database Query especially for Detail Type of API
    }

}