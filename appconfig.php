<?php

$base_url = function_exists('apache_getenv') == true ? 'http://bpmppt.local/' : 'http://localhost:8088/';
$hostname = 'localhost';
$username = 'root';
$password = 'password';
$name     = 'bpmppt';

if ($vcap_services = getenv("VCAP_SERVICES"))
{
    $service_json = json_decode($vcap_services, true);
    $env_config   = $service_json['mysql-5.1'][0]['credentials'];

    foreach (array('hostname', 'username', 'password', 'name') as $service)
    {
        $$service = $env_config[$service];
    }

    $base_url = 'http://bpmppt.ap01.aws.af.cm/';
}

/*
|--------------------------------------------------------------------
| BASE SITE URL
|--------------------------------------------------------------------
*/
// $base_url = function_exists('apache_getenv') == true ? 'http://bpmppt.local/' : 'http://localhost:8088/';
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
