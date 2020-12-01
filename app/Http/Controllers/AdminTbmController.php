<?php 
namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;
use Illuminate\Support\Facades\Storage;

class AdminTbmController extends \crocodicstudio\crudbooster\controllers\CBController {

    public function __construct() {
        $this->table              = "tbm";
        $this->primary_key        = "id";
        $this->title_field        = "nama";
        $this->limit              = 20;
        $this->index_orderby      = ["id"=>"desc"];
        $this->button_show_data   = true;        
        $this->button_new_data    = true;
        $this->button_delete_data = true;
        $this->button_sort_filter = true;        
        $this->button_export_data = true;
        $this->button_table_action = true;
        $this->button_import_data = true;

        $this->col = array();
        $this->col[] = array("label"=>"ID TBM","name"=>"tbm.id" );
        // $this->col[] = array("label"=>"Photo","name"=>"image","image"=>1 );
        $this->col[] = array("label"=>"Nama","name"=>"nama" );
        $this->col[] = array("label"=>"No Ijn","name"=>"no_izin" );
		$this->col[] = array("label"=>"Alamat","name"=>"alamat" );
        $this->col[] = array("label"=>"Provinsi","name"=>"provinsi","join"=>"propinsi,propinsi" );
        $this->col[] = array("label"=>"Kota","name"=>"kota","join"=>"kabupaten,kabupaten" );
		$this->col[] = array("label"=>"Kode Pos","name"=>"kodepos" );
		$this->col[] = array("label"=>"Tlpn","name"=>"tlpn" );
        $this->col[] = array("label"=>"Email","name"=>"email" );
        $this->col[] = array("label"=>"Nama Ketua","name"=>"nama_ketua" );
        $this->col[] = array("label"=>"Tlpn Pengelola","name"=>"tlpn_pengelola" );
        $this->col[] = array("label"=>"Tempat Lahir Pengelola","name"=>"tempat_lahir_pengelola" );
        $this->col[] = array("label"=>"Tanggal Registrasi","name"=>"created_at" );
        $this->col[] = array("label"=>"Setujui","name"=>"setujui");
        $this->col[] = array("label"=>"Di Setujui Oleh","name"=>"confirm_by","join"=>"cms_users,name");
        $this->col[] = array("label"=>"Di Setujui Oleh","name"=>"confirm_by");
        $this->col[] = array("label"=>"Login Terakhir","name"=>"last_login" );

		$this->form = array();
		$this->form[] = array("label"=>"Nama","name"=>"nama","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255","placeholder"=>"You can only enter the letter only");
		$this->form[] = array("label"=>"Alamat","name"=>"alamat","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000");
        $this->form[] = array("label"=>"Provinsi","name"=>"provinsi","type"=>"select2","datatable"=>"propinsi,propinsi","required"=>TRUE);

        $this->form[] = array("label"=>"Kota","name"=>"kota","type"=>"select2","datatable"=>"kabupaten,kabupaten","required"=>TRUE);
		$this->form[] = array("label"=>"Kodepos","name"=>"kodepos","type"=>"text","required"=>TRUE,"validation"=>"required|string");
		$this->form[] = array("label"=>"Tlpn","name"=>"tlpn","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255");
		$this->form[] = array("label"=>"Email","name"=>"email","type"=>"email","required"=>TRUE,"validation"=>"required|min:3|max:255|email|unique:tbm","placeholder"=>"Please enter a valid email address");
		$this->form[] = array("label"=>"Password","name"=>"password","type"=>"password","help"=>"Please leave empty if you did not change the password.");
		$this->form[] = array("label"=>"Tahun Berdiri","name"=>"tahun_berdiri","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
		$this->form[] = array("label"=>"No Izin","name"=>"no_izin","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255");
		$this->form[] = array("label"=>"Latitude","name"=>"latitude","type"=>"hidden","required"=>TRUE,"validation"=>"required|min:3|max:255","googlemaps"=>TRUE);
		$this->form[] = array("label"=>"Longitude","name"=>"longitude","type"=>"hidden","required"=>TRUE,"validation"=>"required|min:3|max:255");
		$this->form[] = array("label"=>"Image","name"=>"image","type"=>"upload_standard","required"=>TRUE,"validation"=>"required|min:3|max:255","help"=>"File types support : JPG, JPEG, PNG, GIF, BMP","upload_file"=>FALSE);
		$this->form[] = array("label"=>"Nama Ketua","name"=>"nama_ketua","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
		$this->form[] = array("label"=>"Alamat Pengelola","name"=>"alamat_pengelola","type"=>"textarea","required"=>TRUE,"validation"=>"required|min:3|max:255");
		$this->form[] = array("label"=>"Kodepos Pengelola","name"=>"kodepos_pengelola","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
        $this->form[] = array("label"=>"Tempat Lahir Pengelola","name"=>"tempat_lahir_pengelola","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
        $this->form[] = array("label"=>"Tanggal Lahir Pengelola","name"=>"tanggal_lahir_pengelola","type"=>"date","required"=>TRUE,);
		$this->form[] = array("label"=>"Tlpn Pengelola","name"=>"tlpn_pengelola","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
		$this->form[] = array("label"=>"Email Pengelola","name"=>"email_pengelola","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
        $this->form[] = array("label"=>"Type TBM","name"=>"id_master_tbm","type"=>"select","datatable"=>"master_tbm,name","required"=>TRUE);
        $this->form[] = array("label"=>"Type SPM","name"=>"id_master_spm","type"=>"select","datatable"=>"master_spm,name","required"=>TRUE);
        $this->form[] = array("label"=>"Type SPNF","name"=>"id_master_spnf","type"=>"select","datatable"=>"master_spnf,name","required"=>TRUE);
     

        /* 
        | ---------------------------------------------------------------------- 
        | Add relational module
        | ----------------------------------------------------------------------     
        | @label       = Name of sub module 
        | @controller  = Controller name of other module 
        | @foreign_key = required.  
        | 
        */
        $this->sub_module   = array();
        $this->sub_module[] = array('label'=>'TBM Dokumen','icon'=>'fa fa-bars','path'=>"tbm_dokumen",'foreign_key'=>'id_tbm');




        /* 
        | ---------------------------------------------------------------------- 
        | Add More Action Button / Menu
        | ----------------------------------------------------------------------     
        | @label       = Label of action 
        | @route       = URL , you can use alias to get field, prefix [, suffix ], 
        |                e.g : [id], [name], [title], etc ...
        | @icon        = font awesome class icon         
        | 
        */
        $this->addaction = array();




                
        /* 
        | ---------------------------------------------------------------------- 
        | Add alert message to this module at overheader
        | ----------------------------------------------------------------------     
        | @message = Text of message 
        | @type    = warning,success,danger,info        
        | 
        */
        $this->alert        = array();
                

        
        /* 
        | ---------------------------------------------------------------------- 
        | Add more button to header button 
        | ----------------------------------------------------------------------     
        | @label = Name of button 
        | @url   = URL Target
        | @icon  = Icon from Awesome.
        | 
        */
        $this->index_button = array();       


        
        /* 
        | ---------------------------------------------------------------------- 
        | Add element to form at bottom 
        | ----------------------------------------------------------------------     
        | push your html / code in object array         
        | 
        */
        $this->form_add     = array();       



        
        /*
        | ---------------------------------------------------------------------- 
        | You may use this bellow array to add statistic at dashboard 
        | ---------------------------------------------------------------------- 
        | @label, @count, @icon, @color 
        |
        */
        $this->index_statistic = array();




        /*
        | ---------------------------------------------------------------------- 
        | Add additional view at top or bottom of index 
        | ---------------------------------------------------------------------- 
        | @view = view location 
        | @data = data array for view 
        |
        */
        $this->index_additional_view = array();



        /*
        | ---------------------------------------------------------------------- 
        | Add javascript at body 
        | ---------------------------------------------------------------------- 
        | javascript code in the variable 
        | $this->script_js = "function() { ... }";
        |
        */
        $this->script_js = NULL;
        $this->script_js = '$(document).ready(function(){
                                $("#box-body-table").css("overflow-x","auto");
                            });';



        /*
        | ---------------------------------------------------------------------- 
        | Include Javascript File 
        | ---------------------------------------------------------------------- 
        | URL of your javascript each array 
        | $this->load_js[] = asset("myfile.js");
        |
        */
        $this->load_js = array();
        // $this->load_js[] = asset("/assets/css/style-admin.css");



        //No need chanage this constructor
        $this->constructor();
    }


    /*
    | ---------------------------------------------------------------------- 
    | Hook for manipulate query of index result 
    | ---------------------------------------------------------------------- 
    | @query = current database query 
    |
    */
    public function hook_query_index(&$query) {
        //Your code here
            
    }

    /*
    | ---------------------------------------------------------------------- 
    | Hook for manipulate row of index table html 
    | ---------------------------------------------------------------------- 
    | @html for row html 
    | @data for get data row
    | You should using foreach
    |
    */    
    public function hook_row_index(&$html,$data) {
        //Your code here
        $i = 0;
        foreach ($html as &$item) {
            $setujui = $item[14];
            if ($setujui == 1) {
                $item[14] = '<a href="'.url('/').'/admin/tbm/setujui?setujui=0&id='.$data[$i]->id.'" class="btn btn-sm btn-success">Setujui</a>';
            }else{
                $item[14] = '<a href="'.url('/').'/admin/tbm/setujui?setujui=1&id='.$data[$i]->id.'" class="btn btn-sm btn-warning">Tidak di Setujui</a>';
            }
            $i++;
        }


    }

    /*
    | ---------------------------------------------------------------------- 
    | Hook for manipulate data input before add data is execute
    | ---------------------------------------------------------------------- 
    | @arr
    |
    */
    public function hook_before_add(&$arr) {        
        //Your code here

    }

    /* 
    | ---------------------------------------------------------------------- 
    | Hook for execute command after add function called 
    | ---------------------------------------------------------------------- 
    | @id = last insert id
    | 
    */
    public function hook_after_add($id) {        
        //Your code here

    }

    /* 
    | ---------------------------------------------------------------------- 
    | Hook for manipulate data input before update data is execute
    | ---------------------------------------------------------------------- 
    | @postdata = input post data 
    | @id       = current id 
    | 
    */
    public function hook_before_edit(&$postdata,$id) {        
        //Your code here

    }

    /* 
    | ---------------------------------------------------------------------- 
    | Hook for execute command after edit function called
    | ----------------------------------------------------------------------     
    | @id       = current id 
    | 
    */
    public function hook_after_edit($id) {
        //Your code here 

    }

    /* 
    | ---------------------------------------------------------------------- 
    | Hook for execute command before delete function called
    | ----------------------------------------------------------------------     
    | @id       = current id 
    | 
    */
    public function hook_before_delete($id) {
        //Your code here
    }

    /* 
    | ---------------------------------------------------------------------- 
    | Hook for execute command after delete function called
    | ----------------------------------------------------------------------     
    | @id       = current id 
    | 
    */
    public function hook_after_delete($id) {
        //Your code here       
        // delete image file
        $query = DB::table('tbm_dokumen')->where('id_tbm',$id)->get();
        foreach ($query as $item) {         
            // if(Storage::exists($item->upload)) Storage::delete($row->upload);
            $file = str_replace('uploads/','',$item->upload);
            if(Storage::exists($file)) {
                Storage::delete($file);
            }
        }
        // delete on db
        DB::table('tbm_dokumen')->where('id_tbm',$id)->delete();
    }



    //By the way, you can still create your own method in here... :) 
    public function getSetujui()
    {
        $id      = Request::get('id');
        $setujui = Request::get('setujui');
        $email   = show_value($id,'tbm','email');
        $id_user = Session::get('admin_id');
        $update['setujui'] = $setujui;
        if ($setujui == 1) {
            $update['confirm_by'] = $id_user;
            $update['confirm_at'] = date('Y-m-d H:i:s');
        }else{
            $update['confirm_by'] = NULL;
            $update['confirm_at'] = NULL;
        }
        DB::table('tbm')->where('id',$id)->update($update);

        if ($setujui == 1) {   
            $html = "<h2>Kemendikbud - TBM, Registrasi TBM</h2>
                    <p>Akun TBM anda sudah aktif, silahkan login dengan email dan password yang anda daftarkan.</p>";
            send_email($email,'Kemendikbud - TBM, Aktifasi TBM',$html);
            $check = DB::table('tbm_req')->where('id_tbm',$id)->where('id_kategori_buku',99)->count();
            if ($check == 0) {
                $insert['id_tbm'] = $id;
                $insert['id_kategori_buku'] = 99;

                DB::table('tbm_req')->insert($insert);
            }
        }else{      
            $html = "<h2>Kemendikbud - TBM, Registrasi TBM</h2>
                    <p>Akun TBM anda di nonaktifkan karena beberapa hal, Untuk keterangan lebih lanjut silahkan hubungi kami.</p>";
            send_email($email,'Kemendikbud - TBM, Nonaktif TBM',$html);
        }

        return redirect('admin/tbm')->with(['message'=>'Success update data','message_type'=>'success']);
    }


}