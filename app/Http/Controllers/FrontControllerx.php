<?php 
namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;
use Faker\Factory as Faker;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;

class FrontController extends Controller {

    function getIndex(){

        // return redirect('login');

        $data['action']          = 'home';
        $data['body_class']      = array('home');
        $data['title_meta']      = get_setting('title_meta');
        $data['keywords']        = get_setting('keywords');
        $data['description']     = get_setting('description');
        
        $data['slider']          = DB::table('slider')->orderBy('id','DESC')->get();
        $data['artikel_big']     = DB::table('artikel')->orderBy('id','DESC')->first();
        $data['artikel_terkini'] = DB::table('artikel')->orderBy('id','DESC')->paginate(5);
        $data['artikel']         = DB::table('artikel')->orderBy('id','DESC')->paginate(11);
        $data['buku_favorite']   = DB::table('buku_favorite')->orderBy('id','DESC')->paginate(8);

        return view('home',$data);

    }

    function getRegister()
    {
        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }

        $data['action']      = 'register_tbm';
        $data['body_class']  = array('register_tbm','page-form');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        $data['propinsi'] = DB::table('propinsi')->orderBy('propinsi')->get();

        return view('register',$data);
    }

    function getLogin()
    {
        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }

        $data['action']      = 'login';
        $data['body_class']  = array('login');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        return view('login',$data);
    }

    function postRegisterTbm()
    {
        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }
        
        // Validation
        $validator = Validator::make(Request::all(),           
            [
                'nama'                    => 'required',                  
                'password'                => 'required',                
                'tahun_berdiri'           => 'required',                  
                'no_izin'                 => 'required',              
                'provinsi'                => 'required',              
                'kota'                    => 'required',  
                'alamat'                  => 'required',                  
                'tlpn'                    => 'required',                  
                'kodepos'                 => 'required',                  
                'email'                   => 'required|email',                  
                'image'                   => 'required',                  
                'nama_ketua'              => 'required',                  
                'tempat_lahir_pengelola'  => 'required',                  
                'tanggal_lahir_pengelola' => 'required',                  
                'alamat_pengelola'        => 'required',                  
                'no_hp'                   => 'required',                   
                'kodepos_pengelola'       => 'required',                  
                'email_pengelola'         => 'required|email' ,               
                // 'upload'               => 'required',               
                'image_ktp_pengelola'     => 'required',             
                'image_izin_oprasional'   => 'required',             
                'confirm_data'            => 'required'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Isilah semua fill dengan lengkap dan benar.');
        } 

        $check = showValue_byField('email',Request::get('email'),'tbm','email');
        if ($check) {
            return redirect()->back()->withInput()->with("message",'Email yang anda gunakan sudah terdaftar');
        }

        // $dokumen = Request::file('upload');
        // if (!$dokumen[0]) {
        //     return redirect()->back()->withInput()->with("message",'Mohon untuk mengisi dokumen penunjang TBM(Foto Gedung,Plang Nama dan lain lain)');
        //     // echo 1;die();
        // }
        
        $nama          = Request::get('nama');                  
        $password      = Request::get('password');                
        $tahun_berdiri = Request::get('tahun_berdiri');                  
        $no_izin       = Request::get('no_izin');              
        $provinsi      = Request::get('provinsi');              
        $kota          = Request::get('kota');  
        $alamat        = Request::get('alamat');                  
        $tlpn          = Request::get('tlpn');                
        $no_hp         = Request::get('no_hp');                  
        $kodepos       = Request::get('kodepos');                  
        $email         = Request::get('email');                
        $image         = Request::file('image');                  
        $nama_ketua    = Request::get('nama_ketua'); 
        
        $latitude      = Request::get('latitude');             
        $longitude     = Request::get('longitude');
        
        $tempat_lahir_pengelola  = Request::get('tempat_lahir_pengelola');              
        $tanggal_lahir_pengelola = Request::get('tanggal_lahir_pengelola');                     
        $alamat_pengelola        = Request::get('alamat_pengelola');                  
        $tlpn_pengelola          = Request::get('tlpn_pengelola');               
        $kodepos_pengelola       = Request::get('kodepos_pengelola');                  
        $email_pengelola         = Request::get('email_pengelola');                   
        $confirm_data            = Request::get('confirm_data');             
        // $dokumen              = Request::file('upload');            
        $image_ktp_pengelola     = Request::file('image_ktp_pengelola');            
        $image_izin_oprasional   = Request::file('image_izin_oprasional');

        $q['nama']                    = $nama;
        $q['alamat']                  = $alamat;
        $q['provinsi']                = $provinsi;
        $q['kota']                    = $kota;
        $q['kodepos']                 = $kodepos;
        $q['tlpn']                    = $tlpn;
        $q['no_hp']                   = $no_hp;
        $q['email']                   = $email;
        $q['password']                = \Hash::make($password);
        $q['tahun_berdiri']           = $tahun_berdiri;
        $q['no_izin']                 = $no_izin;
        
        $q['latitude']                = $latitude;
        $q['longitude']               = $longitude;
        
        $q['nama_ketua']              = $nama_ketua;
        $q['alamat_pengelola']        = $alamat_pengelola;
        $q['kodepos_pengelola']       = $kodepos_pengelola;
        $q['tempat_lahir_pengelola']  = $tempat_lahir_pengelola;
        $q['tanggal_lahir_pengelola'] = $tanggal_lahir_pengelola;
        $q['tlpn_pengelola']          = $tlpn_pengelola;
        $q['email_pengelola']         = $email_pengelola;
        $q['confirm_data']            = $confirm_data;
        $q['created_at']              = date('Y-m-d H:i:s');

        if (Request::hasFile('image')){
            $image = Request::file('image');
            $ext   = $image->getClientOriginalExtension();
            //Create Directory Monthly 
            Storage::makeDirectory(date('Y-m'));

            //Move file to storage
            $name = $image->getClientOriginalName();
            $filename = md5(str_random(5));
            $filename .= preg_replace('/\s+/u', '_', $name); 
            if($image->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
                $v = 'uploads/'.date('Y-m').'/'.$filename;
            } 
            $q['image']   = $v;
        }


        $insert       = DB::table('tbm')->insert($q);
        $lastInsertId = DB::getPdo()->lastInsertId();

        if (Request::hasFile('image_ktp_pengelola')){
            $file = Request::file('image_ktp_pengelola');            
            $ext  = $file->getClientOriginalExtension();

            //Create Directory Monthly 
            Storage::makeDirectory(date('Y-m'));

            //Move file to storage
            $name = $file->getClientOriginalName();
            $filename = md5(str_random(5));
            $filename .= preg_replace('/\s+/u', '_', $name); 
            if($file->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
                $v = 'uploads/'.date('Y-m').'/'.$filename;
            }   

            $p['id_tbm'] = $lastInsertId;
            $p['upload'] = $v;
            $p['desk']   = 'KTP Pengelola';
            $insert      = DB::table('tbm_dokumen')->insert($p);
        }

        if (Request::hasFile('image_izin_oprasional')){
            $file = Request::file('image_izin_oprasional');            
            $ext  = $file->getClientOriginalExtension();

            //Create Directory Monthly 
            Storage::makeDirectory(date('Y-m'));

            //Move file to storage
            $name = $file->getClientOriginalName();
            $filename = md5(str_random(5));
            $filename .= preg_replace('/\s+/u', '_', $name); 
            if($file->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
                $v = 'uploads/'.date('Y-m').'/'.$filename;
            }   

            $p['id_tbm'] = $lastInsertId;
            $p['upload'] = $v;
            $p['desk']   = 'Izin Oprasional';
            $insert      = DB::table('tbm_dokumen')->insert($p);
        }

        // Upload dokumen tidak terbatas
        // foreach($dokumen as $file) {
            
        //     $ext  = $file->getClientOriginalExtension();

        //     //Create Directory Monthly 
        //     Storage::makeDirectory(date('Y-m'));

        //     //Move file to storage
        //     $name = $file->getClientOriginalName();
        //     $filename = md5(str_random(5));
        //     $filename .= preg_replace('/\s+/u', '_', $name); 
        //     if($file->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
        //         $v = 'uploads/'.date('Y-m').'/'.$filename;
        //     }   

        //     $p['id_tbm'] = $lastInsertId;
        //     $p['upload'] = $v;
        //     $insert      = DB::table('tbm_dokumen')->insert($p);

        // }

        return redirect('register')->with("message",'TBM Berhasil didaftarkan, Pemberitahuan Aproval akan dikirim melalui Email, Approval TBM akan diproses maksimal 2x24Jam');
    }

    function postLoginTbm()
    {

        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }

        // Validation
        $validator = Validator::make(Request::all(),            
            [               
                'email'                 => 'required|email',        
                'password'              => 'required' 
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->with("message",'Isilah semua fill dengan lengkap dan benar.');
        }
        $email    = Request::input("email");
        $password = Request::input("password");
        
        $tbm   = DB::table('tbm')->where("email",$email)->first();
        if (!$tbm) {
            return redirect('login')->with('message', 'Maaf email anda tidak terdaftar, mohon untuk melakukan pendaftaran.');
        }
        if ($tbm->setujui == 0) {
            return redirect('login')->with('message', 'Maaf TBM Masih Proses Approval');
        }    

        if(\Hash::check($password,$tbm->password)) {
            Session::put('ss_tbm_id', $tbm->id);
            Session::put('ss_tbm_email', $tbm->email);
            Session::put('ss_type_pengguna', 'tbm');

            DB::table('tbm')
                ->where('id', $tbm->id)
                ->update(['last_login' => date('Y-m-d H:i:s')]);
            
            return redirect('/')->with('message', 'Anda berhasil Login!');
        }else{
            return redirect('login')->with('message', 'Harap memasukan email dan password dengan benar!');
        }
        
    }

    function getLogout(){
        Session::flush();
        return redirect('/');   
    }

    function postLoginDonatur()
    {

        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }

        // Validation
        $validator = Validator::make(Request::all(),            
            [               
                'email'                 => 'required|email',        
                'password'              => 'required' 
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->with("message",'Isilah semua fill dengan lengkap dan benar.');
        }
        $email    = Request::input("email");
        $password = Request::input("password");
        
        $donatur   = DB::table('donatur')->where("email",$email)->first();  
        if (!$donatur) {
            return redirect('login')->with('message', 'Maaf email anda tidak terdaftar, mohon untuk melakukan pendaftaran.');
        }    
        if ($donatur->aktif == 0) {
            return redirect('login')->with('message', 'Mohon untuk aktivasi akun terlebih dahulu');
        }    

        if(\Hash::check($password,$donatur->password)) {
            Session::put('ss_donatur_id', $donatur->id);
            Session::put('ss_donatur_email', $donatur->email);
            Session::put('ss_type_pengguna', 'donatur');

            DB::table('donatur')
                ->where('id', $donatur->id)
                ->update(['last_login' => date('Y-m-d H:i:s')]);
            
            return redirect('/')->with('message', 'Anda berhasil Login!');
        }else{
            return redirect('login')->with('message', 'Harap memasukan email dan password dengan benar!');
        }
        
    }

    function getAktivasi($id_encrypt=''){
        $id = Crypt::decrypt($id_encrypt);        

        $check_donatur = show_value($id,'donatur','id');
        if ($check_donatur) {
            DB::table('donatur')->where('id',$id)->update(['aktif'=>1]);
            return redirect('login')->with("message",'Akun telah berhasil di aktivasi<br>Silahkan Login dengan Email dan Password yang sudah Didaftarkan');
        }else{
            return redirect('login')->with("message",'Terdapat kesalahan silahkan hubungi kontak kami'); 
        }
    }

    function getProfile($slug=''){

        if (!Session::get('ss_type_pengguna')) {
            Session::flush();
            return redirect('login')->with('message', 'Harap login terlebih dahulu');
        }

        if (Session::get('ss_type_pengguna') == 'tbm') {
            $tbm = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
            if ($tbm->setujui == 0) {
                Session::flush();
                return redirect('login')->with('message', 'Maaf TBM Masih Proses Approval');
            } 
        }
        if (Session::get('ss_type_pengguna') == 'donatur') {  
            $donatur = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
            if ($donatur->aktif == 0) {
                Session::flush();
                return redirect('login')->with('message', 'Mohon untuk aktivasi akun terlebih dahulu');
            }

        }    

        switch ($slug) {
            case 'kebutuhan-kategori':
                    $data['action']      = 'kebutuhan-kategori';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('kebutuhan-kategori','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');

                    $data['id_kategori_buku'] = Request::segment(3);
                    $data['tbm']              = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();

                    $check = show_value(Request::segment(3),'kategori_buku','id');
                    if (!$check) {
                        return view('errors.404');
                    }
                    return view('profile.profile_tbm',$data);
                break;
            case 'ubah-kebutuhan':
                    $data['action']      = 'add-kebutuhan';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('add-kebutuhan','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');

                    $data['kebutuhan']     = DB::table('req_buku')->where('id',Request::segment(3))->first();
                    $data['tbm']           = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    $data['kategori_buku'] = DB::table('kategori_buku')->orderBy('nama','ASC')->get();
                    return view('profile.profile_tbm',$data);
                break;
            case 'ubah-kebutuhan':
                    $data['action']      = 'add-kebutuhan';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('add-kebutuhan','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');

                    $data['kebutuhan']     = DB::table('req_buku')->where('id',Request::segment(3))->first();
                    $data['tbm']           = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    $data['kategori_buku'] = DB::table('kategori_buku')->orderBy('nama','ASC')->get();
                    return view('profile.profile_tbm',$data);
                break;
            case 'add-kebutuhan':
                    $data['action']      = 'add-kebutuhan';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('add-kebutuhan','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');

                    $data['tbm']           = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    $data['kategori_buku'] = DB::table('kategori_buku')->orderBy('nama','ASC')->get();
                    return view('profile.profile_tbm',$data);
                break;
            case 'ubah-kegiatan':
                    $data['action']      = 'add-kegiatan';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('add-kegiatan','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');
                    
                    $data['kegiatan']    = DB::table('kegiatan_tbm')->where('id',Request::segment(3))->first();
                    $data['tbm']         = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    return view('profile.profile_tbm',$data);
                break;
            case 'add-kegiatan':
                    $data['action']      = 'add-kegiatan';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('add-kegiatan','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');

                    $data['tbm']          = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    return view('profile.profile_tbm',$data);
                break;

            case 'kegiatan':
                    $data['action']      = 'kegiatan';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('kegiatan','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');

                    $data['tbm']          = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    $data['kegiatan'] = DB::table('kegiatan_tbm')->where('id_tbm',Session::get('ss_tbm_id'))->orderBy('id','DESC')->paginate(5);
                    
                    return view('profile.profile_tbm',$data);
                break;

            case 'kebutuhan':
                    $data['action']      = 'kebutuhan';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('kebutuhan','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');
                    
                    $data['tbm']         = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    $data['kebutuhan']   = DB::table('req_buku')->where('id_tbm',Session::get('ss_tbm_id'))->orderBy('id','DESC')->paginate(5);
                    
                    return view('profile.profile_tbm',$data);
                break;
            case 'konfirmasi-pembayaran':
                    
                    $check = DB::table('konfirmasi_donasi')->where('id_donasi',Request::segment(3))->first();
                    if ($check) {
                        return redirect('profile/riwayat-donasi')->with('message','Donasi sudah di Konfirmasi');
                    }

                    $data['action']      = 'konfirmasi-pembayaran';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('konfirmasi-pembayaran','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');
                    
                    $data['donasi'] = DB::table('donasi')->where('id',Request::segment(3))->first();
                    $data['bank']   = DB::table('bank')->orderBy('bank','ASC')->get();
                    $data['donatur']    = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
                    return view('profile.profile_donatur',$data);
                break;
            case 'riwayat-donasi':
                    $data['action']      = 'riwayat-donasi';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('riwayat-donasi','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');

                    $data['donasi']     = DB::table('donasi')->where('id_donatur',Session::get('ss_donatur_id'))->orderBy('id','DESC')->paginate(5);
                    
                    return view('profile.profile_donatur',$data);
                    // return view('errors.404');
                break;
            case 'pengelola':
                    $data['action']      = 'pengelola';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('pengelola','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');

                    $data['tbm']     = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    
                    return view('profile.profile_tbm',$data);
                break;
            case 'edit':
                    if (Session::get('ss_type_pengguna')=='tbm') {
                        $data['action']      = 'edit-tbm';
                        $data['slug']        = $slug;
                        $data['body_class']  = array('profile','edit-tbm','page-form');
                        $data['title_meta']  = get_setting('title_meta');
                        $data['keywords']    = get_setting('keywords');
                        $data['description'] = get_setting('description');

                        $data['tbm']     = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                        $data['dokumen'] = DB::table('tbm_dokumen')->where('id_tbm',Session::get('ss_tbm_id'))->get();

                        $data['propinsi'] = DB::table('propinsi')->orderBy('propinsi')->get();
                        
                        return view('profile.edit_tbm',$data);
                    }else{
                        $data['action']      = 'edit-donatur';
                        $data['slug']        = $slug;
                        $data['body_class']  = array('profile','edit-donatur','page-form');
                        $data['title_meta']  = get_setting('title_meta');
                        $data['keywords']    = get_setting('keywords');
                        $data['description'] = get_setting('description');

                        $data['donatur']     = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
                        
                        return view('profile.edit_donatur',$data);

                    }
                break;

            case '':
                $data['action']      = 'profile';
                $data['slug']        = $slug;
                $data['body_class']  = array('profile');
                $data['title_meta']  = get_setting('title_meta');
                $data['keywords']    = get_setting('keywords');
                $data['description'] = get_setting('description');

                if (Session::get('ss_type_pengguna')=='tbm') {
                    $data['tbm']     = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    $data['dokumen'] = DB::table('tbm_dokumen')->where('id_tbm',Session::get('ss_tbm_id'))->get();
                    return view('profile.profile_tbm',$data);
                }else{
                    array_push($data['body_class'],'profile-donatur');
                    $data['donatur'] = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
                    return view('profile.profile_donatur',$data);

                }
                break;
            
            default:   
                    return view('errors.404');
                break;
        }
    }

    function postUpdateTbm()
    {

        if (!Session::get('ss_type_pengguna')) {
            return redirect('/');
        }
        
        // Validation
        $validator = Validator::make(Request::all(),            
            [
                'nama'                    => 'required',                 
                'tahun_berdiri'           => 'required',                  
                'no_izin'                 => 'required',              
                'provinsi'                => 'required',              
                'kota'                    => 'required',  
                'alamat'                  => 'required',                  
                // 'tlpn'                    => 'required',                 
                'no_hp'                    => 'required',                  
                'kodepos'                 => 'required',                              
                'nama_ketua'              => 'required',                  
                'tempat_lahir_pengelola'  => 'required',                  
                'tanggal_lahir_pengelola' => 'required',                  
                'alamat_pengelola'        => 'required',                  
                'tlpn'                    => 'required',                   
                'kodepos_pengelola'       => 'required',                  
                'email_pengelola'         => 'required|email'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message","Harap mengisi fill dengan lengkap dan benar");
        }
        
        if(!is_numeric(Request::get('tlpn'))) {
            return redirect()->back()->withInput()->with("message","Mohon memasukan No Telepon dengan benar");
        }
        
        if(!is_numeric(Request::get('no_hp'))) {
            return redirect()->back()->withInput()->with("message","Mohon memasukan No Handphone dengan benar");
        }
        
        if(!is_numeric(Request::get('tlpn_pengelola'))) {
            return redirect()->back()->withInput()->with("message","Mohon memasukan No Telepon Pengelola dengan benar");
        }
        
        $nama                    = Request::get('nama');                  
        $old_password            = Request::get('old_password');              
        $new_password            = Request::get('new_password');              
        $conf_password           = Request::get('conf_password');                
        $tahun_berdiri           = Request::get('tahun_berdiri');                  
        $no_izin                 = Request::get('no_izin');              
        $provinsi                = Request::get('provinsi');              
        $kota                    = Request::get('kota');  
        $alamat                  = Request::get('alamat');                  
        $tlpn                    = Request::get('tlpn');                    
        $no_hp                   = Request::get('no_hp');                  
        $kodepos                 = Request::get('kodepos');                
        $image                   = Request::file('image');                  
        $nama_ketua              = Request::get('nama_ketua');              
        $tempat_lahir_pengelola  = Request::get('tempat_lahir_pengelola');              
        $tanggal_lahir_pengelola = Request::get('tanggal_lahir_pengelola');                     
        $alamat_pengelola        = Request::get('alamat_pengelola');                  
        $tlpn_pengelola          = Request::get('tlpn_pengelola');               
        $kodepos_pengelola       = Request::get('kodepos_pengelola');                  
        $email_pengelola         = Request::get('email_pengelola');             
        $dokumen                 = Request::file('upload');           
        $latitude                = Request::get('latitude');        
        $longitude               = Request::get('longitude');   

        $q['nama']                    = $nama;
        $q['alamat']                  = $alamat;
        $q['provinsi']                = $provinsi;
        $q['kota']                    = $kota;
        $q['kodepos']                 = $kodepos;
        $q['tlpn']                    = $tlpn;
        $q['no_hp']                   = $no_hp;
        $q['tahun_berdiri']           = $tahun_berdiri;
        $q['no_izin']                 = $no_izin;
        $q['latitude']                = $latitude;
        $q['longitude']               = $longitude;
        $q['nama_ketua']              = $nama_ketua;
        $q['alamat_pengelola']        = $alamat_pengelola;
        $q['kodepos_pengelola']       = $kodepos_pengelola;
        $q['tempat_lahir_pengelola']  = $tempat_lahir_pengelola;
        $q['tanggal_lahir_pengelola'] = $tanggal_lahir_pengelola;
        $q['tlpn_pengelola']          = $tlpn_pengelola;
        $q['email_pengelola']         = $email_pengelola;
        $q['latitude']                = $latitude;
        $q['longitude']               = $longitude;
        $q['updated_at']              = date('Y-m-d H:i:s');

        if (Request::file('image')) {
            if (Request::hasFile('image')){

                // delete image
                $row  = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                $file = str_replace('uploads/','',$row->image);
                if(Storage::exists($file)) {
                    Storage::delete($file);
                }

                $image = Request::file('image');
                $ext   = $image->getClientOriginalExtension();
                //Create Directory Monthly 
                Storage::makeDirectory(date('Y-m'));

                //Move file to storage
                $name = $image->getClientOriginalName();
                $filename = md5(str_random(5));
                $filename .= preg_replace('/\s+/u', '_', $name); 
                if($image->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
                    $v = 'uploads/'.date('Y-m').'/'.$filename;
                } 
                $q['image']   = $v;
            }
        }

        if ($old_password) {
            if ($old_password && $new_password && $conf_password) {
                $tbm   = DB::table('tbm')->where("id",Session::get('ss_tbm_id'))->first();  
                if(\Hash::check($old_password,$tbm->password)) {
                    if ($new_password == $conf_password) {
                        $q['password']   = \Hash::make($new_password);
                    }else{
                        return redirect()->back()->withInput()->with("message",'Kata sandi baru tidak sama dengan Konfirmasi Kata sandi baru');
                    }
                }else{
                    return redirect()->back()->withInput()->with("message",'Kata Sandi Salah');
                }
            }else{
                return redirect()->back()->withInput()->with("message",'Pastikan mengisi semua fill dengan lengkap dan benar');
            }
        }


        $update       = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->update($q);

        // Loop through each file
        // if (Request::hasFile('upload')){
        //         foreach($dokumen as $file) {
                
        //         $ext  = $file->getClientOriginalExtension();

        //         //Create Directory Monthly 
        //         Storage::makeDirectory(date('Y-m'));

        //         //Move file to storage
        //         $name = $file->getClientOriginalName();
        //         $filename = md5(str_random(5));
        //         $filename .= preg_replace('/\s+/u', '_', $name); 
        //         if($file->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
        //             $v = 'uploads/'.date('Y-m').'/'.$filename;
        //         }   

        //         $p['id_tbm'] = Session::get('ss_tbm_id');
        //         $p['upload'] = $v;
        //         $insert      = DB::table('tbm_dokumen')->insert($p);

        //     }
        // }
        

        if (Request::file('image_ktp_pengelola')) {
            if (Request::hasFile('image_ktp_pengelola')){

                // delete image
                $row  = DB::table('tbm_dokumen')->where('id_tbm',Session::get('ss_tbm_id'))->where('desk','KTP Pengelola')->first();
                $file = str_replace('uploads/','',$row->image);
                if(Storage::exists($file)) {
                    Storage::delete($file);
                }

                $image = Request::file('image_ktp_pengelola');
                $ext   = $image->getClientOriginalExtension();
                //Create Directory Monthly 
                Storage::makeDirectory(date('Y-m'));

                //Move file to storage
                $name     = $image->getClientOriginalName();
                $filename = md5(str_random(5));
                $filename .= preg_replace('/\s+/u', '_', $name); 
                if($image->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
                    $v = 'uploads/'.date('Y-m').'/'.$filename;
                } 
                $p['upload']   = $v;

                $check = DB::table('tbm_dokumen')->where('id_tbm',Session::get('ss_tbm_id'))->where('desk','KTP Pengelola')->first();
                if ($check) {
                	$update = DB::table('tbm_dokumen')->where('id_tbm',Session::get('ss_tbm_id'))->where('desk','KTP Pengelola')->update($p);
                }else{
					$p['id_tbm'] = Session::get('ss_tbm_id');
					$p['desk']   = 'KTP Pengelola';
                	DB::table('tbm_dokumen')->insert($p);
                }

            }
        }

        if (Request::file('image_izin_oprasional')) {
            if (Request::hasFile('image_izin_oprasional')){

                // delete image
                $row  = DB::table('tbm_dokumen')->where('id_tbm',Session::get('ss_tbm_id'))->where('desk','Izin Oprasional')->first();
                $file = str_replace('uploads/','',$row->image);
                if(Storage::exists($file)) {
                    Storage::delete($file);
                }

                $image = Request::file('image_izin_oprasional');
                $ext   = $image->getClientOriginalExtension();
                //Create Directory Monthly 
                Storage::makeDirectory(date('Y-m'));

                //Move file to storage
                $name     = $image->getClientOriginalName();
                $filename = md5(str_random(5));
                $filename .= preg_replace('/\s+/u', '_', $name); 
                if($image->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
                    $v = 'uploads/'.date('Y-m').'/'.$filename;
                } 
                $o['upload']   = $v;

                $check = DB::table('tbm_dokumen')->where('id_tbm',Session::get('ss_tbm_id'))->where('desk','Izin Oprasional')->first();
                if ($check) {
                	$update = DB::table('tbm_dokumen')->where('id_tbm',Session::get('ss_tbm_id'))->where('desk','Izin Oprasional')->update($o);
                }else{
					$o['id_tbm'] = Session::get('ss_tbm_id');
					$o['desk']   = 'Izin Oprasional';
                	DB::table('tbm_dokumen')->insert($o);
                }
            }
        }

        return redirect('profile/edit')->with("message",'Update Profile Berhasil');
    }

    function getDeleteTbmDokumen($id='')
    {
        $row  = DB::table('tbm_dokumen')->where('id',$id)->first();
        $file = str_replace('uploads/','',$row->upload);
        if(Storage::exists($file)) {
            Storage::delete($file);
        }
        DB::table('tbm_dokumen')->where('id',$id)->delete();
        return redirect('profile/edit')->with("message",'Dokumen berhasil di hapus');
    }

    function postRegisterDonatur(){
        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }
        
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'email'        => 'required|email', 
                'password'     => 'required' , 
                'confirm_data' => 'required' 
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap Memasukan Email dan Password dengan Benar');
        }
        
        $email        = Request::get('email');                  
        $password     = Request::get('password');             
        $confirm_data = Request::get('confirm_data');  

        $check_email = DB::table('donatur')->where('email',$email)->first();
        if ($check_email) { 
            return redirect()->back()->withInput()->with("message",'Email yang anda gunakan sudah terdaftar');
            
        }
        $p['email']        = $email;
        $p['confirm_data'] = $confirm_data;
        $p['password']     = \Hash::make($password);
        $p['created_at'] = date('Y-m-d H:i:s');

        DB::table('donatur')->insert($p);
        $lastInsertId = DB::getPdo()->lastInsertId();

        $email = show_value($lastInsertId,'donatur','email');
        $html  = "<h2>Kemendikbud - TBM, Aktivasi Akun Donatur</h2>
                <p>Silahkan klik link di bawah ini untuk aktivasi akun anda</p>
                <p><a href='".url('/aktivasi/'.Crypt::encrypt($lastInsertId))."'>".url('/aktivasi/'.Crypt::encrypt($lastInsertId))."</a></p>";
        send_email($email,'Kemendikbud - TBM, Aktivasi Akun Donatur',$html);

        return redirect('login')->with("message",'Registrasi Donatur Berhasil<br>Silahkan cek email anda untuk aktivasi akun');
    }

    function postLupaSandi()
    {
        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }
        
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'email'    => 'required|email', 
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap Memasukan Email dengan Benar');
        }
        
        $email    = Request::get('email');     

        $check_email = DB::table('tbm')->where('email',$email)->first();
        if (!$check_email) { 
            return redirect()->back()->withInput()->with("message",'Email yang anda masukan tidak terdaftar');
            
        }
        $password        = uniqid();
        $p['password']   = \Hash::make($password);
        $p['updated_at'] = date('Y-m-d H:i:s');

        DB::table('tbm')->where('id',$check_email->id)->update($p);

        $email = show_value($check_email->id,'tbm','email');
        $html  = "<h2>Kemendikbud - TBM, Lupa Sandi</h2>
                <p>Silahkan login dengan email dan password di bawah ini :</p>
                <p>Email : ".$email."</p>
                <p>Password : ".$password."</p>";
        send_email($email,'Kemendikbud - TBM, Lupa Sandi',$html);

        return redirect('login')->with("message",'Lupa Sandi Berhasil<br>Silahkan cek email anda');

    }

    function postLupaSandiDon()
    {
        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }
        
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'email'    => 'required|email', 
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap Memasukan Email dengan Benar');
        }
        
        $email    = Request::get('email');     

        $check_email = DB::table('donatur')->where('email',$email)->first();
        if (!$check_email) { 
            return redirect()->back()->withInput()->with("message",'Email yang anda masukan tidak terdaftar');
            
        }
        $password        = uniqid();
        $p['password']   = \Hash::make($password);
        $p['updated_at'] = date('Y-m-d H:i:s');

        DB::table('donatur')->where('id',$check_email->id)->update($p);

        $email = show_value($check_email->id,'donatur','email');
        $html  = "<h2>Kemendikbud - TBM, Lupa Sandi</h2>
                <p>Silahkan login dengan email dan password di bawah ini :</p>
                <p>Email : ".$email."</p>
                <p>Password : ".$password."</p>";
        send_email($email,'Kemendikbud - TBM, Lupa Sandi',$html);

        return redirect('login')->with("message",'Lupa Sandi Berhasil<br>Silahkan cek email anda');

    }

    function postUpdateDonatur()
    {
        if (!Session::get('ss_type_pengguna')) {
            return redirect('/');
        }
        
        $nama          = Request::get('nama'); 
        $instansi      = Request::get('instansi'); 
        $alamat        = Request::get('alamat'); 
        $tlpn          = Request::get('tlpn'); 
        $old_password  = Request::get('old_password'); 
        $new_password  = Request::get('new_password'); 
        $conf_password = Request::get('conf_password');  

        $p['nama']     = $nama;
        $p['instansi'] = $instansi;
        $p['alamat']   = $alamat;
        $p['tlpn']     = $tlpn; 

        if ($old_password) {
            if ($old_password && $new_password && $conf_password) {
                $donatur   = DB::table('donatur')->where("id",Session::get('ss_donatur_id'))->first();  
                if(\Hash::check($old_password,$donatur->password)) {
                    if ($new_password == $conf_password) {
                        $p['password']   = \Hash::make($new_password);
                    }else{
                        return redirect()->back()->withInput()->with("message",'Kata sandi baru tidak sama dengan Konfirmasi Kata sandi baru');
                    }
                }else{
                    return redirect()->back()->withInput()->with("message",'Kata Sandi Salah');
                }
            }else{
                return redirect()->back()->withInput()->with("message",'Pastikan mengisi semua fill dengan lengkap dan benar');
            }
        }
        $update = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->update($p);
        return redirect('/profile/edit')->with("message",'Berhasil Ubah Profil');
    }

    function postSendEmail()
    {
        
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'email'    => 'required|email', 
                'pesan'    => 'required'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect('/')->with("message",'Harap Mengisi Fill Dengan Lengkap Dan Benar');
        }
        $email = get_setting('email-admin');
        $html  = "<h2>Kemendikbud - TBM, Email Baru Dari Website</h2>
                <p style='font-weight:bold;'>Detail Email Dibawah ini :</p>
                <p>Email : ".Request::get('email')."</p>
                <p>Pesan : ".Request::get('pesan')."</p>";
        send_email($email,'Kemendikbud - TBM, Email Baru Dari Website',$html);

        return redirect('/')->with("message",'Email Berhasil Dikirim<br>Terimakasih Telah Menghubungi Kami');
    }

    function getArtikel($slug=''){      

        if ($slug) {
            $id = showValue_byField('slug',$slug,'artikel','id');
            if ($slug == '' || $id == '') {
                return view('errors.404');
            }
            $data['action']      = 'artikel-single';
            $data['body_class']  = array('template-artikel','page-single','body-frame-white');
            $data['title_meta']  = get_setting('title_meta');
            $data['keywords']    = get_setting('keywords');
            $data['description'] = get_setting('description');

            $data['artikel']   = DB::table('artikel')->where('id',$id)->first();

            return view('artikel.single',$data);
        }else{            
            $data['action']      = 'artikel';
            $data['body_class']  = array('template-artikel','page-loop-title-dongker','page-loop','body-frame-white');
            $data['title_meta']  = get_setting('title_meta');
            $data['keywords']    = get_setting('keywords');
            $data['description'] = get_setting('description');

            $data['artikel']     = DB::table('artikel')->orderBy('id','DESC')->paginate(5);

            return view('artikel.loop',$data);
        }
    }

    function getTokoBuku(){
        $data['action']      = 'toko-buku';
        $data['body_class']  = array('template-toko-buku','toko-buku','body-frame-white');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        $data['toko_buku']   = DB::table('toko_buku')->paginate(12);

        return view('toko_buku',$data);        
    }

    function getTbm($slug='',$slug2=''){
        if ($slug) {

            $id_by_email = showValue_byField('email',$slug,'tbm','id');
            if ($id_by_email != '') {
                return redirect(url('tbm/'.Crypt::encrypt($id_by_email)));
            }

            $id_decrypt = Crypt::decrypt($slug);
            $id = $id_decrypt;
            if ($slug == '' || $id == '') {
                return view('errors.404');
            }

            switch ($slug2) {
                case 'pengelola':
                        $data['action']      = 'pengelola';
                        $data['slug']        = $slug2;
                        $data['id_tbm']      = $id;
                        $data['body_class']  = array('pengelola','profile');
                        $data['title_meta']  = get_setting('title_meta');
                        $data['keywords']    = get_setting('keywords');
                        $data['description'] = get_setting('description');

                        $data['tbm']     = DB::table('tbm')->where('id',$id)->first();
                        
                        return view('profile.profile_tbm',$data);
                    break;

                case 'kegiatan':
                        $data['action']      = 'kegiatan';
                        $data['slug']        = $slug2;
                        $data['id_tbm']      = $id;
                        $data['body_class']  = array('kegiatan','profile');
                        $data['title_meta']  = get_setting('title_meta');
                        $data['keywords']    = get_setting('keywords');
                        $data['description'] = get_setting('description');

                        $data['tbm']          = DB::table('tbm')->where('id',$id)->first();
                        $data['kegiatan'] = DB::table('kegiatan_tbm')->where('id_tbm',$id)->orderBy('id','DESC')->paginate(5);
                        
                        return view('profile.profile_tbm',$data);
                    break;

                case 'kebutuhan':
                        $data['action']      = 'kebutuhan';
                        $data['slug']        = $slug2;
                        $data['id_tbm']      = $id;
                        $data['body_class']  = array('kebutuhan','profile');
                        $data['title_meta']  = get_setting('title_meta');
                        $data['keywords']    = get_setting('keywords');
                        $data['description'] = get_setting('description');
                        
                        $data['tbm']         = DB::table('tbm')->where('id',$id)->first();
                        $data['kebutuhan']   = DB::table('req_buku')->where('id_tbm',$id)->orderBy('id','DESC')->paginate(5);
                        
                        return view('profile.profile_tbm',$data);
                    break;
                
                case '':
                    $data['action']      = 'profile';
                    $data['slug']        = $slug2;
                    $data['id_tbm']      = $id;
                    $data['body_class']  = array('profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');
                    
                    $data['tbm']         = DB::table('tbm')->where('id',$id)->first();
                    $data['dokumen']     = DB::table('tbm_dokumen')->where('id_tbm',$id)->orderBy('id','DESC')->get();

                    return view('profile.profile_tbm',$data);
                    break;
                default :
                    return view('errors.404');
                    break;
            }

        }else{
            $data['action']      = 'daftar-tbm';
            $data['body_class']  = array('template-daftar-tbm','daftar-tbm','page-loop','body-frame-white');
            $data['title_meta']  = get_setting('title_meta');
            $data['keywords']    = get_setting('keywords');
            $data['description'] = get_setting('description');

            if (Request::get('provinsi')) {
                $data['dataLokasi']   = DB::table('tbm')
                                        ->join('kabupaten', 'tbm.kota', '=', 'kabupaten.id')
                                        ->where('tbm.provinsi',Request::get('provinsi'))
                                        ->select('kabupaten.id','kabupaten.kabupaten as value')
                                        ->where('setujui',1)
                                        ->groupBy('tbm.kota')
                                        ->orderby('kabupaten.kabupaten','ASC')
                                        ->get();
            }else{
                $data['dataLokasi']   = DB::table('tbm')
                                        ->join('propinsi', 'tbm.provinsi', '=', 'propinsi.id')
                                        ->select('propinsi.id','propinsi.propinsi as value')
                                        ->groupBy('tbm.provinsi')
                                        ->orderby('propinsi.propinsi','ASC')
                                        ->where('setujui',1)
                                        ->get();
            }

            $data['tbm']   = DB::table('tbm')->where('setujui',1)
                            ->where('provinsi',Request::get('provinsi'))
                            ->where('kota',Request::get('kota'))
                            ->orderBy('id','DESC')->paginate(12);

            if (Request::get('kota')) {
                return view('daftar_tbm',$data); 
            }else{
                return view('daftar_tbm_filter',$data); 
            }
        }     
    }


    function getPage($slug=''){
        $id = showValue_byField('slug',$slug,'cms_pages','id');
        if ($slug=='' || $id == '') {            
            return view('errors.404');
        }
        $data['action']      = 'page';
        $data['body_class']  = array('template-artikel','page-single','body-frame-white');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        $data['page']   = DB::table('cms_pages')->where('id',$id)->first();

        return view('page',$data);        
    }


    function getPendonatur(){

        $data['action']      = 'pendonatur';
        $data['body_class']  = array('template-pendonatur','page-loop','body-frame-white');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        $data['donatur']   = DB::table('donatur')->orderBy('id','DESC')->paginate(10);

        return view('daftar_donatur',$data);      
    }

    function getDaftarBuku($slug=''){

        $data['action']      = 'daftar-buku';
        $data['body_class']  = array('template-daftar-buku','page-loop','body-frame-white');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        if ($slug) {
            $data['kebutuhan']   = DB::table('req_buku')->where('judul','LIKE','%'.$slug.'%')->orderBy('id','DESC')->paginate(10);
        }else{
            $data['kebutuhan']   = DB::table('req_buku')->orderBy('id','DESC')->paginate(10);
        }

        return view('daftar_buku',$data);    

    }

    function postSearch(){
        return redirect('daftar-buku/'.Request::get('s'));
    }

    function getBukuFavorite(){

        $data['action']      = 'buku-favorite';
        $data['body_class']  = array('template-buku-favorite','page-loop','body-frame-white');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        $data['buku_favorite']   = DB::table('buku_favorite')->orderBy('id','DESC')->paginate(10);

        return view('buku_favorite',$data);    

    }

    function getAddDonasi($id_buku=''){
        if ($id_buku == '') {
            return view('errors.404');
        }
        if (!Session::get('ss_donatur_id')) {
            return redirect('daftar-buku')->with("message",'Anda harus login terlebih dahulu, Sebagai Donatur');
        }


        $donatur  = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
        $req_buku = DB::table('req_buku')->where('id',$id_buku)->first();

        if (!Session::get('ss_id_donasi')) {
            $no_donasi       = no_donasi();  

            $p['no_donasi']  = $no_donasi;  
            $p['status']     = 'Donasi Belum Lengkap';       
            $p['id_donatur'] = Session::get('ss_donatur_id');       
            $p['tgl_donasi'] = date('Y-m-d H:i:s');
            DB::table('donasi')->insert($p);
            $lastInsertId    = DB::getPdo()->lastInsertId();

            Session::put('ss_no_donasi', $no_donasi);
            Session::put('ss_id_donasi', $lastInsertId);
        }

        $check_item = DB::table('donasi_item')->where('id_donasi',Session::get('ss_id_donasi'))->where('id_req_buku',$id_buku)->first();
        if ($check_item) {            
            $q['qty']         = $check_item->qty+1;
            DB::table('donasi_item')->where('id',$check_item->id)->update($q);
        }else{
            $q['id_donasi']   = Session::get('ss_id_donasi');
            $q['id_tbm']      = $req_buku->id_tbm;
            $q['id_req_buku'] = $req_buku->id;
            $q['judul']        = $req_buku->judul;
            $q['kategori']    = show_value($req_buku->id_kategori_buku,'kategori_buku','nama');
            $q['penerbit']    = $req_buku->penerbit;
            $q['toko_buku']   = $req_buku->toko_buku;
            $q['pengarang']   = $req_buku->pengarang;
            $q['harga']       = $req_buku->harga;
            $q['qty']         = 1;
            DB::table('donasi_item')->insert($q);
        }
        
        return redirect('keranjang');

    }

    function getKeranjang(){

        if (Request::segment(2)) {
            $donasi = DB::table('donasi')->where('no_donasi',Request::segment(2))->first();
            Session::forget('ss_id_donasi');
            Session::forget('ss_no_donasi');            
            Session::put('ss_no_donasi', $donasi->no_donasi);
            Session::put('ss_id_donasi', $donasi->id);
        }

        $data['action']      = 'keranjang';
        $data['body_class']  = array('template-keranjang','template-daftar-buku','page-loop','page-loop-title-dongker','body-frame-white');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        $data['donasi']      = DB::table('donasi')->where('id',Session::get('ss_id_donasi'))->first();
        $data['donasi_item'] = DB::table('donasi_item')->where('id_donasi',Session::get('ss_id_donasi'))->orderBy('id','DESC')->get();

        return view('keranjang',$data); 

    }

    function postUpdateDonasiItem(){
        $id  = Request::get('id');
        $qty = Request::get('qty');

        foreach ($id as $key => $id) {
            $id = $id;
            $p['qty'] = $qty[$key];
            DB::table('donasi_item')->where('id',$id)->update($p);
        }
        return redirect('keranjang');
    }

    function getCheckout(){

        $data['action']      = 'checkout';
        $data['body_class']  = array('template-checkout','page-loop','page-loop-title-dongker','body-frame-white');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        $data['donasi']      = DB::table('donasi')->where('id',Session::get('ss_id_donasi'))->first();
        $data['donasi_item'] = DB::table('donasi_item')->where('id_donasi',Session::get('ss_id_donasi'))->orderBy('id','DESC')->get();
        $data['donatur']     = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
        $data['bank']        = DB::table('bank')->orderBy('id','DESC')->get();

        return view('checkout',$data); 

    }

    function postCheckout(){   
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'nama'    => 'required',
                'tlpn'    => 'required',
                'email'   => 'required|email',
                'id_bank' => 'required'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap mengisi fill dengan lengkap dan benar');
        }

        $q['status']  = 'Donasi Baru';
        $q['nama']    = Request::get('nama');
        $q['email']   = Request::get('email');
        $q['tlpn']    = Request::get('tlpn');
        // $q['id_bank'] = Request::get('id_bank');

        $bank = DB::table('bank')->where('id',Request::get('id_bank'))->first();
        $q['bank'] = $bank->bank.', No Rekening : '.$bank->norek.', An : '.$bank->an.', Cabang : '.$bank->cabang;


        DB::table('donasi')->where('id',Session::get('ss_id_donasi'))->update($q);

        // send email
        $donasi      = DB::table('donasi')->where('id',Session::get('ss_id_donasi'))->first();
        $donasi_item = DB::table('donasi_item')->where('id_donasi',Session::get('ss_id_donasi'))->get();

        $donasi_item_html ='';
        foreach ($donasi_item as $item) {
            $donasi_item_html .= '
                            <tr>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.show_value($item->id_tbm,'tbm','nama').'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.$item->judul.'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.number_format($item->qty).'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.number_format($item->harga).'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.number_format($item->qty*$item->harga).'</td>
                            </tr>
                            ';
        }

        // email ke forum
        $html  = '<h2>Kemendikbud - TBM, Donasi Baru '.$donasi->no_donasi.'</h2>
                <h4>Ada Donasi baru, Detail donasi sebagai berikut :</h4>
                <p>No Donasi : '.$donasi->no_donasi.'</p>
                <p>Total Donasi : '.number_format(total($donasi->id)).'</p>
                <p>Nama : '.$donasi->nama.'</p>
                <p>Telepon : '.$donasi->tlpn.'</p>
                <p>Email : '.$donasi->email.'</p>
                <p>Bank yang Dituju : '.$donasi->bank.'</p>
                <p>Tanggal : '.$donasi->tgl_donasi.'</p>
                <h4>Donasi Item</h4>
                <table cellspacing="0" cellpadding="6" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4" border="1">
                    <thead>
                    <tr>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">TBM</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Buku</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">QTY</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Harga</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    '.$donasi_item_html.'
                    </tbody>
                </table>
                <p>Untuk lebih lengkapnya dapat di lihat pada <a href="'.url('/admin/donasi/sub-module/'.$donasi->id.'/donasi_item').'">Panel Admin</a></p>';
        send_email(get_setting('email_forum'),'Kemendikbud - TBM, Donasi Baru'.$donasi->no_donasi,$html);

        // email ke donatur
        $html  = '<h2>Kemendikbud - TBM, Donasi '.$donasi->no_donasi.'</h2>
                <h4>Terimakasih telah melakukan donasi, Detail donasi sebagai berikut :</h4>
                <p>No Donasi : '.$donasi->no_donasi.'</p>
                <p>Total Donasi : '.number_format(total($donasi->id)).'</p>
                <p>Nama : '.$donasi->nama.'</p>
                <p>Telepon : '.$donasi->tlpn.'</p>
                <p>Email : '.$donasi->email.'</p>
                <p>Tanggal : '.$donasi->tgl_donasi.'</p>
                <h4>Donasi Item</h4>
                <table cellspacing="0" cellpadding="6" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4" border="1">
                    <thead>
                    <tr>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">TBM</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Buku</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">QTY</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Harga</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    '.$donasi_item_html.'
                    </tbody>
                </table>

                <h4>Segera lakukan transfer pada bank yang dituju</h4>
                <p>'.$donasi->bank.'</p>
                <p>Bila Sudah Transfer silahkan untuk melakukan konfirmasi pembayaran, untuk konfirmasi pembayaran silahkan <a href="'.url('/profile/konfirmasi-pembayaran/'.$donasi->id).'">klik disni</a></p>';            
        send_email($donasi->email,'Kemendikbud - TBM, Donasi '.$donasi->no_donasi,$html);
        // /send email

        Session::forget('ss_id_donasi');
        Session::forget('ss_no_donasi');


        return redirect('thank');
    }

    function getThank(){

        $data['action']      = 'thank';
        $data['body_class']  = array('template-thank','body-frame-white');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        return view('thank',$data); 

    }

    function getDonasiDetail($no_donasi=""){
        if ($no_donasi == '') {
            return view('errors.404');
        }
        if (!Session::get('ss_donatur_id')) {
            return view('errors.404');
        }
        $donasi = DB::table('donasi')->where('id_donatur',Session::get('ss_donatur_id'))->where('no_donasi',$no_donasi)->first();
        if (!$donasi) {
            return view('errors.404');
        }

        $data['action']      = 'detail-donasi';
        $data['body_class']  = array('template-checkout','page-loop','page-loop-title-dongker','body-frame-white');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');

        $data['donasi']      = DB::table('donasi')->where('id',$donasi->id)->first();
        $data['donasi_item'] = DB::table('donasi_item')->where('id_donasi',$donasi->id)->orderBy('id','DESC')->get();
        $data['donatur']     = DB::table('donatur')->where('id',$donasi->id_donatur)->first();
        $data['bank']        = DB::table('bank')->where('id',$donasi->id_bank)->orderBy('id','DESC')->first();

        return view('detail_donasi',$data);

    }

    function getDeleteDonasiItem($id){
        DB::table('donasi_item')->where('id',$id)->delete();
        return redirect('keranjang');
    }

    function postAddKegiatan(){
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'title'    => 'required', 
                'image'    => 'required'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap mengisi fill dengan lengkap dan benar');
        }
        $q['id_tbm']   = Session::get('ss_tbm_id');
        $q['title']    = Request::get('title');
        $q['datetime'] = date('Y-m-d H:i:s');

        if (Request::hasFile('image')){
            $image = Request::file('image');
            $ext   = $image->getClientOriginalExtension();
            //Create Directory Monthly 
            Storage::makeDirectory(date('Y-m'));

            //Move file to storage
            $name = $image->getClientOriginalName();
            $filename = md5(str_random(5));
            $filename .= preg_replace('/\s+/u', '_', $name); 
            if($image->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
                $v = 'uploads/'.date('Y-m').'/'.$filename;
            } 
            $q['image']   = $v;
        }


        $insert       = DB::table('kegiatan_tbm')->insert($q);
        return redirect('profile/kegiatan')->with("message",'Kegiatan Berhasil Disimpan');

    }

    function postUbahKegiatan(){
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'title'    => 'required'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap mengisi fill dengan lengkap dan benar');
        }
        $q['title']    = Request::get('title');

        if (Request::hasFile('image')){

            // delete image
            $row  = DB::table('kegiatan_tbm')->where('id',Request::get('id'))->first();
            $file = str_replace('uploads/','',$row->image);
            if(Storage::exists($file)) {
                Storage::delete($file);
            }

            $image = Request::file('image');
            $ext   = $image->getClientOriginalExtension();
            //Create Directory Monthly 
            Storage::makeDirectory(date('Y-m'));

            //Move file to storage
            $name = $image->getClientOriginalName();
            $filename = md5(str_random(5));
            $filename .= preg_replace('/\s+/u', '_', $name); 
            if($image->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
                $v = 'uploads/'.date('Y-m').'/'.$filename;
            } 
            $q['image']   = $v;
        }


        DB::table('kegiatan_tbm')->where('id',Request::get('id'))->update($q);
        return redirect('profile/ubah-kegiatan/'.Request::get('id'))->with("message",'Kegiatan Berhasil Diubah');

    }

    function postAddKebutuhan(){

        $id_tbm           = Session::get('ss_tbm_id');
        $id_kategori_buku = Request::get('id_kategori_buku');
        $judul            = Request::get('judul');
        if ($id_kategori_buku && !$judul) {
            return redirect('profile/kebutuhan-kategori/'.$id_kategori_buku);
        }

        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'judul'            => 'required', 
                'id_kategori_buku' => 'required', 
                'penerbit'         => 'required', 
                'toko_buku'        => 'required', 
                'pengarang'        => 'required', 
                'harga'            => 'required|numeric'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap mengisi fill dengan lengkap dan benar');
        }
        $q['id_tbm']           = Session::get('ss_tbm_id');
        $q['id_kategori_buku'] = Request::get('id_kategori_buku');
        $q['judul']            = Request::get('judul');
        $q['penerbit']         = Request::get('penerbit');
        $q['toko_buku']        = Request::get('toko_buku');
        $q['pengarang']        = Request::get('pengarang');
        $q['harga']            = Request::get('harga');
        $q['created_at']       = date('Y-m-d H:i:s');


        $insert       = DB::table('req_buku')->insert($q);
        return redirect('profile/kebutuhan')->with("message",'Permintaan Buku Berhasil Disimpan');

    }

    function postAddKebutuhanKtg(){


        $q['id_tbm']           = Session::get('ss_tbm_id');
        $q['id_kategori_buku'] = Request::get('id_kategori_buku');
        $q['created_at']       = date('Y-m-d H:i:s');


        $insert       = DB::table('req_buku')->insert($q);
        return redirect('profile/kebutuhan')->with("message",'Permintaan Buku Berhasil Disimpan');

    }

    function postUbahKebutuhan(){
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'judul'            => 'required', 
                'id_kategori_buku' => 'required', 
                'penerbit'         => 'required', 
                'toko_buku'        => 'required', 
                'pengarang'        => 'required', 
                'harga'            => 'required|numeric'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap mengisi fill dengan lengkap dan benar');
        }
        $q['id_kategori_buku'] = Request::get('id_kategori_buku');
        $q['judul']            = Request::get('judul');
        $q['penerbit']         = Request::get('penerbit');
        $q['toko_buku']        = Request::get('toko_buku');
        $q['pengarang']        = Request::get('pengarang');
        $q['harga']            = Request::get('harga');


        DB::table('req_buku')->where('id',Request::get('id'))->update($q);
        return redirect('profile/ubah-kebutuhan/'.Request::get('id'))->with("message",'Permintaan Buku Berhasil Diubah');

    }

    function getDeleteKebutuhan($id){
        $check = DB::table('req_buku')->where('id_tbm',Session::get('ss_tbm_id'))->where('id',$id)->first();
        if (!$check) {
            return view('errors.404');
        }
        DB::table('req_buku')->where('id',$id)->delete();
        return redirect('profile/kebutuhan')->with("message",'Permintaan Buku Berhasil Dihapus');
    }

    function getDeleteKegiatan($id){
        $check = DB::table('kegiatan_tbm')->where('id_tbm',Session::get('ss_tbm_id'))->where('id',$id)->first();
        if (!$check) {
            return view('errors.404');
        }

        // delete image
        $row  = DB::table('kegiatan_tbm')->where('id',$id)->first();
        $file = str_replace('uploads/','',$row->image);
        if(Storage::exists($file)) {
            Storage::delete($file);
        }

        DB::table('kegiatan_tbm')->where('id',$id)->delete();
        return redirect('profile/kegiatan')->with("message",'Kegiatan Berhasil Dihapus');
    }

    function postAddKonfimasiPembayaran(){
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'bank'    => 'required', 
                'an'      => 'required', 
                'norek'   => 'required'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap mengisi fill dengan lengkap dan benar');
        }

        $donasi = DB::table('donasi')->where('id',Request::get('id'))->first();

        $q['id_donasi'] = Request::get('id');
        $q['ke_bank']   = $donasi->bank;
        $q['bank']      = Request::get('bank');
        $q['an']        = Request::get('an');
        $q['norek']     = Request::get('norek');
        $q['nominal']   = total($donasi->id);
        $q['datetime']  = date('Y-m-d H:i:s');


        $insert       = DB::table('konfirmasi_donasi')->insert($q);
        return redirect('profile/riwayat-donasi')->with("message",'Donasi Berhasil Di konfirmasi Pembayaran');

    }

    function getTest(){   
        echo get_setting('email-admin');die();
        $donasi      = DB::table('donasi')->where('id',10)->first();
        $donasi_item = DB::table('donasi_item')->where('id_donasi',10)->get();

        $donasi_item_html ='';
        foreach ($donasi_item as $item) {
            $donasi_item_html .= '
                            <tr>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.show_value($item->id_tbm,'tbm','nama').'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.$item->judul.'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.number_format($item->qty).'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.number_format($item->harga).'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.number_format($item->qty*$item->harga).'</td>
                            </tr>
                            ';
        }

        // email ke forum
        $html  = '<h2>Kemendikbud - TBM, Donasi Baru '.$donasi->no_donasi.'</h2>
                <h4>Ada Donasi baru, Detail donasi sebagai berikut :</h4>
                <p>No Donasi : '.$donasi->no_donasi.'</p>
                <p>Total Donasi : '.number_format(total($donasi->id)).'</p>
                <p>Nama : '.$donasi->nama.'</p>
                <p>Telepon : '.$donasi->tlpn.'</p>
                <p>Email : '.$donasi->email.'</p>
                <p>Bank yang Dituju : '.$donasi->bank.'</p>
                <p>Tanggal : '.$donasi->tgl_donasi.'</p>
                <h4>Donasi Item</h4>
                <table cellspacing="0" cellpadding="6" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4" border="1">
                    <thead>
                    <tr>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">TBM</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Buku</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">QTY</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Harga</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    '.$donasi_item_html.'
                    </tbody>
                </table>
                <p>Untuk lebih lengkapnya dapat di lihat pada <a href="'.url('/admin/donasi/sub-module/'.$donasi->id.'/donasi_item').'">Panel Admin</a></p>';
        send_email('riki@crocodic.com','Kemendikbud - TBM, Donasi Baru'.$donasi->no_donasi,$html);

        // email ke donatur
        $html  = '<h2>Kemendikbud - TBM, Donasi '.$donasi->no_donasi.'</h2>
                <h4>Terimakasih telah melakukan donasi, Detail donasi sebagai berikut :</h4>
                <p>No Donasi : '.$donasi->no_donasi.'</p>
                <p>Total Donasi : '.number_format(total($donasi->id)).'</p>
                <p>Nama : '.$donasi->nama.'</p>
                <p>Telepon : '.$donasi->tlpn.'</p>
                <p>Email : '.$donasi->email.'</p>
                <p>Tanggal : '.$donasi->tgl_donasi.'</p>
                <h4>Donasi Item</h4>
                <table cellspacing="0" cellpadding="6" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4" border="1">
                    <thead>
                    <tr>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">TBM</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Buku</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">QTY</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Harga</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    '.$donasi_item_html.'
                    </tbody>
                </table>

                <h4>Segera lakukan transfer pada bank yang dituju</h4>
                <p>'.$donasi->bank.'</p>
                <p>Bila Sudah Transfer silahkan untuk melakukan konfirmasi pembayaran, untuk konfirmasi pembayaran silahkan <a href="'.url('/profile/konfirmasi-pembayaran/'.$donasi->id).'">klik disni</a></p>';            
        send_email($donasi->email,'Kemendikbud - TBM, Donasi '.$donasi->no_donasi,$html);

    }

    function postTest(){
        // Validation
        $validator = Validator::make(Request::all(),           
            [
                'test'                    => 'required',
                'test2'                    => 'required'
            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect('test')->withInput();
        }
    }

    function getAjakKota(){
        $id_prov = Request::get('id_prov');
        $result  = '<option value="">Pilih Kab / Kota</option>';
        $kota    = DB::table('kabupaten')->where('id_propinsi',$id_prov)->orderBy('kabupaten','ASC')->get();
        foreach ($kota as $item) {
            $result .= '<option value="'.$item->id.'">'.$item->kabupaten.'</option>';
        }
        echo $result;
    }

    function getbak(){
        exec('mysqldump --host=localhost --user=root --password=CR0C0DICkemendlkbud tbm3 > /var/www/html/tbm/bakdb/tbm3-'.date('Y-m-d').'.sql');
        exec('mysqldump --host=localhost --user=root --password=CR0C0DICkemendlkbud tbm3 > /var/www/bakdb/tbm3-'.date('Y-m-d').'.sql');
        echo '1';
    }
}
