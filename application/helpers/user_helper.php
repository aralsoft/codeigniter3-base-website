<?php

function sendVerificationEmail($user_id = 0, $user_email = '')
{
    $CI = get_instance();

    $CI->load->model('User_email_verifications');

    if (!$user_id) {
        if ($CI->user->isLoggedIn()) {
            $user_id = $CI->user->getId();
            $user_email = $CI->user->getEmail();
        }
    }

    if ($user_id)
    {
        $minimumInterval = $CI->config->item('verification_email_interval');
        $interval = 0;

        if ($emailVerification = $CI->User_email_verifications->get($user_id)) {
            $interval = strtotime("now") - strtotime($emailVerification['add_date']);
        }

        if (!$emailVerification || $interval > $minimumInterval) {
            if ($CI->ses->sendUserVerificationLink($user_id, $user_email)) {
                $CI->messages->addMessageToSession('verification_link_sent');
                return TRUE;
            }
        } else {
            $CI->messages->addMessageToSession('verification_too_soon', 'danger', array('<interval>' => $minimumInterval));
            return FALSE;
        }

    }

    $CI->messages->addMessageToSession('verification_link_not_sent', 'danger');
    return FALSE;
}