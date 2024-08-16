<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['base_url'] = "https://skeleton.com/";
$config['support_email'] = 'me@mydomain.com';
$config['keep_user_logs'] = TRUE;
$config['verification_email_interval'] = 60;

$config['language'] = 'english';
$config['languages'] = array('en' => 'english',
    'es' => 'spanish',
    'fr' => 'french',
    'pt' => 'portuguese',
    'de' => 'german',
    'it' => 'italian',
    'pl' => 'polish',
    'ru' => 'russian',
    'zh-TW' => 'chinese',
    'ja' => 'japanese',
    'ko' => 'korean',
    'th' => 'thai',
    'hi' => 'hindi',
    'tr' => 'turkish',
    'el' => 'greek',
    'da' => 'danish',
    'nl' => 'dutch',
    'no' => 'norwegian',
    'sv' => 'swedish',
);

$config['encryption_key'] = 'Mobil609!$Tuvok5174#';
$config['index_page'] = '';
$config['subclass_prefix'] = 'MY_';
$config['charset'] = 'UTF-8';

$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 1;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;

$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'cc_session';
$config['sess_expiration'] = 0;
$config['sess_save_path'] = 'sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix'] = '';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = FALSE;

$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

$config['enable_hooks'] = FALSE;
$config['composer_autoload'] = FALSE;
$config['allow_get_array'] = TRUE;
$config['error_views_path'] = '';
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';