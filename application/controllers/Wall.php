<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wall extends MY_Controller
{
    /**
     * Index Page for this controller.
    **/
    public function index()
    {

        
        $this->load->view('index', $this->viewData);
    }


    public function analysis()
    {

        
        $this->load->view('index', $this->viewData);
    }

}
