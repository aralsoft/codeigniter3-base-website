<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logging
{
    // Object properties
    protected $controller = '';

    // CodeIgniter super-object
    protected $CI;
    
    // Constructor function
    public function __construct($params = [])
    {   
        $this->CI =& get_instance();

        $this->CI->load->model('Logs');

        if (isset($params['controller'])) {
            $this->controller = $params['controller'];
        }
    }

    public function logAction($message)
    {
        $data = [
            'controller' => $this->controller,
            'message' => $message
        ];

        $this->CI->Logs->insert($data);
    }

}