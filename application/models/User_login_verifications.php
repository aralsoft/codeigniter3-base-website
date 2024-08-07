<?php

class User_login_verifications extends MY_Model {

    public function __construct()
    {
        parent::__construct('user_login_verifications');
    }

    public function getByCode($code)
    {
        $this->db->where('code', $code);
        $this->db->where('status', 1);

        return $this->getRow();
    }
    
    public function deactivate($code)
    {
        return $this->update($code, array('status' => 2));
    }
    
}