<?php

if (VCAP_SERVICES)
{
	$service_json = json_decode(VCAP_SERVICES, true);
	$env_config   = $service_json['mysql-5.1'][0]['credentials'];
}
elseif (getenv("TRAVIS") == true)
{
	$env_config['hostname'] = '127.0.0.1';
	$env_config['username'] = 'travis';
	$env_config['password'] = '';
	$env_config['name']     = 'bpmppt_test';
}
/*
|--------------------------------------------------------------------
| BASE SITE URL
|--------------------------------------------------------------------
*/
define('APP_BASE_URL', 'http://localhost:8088/');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/
define('APP_HOSTNAME', 'localhost');
define('APP_USERNAME', 'root');
define('APP_PASSWORD', 'password');
define('APP_DATABASE', 'bpmppt');
define('APP_DBPREFIX', 'baka_');