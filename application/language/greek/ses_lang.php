<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Με εκτίμηση<br /><br /><common_app_name> Ομάδα<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Επαληθεύστε το δικό σας<common_app_name> Λογαριασμός';
$lang['ses_verification_body'] = 'Αγαπητός<user_name> ,<br /><br /> Κάντε κλικ στον παρακάτω σύνδεσμο για να επιβεβαιώσετε τη δική σας<common_app_name> λογαριασμός. Εάν ο σύνδεσμος δεν λειτουργεί, δοκιμάστε να αντιγράψετε/επικολλήσετε ολόκληρο τον σύνδεσμο στη γραμμή διευθύνσεων του προγράμματος περιήγησής σας.<br /><br /><url> account/email_verification_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Επαναφορά σας<common_app_name> Σύνθημα';
$lang['ses_recover_password_body'] = 'Αγαπητός<user_name> ,<br /><br /> Κάντε κλικ στον παρακάτω σύνδεσμο για να επαναφέρετε τον κωδικό πρόσβασής σας. Αυτός ο σύνδεσμος ισχύει για 24 ώρες.<br /><br /><url> account/forgot_password_final/<verify_code>';
$lang['ses_change_password_subject'] = 'Σας<common_app_name> ο κωδικός πρόσβασης έχει αλλάξει';
$lang['ses_change_password_body'] = 'Αγαπητός<user_name> ,<br /><br /> Σας ενημερώνουμε ότι κάποιος σας άλλαξε<common_app_name> σύνθημα. Εάν δεν ήσασταν εσείς, χρησιμοποιήστε τον παρακάτω σύνδεσμο επαναφοράς κωδικού πρόσβασης για να αλλάξετε τον κωδικό πρόσβασής σας.<br /><br /><url> λογαριασμός/forgot_password';
$lang['ses_contact_subject'] = 'Αίτημα επικοινωνίας';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'ΣΦΑΛΜΑ -<common_app_name>';
$lang['ses_error_body'] = 'Γεια<br/><br/> Σφάλμα:<error_msg>';