<?php 
namespace App\Http\Controllers;

use App;
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
    function getTest(){
        $tbm = DB::table('tbm')->where('setujui',1)->get();
        foreach ($tbm as $q) {
            $insert[] = array(
                'id_tbm' => $q->id,
                'id_kategori_buku' => 99,
            );
        }
        DB::table('tbm_req')->insert($insert);
    }
    function getTestj(){
        $url = url('notelp.json');
        $data = json_decode(file_get_contents("notelp.json"),true);

        dd($data['list_number']);
    }
    function getIndex(){

        // return redirect('login');
        $data['active']          = 'home';
        $data['action']          = 'home';
        $data['page_title']      = 'Donasi Buku Daring - Kemdikbud Republik Indonesia';
        $data['body_class']      = array('home');
        $data['title_meta']      = get_setting('title_meta');
        $data['keywords']        = get_setting('keywords');
        $data['description']     = get_setting('description');
        $data['how_it_work']     = DB::table('how_it_work')->orderby('id','desc')->take(4)->get();
        $data['how_it_work_2']     = DB::table('how_it_work')->orderby('id','desc')->skip(4)->take(3)->get();
        $data['slider']          = DB::table('slider')->orderBy('id','DESC')->get();
        $data['artikel_big']     = DB::table('artikel')->orderBy('id','DESC')->first();
        $data['artikel_terkini'] = DB::table('artikel')->orderBy('id','DESC')->paginate(6);
        $data['artikel']         = DB::table('artikel')->orderBy('id','DESC')->paginate(11);
        $data['buku_favorite']   = DB::table('buku_favorite')->orderBy('id','DESC')->paginate(8);

        return view('indexs',$data);

    }

    // {{   NEW PAGE    }}


    function getIndexs(){

        // return redirect('login');
        $data['active']          = 'home';
        $data['action']          = 'home';
        $data['page_title']      = 'Donasi Buku Daring - Kemdikbud Republik Indonesia';
        $data['body_class']      = array('home');
        $data['title_meta']      = get_setting('title_meta');
        $data['keywords']        = get_setting('keywords');
        $data['description']     = get_setting('description');
        $data['how_it_work']     = DB::table('how_it_work')->orderby('id','desc')->take(4)->get();
        $data['how_it_work_2']     = DB::table('how_it_work')->orderby('id','desc')->skip(4)->take(3)->get();
        $data['slider']          = DB::table('slider')->orderBy('id','DESC')->get();
        $data['artikel_big']     = DB::table('artikel')->orderBy('id','DESC')->first();
        $data['artikel_terkini'] = DB::table('artikel')->orderBy('id','DESC')->paginate(3);
        $data['artikel']         = DB::table('artikel')->orderBy('id','DESC')->paginate(11);
        $data['buku_favorite']   = DB::table('buku_favorite')->orderBy('id','DESC')->paginate(8);

        return view('indexs',$data);

    }
 
    function getTentang(){

        $data['page_title']      = 'Donasi Buku Daring - Kemdikbud Republik Indonesia';

        $data['title_meta']      = get_setting('title_meta');
        $data['keywords']        = get_setting('keywords');
        $data['description']     = get_setting('description');

        return view('tentang_kami', $data);
    }

    function getTentangtbm(){

        $data['page_title']      = 'Donasi Buku Daring - Kemdikbud Republik Indonesia';

        $data['title_meta']      = get_setting('title_meta');
        $data['keywords']        = get_setting('keywords');
        $data['description']     = get_setting('description');

        return view('tentang_tbm', $data);
    }
    function getDonatur(){

        $data['page_title']      = 'Donasi Buku Daring - Kemdikbud Republik Indonesia';

        $data['title_meta']      = get_setting('title_meta');
        $data['keywords']        = get_setting('keywords');
        $data['description']     = get_setting('description');
        return view('donatur', $data);  
    }
    function getFli2020(){
        $data['page_title']      = 'Donasi Buku Daring - Kemdikbud Republik Indonesia';

        $data['title_meta']      = get_setting('title_meta');
        $data['keywords']        = get_setting('keywords');
        $data['description']     = get_setting('description');

        return view('fli2020.page', $data);
    }

    // {{   NEW PAGE    }}




    function getUnduh(){
    	$data['active']          = 'home';
        $data['action']          = 'home';
        $data['page_title']      = 'Donasi Buku Daring - Kemdikbud Republik Indonesia';
        $data['body_class']      = array('home');
        $data['title_meta']      = get_setting('title_meta');
        $data['keywords']        = get_setting('keywords');
        $data['description']     = get_setting('description');
        $data['download']		 = DB::table('download')->orderby('nama_file','asc')->paginate(5);

        return view('download',$data);
    }
    function getArtikel($slug=''){  
        $data['active']          = 'article';    
        $data['page_title']      = 'Donasi Buku Daring - Kemdikbud Republik Indonesia';
        if ($slug) {
            $id = showValue_byField('slug',$slug,'artikel','id');
            if ($slug == '' || $id == '') {

                return view('errors.404');
            }
            $data['kategori']    = DB::table('kategori_artikel')->where('id_artikel',$id)->get();
            $data['action']      = 'artikel-single';
            $data['body_class']  = array('template-artikel','page-single','body-frame-white');
            $data['title_meta']  = get_setting('title_meta');
            $data['keywords']    = get_setting('keywords');
            $data['description'] = get_setting('description');
            $get_id              = DB::table('artikel')->where('slug',$slug)->first();
            $data['next']        = DB::table('artikel')->where('id','>',$get_id->id)->orderby('id','asc')->first();
            $data['prev']        = DB::table('artikel')->where('id','<',$get_id->id)->orderby('id','desc')->first();

            $data['artikel']   = DB::table('artikel')->where('id',$id)->first();

            return view('article.single',$data);
        }else{            
            $data['action']      = 'artikel';
            $data['body_class']  = array('template-artikel','page-loop-title-dongker','page-loop','body-frame-white');
            $data['title_meta']  = get_setting('title_meta');
            $data['keywords']    = get_setting('keywords');
            $data['description'] = get_setting('description');
            if(!empty(Request::get('kategori'))){
                $data['artikel'] = DB::table('artikel')->orderBy('id','DESC')
                                    ->join('kategori_artikel', 'artikel.id', '=', 'kategori_artikel.id_artikel')
                                    ->select('artikel.*','kategori_artikel.id_master_kategori as kategori')
                                    ->where('kategori_artikel.id_master_kategori',Request::get('kategori'))->paginate(5); 
            }else{
                $artikel     = DB::table('artikel')->orderBy('id','DESC');
                if (Request::get('q')) {
                    $artikel->where("title","like","%".Request::get("q")."%");
                    $artikel->orwhere("content","like","%".Request::get("q")."%");
                }
                $data['artikel'] = $artikel->paginate(5);
            }

            return view('article.loop',$data);
        }
    }
    function getTbm($slug='',$slug2=''){
        $data['active']          = 'tbm';
        $data['page_title']      = 'Donasi Buku Daring - Kemdikbud Republik Indonesia';
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
                        $data['kategori_buku']    = DB::table('kategori_buku')->orderby('nama','asc')->get();
                        $data['kebutuhan']   = DB::table('tbm_req')
                                            ->where('id_tbm',$id)
                                            ->orderBy('id_kategori_buku','asc')
                                            ->join('kategori_buku', 'tbm_req.id_kategori_buku', '=', 'kategori_buku.id')
                                            ->select('tbm_req.*','kategori_buku.nama as nama_kategori')
                                            ->paginate(5);
                        
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

            if (!empty(Request::get('q')) && empty(Request::get('provinsi'))) {
            	$tbm   = DB::table('tbm')->where('setujui',1)
					            ->orderBy('id','DESC')
					            ->where(function ($query) {
							    $query->orwhere('nama','like','%'.Request::get('q').'%')
							             ->orwhere('alamat','like','%'.Request::get('q').'%');
							    });
				if (!empty(Request::get('type'))) {
	            	$tbm = $tbm->where('id_master_tbm',Request::get('type'));
	            }
				$data['tbm'] = $tbm->paginate(12);
				return view('daftar_tbm',$data);
            }else{
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

				$tbm   = DB::table('tbm')->where('setujui',1)
				            ->where('provinsi',Request::get('provinsi'))
				            ->where('kota',Request::get('kota'))
				            ->where(function ($query) {
							    $query->orwhere('nama','like','%'.Request::get('q').'%')
							       ->orwhere('alamat','like','%'.Request::get('q').'%');
							    })->orderBy('id','DESC');
				            if (!empty(Request::get('type'))) {
				            	$tbm = $tbm->where('id_master_tbm',Request::get('type'));
				            }
				$data['tbm'] = $tbm->paginate(8);
            	if (Request::get('kota')) {
	                $kota = DB::table('kabupaten')->where('id',Request::get('kota'))->first();
	                $data['kota'] = $kota->kabupaten;
	                return view('daftar_tbm',$data); 
	            }else{
	                return view('daftar_tbm_filter',$data); 
	            }
            }
        }     
    }
    function getDetailKebutuhan($id){
        $result = DB::table('kegiatan_tbm')->where('id',$id)->first();

        $res = response()->json($result);
        $res->send();
    }
    function getDeleteKegiatan($id){
        DB::table('kegiatan_tbm')->where('id',$id)->delete();
        return redirect()->back()->with("message",'Berhasil menghapus kegiatan');
    }
    function getPage($slug=''){
        if ($slug == 'tentang-donasi-buku-kemdikbud') {
            $data['active']          = 'tentang';
            $data['page_title']      = 'Tentang Kita | TBM';
        }else{
            $data['active']          = 'donatur';
            $data['page_title']      = 'Donatur | TBM';
            

        }
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
    function postSendEmail(){
        
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

        return redirect('/')->with("message",'Email Berhasil Dikirim, Terimakasih Telah Menghubungi Kami');
    }
    function getLogin($slug=''){
        $data['page_title'] = 'Login | TBM';
        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }

        if($slug == 'donatur'){

            $data['action']      = 'login';
            $data['master_tbm'] = DB::table('master_tbm')->orderby('name','asc')->get();
            $data['master_spm'] = DB::table('master_spm')->orderby('id','asc')->get();
            $data['master_spnf'] = DB::table('master_spnf')->orderby('id','asc')->get();
            $data['body_class']  = array('login');
            $data['title_meta']  = get_setting('title_meta');
            $data['keywords']    = get_setting('keywords');
            $data['description'] = get_setting('description');

            return view('login/donatur',$data);
        }
        if($slug == 'tbm'){

            $data['action']      = 'login';
            $data['master_tbm'] = DB::table('master_tbm')->orderby('name','asc')->get();
            $data['master_spm'] = DB::table('master_spm')->orderby('id','asc')->get();
            $data['master_spnf'] = DB::table('master_spnf')->orderby('id','asc')->get();
            $data['body_class']  = array('login');
            $data['title_meta']  = get_setting('title_meta');
            $data['keywords']    = get_setting('keywords');
            $data['description'] = get_setting('description');

            return view('login/tbm',$data);
        } 

        return redirect('/');

    }

    function getSpnf(){
    	$data = DB::table('master_spnf')->where('id_master_spm',Request::get('id_master_spm'))->orderby('id','asc')->get();
    	if (count($data) > 0) {
    		$result = DB::table('master_spnf')->where('id_master_spm',Request::get('id_master_spm'))->orderby('id','asc')->get();
    	}else{
    		$response['api_message'] = 0;
    		$result = $response;
    	}
    	$res = response()->json($result);
        $res->send();
    }
    function postLupaSandi(){
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

        return redirect()->back()->with("message",'Lupa Sandi Berhasil, Silahkan cek email anda');

    }

    function postLupaSandiDon(){
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

        return redirect('login')->with("message",'Lupa Sandi Berhasil, Silahkan cek email anda');

    }
    function getAktivasi($id_encrypt=''){
        $id = Crypt::decrypt($id_encrypt);        

        if (Request::get('type') == 'tbm') {
            $check_tbm = show_value($id,'tbm','id');
            if ($check_tbm) {
                $update['setujui']    = 1;
                $update['confirm_by'] = 'Email';
                $update['confirm_at'] = date('Y-m-d H:i:s');
                DB::table('tbm')->where('id',$id)->update($update);
                return redirect('login')->with("message",'Akun telah berhasil di aktivasi, Silahkan Login dengan Email dan Password yang sudah Didaftarkan');
            }else{
                return redirect('login')->with("message",'Terdapat kesalahan silahkan hubungi kontak kami'); 
            }
        }else{
            $check_donatur = show_value($id,'donatur','id');
            if ($check_donatur) {
                DB::table('donatur')->where('id',$id)->update(['aktif'=>1]);
                return redirect('login')->with("message",'Akun telah berhasil di aktivasi, Silahkan Login dengan Email dan Password yang sudah Didaftarkan');
            }else{
                return redirect('login')->with("message",'Terdapat kesalahan silahkan hubungi kontak kami'); 
            }
        }
    }
    function postUpdateTbm(){

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
        // dd(Request::get('kode_no_seluler'));
        
        $nama                    = Request::get('nama');                  
        $old_password            = Request::get('old_password');              
        $new_password            = Request::get('new_password');              
        $conf_password           = Request::get('conf_password');                
        $tahun_berdiri           = Request::get('tahun_berdiri');                  
        $no_izin                 = Request::get('no_izin');              
        $provinsi                = Request::get('provinsi');              
        $kota                    = Request::get('kota');  
        $alamat                  = Request::get('alamat');                  
        $tlpn                    = "(".Request::get('kode_no_telepon').")".Request::get('tlpn');                
        $no_hp                   = "(".Request::get('kode_no_seluler').")".Request::get('no_hp');                     
        $kodepos                 = Request::get('kodepos');                
        $image                   = Request::file('image');                  
        $nama_ketua              = Request::get('nama_ketua');              
        $tempat_lahir_pengelola  = Request::get('tempat_lahir_pengelola');              
        $tanggal_lahir_pengelola = Request::get('tanggal_lahir_pengelola');                     
        $alamat_pengelola        = Request::get('alamat_pengelola');                  
        $tlpn_pengelola          = "(".Request::get('kode_no_pengelola').")".Request::get('tlpn_pengelola');               
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
        $q['kecamatan']    = Request::get('kecamatan');
        $q['desa']    = Request::get('desa');
        $q['rt']    = Request::get('rt');
        $q['rw']    = Request::get('rw');


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

        return redirect('profile')->with("message",'Update Profile Berhasil');
    }
    function postUpdateTbmType(){
        if (!Session::get('ss_type_pengguna')) {
            return redirect('/');
        }
        $master_tbm = DB::table('master_tbm')->where('name',Request::get('kategori_tbm'))->first();
        $id_master_tbm  = $master_tbm->id;  
        $master_spm = DB::table('master_spm')->where('name',Request::get('kategori_spm'))->first();
        $id_master_spm  = $master_spm->id;  
        $master_spnf = DB::table('master_spnf')->where('name',Request::get('kategori_spnf'))->first();
        $id_master_spnf  = $master_spnf->id; 
        $q['id_master_tbm']            = $id_master_tbm;
        $q['id_master_spm']            = $id_master_spm;
        $q['id_master_spnf']            = $id_master_spnf;
        $q['nama_lembaga_naungan']    = Request::get('nama_lembaga_naungan');

        $update       = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->update($q);

        return redirect('profile/edit')->with("message",'Update Profile Berhasil');
    }
    function postAddKegiatan(){
        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'title'    => 'required', 
                'content'    => 'required', 
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
        $q['content']    = Request::get('content');
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
    function postLoginTbm(){
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
            return redirect('login?failed=tbm')->with('message', 'Maaf email anda tidak terdaftar, mohon untuk melakukan pendaftaran.');
        }
        if ($tbm->setujui == 0) {
            return redirect('login?failed=tbm')->with('message', 'Maaf TBM Masih Proses Approval');
        }    

        if(\Hash::check($password,$tbm->password)) {
            Session::put('ss_tbm_id', $tbm->id);
            Session::put('ss_tbm_email', $tbm->email);
            Session::put('ss_type_pengguna', 'tbm');

            DB::table('tbm')
                ->where('id', $tbm->id)
                ->update(['last_login' => date('Y-m-d H:i:s')]);
            
            return redirect('profile')->with('message', 'Anda berhasil Login!');
        }else{
            return redirect('login?failed=tbm')->with('message', 'Harap memasukan email dan password dengan benar!');
        }
        
    }
    function postAddKebutuhan(){

        $id_tbm           = Session::get('ss_tbm_id');
        $id_kategori_buku = Request::get('id_kategori_buku');

        // Validation
        $validator = Validator::make(Request::all(),            
            [                   
                'id_tbm'            => 'required', 
                'id_kategori_buku' => 'required', 

            ]
        );
        
        if ($validator->fails()) 
        {
            $message = $validator->messages();
            return redirect()->back()->withInput()->with("message",'Harap mengisi fill dengan lengkap dan benar');
        }
        $q['id_tbm']           = Session::get('ss_tbm_id');
        $q['id_kategori_buku'] = Request::get('id_kategori_buku');
        $q['created_at']       = date('Y-m-d H:i:s');


        $insert       = DB::table('tbm_req')->insert($q);
        return redirect('profile/kebutuhan')->with("message",'Permintaan Buku Berhasil Disimpan');

    }
    function postUbahKebutuhan(){

        // DB::table('donasi_item')->where('id',Request::get('id'))->update($q);
        DB::table('buku_diterima')->where('id_donasi_item',Request::get('id'))->delete();
        $judul = Request::get('judul');
        $pengarang = Request::get('pengarang');
        $penerbit = Request::get('penerbit');
        $qty = Request::get('qty');
        $total = 0;
        if (!empty($judul)) {
            foreach ($judul as $key => $value) {
                $simpan['id_tbm'] = Session::get('ss_tbm_id');
                $simpan['id_donasi_item'] = Request::get('id');
                $simpan['judul'] = $value;
                $simpan['penulis'] = $pengarang[$key];
                $simpan['penerbit'] = $penerbit[$key];
                $simpan['qty'] = $qty[$key];
                $total += $qty[$key];

                DB::table('buku_diterima')->insert($simpan);
            }
        }
        $donasi['qty'] = $total;

        DB::table('donasi_item')->where('id',Request::get('id'))->update($donasi);
        return redirect('profile/pemberitahuan?page='.g('page'))->with("message",'Permintaan Buku Berhasil Diupdate');

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
        $p['nama']         = Request::get('nama');
        $p['instansi']         = Request::get('instansi');
        $p['tlpn']         = Request::get('tlpn');
        $p['alamat']         = Request::get('alamat');
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

        return redirect('login')->with("message",'Registrasi Donatur Berhasil, Silahkan cek email anda untuk aktivasi akun');
    }
    function postDonasiBuku(){
        $no_donasi       = no_donasi();  
        $data['no_donasi'] = $no_donasi;
        $data['status']     = 'Donasi Belum Lengkap'; 
        $data['id_donatur'] = Session::get('ss_donatur_id');       
        $data['tgl_donasi'] = date('Y-m-d H:i:s');
        $data['alamat_pengirim'] = Request::get('alamat_pengirim');
        $data['nama'] = Request::get('nama_pengirim');
        $data['tlpn'] = Request::get('no_telp_pengirim');

        DB::table('donasi')->insert($data);
        $lastInsertId    = DB::getPdo()->lastInsertId();
        $donasi_kode    = DB::getPdo()->lastInsertId();

        $id_book = Request::get('book_id');
        $id_tbm = Request::get('id_tbm');
        // print_r($id_tbm);exit();
        $item = $id_book;

        foreach ($id_tbm as $key => $value) {
            $check_buku = DB::table('tbm_req')->where('id',$item[$key])->first();
            $check_kategori = DB::table('kategori_buku')->where('id',$check_buku->id_kategori_buku)->first();
            $q['id_donasi'] = $lastInsertId;
            $q['id_tbm']    = $value;
            $q['id_kategori_buku'] = $check_buku->id_kategori_buku;

            DB::table('donasi_item')->insert($q);

            $a = DB::getPdo()->lastInsertId();

            $insert['id_tbm'] = $value;
            $insert['type_info'] = 1;
            $insert['id_donasi'] = $lastInsertId;
            $insert['content'] = $a;

            DB::table('tbm_notice')->insert($insert);

            $check_tbm = DB::table('tbm')->where('id',$value)->first();
            $check_donasi = DB::table('donasi')->where('id',$lastInsertId)->first();
            $check_donatur = DB::table('donatur')->where('id',$check_donasi->id_donatur)->first();
            $html['no_donasi'] = $check_donasi->no_donasi; 
            $html['kategori'] = $check_kategori->nama;
            $html['nama_donatur'] = $check_donatur->nama;

            $template = 'email-notice';
	    	$email = $check_tbm->email;
	        send_email($email,'Kemendikbud - TBM, Email Baru Dari Website',$html,'',$template);
        }

        // $data['testimony'] = Request::get('testimony');
        return redirect('donasi-buku/'.$lastInsertId);
    }
    function getDonasiBuku($id){
        $data['page_title'] = 'Detail Donasi Buku';        
        $data['id_donasi_nya'] = $id;
        $list = DB::table('donasi_item')->where('id_donasi',$id)->groupby('id_tbm')->orderby('id','asc')->get();
        $donasi = DB::table('donasi')->where('id',$id)->first();

        $data['no_donasi'] = $donasi->no_donasi;
        $data['tbm'] = $list;

        return view('profile.info_pengiriman',$data);
    }
    function postTestimony(){
        // $p['no_donasi']  = Request::get('no_donasi');
        // $p['status']     = 'Donasi Belum Lengkap';  
        // // $p['id_tbm']    = Request::get('id_tbm');     
        // $p['id_donatur'] = Session::get('ss_donatur_id');       
        // $p['tgl_donasi'] = date('Y-m-d H:i:s');
        $p['testimony'] = Request::get('testimony');
        DB::table('donasi')->where('id',Request::get('id_donasi'))->update($p);

        $check = DB::table('donasi_item')->where('id_donasi',Request::get('id_donasi'))->get();
        foreach ($check as $q) {
            $insert['id_tbm'] = $q->id_tbm;
            $insert['type_info'] = 2;
            $insert['id_donasi'] = Request::get('id_donasi');
            $insert['content'] = Request::get('testimony');

            DB::table('tbm_notice')->insert($insert);
        }
        // $lastInsertId    = DB::getPdo()->lastInsertId();

        // $id_book = Request::get('id_book');
        // $id_tbm = json_decode(Request::get('id_tbm'));
        // $item = json_decode($id_book);

        // foreach ($id_tbm as $key => $value) {
        //     $check_buku = DB::table('tbm_req')->where('id',$item[$key])->first();
        //     $check_kategori = DB::table('kategori_buku')->where('id',$check_buku->id_kategori_buku)->first();
        //     $q['id_donasi'] = $lastInsertId;
        //     $q['id_tbm']    = $value;
        //     $q['id_kategori_buku'] = $item[$key];

        //     DB::table('donasi_item')->insert($q);
        // }
        return redirect('profile')->with("message",'Terimakasih, atas testimonial untuk buku yang sudah di donasikan');
     }
    function getDetail($id){
        $data['page_title'] = 'Detail Donasi | Donatur TBM';
        $data['id_donasi_nya'] = $id;
        $list = DB::table('donasi_item')->where('id_donasi',$id)->groupby('id_tbm')->orderby('id','asc')->get();
        $donasi = DB::table('donasi')->where('id',$id)->first();

        $data['no_donasi'] = $donasi->no_donasi;
        $data['tbm'] = $list;
        return view('profile.info_riwayat',$data);
    }
     function getPrintAlamatView(){
        $this->index_return = true;
        $data          = DB::table('tbm')->where('id',Request::get('id_tbm'))->first();
        $donasi = DB::table('donasi')->where('id',Request::get('id_donasi'))->first();
        $response['donasi'] = Request::get('no_donasi');
        $response['data']   = $data;
        $filetype           = 'pdf';
        $filename           = $data->nama;
        $papersize          = 'F4';
        $paperorientation   = 'landscape';   


        return view('export.alamat',$response);
        // if(Request::input('default_paper_size')) {
        //     DB::table('cms_settings')->where('name','default_paper_size')->update(['content'=>$papersize]);
        // }
        // $view = view('export.alamat',$response)->render();
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML($view);
        // $pdf->setPaper($papersize,$paperorientation);
        // return $pdf->stream($filename.'.pdf'); 
    }
    function getPrintAlamat(){
        $this->index_return = true;
        $data          = DB::table('tbm')->where('id',Request::get('id_tbm'))->first();
        $donasi = DB::table('donasi')->where('id',Request::get('id_donasi'))->first();
        $response['donasi'] = $donasi->no_donasi;
        $response['donatur'] = $donasi;
        $response['data']   = $data;
        $filetype           = 'pdf';
        $filename           = $data->nama;
        $papersize          = 'F4';
        $paperorientation   = 'landscape';   

        if(Request::input('default_paper_size')) {
            DB::table('cms_settings')->where('name','default_paper_size')->update(['content'=>$papersize]);
        }
        // return view('export.alamat',$response);
        $view = view('export.alamat',$response)->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper($papersize,$paperorientation);
        return $pdf->stream($filename.'.pdf'); 
    }
    function postRegisterTbm(){
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
                // 'image'                   => 'required',                  
                'nama_ketua'              => 'required',                  
                'tempat_lahir_pengelola'  => 'required',                  
                'tanggal_lahir_pengelola' => 'required',                  
                'alamat_pengelola'        => 'required',                  
                'no_hp'                   => 'required',                   
                'kodepos_pengelola'       => 'required',                  
                // 'email_pengelola'         => 'required|email' ,               
                // 'upload'               => 'required',               
                // 'image_ktp_pengelola'     => 'required',             
                // 'image_izin_oprasional'   => 'required',             
                // 'confirm_data'            => 'required'
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
        $tlpn          = "(".Request::get('kode_no_telepon').")".Request::get('tlpn');                
        $no_hp         = "(".Request::get('kode_no_seluler').")".Request::get('no_hp');                  
        $kodepos       = Request::get('kodepos');                  
        $email         = Request::get('email');                
        $image         = Request::file('image');                  
        $nama_ketua    = Request::get('nama_ketua'); 
        
        // $latitude      = Request::get('latitude');             
        // $longitude     = Request::get('longitude');
        
        $tempat_lahir_pengelola  = Request::get('tempat_lahir_pengelola');              
        $tanggal_lahir_pengelola = Request::get('tanggal_lahir_pengelola');                     
        $alamat_pengelola        = Request::get('alamat_pengelola');                  
        $tlpn_pengelola          = "(".Request::get('kode_tlpn_pengelola').")".Request::get('tlpn_pengelola');               
        $kodepos_pengelola       = Request::get('kodepos_pengelola');                  
        // $email_pengelola         = Request::get('email_pengelola');                   
        $confirm_data            = 1;    
        $master_tbm = DB::table('master_tbm')->where('name',Request::get('kategori_tbm'))->first();
        $id_master_tbm  = $master_tbm->id;  
        $master_spm = DB::table('master_spm')->where('name',Request::get('kategori_spm'))->first();
        $id_master_spm  = $master_spm->id;  
        $master_spnf = DB::table('master_spnf')->where('name',Request::get('kategori_spnf'))->first();
        $id_master_spnf  = $master_spnf->id;     
        // $dokumen              = Request::file('upload');            
        // $image_ktp_pengelola     = Request::file('image_ktp_pengelola');            
        // $image_izin_oprasional   = Request::file('image_izin_oprasional');

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
        
        // $q['latitude']                = $latitude;
        // $q['longitude']               = $longitude;
        
        $q['nama_ketua']              = $nama_ketua;
        $q['alamat_pengelola']        = $alamat_pengelola;
        $q['kodepos_pengelola']       = $kodepos_pengelola;
        $q['tempat_lahir_pengelola']  = $tempat_lahir_pengelola;
        $q['tanggal_lahir_pengelola'] = $tanggal_lahir_pengelola;
        $q['tlpn_pengelola']          = $tlpn_pengelola;
        $q['email_pengelola']         = $email_pengelola;
        $q['confirm_data']            = $confirm_data;
        $q['id_master_tbm']            = $id_master_tbm;
        $q['id_master_spm']            = $id_master_spm;
        $q['id_master_spnf']            = $id_master_spnf;
        $q['nama_lembaga_naungan']    = Request::get('nama_lembaga_naungan');
        $q['kecamatan']    = Request::get('kecamatan');
        $q['desa']    = Request::get('desa');
        $q['rt']    = Request::get('rt');
        $q['rw']    = Request::get('rw');
        $q['created_at']              = date('Y-m-d H:i:s');

        // if (Request::hasFile('image')){
        //     $image = Request::file('image');
        //     $ext   = $image->getClientOriginalExtension();
        //     //Create Directory Monthly 
        //     Storage::makeDirectory(date('Y-m'));

        //     //Move file to storage
        //     $name = $image->getClientOriginalName();
        //     $filename = md5(str_random(5));
        //     $filename .= preg_replace('/\s+/u', '_', $name); 
        //     if($image->move(storage_path('app'.DIRECTORY_SEPARATOR.date('Y-m')),$filename)) {                        
        //         $v = 'uploads/'.date('Y-m').'/'.$filename;
        //     } 
        //     $q['image']   = $v;
        // }


        $insert       = DB::table('tbm')->insert($q);
        $lastInsertId = DB::getPdo()->lastInsertId();

        // $html  = "<h2>Kemendikbud - TBM, Aktivasi Akun TBM</h2>
        //         <p>Silahkan klik link di bawah ini untuk aktivasi akun anda</p>
        //         <p><a href='".url('/aktivasi/'.Crypt::encrypt($lastInsertId))."?type=tbm'>".url('/aktivasi/'.Crypt::encrypt($lastInsertId))."?type=tbm</a></p>";
        // send_email($email,'Kemendikbud - TBM, Aktivasi Akun TBM',$html);

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

        return redirect('login')->with("message",'TBM Berhasil didaftarkan, Pemberitahuan Aproval akan dikirim melalui Email, Approval TBM akan diproses maksimal 2x24Jam');
    }
    function getRegister(){
        if (Session::get('ss_type_pengguna')) {
            return redirect('/profile');
        }
        $data['page_title'] = 'Register TBM';
        $data['action']      = 'register_tbm';
        $data['body_class']  = array('register_tbm','page-form');
        $data['title_meta']  = get_setting('title_meta');
        $data['keywords']    = get_setting('keywords');
        $data['description'] = get_setting('description');
        $data['master_tbm'] = DB::table('master_tbm')->orderby('name','asc')->get();
        $data['master_spm'] = DB::table('master_spm')->orderby('id','asc')->get();
        $data['master_spnf'] = DB::table('master_spnf')->orderby('id','asc')->get();

        $data['propinsi'] = DB::table('propinsi')->orderBy('propinsi')->get();

        return view('register',$data);
    }
    public function postEditTentang(){
        $id_tbm = Session::get('ss_tbm_id');
        $save['description'] = Request::get('description');
        $save['url_website'] = Request::get('url_website');
        $save['facebook'] = Request::get('facebook');
        $save['twitter'] = Request::get('twitter');
        $save['gplus'] = Request::get('gplus');
        $save['instagram'] = Request::get('instagram');

        // dd($save);

        DB::table('tbm')->where('id',$id_tbm)->update($save);

        return redirect()->back()->with('message', 'Berhasil memperbarui profil');

    }
    public function getEmail(){
    	// return view('email-notice');

    	$template = 'email-notice';
    	$email = 'adam@crocodic.com';
    	$html['no_donasi'] = 'asdasd';
    	$html['kategori'] = 'jidajisjd';
    	$html['nama_donatur'] = 'jidajisjd';
        send_email($email,'Kemendikbud - TBM, Email Baru Dari Website',$html,'',$template);
    }
    function getLogout(){
        Session::flush();
        return redirect('/');   
    }

    function postLoginDonatur(){

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
            return redirect('login?failed=donatur')->with('message', 'Maaf email anda tidak terdaftar, mohon untuk melakukan pendaftaran.');
        }    
        if ($donatur->aktif == 0) {
            return redirect('login?failed=donatur')->with('message', 'Mohon untuk aktivasi akun terlebih dahulu');
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
            return redirect('login?failed=donatur')->with('message', 'Harap memasukan email dan password dengan benar!');
        }   
    }
    function getProfile($slug=''){
        $data['page_title'] = 'Profile Data | TBM';
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
            // case 'ubah-kebutuhan':
            //         $data['action']      = 'add-kebutuhan';
            //         $data['slug']        = $slug;
            //         $data['body_class']  = array('add-kebutuhan','profile');
            //         $data['title_meta']  = get_setting('title_meta');
            //         $data['keywords']    = get_setting('keywords');
            //         $data['description'] = get_setting('description');

            //         $data['kebutuhan']     = DB::table('req_buku')->where('id',Request::segment(3))->first();
            //         $data['tbm']           = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
            //         $data['kategori_buku'] = DB::table('kategori_buku')->orderBy('nama','ASC')->get();
            //         return view('profile.profile_tbm',$data);
            //     break;
            case 'ubah-kebutuhan':
                    $data['action']      = 'add-kebutuhan';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('add-kebutuhan','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');

                    $data['kebutuhan']     = DB::table('donasi_item')->where('id',Request::segment(3))->first();
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
                    $data['kategori_buku']    = DB::table('kategori_buku')->orderby('nama','asc')->get();
                    $data['kebutuhan']   = DB::table('tbm_req')
                                            ->where('id_tbm',Session::get('ss_tbm_id'))
                                            ->orderBy('id_kategori_buku','asc')
                                            ->join('kategori_buku', 'tbm_req.id_kategori_buku', '=', 'kategori_buku.id')
                                            ->select('tbm_req.*','kategori_buku.nama as nama_kategori')
                                            ->paginate(5);
                    
                    return view('profile.profile_tbm',$data);
                break;
            case 'pemberitahuan':
                    $update['is_read'] = 1;
                    DB::table('donasi')->where('id_tbm',Session::get('ss_tbm_id'))->orderBy('id','DESC')->where('is_read',0)->update($update);
                    $data['action']      = 'pemberitahuan';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('pemberitahuan','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');
                    $data['tbm']         = DB::table('tbm')->where('id',Session::get('ss_tbm_id'))->first();
                    $data['pemberitahuan'] = DB::table('tbm_notice')
                    ->leftjoin('donasi','donasi.id','=','tbm_notice.id_donasi')
                    ->select('tbm_notice.*','donasi.no_donasi as no_donasi','donasi.id_donatur as id_donatur')
                    ->orderby('tbm_notice.id','desc')
                    ->where('tbm_notice.id_tbm',Session::get('ss_tbm_id'))
                    ->paginate(5);
                    $data['donasi']     = DB::table('donasi_item')->where('id_tbm',Session::get('ss_tbm_id'))->orderBy('id','DESC')->paginate(5);
                    $data['info']     = DB::table('donasi')->where('id_tbm',Session::get('ss_tbm_id'))->orderBy('id','DESC')->where('is_read',0)->get();
                    
                    return view('profile.profile_tbm',$data);
                    // return view('errors.404');
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
                    $data['donatur']    = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
                    $data['donasi']     = DB::table('donasi')->where('id_donatur',Session::get('ss_donatur_id'))->orderBy('id','DESC')->paginate(5);
                    
                    return view('profile.profile_donatur',$data);
                    // return view('errors.404');
                break;
            case 'donasi-buku':
                    $data['action']      = 'donasi-buku';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('donasi-buku','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');
                    $data['donatur']    = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
                    
                    return view('profile.profile_donatur',$data);
                    // return view('errors.404');
                break;
            case 'donasi-buku-by-kategori':
                    $data['action']      = 'donasi-buku-by-kategori';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('donasi-buku-by-kategori','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');
                    $data['donatur']    = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
                    if(!empty(Request::get('kategori'))){
                        // $data['req_buku'] = DB::table('req_buku')->where('id_kategori_buku',Request::get('kategori'))->orderBy('judul','asc')->paginate(5);
                        $req_buku   = DB::table('tbm_req')
                                            ->where('id_kategori_buku',Request::get('kategori'))
                                            ->orderBy('id_kategori_buku','asc')
                                            ->join('kategori_buku', 'tbm_req.id_kategori_buku', '=', 'kategori_buku.id')
                                            ->join('tbm', 'tbm_req.id_tbm', '=', 'tbm.id')
                                            ->select('tbm_req.*','kategori_buku.nama as nama_kategori','tbm.nama as nama_tbm');
                        if (Request::get('q')) {
                            $req_buku->where("tbm.nama","like","%".Request::get("q")."%");
                            // $req_buku->orwhere("content","like","%".Request::get("q")."%");
                        }
                        $data['req_buku']   = $req_buku->paginate(5);
                    }else{
                        $data['kategori'] = DB::table('kategori_buku')->orderby('nama','asc')->get();
                    }
                    
                    return view('profile.profile_donatur',$data);
                    // return view('errors.404');
                break;
            case 'donasi-buku-by-tbm':
                    $data['action']      = 'donasi-buku-by-tbm';
                    $data['slug']        = $slug;
                    $data['body_class']  = array('donasi-buku-by-tbm','profile');
                    $data['title_meta']  = get_setting('title_meta');
                    $data['keywords']    = get_setting('keywords');
                    $data['description'] = get_setting('description');
                    $data['donatur']     = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
                    
                    $data['tbm']		 = DB::table('tbm')->orderby('nama','asc')->get();
                    
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
                    $data['donatur']    = DB::table('donatur')->where('id',Session::get('ss_donatur_id'))->first();
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
                        $data['master_tbm'] = DB::table('master_tbm')->orderby('name','asc')->get();
                        $data['master_spm'] = DB::table('master_spm')->orderby('name','asc')->get();
                        $data['master_spnf'] = DB::table('master_spnf')->orderby('name','asc')->get();

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
    function postUpdateDonatur(){
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
        return redirect('/profile')->with("message",'Berhasil Ubah Profil');
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
    function getDeleteKebutuhan($id){
        DB::table('tbm_req')->where('id',$id)->delete();

        return redirect()->back()->with("message",'Berhasil Menghapus kebutuhan');
    }
    function TotalData($year,$month){
        $datas = DB::table('donasi')
        ->select('donasi.*',
            DB::raw('(SELECT SUM(qty) FROM donasi_item WHERE id_donasi = donasi.id) AS total_buku'),
            DB::raw("DATE_FORMAT(tgl_donasi, '%m-%Y') new_date"),
            DB::raw("DATE_FORMAT(tgl_donasi, '%m') month"),
            DB::raw('YEAR(tgl_donasi) year, MONTH(tgl_donasi) month')
        )
        ->get();
        $total_buku = 0;
        foreach ($datas as $y) {
            if($y->month == $month && $y->year == $year){
                $total_buku += $y->total_buku;
            }
        }

        return $total_buku;
    }
    function tgl_indo($bln){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
       
        return $bulan[ (int)$bln ];
    }   
    function getDataJson(){
        for ($i=1; $i <= 12 ; $i++) { 
            if ($i < 10) {
                $now = "0".$i;
            }else{
                $now = $i;
            }
            $array[] = self::TotalData(g('year'),$now);
        }
        $res = response()->json($array);
        $res->send();
    }

}
?>