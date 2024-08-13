<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Saygılarımla<br /><br /><common_app_name> Takım<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Doğrulayın<common_app_name> Hesap';
$lang['ses_verification_body'] = 'Canım<user_name> ,<br /><br /> Lütfen doğrulamak için aşağıdaki bağlantıya tıklayın<common_app_name> hesap. Bağlantı çalışmazsa, bağlantının tamamını tarayıcınızın adres çubuğuna kopyalayıp yapıştırmayı deneyin.<br /><br /><url> hesap/e-posta_doğrulaması_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Sıfırla<common_app_name> Şifre';
$lang['ses_recover_password_body'] = 'Canım<user_name> ,<br /><br /> Lütfen şifrenizi sıfırlamak için aşağıdaki bağlantıya tıklayın. Bu bağlantı 24 saat geçerlidir.<br /><br /><url> hesap/şifremi_unuttum_final/<verify_code>';
$lang['ses_change_password_subject'] = 'Senin<common_app_name> şifre değiştirildi';
$lang['ses_change_password_body'] = 'Canım<user_name> ,<br /><br /> Birisinin kimliğinizi değiştirdiğini size bildiriyoruz<common_app_name> Şifre. Eğer siz değilseniz, lütfen şifrenizi değiştirmek için aşağıdaki şifre sıfırlama bağlantısını kullanın.<br /><br /><url> hesap/şifremi unuttum';
$lang['ses_contact_subject'] = 'İletişim Talebi';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'HATA -<common_app_name>';
$lang['ses_error_body'] = 'MERHABA<br/><br/> Hata:<error_msg>';