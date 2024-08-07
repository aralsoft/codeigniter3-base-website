<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Distinti saluti<br /><br /><common_app_name> Squadra<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Verifica il tuo<common_app_name> Account';
$lang['ses_verification_body'] = 'Caro<user_name> ,<br /><br /> Fai clic sul seguente collegamento per verificare il tuo<common_app_name> account. Se il collegamento non funziona, prova a copiare/incollare l&#39;intero collegamento nella barra degli indirizzi del browser.<br /><br /><url> account/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Ripristina il tuo<common_app_name> Parola d&#39;ordine';
$lang['ses_recover_password_body'] = 'Caro<user_name> ,<br /><br /> Fai clic sul collegamento sottostante per reimpostare la password. Questo collegamento è valido per 24 ore.<br /><br /><url> account/password_forgot_final/<verify_code>';
$lang['ses_change_password_subject'] = 'Tuo<common_app_name> la password è stata cambiata';
$lang['ses_change_password_body'] = 'Caro<user_name> ,<br /><br /> Ti stiamo comunicando che qualcuno ha cambiato il tuo<common_app_name> parola d&#39;ordine. Se non eri tu, utilizza il seguente collegamento per la reimpostazione della password per modificare la password.<br /><br /><url> account/password_dimenticata';
$lang['ses_contact_subject'] = 'Richiesta di contatto';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'ERRORE Cron -<common_app_name>';
$lang['ses_error_body'] = 'CIAO<br/><br/><error_msg>';