<?php

class Dashboard extends MY_Controller
{
    // Default method
    public function index()
    {


        $this->load->view('index', $this->viewData);
    }

    // Update user details
    public function update()
    {
        $form = array(
            'fields' => array(
                'first_name' => array('type' => 'text', 'validation' => 'trim|required'),
                'last_name' => array('type' => 'text', 'validation' => 'trim|required'),
                'spam' => array('type' => 'checkbox')
            ),
            'buttons' => array(
                'submit' => 'update',
                'cancel' => 'go_back'
            )
        );

        $this->load->library('forms', $form);
        
        if ($this->input->post('submit'))
        {
            $this->forms->addElements($this->input->post());

            if ($this->form_validation->run())
            {
                if ($this->Users->update_user($this->user->getId(), prepareInputForDatabase($form['fields'], $this->input->post()))) {
                    $this->messages->addMessageToSession('user_updated');
                } else {
                    $this->messages->addMessageToSession('user_not_updated', 'danger');
                }

                redirect('/dashboard');
            }
            else {
                $this->messages->addMessage($this->input->post());
            }
        }
        else {
            $this->forms->addElements($this->user->getUserDataArray());
        }

        $this->load->view('index', $this->viewData);
    }
    
    // Upload photo
    public function upload_photo()
    {
        $form = array(
            'cols' => 12,
            'attrs' => array(
                'enctype' => 'multipart/form-data'
            ),
            'fields' => array(
                'userfile' => array('type' => 'file')
            ),
            'buttons' => array(
                'submit' => 'upload_photo',
                'cancel' => 'cancel'
            )
        );

        $this->load->library('forms', $form);
        
        $this->forms->addElements();
        
        if ($this->input->post('submit'))
        {
            $this->config->load('file_upload');
            
            $upload_config = $this->config->item('file_upload');
            $upload_config['file_name'] = $this->user->getId().'_profile';

            $this->load->library('upload', $upload_config);
        
            if ($this->upload->do_upload('userfile'))
            {
                $filename = $this->upload->data('file_name');
                
                $this->config->load('image_manipulation');
                
                $image_config = $this->config->item('image_manipulation'); 
                $image_config['source_image'] = $image_config['source_image'].$filename;
                $image_config['new_image'] = $image_config['new_image'].$filename;
              
                $this->load->library('image_lib', $image_config);

                if ($this->image_lib->resize())
                {
                    if ($this->Users->update_user($this->user->getId(), array('image' => $filename))) {
                        $this->messages->addMessageToSession('user_updated');
                    } else {
                        $this->messages->addMessageToSession('user_not_updated', 'danger');
                    }

                    redirect('/dashboard');
                }
                else {
                    $this->messages->addMessage($this->image_lib->display_errors('', ''));
                }
            }
            else {
                $this->messages->addMessage($this->upload->display_errors('', ''));
            }  
        }
            
        $this->messages->addMessage('photo_upload_info' ,'info');
        
        $this->load->view('index', $this->viewData);
    }    

    // Change password
    public function change_password()
    {
        $form = array(
            'fields' => array(
                'password' => array('type' => 'password', 'validation' => 'trim|required|min_length[6]|max_length[16]'),
                'new_password' => array('type' => 'password', 'validation' => 'trim|required|min_length[6]|max_length[16]'),
                'password_confirm' => array('type' => 'password', 'validation' => 'trim|required|matches[new_password]')
            ),
            'buttons' => array(
                'submit' => 'change_password',
                'cancel' => 'cancel'
            )
        );

        $this->load->library('forms', $form);

        $this->forms->addElements($this->input->post());
        
        if ($this->form_validation->run() == TRUE) {
            if ($this->Users->check_password($this->user->getId(), $this->input->post('password'))) {
                 if ($this->Users->update_user_password($this->user->getId(), $this->input->post('new_password')))
                 {
                    $emailParams = array(
                        'to' => $this->user->getEmail(),
                        'type' => 'change_password'
                    );

                    $this->ses->sendMyEmail($emailParams);

                    $this->messages->addMessage('password_changed', 'success');
                    $this->viewData['viewPage'] = FALSE;
                 } else {
                    $this->processError("Unable to update password."); 
                 }
             } else {
                $this->messages->addMessage('old_password_invalid');
             } 
        } else {
            $this->messages->addMessage($this->input->post());
        }
        
        $this->load->view('index', $this->viewData);
    }

    // List all bets for user
    public function transactions()
    {
        $this->load->helper('table');

        $table = array();

        $this->viewData['pages'] = createViewTable($table);

        $this->messages->addMessage('list_transactions', 'info');

        $this->load->view('index', $this->viewData);
    }

    // Update betting options
    public function options()
    {
        $form = array(
            'fields' => array(
                'spam' => array('type' => 'checkbox')
            ),
            'buttons' => array(
                'submit' => 'update',
                'cancel' => 'go_back'
            )
        );

        $this->load->library('forms', $form);

        if ($this->input->post('submit'))
        {
            $this->forms->addElements($this->input->post());

            if ($this->Users->update($this->user->getId(), prepareInputForDatabase($form['fields'], $this->input->post()))) {
                $this->messages->addMessage('options_updated', 'success');
            } else {
                $this->messages->addMessage('update_failed');
            }
        }
        else {
            $this->forms->addElements(array('spam' => $this->user->getSpam()));
        }

        $this->load->view('index', $this->viewData);
    }

    // Affiliate dashboard
    public function affiliate()
    {
        $table = array(
            'columns' => array(
                'id' => '',
                'nick_name' => '',
                'add_date' => array('format' => 'date'),
                'last_login_date' => array('format' => 'date'),
            )
        );

        $table['data'] = $this->Users->get_affiliates($this->user->isAffiliate());

        $this->load->library('tables', $table);

        $this->messages->addMessage('affiliates_list', 'info', ['base_url' => $this->config->item('base_url'), 'affiliate_code' => $this->user->isAffiliate()]);

        $this->load->view('index', $this->viewData);
    }

    // Become an affiliate
    public function become_affiliate()
    {
        $form = array(
            'fields' => array(
                'become_affiliate_approve' => array('type' => 'checkbox')
            ),
            'buttons' => array(
                'submit' => 'update',
                'cancel' => 'go_back'
            )
        );

        $this->load->library('forms', $form);

        if ($this->input->post('submit'))
        {
            if ($this->input->post('become_affiliate_approve')) {
                if ($this->Affiliates->insert(array('user_id' => $this->user->getId()))) {
                    $this->messages->addMessage('added_as_affiliate', 'success');
                } else {
                    $this->messages->addMessage('update_failed');
                }
            } else {
                $this->forms->addElements(array('become_affiliate_approve' => 0));
            }
        }
        else
        {
            if (!$this->user->isAffiliate()) {
                $this->forms->addElements(array('become_affiliate_approve' => 0));
            } else {
                redirect('/dashboard/affiliate');
            }
        }

        $this->load->view('index', $this->viewData);
    }


}
