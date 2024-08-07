<?php

class User
{
    // Object properties
    protected $id = 0;
    protected $email = FALSE;
    protected $nick_name = '';
    protected $first_name = '';
    protected $last_name = '';
    protected $gender = '';
    protected $country = '';
    protected $image = '';
    protected $type = 0;
    protected $status = 0;
    protected $spam = 0;
    protected $affiliate_id = 0;
    protected $add_date = '';
    protected $last_login_date = '';
    protected $attributes = array();

    protected $userSessionData = array(
        'email',
        'subDir',
        'controller',
        'method',
        'urlParameters',
        'goBackLink',
        'full_url',
        'twitter_auth'
    );

    // CodeIgniter super-object
    protected $CI;
    
    // Constructor function
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();

        /* $this->CI->load->model('User_attributes'); */

        $this->getPropertyData();
    }

    // login user
    public function logIn($id, $email)
    {   
        if ($this->CI->Users->update_user($id, array('last_login_date' => date("Y-m-d H:i:s"))))
        {
            $this->CI->session->set_userdata('email',  $email);
            $this->getPropertyData();

            return TRUE;
        }
        
        return FALSE;
    }

    public function logOut()
    {
        $this->CI->session->unset_userdata($this->userSessionData);
    }
    
    public function isLoggedIn()
    {
        if ($this->email && $this->email == $this->CI->session->userdata('email')) {
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function isVerified()
    {
        if ($this->status == 2) {
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function isAdmin()
    {
        if ($this->type == 1) {
            return TRUE;
        }
        
        return FALSE;
    }

    public function isAffiliate()
    {
        if ($affiliate = $this->CI->Affiliates->getByUser($this->id)) {
            return $affiliate['id'];
        }

        return FALSE;
    }
    
    public function getId()
    {
        return $this->id; 
    }
    
    public function getEmail()
    {
        return $this->email; 
    }

    public function getNickName()
    {
        if ($this->nick_name) {
            return $this->nick_name;
        }

        return $this->getEmail();
    }

    public function getFirstName()
    {
        return $this->first_name; 
    }
    
    public function getLastName()
    {
        return $this->last_name; 
    }

    public function getGender()
    {
        if (!$this->gender) {
            return 'M';
        }

        return $this->gender;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getImage()
    {
        if ($this->image) {
            if (strpos($this->image, 'http') === FALSE) {
                if (file_exists(SITEDIRECTORY.'/img/users/profile/'.$this->image)) {
                    return '/img/users/profile/'.$this->image;
                }

                return '/img/users/profile/default-avatar-'.strtolower($this->getGender()).'.png';
            }
        } else {
            return '/img/users/profile/default-avatar-'.strtolower($this->getGender()).'.png';
        }

        return $this->image;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getStatus()
    {
        return $this->status; 
    }

    public function getSpam()
    {
        return $this->spam;
    }

    public function getAffiliateId()
    {
        return $this->affiliate_id;
    }

    public function getAddDate()
    {
        return $this->add_date; 
    }
    
    public function getLastLoginDate()
    {
        return $this->last_login_date; 
    }

    public function getFullName()
    {
        if ($fullName = trim($this->getFirstName().' '.$this->getLastName())) {
            return $fullName;
        }

        return $this->getNickName();
    }

    public function getLongGender()
    {
        if ($this->gender == 'M') {
            return $this->CI->getLanguageText("male");
        }

        if ($this->gender == 'F') {
            return $this->CI->getLanguageText("female");
        }

        return '';
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getUserDataArray()
    {
        return array(
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'spam' => $this->getSpam()
        );
    }

    public function getPropertyData()
    {
        // Get user data from DB
        if ($userData = $this->CI->Users->get_user_by_email($this->CI->session->userdata('email')))
        {
            // Move passed data into object properties
            foreach($userData as $key => $val) {
                if (isset($this->{$key}) && $val) {
                    $this->{$key} = $val;
                }
            }

/*
            if ($userAttrs = $this->CI->User_attributes->get_user_attributes($this->id)) {
                foreach ($userAttrs AS $userAttr) {
                    $this->attributes[$userAttr['name']] = $userAttr['value'];
                }
            }
*/
        }

    }

}
