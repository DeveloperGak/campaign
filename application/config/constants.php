<?php defined('BASEPATH') OR exit('No direct script access allowed');

define('VERSION', date("YmdHi"));
define('ADMIN_CSS', '/asset/admin/css');
define('ADMIN_IMG', '/asset/admin/img');
define('ADMIN_JS', '/asset/admin/js');
define('EDITER', '/asset/admin/smarteditor2');

define('VIEW_PATH', $_SERVER["DOCUMENT_ROOT"].'/application/views');
define('MODULES_PATH', '/public/admin/modules');
define('MOIMG_PATH', $_SERVER["DOCUMENT_ROOT"].'/data/campaign/images/mo/');
define('MOIMG_WEB_PATH', '/data/campaign/images/mo/');
define('PCIMG_PATH', $_SERVER["DOCUMENT_ROOT"].'/data/campaign/images/pc/');
define('PCIMG_WEB_PATH', '/data/campaign/images/pc/');
define('IMG_PATH', $_SERVER["DOCUMENT_ROOT"].'/data/campaign/images/');
define('IMG_WEB_PATH', '/data/campaign/images/');

defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

# SITE INFO
defined('SSL')				OR define('SSL', "http://");
defined('HTTP_HOST')		OR define('HTTP_HOST', $_SERVER['HTTP_HOST']);
defined('SITE_URL')			OR define('SITE_URL', SSL.HTTP_HOST);
defined('PAGE_URL')			OR define('PAGE_URL', SITE_URL.$_SERVER['REQUEST_URI']);

// PATH
define('MO_CSS', '/asset/css/mo');
define('PC_CSS', '/asset/css/pc');
define('MO_IMG', '/asset/img/mo');
define('PC_IMG', '/asset/img/pc');
define('JS', '/asset/js');
define('FONT', '/asset/font');
define('TEXT',  $_SERVER["DOCUMENT_ROOT"].'/asset/text');

