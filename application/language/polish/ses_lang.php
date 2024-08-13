<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Z wyrazami szacunku<br /><br /><common_app_name> Zespół<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Zweryfikuj swoje<common_app_name> Konto';
$lang['ses_verification_body'] = 'Droga<user_name> ,<br /><br /> Aby zweryfikować swoje dane, kliknij poniższy link<common_app_name> konto. Jeśli link nie działa, spróbuj skopiować/wkleić cały link do paska adresu przeglądarki.<br /><br /><url> konto/email_weryfikacja_końcowa/<verify_code>';
$lang['ses_recover_password_subject'] = 'Zresetuj swoje<common_app_name> Hasło';
$lang['ses_recover_password_body'] = 'Droga<user_name> ,<br /><br /> Kliknij poniższy link, aby zresetować hasło. Ten link jest ważny przez 24 godziny.<br /><br /><url> konto/zapomniane_hasło_końcowe/<verify_code>';
$lang['ses_change_password_subject'] = 'Twój<common_app_name> hasło zostało zmienione';
$lang['ses_change_password_body'] = 'Droga<user_name> ,<br /><br /> Informujemy, że ktoś zmienił Twoje dane.<common_app_name> hasło. Jeśli to nie byłeś ty, użyj poniższego linku resetowania hasła, aby zmienić swoje hasło.<br /><br /><url> konto/zapomniałem_hasła';
$lang['ses_contact_subject'] = 'Prośba o kontakt';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'BŁĄD -<common_app_name>';
$lang['ses_error_body'] = 'Cześć<br/><br/> Błąd:<error_msg>';