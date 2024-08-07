<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends MY_Controller {

    /**
    * Controller 
    */
    public function index()
    {   
        $this->load->view('index', $this->viewData);
    }
    
    /**
    * Controller 
    */
    public function content()
    {
        if (isset($this->inputParameters['contentid']) && $this->inputParameters['contentid']) {
            $this->viewData['pageData'] = getLanguageLine("content_{$this->inputParameters['contentid']}");
        }
        
        $this->load->view('index', $this->viewData);
    }


    public function contact()
    {
        $form = array(
            'attrs' => array(
                'name' => 'contact'
            ),
            'fields' => array(
                'full_name' => array('type' => 'text', 'validation' => 'trim|required|max_length[80]|regex_match[/^[a-z ,.\'-]+$/i]'),
                'email' => array('type' => 'text', 'validation' => 'trim|required|valid_email'),
                'message' => array('type' => 'textarea', 'validation' => 'trim|required', 'attrs' => array('rows' => 10)),
                'g-recaptcha' => array('type' => 'g-recaptcha')
            ),
            'buttons' => array(
                'submit' => 'send_message'
            )
        );

        $this->load->library('forms', $form);

        if ($this->input->post('submit')) {
            $this->forms->addElements($this->input->post());

            if ($this->form_validation->run())
            {
                $captcha_result = prepareGoogleCaptcha();

                if ($captcha_result)
                {
                    $emailParams = array(
                        'to' => $this->config->item('support_email'),
                        'type' => 'contact',
                        'user_name' => $this->input->post('full_name'),
                        'user_message' => $this->input->post('message'),
                        'replyto' => $this->input->post('email')
                    );

                    $this->ses->sendMyEmail($emailParams);

                    $this->messages->addMessage('support_email_sent', 'success');
                    $this->viewData['viewPage'] = FALSE;
                } else {
                    $this->messages->addMessage('google_captcha_failed');
                }
            } else {
                $this->messages->addMessage($this->input->post());
            }
        } else {
            if ($this->user->isLoggedIn()) {
                $this->forms->addElements(array('full_name' => $this->user->getFullName(), 'email' => $this->user->getEmail()));
            } else {
                $this->forms->addElements();
            }
        }

        $this->load->view('index', $this->viewData);
    }
    
}

?>