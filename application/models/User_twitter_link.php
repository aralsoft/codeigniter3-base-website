<?php
class User_twitter_link extends MY_Model 
{

    public function __construct()
    {
        parent::__construct('user_twitter_link');
    }


    public function get_user_by_twitter_id($id)
    {
        $this->db->where('twitter_user_id', $id);

        return $this->getRow();
    }


    public function create_user_link($data) 
    {
        return $this->insert($data);
    }

	
} 
?>