<?php

$base_url = function_exists('apache_getenv') == true ? '//bpmppt.local/' : '//localhost:8088/';
$hostname = 'localhost';
$username = 'root';
$password = 'password';
$name     = 'bpmppt';

if ($clear_db = getenv("CLEARDB_DATABASE_URL"))
{
    $clear_db = $clear_db != '' ? parse_url($clear_db)                  : array();
    $hostname = isset($clear_db['host']) ? $clear_db['host']            : '';
    $username = isset($clear_db['user']) ? $clear_db['user']            : '';
    $password = isset($clear_db['pass']) ? $clear_db['pass']            : '';
    $name     = isset($clear_db['path']) ? substr($clear_db['path'], 1) : '';
	$base_url = '//bpmppt.herokuapp.com/';
}

/*
|--------------------------------------------------------------------
| BASE SITE URL
|--------------------------------------------------------------------
*/
// $base_url = function_exists('apache_getenv') == true ? '//bpmppt.local/' : '//localhost:8088/';
!defined('APP_BASE_URL') and define('APP_BASE_URL', $base_url);

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/
!defined('APP_HOSTNAME') and define('APP_HOSTNAME', $hostname );
!defined('APP_USERNAME') and define('APP_USERNAME', $username );
!defined('APP_PASSWORD') and define('APP_PASSWORD', $password );
!defined('APP_DATABASE') and define('APP_DATABASE', $name );
!defined('APP_DBPREFIX') and define('APP_DBPREFIX', 'baka_');
