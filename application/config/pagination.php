<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['pagination']['uri_segment'] = 3;
$config['pagination']['num_links'] = 5;
$config['pagination']['per_page'] = 10;
$config['pagination']['suffix'] = '/#bets-table';

$config['pagination']['full_tag_open'] = '<nav class="text-center"><ul class="pagination justify-content-center">';
$config['pagination']['full_tag_close'] = '</ul></nav>';

$config['pagination']['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="/#bets-table">';
$config['pagination']['cur_tag_close'] = '</a></li>';

$config['pagination']['first_tag_open'] = '<li class="page-item">';
$config['pagination']['first_tag_close'] = '</li>';

$config['pagination']['last_tag_open'] = '<li class="page-item">';
$config['pagination']['last_tag_close'] = '</li>';

$config['pagination']['next_tag_open'] = '<li class="page-item">';
$config['pagination']['next_tag_close'] = '</li>';

$config['pagination']['prev_tag_open'] = '<li class="page-item">';
$config['pagination']['prev_tag_close'] = '</li>';

$config['pagination']['num_tag_open'] = '<li class="page-item">';
$config['pagination']['num_tag_close'] = '</li>';

$config['pagination']['attributes'] = array('class' => 'page-link');