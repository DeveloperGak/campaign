<?php defined('BASEPATH') OR exit('No direct script access allowed');

# DB 설정
$active_group = 'default';
$query_builder = TRUE;


$fp = fopen(APPPATH."config/info.txt", "r") or die("파일을 열 수 없습니다！");
while( !feof($fp) ) {
    $hostName = trim(str_replace("host:", "", fgets($fp)));
    $userName = trim(str_replace("username:", "", fgets($fp)));
    $password = trim(str_replace("password:", "", fgets($fp)));
    $database = trim(str_replace("database:", "", fgets($fp)));
}

// 파일 닫기
fclose($fp);

$db['default'] = array(
    'dsn'	=> '',
    'hostname' => $hostName,
    'username' => $userName,
    'password' => $password,
    'database' => $database,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);