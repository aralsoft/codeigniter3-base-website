<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Τις καλύτερες ευχές<br /><br /><common_app_name> Ομάδα<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Επαληθεύστε το δικό σας<common_app_name> λογαριασμός';
$lang['ses_verification_body'] = 'αγαπητός<user_name> ,<br /><br /> Κάντε κλικ στον παρακάτω σύνδεσμο για να επιβεβαιώσετε τη δική σας<common_app_name> λογαριασμός. Εάν ο σύνδεσμος δεν λειτουργεί, δοκιμάστε να αντιγράψετε/επικολλήσετε ολόκληρο τον σύνδεσμο στη γραμμή διευθύνσεων του προγράμματος περιήγησής σας.<br /><br /><url> account/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Επαναφορά σας<common_app_name> Κωδικός πρόσβασης';
$lang['ses_recover_password_body'] = 'αγαπητός<user_name> ,<br /><br /> Κάντε κλικ στον παρακάτω σύνδεσμο για να επαναφέρετε τον κωδικό πρόσβασής σας. Αυτός ο σύνδεσμος ισχύει για 24 ώρες.<br /><br /><url> account/forgot_password_final/<verify_code>';
$lang['ses_change_password_subject'] = 'Τα δικα σου<common_app_name> Ο κωδικός έχει αλλάξει';
$lang['ses_change_password_body'] = 'αγαπητός<user_name> ,<br /><br /> Σας ενημερώνουμε ότι κάποιος σας άλλαξε<common_app_name> Κωδικός πρόσβασης. Εάν δεν ήσασταν εσείς, χρησιμοποιήστε τον παρακάτω σύνδεσμο επαναφοράς κωδικού πρόσβασης για να αλλάξετε τον κωδικό πρόσβασής σας.<br /><br /><url> λογαριασμός/forgot_password';
$lang['ses_contact_subject'] = 'Αίτημα επικοινωνίας';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'Cron ERROR -<common_app_name>';
$lang['ses_error_body'] = 'γεια<br/><br/><error_msg>';