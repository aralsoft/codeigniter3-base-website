<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Z wyrazami szacunku<br /><br /><common_app_name> Zespół<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Zweryfikuj swoje<common_app_name> Konto';
$lang['ses_verification_body'] = 'Droga<user_name> ,<br /><br /> Kliknij poniższy link, aby zweryfikować swój<common_app_name> konto. Jeśli link nie działa, spróbuj skopiować/wkleić cały link do paska adresu przeglądarki.<br /><br /><url> konto/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Zresetuj swoje<common_app_name> Hasło';
$lang['ses_recover_password_body'] = 'Droga<user_name> ,<br /><br /> Aby zresetować hasło, kliknij poniższy link. Ten link jest ważny przez 24 godziny.<br /><br /><url> konto/zapomniałem_hasła_końcowego/<verify_code>';
$lang['ses_change_password_subject'] = 'Twój<common_app_name> Hasło zostało zmienione';
$lang['ses_change_password_body'] = 'Droga<user_name> ,<br /><br /> Informujemy Cię, że ktoś zmienił Twoje dane<common_app_name> hasło. Jeśli to nie byłeś Ty, użyj poniższego linku do resetowania hasła, aby zmienić hasło.<br /><br /><url> konto/zapomniałem_hasła';
$lang['ses_contact_subject'] = 'Prośba o kontakt';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'BŁĄD CRONA -<common_app_name>';
$lang['ses_error_body'] = 'Cześć<br/><br/><error_msg>';