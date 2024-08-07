<?php

class Affiliates extends MY_Model {

    public function __construct()
    {
        parent::__construct('affiliates');
    }

    public function getByUser($user)
    {
        $this->db->where('user_id', $user);

        return $this->getRow();
    }

}