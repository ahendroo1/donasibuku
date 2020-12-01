<?php 
namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class AdminArtikelController extends \crocodicstudio\crudbooster\controllers\CBController {

    public function __construct() {
        $this->table              = "artikel";
        $this->primary_key        = "id";
        $this->title_field        = "title";
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
		$this->col[] = array("label"=>"Title","name"=>"title" );
		$this->col[] = array("label"=>"Content","name"=>"content",'str_limit'=>100 );
		$this->col[] = array("label"=>"Image","name"=>"image" ,"image"=>true);
		$this->col[] = array("label"=>"Users","name"=>"id_cms_users","join"=>"cms_users,name");

		$this->form = array();
		$this->form[] = array("label"=>"Title","name"=>"title","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
		$this->form[] = array("name"=>"slug","type"=>"hidden");
		$this->form[] = array("label"=>"Content","name"=>"content","type"=>"wysiwyg","required"=>TRUE,"validation"=>"required|string");
		$this->form[] = array("label"=>"Image","name"=>"image","type"=>"upload_standard","required"=>TRUE,"validation"=>"required","help"=>"File types support : JPG, JPEG, PNG, GIF, BMP","upload_file"=>FALSE);
        $html = '<label>Kategori <span class="text-danger" title="This field is required">*</span></label><br>';
        $get_kategori = DB::table('master_kategori')->orderby('name','asc')->get();
        if(Request::segment('3') == 'add'){
            foreach($get_kategori as $row){
                $html .= "<label><input type='checkbox' name='id_kategori[]' value='".$row->id."'> ".$row->name."</label><br>";
            }
        }else{
            foreach($get_kategori as $row){
                $check = DB::table('kategori_artikel')->where('id_artikel',Request::segment('4'))->where('id_master_kategori',$row->id)->first();
                if (count($check) > 0) {
                    $html .= "<label><input type='checkbox' name='id_kategori[]' value='".$row->id."' checked=''> ".$row->name."</label><br>";
                }else{
                    $html .= "<label><input type='checkbox' name='id_kategori[]' value='".$row->id."' > ".$row->name."</label><br>";
                }
            }
        }
        $this->form[] = array("label"=>"Kategori","type"=>"html","html"=>$html);
		$this->form[] = array("label"=>"Cms Users","name"=>"id_cms_users","type"=>"select","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"cms_users,name",'value'=>get_my_id());
     

        /* 
        | ---------------------------------------------------------------------- 
        | Add relational module
        | ----------------------------------------------------------------------     
        | @label       = Name of sub module 
        | @controller  = Controller name of other module 
        | @foreign_key = required.  
        | 
        */
        $this->sub_module     = array();




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
        $kategori = Request::get('id_kategori');
        foreach ($kategori as $q) {
            $save['id_artikel'] = $id;
            $save['id_master_kategori'] = $q;

            DB::table('kategori_artikel')->insert($save);
        }
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
        DB::table('kategori_artikel')->where('id_artikel',$id)->delete();
        $kategori = Request::get('id_kategori');
        foreach ($kategori as $q) {
            $save['id_artikel'] = $id;
            $save['id_master_kategori'] = $q;

            DB::table('kategori_artikel')->insert($save);
        }
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


}