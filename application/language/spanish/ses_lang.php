<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />Atentamente<br /><br /><common_app_name> Equipo<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = 'Verificar su<common_app_name> Cuenta';
$lang['ses_verification_body'] = 'Estimado<user_name> ,<br /><br /> Por favor haga clic en el siguiente enlace para verificar su<common_app_name> cuenta. Si el enlace no funciona, intente copiar y pegar el enlace completo en la barra de direcciones de su navegador.<br /><br /><url> cuenta/verificación_de_correo_electrónico_final/<verify_code>';
$lang['ses_recover_password_subject'] = 'Restablecer su<common_app_name> Contraseña';
$lang['ses_recover_password_body'] = 'Estimado<user_name> ,<br /><br /> Haga clic en el enlace que aparece a continuación para restablecer su contraseña. Este enlace es válido durante 24 horas.<br /><br /><url> cuenta/olvidé_contraseña_final/<verify_code>';
$lang['ses_change_password_subject'] = 'Su<common_app_name> La contraseña ha sido cambiada';
$lang['ses_change_password_body'] = 'Estimado<user_name> ,<br /><br /> Le informamos que alguien ha cambiado su<common_app_name> Contraseña. Si no es usted, utilice el siguiente enlace de restablecimiento de contraseña para cambiar su contraseña.<br /><br /><url> cuenta/olvidé_contraseña';
$lang['ses_contact_subject'] = 'Solicitud de contacto';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = 'ERROR -<common_app_name>';
$lang['ses_error_body'] = 'Hola<br/><br/> Error:<error_msg>';