<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiTbmRequestController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "tbm_req";        
        $this->permalink = "tbm_request";    
        $this->method_type = "get";    
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