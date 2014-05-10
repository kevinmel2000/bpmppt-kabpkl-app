<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/

if (VCAP_SERVICES)
{
	$service_json = json_decode(VCAP_SERVICES, true);
	$vcap_config = $service_json['mysql-5.1'][0]['credentials'];
}

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = (isset($vcap_config['hostname']) ? $vcap_config['hostname'] : 'localhost');
$db['default']['username'] = (isset($vcap_config['username']) ? $vcap_config['username'] : 'root');
$db['default']['password'] = (isset($vcap_config['password']) ? $vcap_config['password'] : 'password');
$db['default']['database'] = (isset($vcap_config['name']) ? $vcap_config['name'] : 'bpmppt_db');
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = 'baka_';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_unicode_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */