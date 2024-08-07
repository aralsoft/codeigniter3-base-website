<?php
class User_facebook_link extends MY_Model 
{

    public function __construct()
    {
            parent::__construct('user_facebook_link');
    }


    public function get_facebook_user($id)
    {
        $this->db->where('id', $id);

        return $this->getRow();
    }

    public function create_facebook_user_link($data) 
    {
        return $this->insert($data);
    }
    
    
} 
?>
