<?php

class Constants extends MY_Model {

    public function __construct()
    {
        parent::__construct('constants');
    }

    public function getByName($name)
    {
        $this->db->where('name', $name);

        return $this->getRow();
    }



    
}