<?php

class User_attributes extends MY_Model
{
    // Object constants
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function __construct()
    {
        parent::__construct('user_attributes');
    }

    public function getAttributes($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', self::STATUS_ACTIVE);

        return $this->getRows();
    }

    public function getAttribute($user_id, $attribute)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('name', $attribute);

        return $this->getRow();
    }

    public function replaceAll($user_id, $data)
    {
        foreach ($data AS $name => $value) {
            $this->replace(array('user_id' => $user_id, 'name' => $name, 'value' => $value));
        }

        return TRUE;
    }

    public function addDefaultValues($user_id)
    {
        //$this->replace(array('user_id' => $user_id, 'name' => 'cancel_old_orders', 'value' => '1'));
    }

}
