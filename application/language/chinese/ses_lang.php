<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />此致<br /><br /><common_app_name>团队<br /><a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = '验证您的<common_app_name>帐户';
$lang['ses_verification_body'] = '亲爱的<user_name>，<br /><br />请点击以下链接验证您的<common_app_name>帐户。如果链接无效，请尝试将整个链接复制/粘贴到浏览器地址栏。<br /><br /><url>帐户/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = '重置您的<common_app_name>密码';
$lang['ses_recover_password_body'] = '亲爱的<user_name>，<br /><br />请点击以下链接重置您的密码。此链接有效期为 24 小时。<br /><br /><url>帐户/忘记密码最终/<verify_code>';
$lang['ses_change_password_subject'] = '你的<common_app_name>密码已更改';
$lang['ses_change_password_body'] = '亲爱的<user_name>，<br /><br />我们通知您，有人更改了您的<common_app_name>密码。如果这不是您本人所为，请使用以下密码重置链接更改您的密码。<br /><br /><url>账户/忘记密码';
$lang['ses_contact_subject'] = '联系请求';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = '错误 -<common_app_name>';
$lang['ses_error_body'] = '你好<br/><br/>错误：<error_msg>';