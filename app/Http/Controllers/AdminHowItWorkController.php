<?php 
namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class AdminHowItWorkController extends \crocodicstudio\crudbooster\controllers\CBController {

    public function __construct() {
        $this->table              = "how_it_work";
        $this->primary_key        = "id";
        $this->title_field        = "content";
        $this->limit              = 20;
        $this->index_orderby      = ["id"=>"desc"];
        $this->button_show_data   = true;        
        $this->button_new_data    = true;
        $this->button_delete_data = false;
        $this->button_sort_filter = false;        
        $this->button_export_data = false;
        $this->button_table_action = true;
        $this->button_import_data = false;

        $this->col = array();
        $this->col[] = array("label"=>"Icon","name"=>"icon" );
		$this->col[] = array("label"=>"Content","name"=>"content" );

		$this->form = array();
		$this->form[] = array("label"=>"Content","name"=>"content","type"=>"text","required"=>TRUE,"validation"=>"required|min:3|max:255");
        if(Request::segment(3) == 'edit'){
        $check = DB::table('how_it_work')->where('id',Request::segment(4))->first();
        $html ="
                <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.10/css/all.css' integrity='sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg' crossorigin='anonymous'>
                    <label>Icon</label><br>";
        if($check->icon == 'far fa-thumbs-up'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='far fa-thumbs-up'> <i class='far fa-thumbs-up'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-thumbs-up'> <i class='far fa-thumbs-up'></i></div></label>";
        }
        if($check->icon == 'far fa-star'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='far fa-star'> <i class='far fa-star'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-star'> <i class='far fa-star'></i></div></label>";
        }
        if($check->icon == 'far fa-comment-alt'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='far fa-comment-alt'> <i class='far fa-comment-alt'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-comment-alt'> <i class='far fa-comment-alt'></i></div></label>";
        }
        if($check->icon == 'fas fa-address-book'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='fas fa-address-book'> <i class='fas fa-address-book'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-address-book'> <i class='fas fa-address-book'></i></div></label>";
        }
        if($check->icon == 'fab fa-angellist'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='fab fa-angellist'> <i class='fab fa-angellist'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='fab fa-angellist'> <i class='fab fa-angellist'></i></div></label>";
        }
        if($check->icon == 'fas fa-american-sign-language-interpreting'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='fas fa-american-sign-language-interpreting'> <i class='fas fa-american-sign-language-interpreting'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-american-sign-language-interpreting'> <i class='fas fa-american-sign-language-interpreting'></i></div></label>";
        }
        if($check->icon == 'fas fa-align-justify'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='fas fa-align-justify'> <i class='fas fa-align-justify'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-align-justify'> <i class='fas fa-align-justify'></i></div></label>";
        }
        if($check->icon == 'fas fa-chart-line'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='fas fa-chart-line'> <i class='fas fa-chart-line'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-chart-line'> <i class='fas fa-chart-line'></i></div></label>";
        }
        if($check->icon == 'far fa-bookmark'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='far fa-bookmark'> <i class='far fa-bookmark'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-bookmark'> <i class='far fa-bookmark'></i></div></label>";
        }
        if($check->icon == 'far fa-calendar-alt'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='far fa-calendar-alt'> <i class='far fa-calendar-alt'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-calendar-alt'> <i class='far fa-calendar-alt'></i></div></label>";
        }
        if($check->icon == 'fas fa-check'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='fas fa-check'> <i class='fas fa-check'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-check'> <i class='fas fa-check'></i></div></label>";
        }
        if($check->icon == 'fas fa-book'){
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' checked value='fas fa-book'> <i class='fas fa-book'></i></div></label>";
        }else{
            $html .=  "<label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-book'> <i class='fas fa-book'></i></div></label>";
        }
                 

        }else{
        $html = "
                <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.10/css/all.css' integrity='sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg' crossorigin='anonymous'>
                    <label>Icon</label><br>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-thumbs-up'> <i class='far fa-thumbs-up'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-star'> <i class='far fa-star'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-comment-alt'> <i class='far fa-comment-alt'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-address-book'> <i class='fas fa-address-book'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='fab fa-angellist'> <i class='fab fa-angellist'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-american-sign-language-interpreting'> <i class='fas fa-american-sign-language-interpreting'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-align-justify'> <i class='fas fa-align-justify'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-chart-line'> <i class='fas fa-chart-line'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-bookmark'> <i class='far fa-bookmark'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='far fa-calendar-alt'> <i class='far fa-calendar-alt'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-check'> <i class='fas fa-check'></i></div></label>
                 <label><div class='col-sm-2'><input type='radio' name='icon' value='fas fa-book'> <i class='fas fa-book'></i></div></label>";
        }
        $this->form[] = array("label"=>"Icon","name"=>"icon","type"=>"upload","required"=>TRUE);

        // $this->form[] = array("label"=>"Icon","type"=>"html","html"=>$html);
     

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
        $update['icon'] = Request::get('icon');

        DB::table('how_it_work')->where('id',$id)->update($update);
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