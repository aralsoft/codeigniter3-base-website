<?php
class User_instagram_link extends MY_Model 
{

    public function __construct()
    {
        parent::__construct('user_instagram_link');
    }


    public function get_user_by_instagram_id($id)
    {
        $this->db->where('instagram_user_id', $id);

        return $this->getRow();
    }


    public function get_user_by_user_id($id)
    {
        $this->db->where('user_id', $id);

        return $this->getRow();
    }


    public function create_user_link($data) 
    {
        return $this->insert($data);
    }

	
} 
?>