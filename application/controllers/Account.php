<?php

class Account extends MY_Controller
{
    /**
     * Account Controller
     */
    public function index()
    {
        $form = array(
            'fields' => array(
                'email' => array('type' => 'text', 'validation' => 'trim|required|valid_email'),
                'password' => array('type' => 'password', 'validation' => 'trim|required|min_length[6]|max_length[16]'),
                'g-recaptcha' => array('type' => 'g-recaptcha')
            ),
            'buttons' => array(
                'submit' => 'login'
            )
        );

        $this->load->library('forms', $form);

        $this->forms->addElements($this->input->post());

        if ($this->form_validation->run())
        {
            $captcha_result = prepareGoogleCaptcha();

            if ($captcha_result)
            {
                if ($user = $this->Users->user_login($this->input->post())) {
                    if ($this->user->logIn($user['id'], $user['email'])) {
                        redirect('/');
                    }
                }
                $this->messages->addMessage('login_failed');
            } else {
                $this->messages->addMessage('google_captcha_failed');
            }
        } else {
            $this->messages->addMessage($this->input->post());
        }

        $this->load->view('index', $this->viewData);
    }

    /**
     * User registration.
     **/
    public function register()
    {
        $this->load->model('User_email_verifications');
        $this->load->helper('user');

        // Set parameters
        $affiliate_id = $this->uri->segment(3, 0);

        $form = array(
            'fields' => array(
                'email' => array('type' => 'text', 'validation' => 'trim|required|valid_email'),
                'password' => array('type' => 'password', 'validation' => 'trim|required|min_length[6]|max_length[16]'),
                'first_name' => array('type' => 'text', 'validation' => 'trim|required'),
                'last_name' => array('type' => 'text', 'validation' => 'trim|required'),
                'spam' => array('type' => 'checkbox'),
                'g-recaptcha' => array('type' => 'g-recaptcha'),
                'affiliate_id' => array('type' => 'hidden')
            ),
            'buttons' => array(
                'submit' => 'register'
            )
        );

        $this->load->library('forms', $form);

        if (count($this->input->post())) {
            $this->forms->addElements($this->input->post());
        } else {
            $this->forms->addElements(array('affiliate_id' => $affiliate_id));
        }

        if ($this->form_validation->run())
        {
            if (!$this->Users->email_exists($this->input->post('email')))
            {
                $captcha_result = prepareGoogleCaptcha();

                if ($captcha_result)
                {
                    $newUser = $this->input->post();

                    if ($userid = $this->Users->insert_user($newUser))
                    {
                        $this->User_attributes->addDefaultValues($userid);

                        sendVerificationEmail($userid, $newUser['email']);

                        redirect('/dashboard');
                    }
                    else {
                        $this->processError("Could not create user.");
                    }
                } else {
                    $this->messages->addMessage('google_captcha_failed');
                }
            } else {
                $this->messages->addMessage('email_already_exists');
            }
        } else {
            $this->messages->addMessage($this->input->post());
        }

        $this->messages->addMessage('login_or_register', 'info');

        $this->load->view('index', $this->viewData);
    }

    public function email_verification_final()
    {
        $this->load->model('User_email_verifications');
        $verify_code = $this->uri->segment(3);

        if ($verification = $this->User_email_verifications->getByCode($verify_code)) {
            if ($user = $this->Users->get($verification['user_id'])) {
                if ($this->Users->verify($user['id']))
                {
                    $this->User_email_verifications->verify($user['id']);

                    if ($this->user->logIn($user['id'], $user['email'])) {
                        $this->messages->addMessage('verification_success', 'success');
                    } else {
                        $this->messages->addMessage('login_failed');
                    }
                }
                else {
                    $this->processError("Unable to update user status.");
                }
            } else {
                $this->processError("Invalid User. Unable to verify.");
            }
        } else {
            $this->messages->addMessage('verification_failed');
        }

        $this->load->view('index', $this->viewData);
    }

    /**
     * Forgot Password
     */
    public function forgot_password()
    {
        $this->load->model('User_password_reset');

        $form = array(
            'fields' => array(
                'email' => array('type' => 'text', 'validation' => 'trim|required|valid_email'),
            ),
            'buttons' => array(
                'submit' => 'send_password_reset_link'
            )
        );

        $this->load->library('forms', $form);

        $this->forms->addElements($this->input->post());

        if ($this->form_validation->run() == TRUE) {
            $screenEmail = $this->input->post('email');

            if ($user = $this->Users->get_user_by_email($screenEmail))
            {
                $emailParams = array(
                    'to' => $screenEmail,
                    'type' => 'recover_password',
                    'pass_reset' => array(
                        'user_id' => $user['id'],
                        'verify_code' => md5($user['id'] . $screenEmail . time() . rand(1000, 9999))
                    )
                );

                if ($this->User_password_reset->insertNew($emailParams['pass_reset'])) {
                    $this->ses->sendMyEmail($emailParams, $user['id']);
                    $this->messages->addMessage('password_reset_sent', 'success');
                } else {
                    $this->CI->processError("Could not create password reset record.");
                }

                $this->viewData['viewPage'] = FALSE;
            } else {
                $this->messages->addMessage('email_not_found');
            }
        } else {
            $this->messages->addMessage($this->input->post());
        }

        $this->load->view('index', $this->viewData);
    }

    public function forgot_password_final()
    {
        $form = array(
            'fields' => array(
                'new_password' => array('type' => 'password', 'validation' => 'trim|required|min_length[6]|max_length[16]'),
                'password_confirm' => array('type' => 'password', 'validation' => 'trim|required|matches[new_password]'),
                'verify_code' => array('type' => 'hidden')
            ),
            'buttons' => array(
                'submit' => 'change_password'
            )
        );

        $this->load->library('forms', $form);
        $this->load->model('User_password_reset');

        if (!$verifyCode = $this->uri->segment(3)) {
            $verifyCode = $this->input->post('verify_code');
        }

        if (!$passReset = $this->User_password_reset->getByCode($verifyCode)) {
            $this->messages->addMessage('password_reset_code_invalid');
        } else {
            if ($this->input->post('submit'))
            {
                $this->forms->addElements($this->input->post());

                if ($this->form_validation->run() == TRUE) {
                    if ($this->Users->update_user_password($passReset['user_id'], $this->input->post('new_password'))) {
                        $this->User_password_reset->process($passReset['user_id']);
                        $this->messages->addMessage('password_changed', 'success');

                        $this->viewData['viewPage'] = FALSE;
                    } else {
                        $this->processError("Unable to update password.");
                    }
                } else {
                    $this->messages->addMessage($this->input->post());
                }
            } else {
                $this->forms->addElements(array('verify_code' => $verifyCode));
            }
        }

        $this->load->view('index', $this->viewData);
    }

    // Logout user
    public function logout()
    {   
        $this->user->logOut();
        
        redirect("/");
    }

    // Resend verification link
    public function resendVerificationLink()
    {
        $this->load->helper('user');

        sendVerificationEmail();

        redirect($this->goBackLink);
    }

    // Opt out of emails
    public function unsubscribe()
    {
        if ($this->Users->update_user($this->user->getId(), array('spam' => 0)))
        {
            $this->messages->addMessageToSession('user_updated');
            redirect('/dashboard');
        }

        $this->processError("Error: Unable to unsubscribe. Please contact support.");
    }
    
}
