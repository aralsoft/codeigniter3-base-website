<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

    /**
    * Controller 
    */
    public function index()
    {
        $return = array();

        echo json_encode($return);
        exit;
    }

}

?>