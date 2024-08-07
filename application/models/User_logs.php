<?php

class User_logs extends MY_Model {

    public function __construct()
    {
        parent::__construct('user_logs');
    }

    public function get_user_logs($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('add_date', 'DESC');

        return $this->getRows();
    }

}