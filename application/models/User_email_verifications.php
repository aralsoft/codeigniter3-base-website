<?php

class User_email_verifications extends MY_Model {

    // Object constants
    const STATUS_NEW = 1;
    const STATUS_PROCESSED = 2;

    public function __construct()
    {
            parent::__construct('user_email_verifications');
    }

    public function getByCode($code)
    {
        $this->db->where('verify_code', $code);
        $this->db->where('status', self::STATUS_NEW);

        return $this->getRow();
    }

    public function verify($userid)
    {
        return $this->update($userid, array('status' => self::STATUS_PROCESSED));
    }

    public function refresh($data)
    {
        $data['add_date'] = date("Y-m-d H:i:s");

        return $this->replace($data);
    }
    
}