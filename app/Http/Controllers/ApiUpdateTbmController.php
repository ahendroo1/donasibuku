<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;
use Illuminate\Support\Facades\Storage;

class ApiUpdateTbmController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table       = "tbm";        
        $this->permalink   = "update_tbm";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        if ($postdata['password']) {
            $password_lama_sqllite = $postdata['password_lama_sqllite'];
            $password_lama         = $postdata['password_lama'];
            $tbm                   = DB::table('tbm')->where('id',$postdata['id'])->first();
            if(\Hash::check($password_lama_sqllite,$tbm->password)) {
                if(\Hash::check($password_lama,$tbm->password)){                
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

        $image      = $postdata['image'];
        $image_name = $postdata['image_name'];
        // $dokumen    = $postdata['dokumen'];
        if ($image) {
            Storage::makeDirectory(date('Y-m'));

            //Move file to storage
            $name     = $image_name;
            $filename = md5(str_random(5));
            $filename .= preg_replace('/\s+/u', '_', $name); 

            $penyimpanan = storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')).DIRECTORY_SEPARATOR.$filename;            
            if(file_put_contents($penyimpanan,base64_decode(Request::get('image')))){
                $v          = 'uploads/'.date('Y-m').'/'.$filename;
                $q['image'] = $v;                
                $insert     = DB::table('tbm')->where('id',$postdata['id'])->update($q);
            }
            unset($postdata['image']);
        }
        // if ($dokumen) {
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
        //             $p['id_tbm'] = $postdata['id'];
        //             $p['upload'] = $v;
        //             $insert      = DB::table('tbm_dokumen')->insert($p);
        //         }

        //     }
        //     unset($postdata['dokumen']);
        // }
        

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
                $p['upload'] = $v;
                $update      = DB::table('tbm_dokumen')->where('id_tbm',$postdata['id'])->where('desk','KTP Pengelola')->update($p);
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
                $o['upload'] = $v;
                $update      = DB::table('tbm_dokumen')->where('id_tbm',$postdata['id'])->where('desk','Izin Oprasional')->update($o);
            }
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