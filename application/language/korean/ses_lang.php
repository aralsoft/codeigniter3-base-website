<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang['ses_header'] = '';
$lang['ses_footer'] = '<br /><br />감사합니다<br /><br /><common_app_name> 팀<br /> <a href=<url>&gt;</a><url>';
$lang['ses_verification_subject'] = '확인<common_app_name> 계정';
$lang['ses_verification_body'] = '~에게<user_name> ,<br /><br /> 다음 링크를 클릭하여 확인하세요.<common_app_name> 계정. 링크가 작동하지 않으면 전체 링크를 브라우저 주소창에 복사/붙여넣어 보세요.<br /><br /><url> 계정/이메일_검증_최종/<verify_code>';
$lang['ses_recover_password_subject'] = '재설정<common_app_name> 비밀번호';
$lang['ses_recover_password_body'] = '~에게<user_name> ,<br /><br /> 아래 링크를 클릭하여 비밀번호를 재설정하세요. 이 링크는 24시간 동안 유효합니다.<br /><br /><url> 계정/비밀번호_잊어버렸어요_최종/<verify_code>';
$lang['ses_change_password_subject'] = '당신의<common_app_name> 비밀번호가 변경되었습니다';
$lang['ses_change_password_body'] = '~에게<user_name> ,<br /><br /> 누군가가 귀하의 정보를 변경했다는 사실을 알려드립니다.<common_app_name> 비밀번호. 본인이 아니라면 다음 비밀번호 재설정 링크를 사용하여 비밀번호를 변경하세요.<br /><br /><url> 계정/비밀번호를 잊으셨나요?';
$lang['ses_contact_subject'] = '연락 요청';
$lang['ses_contact_body'] = '<user_name> <br /><br /> <user_message>';
$lang['ses_error_subject'] = '오류 -<common_app_name>';
$lang['ses_error_body'] = '안녕<br/><br/> 오류:<error_msg>';