<?php

class Members extends MY_Controller {

    /**
    * Default Method
    */
    public function index()
    {

        $this->load->view('index', $this->viewData);
    }

    /**
     * Show users
     */
    public function list_users()
    {
        if (!$mode = $this->uri->segment(4)) {
            $mode = 1;
        }

        $table = array(
            'columns' => array(
                'id' => '',
                'email' => '',
                'nick_name' => '',
                'first_name' => '',
                'last_name' => '',
                'add_date' => array('format' => 'date'),
                'last_login_date' => array('format' => 'date'),
            ),
            'actions' => array(
                0 => array('class' => 'primary', 'link' => '/admin/members/login_user', 'text' => 'login')
            )
        );

        switch ($mode)
        {
            case 2 :
                $users = $this->Users->get_inactive_users();
                $this->messages->addMessage('blocked_users', 'danger');
                $table['actions'][1] = array('class' => 'success', 'link' => '/admin/restore_user', 'text' => 'restore');
                $table['actions'][2] = array('class' => 'danger', 'link' => '/admin/delete_user', 'text' => 'delete');
                break;

            case 3 :
                $users = $this->Users->get_unverified_users();
                $this->messages->addMessage('unverified_users', 'warning');
                $table['actions'][1] = array('class' => 'danger', 'link' => '/admin/delete_user', 'text' => 'delete');
                break;

            default :
                $users = $this->Users->get_active_users();
                $this->messages->addMessage('active_users', 'info');
                $table['actions'][1] = array('class' => 'danger', 'link' => '/admin/block_user', 'text' => 'block');
        }

        $table['data'] = $users;

        $this->load->library('tables', $table);

        $this->load->view('index', $this->viewData);
    }

    /**
     * List User Logs
     */
    public function user_logs()
    {






        $this->load->view('index', $this->viewData);
    }

    /**
     *
     */
    public function login_user()
    {
        if ($user_id = $this->uri->segment(4)) {
            if ($user = $this->Users->get($user_id)) {
                if ($this->user->logIn($user['id'], $user['email'])) {
                    redirect('/dashboard');
                }
            }
        }

        $this->processError("Could not login as user: ".$user_id);
    }
}
