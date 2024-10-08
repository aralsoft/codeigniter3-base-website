<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Beste hilsener<br /><br /><common_app_name> Team<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Bekreft din<common_app_name> Konto';
$lang['ses_verification_body'] = 'Kjære<user_name> ,<br /><br /> Vennligst klikk på følgende lenke for å bekrefte din<common_app_name> konto. Hvis lenken ikke fungerer, prøv å kopiere/lime inn hele lenken til nettleserens adresselinje.<br /><br /><url> account/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Tilbakestill din<common_app_name> Passord';
$lang['ses_recover_password_body'] = 'Kjære<user_name> ,<br /><br /> Klikk på lenken nedenfor for å tilbakestille passordet ditt. Denne lenken er gyldig i 24 timer.<br /><br /><url> account/forgot_password_final/<verify_code>';
$lang['ses_change_password_subject'] = 'Din<common_app_name> passordet er endret';
$lang['ses_change_password_body'] = 'Kjære<user_name> ,<br /><br /> Vi gir deg beskjed om at noen har endret din<common_app_name> passord. Hvis dette ikke var deg, vennligst bruk følgende lenke for tilbakestilling av passord for å endre passordet ditt.<br /><br /><url> konto/glemt_passord';
$lang['ses_contact_subject'] = 'Kontaktforespørsel';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'FEIL -<common_app_name>';
$lang['ses_error_body'] = 'hei<br/><br/> Feil:<error_msg>';