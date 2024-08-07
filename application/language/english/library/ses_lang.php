<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Best Regards<br /><br /><common_app_name> Team<br /><a href=<url>><url></a>';

$lang['ses_verification_subject'] = 'Verify Your <common_app_name> Account';
$lang['ses_verification_body'] = 'Dear <user_name>, <br /><br />Please click the following link to verify your <common_app_name> account. If the link does not work try copy/pasting the entire link to your browser address bar. <br /><br /> <url>account/email_verification_final/<verify_code>';

$lang['ses_recover_password_subject'] = 'Reset Your <common_app_name> Password';
$lang['ses_recover_password_body'] = 'Dear <user_name>, <br /><br />Please click the link below to reset your password. This link is valid for 24 hours.<br /><br /> <url>account/forgot_password_final/<verify_code>';

$lang['ses_change_password_subject'] = 'Your <common_app_name> password has been changed';
$lang['ses_change_password_body'] = 'Dear <user_name>, <br /><br />We are letting you know that someone has changed your <common_app_name> password. If this was not you, please use the following password reset link to change your password.<br /><br /> <url>account/forgot_password';

$lang['ses_contact_subject'] = 'Contact Request';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';

$lang['ses_error_subject'] = 'Cron ERROR - <common_app_name>';
$lang['ses_error_body'] = 'Hi<br/><br/><error_msg>';
