<?php

class Users extends MY_Model {

    // Object constants
    const TYPE_ADMIN = 1;
    const TYPE_NORMAL = 2;

    const STATUS_INACTIVE = 0;
    const STATUS_UNVERIFIED = 1;
    const STATUS_VERIFIED = 2;

    public function __construct()
    {
        parent::__construct('users');
    }

    public function user_login($data)
    {
        $this->db->where('email', $data['email']);
        $this->db->where('password', md5($data['password']));
        $this->db->where('status != ', self::STATUS_INACTIVE);

        return $this->getRow();
    }

    public function insert_user($data)
    {
        $addData = $this->formatData($data);

        if (!isset($addData['nick_name']) || !$addData['nick_name']) {
            $addData['nick_name'] = substr($addData['email'], 0, strpos($addData['email'], '@'));
        }

        $addData['type'] = self::TYPE_NORMAL;
        $addData['status'] =  self::STATUS_UNVERIFIED;

        return $this->insert($addData);
    }

    public function update_user($id, $data)
    {
        $updateData = $this->formatData($data);

        return $this->update($id, $updateData);
    }

    public function get_active_users()
    {
        $this->db->where('type', self::TYPE_NORMAL);
        $this->db->where('status', self::STATUS_VERIFIED);

        return $this->getRows();
    }

    public function get_active_user($id)
    {
        $this->db->where('id', $id);
        $this->db->where('status', self::STATUS_VERIFIED);

        return $this->getRow();
    }

    public function get_inactive_users()
    {
        $this->db->where('type', self::TYPE_NORMAL);
        $this->db->where('status', self::STATUS_INACTIVE);

        return $this->getRows();
    }

    public function get_unverified_users()
    {
        $this->db->where('type', self::TYPE_NORMAL);
        $this->db->where('status', self::STATUS_UNVERIFIED);

        return $this->getRows();
    }

    public function get_user_by_email($email = FALSE)
    {
        $this->db->where('email', $email);
        $this->db->where('status != ', self::STATUS_INACTIVE);

        return $this->getRow();
    }

    public function get_affiliates($affiliate_id)
    {
        $this->db->where('affiliate_id', $affiliate_id);
        $this->db->where('type', self::TYPE_NORMAL);
        $this->db->where('status', self::STATUS_VERIFIED);

        return $this->getRows();
    }

    public function email_exists($email)
    {
        $this->db->where('email', $email);

        return $this->getRow();
    }
    
    public function update_user_password($id, $password)
    {
        return $this->update($id, array('password' => md5($password)));
    }
    
    public function verify($id)
    {
        return $this->update($id, array('status' => self::STATUS_VERIFIED));
    }
    
    public function check_password($id, $oldpassword)
    {
        $password = md5($oldpassword);
        
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $this->db->where('password', $password);
        
        if ($this->db->count_all_results()) {
            return TRUE;
        }
        
        return FALSE;
    }

    public function formatData($data)
    {
        $adata = array();

        foreach($data as $key => $value)
        {
            $value = trim($value);

            switch ($key)
            {
                case 'email' :
                    $adata[$key] = strtolower($value);
                    break;

                case 'password' :
                    if ($value) {
                        $adata[$key] = md5($value);
                    } else {
                        $adata[$key] = md5('password'.time().rand(1000,9999));
                    }

                    break;

                default :
                    $adata[$key] = $value;
            }
        }

        return $adata;
    }
    
}