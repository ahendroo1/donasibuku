<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiPageController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "cms_pages";        
        $this->permalink = "page";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called

    }

    public function hook_query(&$query) {
        //You can custom the api query 

    }

    public function hook_after($postdata,&$result) {
        //Code here if you want execute some action after API Query Called

    }

}