<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Bedste hilsner<br /><br /><common_app_name> Hold<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Bekræft din<common_app_name> Konto';
$lang['ses_verification_body'] = 'Kære<user_name> ,<br /><br /> Klik venligst på følgende link for at bekræfte din<common_app_name> konto. Hvis linket ikke virker, prøv at kopiere/indsætte hele linket til din browsers adresselinje.<br /><br /><url> account/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Nulstil din<common_app_name> Adgangskode';
$lang['ses_recover_password_body'] = 'Kære<user_name> ,<br /><br /> Klik venligst på linket nedenfor for at nulstille din adgangskode. Dette link er gyldigt i 24 timer.<br /><br /><url> konto/forgot_password_final/<verify_code>';
$lang['ses_change_password_subject'] = 'Dine<common_app_name> adgangskoden er blevet ændret';
$lang['ses_change_password_body'] = 'Kære<user_name> ,<br /><br /> Vi fortæller dig, at nogen har ændret din<common_app_name> adgangskode. Hvis dette ikke var dig, skal du bruge følgende link til nulstilling af adgangskode til at ændre din adgangskode.<br /><br /><url> konto/glemt_adgangskode';
$lang['ses_contact_subject'] = 'Kontakt anmodning';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'FEJL -<common_app_name>';
$lang['ses_error_body'] = 'Hej<br/><br/> Fejl:<error_msg>';