<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />С наилучшими пожеланиями<br /><br /><common_app_name> Команда<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Подтвердите свой<common_app_name> Счет';
$lang['ses_verification_body'] = 'Дорогой<user_name> ,<br /><br /> Пожалуйста, нажмите на следующую ссылку, чтобы подтвердить свой<common_app_name> счет. Если ссылка не работает, попробуйте скопировать ее целиком в адресную строку браузера.<br /><br /><url> аккаунт/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Сбросить настройки<common_app_name> Пароль';
$lang['ses_recover_password_body'] = 'Дорогой<user_name> ,<br /><br /> Пожалуйста, нажмите на ссылку ниже, чтобы сбросить пароль. Эта ссылка действительна в течение 24 часов.<br /><br /><url> аккаунт/забытый_пароль_final/<verify_code>';
$lang['ses_change_password_subject'] = 'Твой<common_app_name> пароль был изменен';
$lang['ses_change_password_body'] = 'Дорогой<user_name> ,<br /><br /> Мы сообщаем вам, что кто-то изменил ваш<common_app_name> пароль. Если это были не вы, воспользуйтесь следующей ссылкой для сброса пароля, чтобы изменить свой пароль.<br /><br /><url> учетная запись/забыли_пароль';
$lang['ses_contact_subject'] = 'Контактный запрос';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'ОШИБКА Крон -<common_app_name>';
$lang['ses_error_body'] = 'Привет<br/><br/><error_msg>';