<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
*/

$autoload['packages'] = array();

$autoload['libraries'] = array('database', 'session', 'ses');

$autoload['drivers'] = array();

$autoload['helper'] = array('url', 'nav', 'language', 'number');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('Users', 'User_attributes', 'User_logs', 'Affiliates');
