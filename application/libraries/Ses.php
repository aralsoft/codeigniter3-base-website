<?php
require_once BASEDIRECTORY.'/vendor/autoload.php';

class Ses
{
    protected $options = array();
    protected $sesInstance = NULL;

    protected $CI;
    
    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->model('Email_logs');
        $this->CI->load->helper(array('nav'));
        $this->CI->loadLanguageFile('ses');
        $this->CI->loadLanguageFile('common');
        $this->CI->config->load('aws');
        
        $this->options['region'] = $this->CI->config->item('aws_region');
        $this->options['version'] = $this->CI->config->item('aws_version');
        $this->options['credentials'] = array(
            "key" => $this->CI->config->item('aws_key'),
            "secret" => $this->CI->config->item('aws_secret')
        );

        $this->sesInstance = new \Aws\Ses\SesClient($this->options);
    }
    
    public function sendMyEmail($emailParams, $userid = 0)
    {
        // Get current user's id
        if (!$userid) {
            $userid = $this->CI->user->getId();
        }

        // Extract all main email parameters
        $emailType = $emailParams['type'];
        $from = $this->CI->config->item('support_email');
        $to = trim($emailParams['to']);

        $replyTo = $from;
        if (isset($emailParams['replyto'])) {
            $replyTo = $emailParams['replyto'];
        }

        // Get email subject and message body.
        $subject = $this->CI->getLanguageText("ses_{$emailType}_subject");
        $message = $this->CI->getLanguageText("ses_{$emailType}_body");

        // Replace all additional email parameters in subject and body
        foreach ($emailParams AS $emailParamKey => $emailParam) {
            $subject = $this->extractParameters($subject, $emailParamKey, $emailParam);
            $message = $this->extractParameters($message, $emailParamKey, $emailParam);
        }

        //Add headers and footers to message body
        $message = $this->CI->getLanguageText("ses_header") . $message . $this->CI->getLanguageText("ses_footer");

        // Replace common tags in email subject and body
        $commonTags = array('<url>', '<code>', '<common_app_name>', '<user_name>');

        $replacements = array(
            getUrl(),
            $this->getCode($emailParams, $userid),
            $this->CI->getLanguageText("common_app_name"),
            $this->CI->user->getFullName()
        );

        $subject = str_replace($commonTags, $replacements, $subject);
        $message = str_replace($commonTags, $replacements, $message);

        // log email into the DB
        $this->logEmail($emailParams, array('subject' => $subject, 'body' => $message), $userid);

        // Do not send email in Dev
        if (!$this->CI->isLive) {
            return TRUE;
        }

        // Send email
        try
        {
            $this->sesInstance->sendEmail(
                array(
                'Destination' => array(
                    'ToAddresses' => array("{$to}"),
                    'CcAddresses' => array("{$from}")
                ),
                'Message' => array(
                    'Body' => array(
                        'Html' => array(
                            'Charset' => 'utf8',
                            'Data' => "{$message}"
                        ),
                    ),
                    'Subject' => array(
                        'Charset' => 'utf8',
                        'Data' => "{$subject}",
                    ),
                ),
                'ReplyToAddresses' => array("{$replyTo}"),
                'ReturnPath' => "{$from}",
                'Source' => "{$from}"
                )
            );

            return TRUE;
        }
        catch (Exception $e) {
            $this->CI->processError("Unable to send email: ".$e->getMessage());
        }

        return FALSE;
    }
    
    public function logEmail($emailParams, $message, $userid)
    {
        $emailLog['user_id'] = $userid;
        $emailLog['data'] = json_encode($emailParams);
        $emailLog['message'] = json_encode($message);
        
        if (!$this->CI->Email_logs->insert($emailLog)) {
            $this->CI->processError("Unable to write email log."); 
        }
    }

    protected function extractParameters($message, $key, $value)
    {
        if (is_array($value)) {
            foreach ($value AS $key2 => $value2) {
                $message = $this->extractParameters($message, $key2, $value2);
            }

            return $message;
        }

        return str_replace('<'.$key.'>', $value, $message);
    }

    public function getCode($emailParams, $userid)
    {
        $this->CI->load->model('User_login_verifications');

        $code = '';

        if ($user = $this->CI->Users->get($userid))
        {
            $redirectParameter = '';
            if (isset($emailParams['redirectParameter'])) {
                $redirectParameter = $emailParams['redirectParameter'];
            }

            $code = md5($user['id'] . time() . rand(1000, 9999));
            $parameters = array('user' => $user['id'], 'email' => $user['email'], 'redirectParameter' => $redirectParameter);

            $this->CI->User_login_verifications->replace(array('code' => $code, 'parameters' => $parameters));
        }

        return $code;
    }


    public function sendUserVerificationLink($id, $email)
    {
        $this->CI->load->model('User_email_verifications');

        $emailParams = array(
            'to' => $email,
            'type' => 'verification',
            'verify' => array(
                'user_id' => $id,
                'email' => $email,
                'verify_code' => md5($id . $email . time() . rand(1000, 9999))
            )
        );

        if ($this->CI->User_email_verifications->refresh($emailParams['verify']))
        {
            $this->CI->user->logIn($id, $email);
            return $this->sendMyEmail($emailParams, $id);
        }

        $this->CI->processError("Unable to write email verification record.");
        return FALSE;
    }

}
