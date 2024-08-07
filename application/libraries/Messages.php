<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages
{
    // Object properties
    public $messagesByType = array(
        'danger' => '',
        'info' => '',
        'success' => '',
        'warning' => '',
        'primary' => '',
        'secondary' => '',
        'light' => '',
        'dark' => ''
    );

    public $messageIcons = array(
        'danger' => 'glyphicon glyphicon-exclamation-sign',
        'info' => 'glyphicon glyphicon-info-sign',
        'success' => 'glyphicon glyphicon-ok-sign',
        'warning' => 'glyphicon glyphicon-question-sign',
        'primary' => 'glyphicon glyphicon-bell',
        'secondary' => 'glyphicon glyphicon-bell',
        'light' => 'glyphicon glyphicon-bell',
        'dark' => 'glyphicon glyphicon-bell'
    );

    // CodeIgniter super-object
    protected $CI;

    // Constructor function
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->loadLanguageFile('library/messages');
    }

    public function render()
    {
        if ($sessionMessages = $this->CI->session->userdata('messages'))
        {
            foreach ($sessionMessages as $id => $value) {
                $this->addMessage($id, $value['msgType'], $value['msgParameters']);
            }

            $this->CI->session->unset_userdata('messages');
        }

        foreach ($this->messagesByType as $messageType => $message) {
            if (trim($message)) {
                echo '<div class="alert alert-' . $messageType . '"><p class="d-flex">' . $message . '</p></div>';
            }
        }


    }

    public function addMessage($data, $type = 'danger', $parameters = array())
    {
        $message = '';

        if (is_array($data))
        {
            foreach ($data as $key => $value) {
                if (form_error($key)) {
                    $message .= form_error($key, '<p><span class="' . $this->messageIcons[$type] . ' mr-1"></span>', '</p>');
                }
            }
        }
        else if (trim($data))
        {
            $messageText = trim($data);

            if (!strpos($messageText, ' ')) {
                $messageText = str_replace(array_keys($parameters), array_values($parameters), $this->CI->getLanguageText("messages_{$data}"));
            }

            $message = '<p><span class="' . $this->messageIcons[$type] . ' mr-1"></span>' . $messageText . '</p>';
        }

        if ($message) {
            $this->messagesByType[$type] .= $message;
        }

    }

    public function addMessageToSession($msgId, $msgType = 'success', $msgParameters = array())
    {
        $sessionMessages = array();

        if ($this->CI->session->userdata('messages')) {
            $sessionMessages = $this->CI->session->userdata('messages');
        }

        $sessionMessages[$msgId] = array('msgType' => $msgType, 'msgParameters' => $msgParameters);

        $this->CI->session->set_userdata('messages', $sessionMessages);

    }

}