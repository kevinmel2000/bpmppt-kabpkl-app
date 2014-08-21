<?php

if (VCAP_SERVICES)
{
	$service_json = json_decode(VCAP_SERVICES, true);
	$env_config   = $service_json['mysql-5.1'][0]['credentials'];

	$env_config['base_url'] = 'http://bpmppt.ap01.aws.af.cm/';
}
elseif (getenv("TRAVIS") == true)
{
	$env_config['hostname'] = '127.0.0.1';
	$env_config['username'] = 'travis';
	$env_config['password'] = '';
	$env_config['name']     = 'bpmppt_test';

	$env_config['base_url'] = 'http://localhost/';
}

/*
|--------------------------------------------------------------------
| BASE SITE URL
|--------------------------------------------------------------------
*/
$hostname = function_exists('apache_getenv') == true ? 'http://bpmppt.local/' : 'http://localhost:8088/';
define('APP_BASE_URL', isset($env_config) ? $env_config['base_url'] : $hostname);

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/
define('APP_HOSTNAME', isset($env_config) ? $env_config['hostname'] : 'localhost' );
define('APP_USERNAME', isset($env_config) ? $env_config['username'] : 'root' );
define('APP_PASSWORD', isset($env_config) ? $env_config['password'] : 'password' );
define('APP_DATABASE', isset($env_config) ? $env_config['name']     : 'bpmppt_dev' );
define('APP_DBPREFIX', 'baka_');
