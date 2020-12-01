<?php 
namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class AdminDonasiController extends \crocodicstudio\crudbooster\controllers\CBController {

    public function __construct() {
        $this->table               = "donasi";
        $this->primary_key         = "id";
        $this->title_field         = "nama";
        $this->limit               = 20;
        $this->index_orderby       = ["id"=>"desc"];
        $this->button_show_data    = true;        
        $this->button_new_data     = false;
        $this->button_delete_data  = false;
        $this->button_sort_filter  = true;        
        $this->button_export_data  = true;
        $this->button_table_action = true;
        $this->button_import_data  = true;

        $this->col = array();
        $this->col[] = array("label"=>"No Donasi","name"=>"no_donasi" );
        $this->col[] = array("label"=>"Status","name"=>"status" );
        $this->col[] = array("label"=>"Donatur Detail","name"=>"id_donatur" );
        // $this->col[] = array("label"=>"Bank","name"=>"bank");
        // $this->col[] = array("label"=>"Total","name"=>"id" );
        $this->col[] = array("label"=>"Tgl Donasi","name"=>"tgl_donasi" );
        $this->col[] = array("label"=>"Konfirmasi","name"=>"id" );

        $this->form = array();
        $this->form[] = array("label"=>"Donatur","name"=>"id_donatur","type"=>"select","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"donatur,nama");
        $this->form[] = array("label"=>"No Donasi","name"=>"no_donasi","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
        $this->form[] = array("label"=>"Status","name"=>"status","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
        $this->form[] = array("label"=>"Nama","name"=>"nama","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255|alpha_spaces","placeholder"=>"You can only enter the letter only");
        $this->form[] = array("label"=>"Tlpn","name"=>"tlpn","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
        $this->form[] = array("label"=>"Email","name"=>"email","type"=>"email","required"=>TRUE,"validation"=>"required|min:3|max:255|email|unique:donasi","placeholder"=>"Please enter a valid email address");
        $this->form[] = array("label"=>"Bank","name"=>"bank","type"=>"text");
        $this->form[] = array("label"=>"Tgl Donasi","name"=>"tgl_donasi","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s");
     

        /* 
        | ---------------------------------------------------------------------- 
        | Add relational module
        | ----------------------------------------------------------------------     
        | @label       = Name of sub module 
        | @path        = The path of module, see at module generator
        | @foreign_key = required.  
        | 
        */
        $this->sub_module     = array();
        $this->sub_module[]     = array('label'=>'Donasi Item','path'=>'donasi_item','foreign_key'=>'id_donasi');

        // $id                 = Request::segment(4);
        // $konfirmasi         = DB::table('konfirmasi_donasi')->where('id_donasi',$id)->first();
        // if ($konfirmasi) {
            // $this->sub_module[] = array('label'=>'Konfirmasi Donasi','path'=>'konfirmasi_donasi','foreign_key'=>'id_donasi');
        // }




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



        /*
        | ---------------------------------------------------------------------- 
        | Include Javascript File 
        | ---------------------------------------------------------------------- 
        | URL of your javascript each array 
        | $this->load_js[] = asset("myfile.js");
        |
        */
        $this->load_js = array();



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
        foreach ($html as &$item) {
            $id = $item[3];
            $donasi = DB::table('donatur')->where('id',$id)->first();


            $item[1] = '<a href="'.url('/admin').'/donasi/sub-module/'.$item[5].'/donasi_item" class="btn btn-sm btn-primary">'.$item[1].'</a>';
            $item[3] = $donasi->nama.'<br>'.$donasi->tlpn.'<br>'.$donasi->email;

            // $id_bank = $item[5];
            // if ($id_bank) {
            //     $bank = DB::table('bank')->where('id',$id_bank)->first();
            //     $item[5] = $bank->bank.'<br>'.$bank->norek.'<br>AN : '.$bank->an;
            // }

            // if ($id) {
            //     $item[5] = number_format(total($id));
            // }


            $status = show_value($id,'donasi','status');

            if ($status != 'Donasi Belum Lengkap') {
                if ($status == "Dalam Proses") {
                    $option = '<select name="status">
                                    <option value="Dalam Proses" selected="selected">Dalam Proses</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Donasi Baru">Donasi Baru</option>
                                </select>';
                }elseif ($status == 'Selesai') {
                    $option = '<select name="status">
                                    <option value="Dalam Proses">Dalam Proses</option>
                                    <option value="Selesai" selected="selected">Selesai</option>
                                    <option value="Donasi Baru">Donasi Baru</option>
                                </select>';
                }else{
                    $option = '<select name="status">
                                    <option value="Dalam Proses">Dalam Proses</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Donasi Baru" selected="selected">Donasi Baru</option>
                                </select>';
                }

                $status_form = '<form action="'.action("AdminDonasiController@postStatus").'" method="post">
                                    <input type="hidden" name="_token" value="'.csrf_token().'" />
                                    <input type="hidden" name="id" value="'.$id.'" />
                                    '.$option.'<br><br>
                                    <input type="submit" value="submit" class="btn btn-sm btn-primary"> 
                                </form>';

                $item[2] = $status_form;
            }

            $konfirmasi = DB::table('konfirmasi_donasi')->where('id_donasi',$id)->first();
            if ($konfirmasi) {
                $item[5] = '<a href="'.url('/admin').'/donasi/sub-module/'.$id.'/konfirmasi_donasi" class="btn btn-sm btn-primary">Terkonfirmasi</a>';
            }else{
                $item[5] = '';
            }
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

    }



    //By the way, you can still create your own method in here... :) 
    public function postStatus()
    {
        $p['status'] = Request::get('status');
        DB::table('donasi')->where('id',Request::get('id'))->update($p);
        return redirect('admin/donasi');
    }


}