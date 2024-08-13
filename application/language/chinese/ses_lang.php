<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />此致<br /><br /><common_app_name>團隊<br /><a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = '驗證您的<common_app_name>帳戶';
$lang['ses_verification_body'] = '親愛的<user_name>,<br /><br />請點擊以下連結來驗證您的<common_app_name>帳戶。如果連結不起作用，請嘗試將整個連結複製/貼上到瀏覽器網址列。<br /><br /><url>帳號/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = '重置您的<common_app_name>密碼';
$lang['ses_recover_password_body'] = '親愛的<user_name>,<br /><br />請點擊下面的連結重設您的密碼。此連結24小時內有效。<br /><br /><url>帳號/忘記密碼_最終/<verify_code>';
$lang['ses_change_password_subject'] = '你的<common_app_name>密碼已更改';
$lang['ses_change_password_body'] = '親愛的<user_name>,<br /><br />我們通知您有人改變了您的<common_app_name>密碼。如果這不是您本人操作，請使用以下密碼重設連結變更您的密碼。<br /><br /><url>帳戶/忘記密碼';
$lang['ses_contact_subject'] = '聯絡請求';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = '錯誤 -<common_app_name>';
$lang['ses_error_body'] = '你好<br/><br/>錯誤：<error_msg>';