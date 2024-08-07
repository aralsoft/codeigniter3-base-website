<?php

class User_password_reset extends MY_Model {

    // Object constants
    const STATUS_NEW = 0;
    const STATUS_PROCESSED = 1;

    public function __construct()
    {
            parent::__construct('user_password_reset');
    }

    public function insertNew($data)
    {
        $data['status'] = self::STATUS_NEW;
        
        return $this->replace($data);
    }

    public function getByCode($code)
    {
        if ($code)
        {
            $this->db->where('verify_code', $code);
            $this->db->where('status', self::STATUS_NEW);
            $this->db->where('add_date >', date("Y-m-d H:i:s", strtotime("now -1 day")));

            return $this->getRow();
        }
        
        return FALSE;
    }

    public function process($id)
    {
        return $this->update($id, array('status' => self::STATUS_PROCESSED));
    }
    
    
}

?>