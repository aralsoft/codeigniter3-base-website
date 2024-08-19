<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Bästa hälsningar<br /><br /><common_app_name> Team<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Verifiera din<common_app_name> Konto';
$lang['ses_verification_body'] = 'Kär<user_name> ,<br /><br /> Klicka på följande länk för att verifiera din<common_app_name> konto. Om länken inte fungerar, försök att kopiera/klistra in hela länken i webbläsarens adressfält.<br /><br /><url> account/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Återställ din<common_app_name> Lösenord';
$lang['ses_recover_password_body'] = 'Kär<user_name> ,<br /><br /> Klicka på länken nedan för att återställa ditt lösenord. Denna länk är giltig i 24 timmar.<br /><br /><url> account/forgot_password_final/<verify_code>';
$lang['ses_change_password_subject'] = 'Din<common_app_name> lösenordet har ändrats';
$lang['ses_change_password_body'] = 'Kär<user_name> ,<br /><br /> Vi låter dig veta att någon har ändrat din<common_app_name> lösenord. Om detta inte var du, använd följande länk för återställning av lösenord för att ändra ditt lösenord.<br /><br /><url> konto/glömt_lösenord';
$lang['ses_contact_subject'] = 'Kontaktförfrågan';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'FEL -<common_app_name>';
$lang['ses_error_body'] = 'Hej<br/><br/> Fel:<error_msg>';