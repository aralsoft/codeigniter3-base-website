<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller
{
    /**
     * Index Page for home page.
    **/
    public function index()
    {
        $this->viewData['homeImages'] = array(1 => 'home-join.png', 2 => 'home-connect.png', 3 => 'home-socialise.png');

        $this->load->view('index', $this->viewData);
    }

    public function change_language()
    {
        if ($this->uri->segment(3) && in_array($this->uri->segment(3), $this->config->item('languages'))) {
            $this->session->set_userdata('language', $this->uri->segment(3));
        }

        redirect($this->goBackLink);
    }

}