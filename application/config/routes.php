<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin/login'] = 'admin/main/login';
$route['admin/logout'] = 'admin/main/logout';

$route['apply'] = 'main/setApplicant';




