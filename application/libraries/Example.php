<?php

class Example
{
    // CodeIgniter super-object
    protected $CI;
    
    // Constructor function
    public function __construct()
    {   
        $this->CI =& get_instance();



    }

    // First Class function
    public function first()
    {


        return TRUE;
    }

}