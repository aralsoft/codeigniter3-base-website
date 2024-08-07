<?php

class Welcome extends MY_Controller {

    /**
    * Default Method
    */
    public function index()
    {

        $this->load->view('index', $this->viewData);
    }

    public function optimize_database()
    {
        $this->load->dbutil();

        $results = $this->dbutil->optimize_database();

        $viewData = array(
            'pagetitle' => 'Block Bet Admin - Optimize Database',
            'optimizedatabase' => 1,
            'optimizedatabaseresults' => $results
        );

        $this->load->view('welcome', $viewData);
    }

}
