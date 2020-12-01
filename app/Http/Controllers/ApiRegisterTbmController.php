<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;
use Illuminate\Support\Facades\Storage;

class ApiRegisterTbmController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "tbm";        
        $this->permalink = "register_tbm";        
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        // print_r($postdata);

        $nama                    = $postdata['nama'];
        $alamat                  = $postdata['alamat'];
        $provinsi                = $postdata['provinsi'];
        $kota                    = $postdata['kota'];
        $kodepos                 = $postdata['kodepos'];
        $tlpn                    = $postdata['tlpn'];
        $email                   = $postdata['email'];
        $password                = $postdata['password'];
        $tahun_berdiri           = $postdata['tahun_berdiri'];
        $no_izin                 = $postdata['no_izin'];
        $latitude                = $postdata['latitude'];
        $longitude               = $postdata['longitude'];
        $nama_ketua              = $postdata['nama_ketua'];
        $alamat_pengelola        = $postdata['alamat_pengelola'];
        $kodepos_pengelola       = $postdata['kodepos_pengelola'];
        $tempat_lahir_pengelola  = $postdata['tempat_lahir_pengelola'];
        $tanggal_lahir_pengelola = $postdata['tanggal_lahir_pengelola'];
        $tlpn_pengelola          = $postdata['tlpn_pengelola'];
        $email_pengelola         = $postdata['email_pengelola'];
        $no_hp                   = $postdata['no_hp'];
        // $dokumen                 = Request::get('dokumen');

        $check_email = DB::table('tbm')->where('email',$email)->first();
        if ($check_email) { 
            $result['api_status']  = 0;
            $result['api_message'] = 'Email yang anda gunakan sudah terdaftar';
            $res                   = response()->json($result);
            $res->send();
            exit;
        }

        $q['nama']                    = $postdata['nama'];
        $q['alamat']                  = $postdata['alamat'];
        $q['provinsi']                = $postdata['provinsi'];
        $q['kota']                    = $postdata['kota'];
        $q['kodepos']                 = $postdata['kodepos'];
        $q['tlpn']                    = $postdata['tlpn'];
        $q['email']                   = $postdata['email'];
        $q['password']                = \Hash::make($password);
        $q['tahun_berdiri']           = $postdata['tahun_berdiri'];
        $q['no_izin']                 = $postdata['no_izin'];
        $q['latitude']                = $postdata['latitude'];
        $q['longitude']               = $postdata['longitude'];
        $q['nama_ketua']              = $postdata['nama_ketua'];
        $q['alamat_pengelola']        = $postdata['alamat_pengelola'];
        $q['kodepos_pengelola']       = $postdata['kodepos_pengelola'];
        $q['tempat_lahir_pengelola']  = $postdata['tempat_lahir_pengelola'];
        $q['tanggal_lahir_pengelola'] = $postdata['tanggal_lahir_pengelola'];
        $q['tlpn_pengelola']          = $postdata['tlpn_pengelola'];    
        $q['email_pengelola']         = $postdata['email_pengelola'];
        $q['no_hp']                   = $postdata['no_hp'];
        $q['created_at']              = date('Y-m-d H:i:s');

        if (Request::get('image')){            
            //Create Directory Monthly 
            Storage::makeDirectory(date('Y-m'));

            //Move file to storage
            $name     = Request::get('image_name');
            $filename = md5(str_random(5));
            $filename .= preg_replace('/\s+/u', '_', $name); 

            $penyimpanan = storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')).DIRECTORY_SEPARATOR.$filename;            
            if(file_put_contents($penyimpanan,base64_decode(Request::get('image')))){
                $v          = 'uploads/'.date('Y-m').'/'.$filename;
                $q['image'] = $v;
            }
        }


        $insert       = DB::table('tbm')->insert($q);
        $lastInsertId = DB::getPdo()->lastInsertId();


        // if (!empty($dokumen)) {
        //     $dokumen = json_decode($dokumen,true);
        //     foreach( $dokumen as $item ) {
        //         //Create Directory Monthly 
        //         Storage::makeDirectory(date('Y-m'));

        //         //Move file to storage
        //         $file     = $item['file'];
        //         $name     = $item['name'];
        //         $filename = md5(str_random(5));
        //         $filename .= preg_replace('/\s+/u', '_', $name); 

        //         $penyimpanan = storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')).DIRECTORY_SEPARATOR.$filename;            
        //         if(file_put_contents($penyimpanan,base64_decode($file))){
        //             $v          = 'uploads/'.date('Y-m').'/'.$filename;
        //             $p['id_tbm'] = $lastInsertId;
        //             $p['upload'] = $v;
        //             $insert      = DB::table('tbm_dokumen')->insert($p);
        //         }
                
        //     }
        // }
        // 
        

        if (Request::get('image_ktp_pengelola')){    
            //Create Directory Monthly 
            Storage::makeDirectory(date('Y-m'));

            //Move file to storage
            $file     = Request::get('image_ktp_pengelola');
            $name     = Request::get('name_image_ktp_pengelola');

            $filename = md5(str_random(5));
            $filename .= preg_replace('/\s+/u', '_', $name); 

            $penyimpanan = storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')).DIRECTORY_SEPARATOR.$filename;            
            if(file_put_contents($penyimpanan,base64_decode($file))){
                $v           = 'uploads/'.date('Y-m').'/'.$filename;
                $p['id_tbm'] = $lastInsertId;
                $p['upload'] = $v;
                $p['desk']   = 'KTP Pengelola';
                $insert      = DB::table('tbm_dokumen')->insert($p);
            }
        }

        if (Request::get('image_izin_oprasional')){    
            //Create Directory Monthly 
            Storage::makeDirectory(date('Y-m'));

            //Move file to storage
            $file     = Request::get('image_izin_oprasional');
            $name     = Request::get('name_image_izin_oprasional');

            $filename = md5(str_random(5));
            $filename .= preg_replace('/\s+/u', '_', $name); 

            $penyimpanan = storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')).DIRECTORY_SEPARATOR.$filename;            
            if(file_put_contents($penyimpanan,base64_decode($file))){
                $v           = 'uploads/'.date('Y-m').'/'.$filename;
                $o['id_tbm'] = $lastInsertId;
                $o['upload'] = $v;
                $o['desk']   = 'Izin Oprasional';
                $insert      = DB::table('tbm_dokumen')->insert($o);
            }
        }

        $result['api_status']  = 1;
        $result['api_message'] = 'TBM Berhasil didaftarkan, Pemberitahuan Aproval akan dikirim melalui Email, Approval TBM akan diproses maksimal 2x24Jam';
        $result['id']          = $lastInsertId;
        $res                   = response()->json($result);
        $res->send();
        exit;
    }

    public function hook_after($postdata,&$result) {
        //Code here if you want execute some action after API Query Called
    }
        

    public function hook_query_list(&$data) {
        //Code here if you want execute some action while API Database Query especially for Listing Type of API
    }

    public function hook_query_detail(&$data) {
        //Code here if you want execute some action while API Database Query especially for Detail Type of API
    }

}