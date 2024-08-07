<?php

use Google\Cloud\Translate\V2\TranslateClient;

class Utilities extends MY_Controller {

    /**
    * Default Method
    */
    public function index()
    {

        $this->load->view('index', $this->viewData);
    }

    /**
     *
     */
    public function translate_site()
    {


        $this->load->view('index', $this->viewData);
    }

    /**
     *
     */

}
