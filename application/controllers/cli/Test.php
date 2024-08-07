<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller
{
    // Initial class function
    public function __construct()
    {
        parent::__construct(TRUE, 'test.lock');

    }

    /**
     * Index Page for this controller.
    **/
    public function index()
    {


    }

}
