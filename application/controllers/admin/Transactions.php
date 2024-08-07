<?php

class Transactions extends MY_Controller {

    /**
    * Default Method
    */
    public function index()
    {

        $this->load->view('index', $this->viewData);
    }

    /**
     * Show users
     */
    public function list_transactions()
    {

        $this->load->view('index', $this->viewData);
    }

}
