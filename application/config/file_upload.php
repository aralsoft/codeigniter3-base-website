<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['file_upload']['upload_path'] = SITEDIRECTORY.'/img/users/uploads/';
$config['file_upload']['allowed_types'] = 'gif|jpg|png|jpeg';
$config['file_upload']['max_size'] = 2048;
$config['file_upload']['max_filename'] = 128;
$config['file_upload']['file_ext_tolower'] = TRUE;
$config['file_upload']['max_filename_increment'] = 9999;
$config['file_upload']['profile_image_path'] = SITEDIRECTORY.'/img/users/profile/';