<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = APP_HOSTNAME;
$db['default']['username'] = APP_USERNAME;
$db['default']['password'] = APP_PASSWORD;
$db['default']['database'] = APP_DATABASE;
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = APP_DBPREFIX;
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