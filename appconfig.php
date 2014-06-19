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

define('APP_HOSTNAME', isset($env_config['hostname']) ? $env_config['hostname'] : 'localhost');
define('APP_USERNAME', isset($env_config['username']) ? $env_config['username'] : 'root');
define('APP_PASSWORD', isset($env_config['password']) ? $env_config['password'] : 'password');
define('APP_DATABASE', isset($env_config['name'])     ? $env_config['name']     : 'bpmppt');
define('APP_DBPREFIX', 'baka_');