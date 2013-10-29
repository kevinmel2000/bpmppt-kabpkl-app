<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| Default application configurations
|--------------------------------------------------------------------------
*/
// BAKA Application Name
$config['baka_app_name']			= 'BPMPPT App';
// BAKA Application Version
$config['baka_app_version']			= 'v0.1.3';
// BAKA Application Author
$config['baka_app_author']			= 'Fery Wardiyanto';
// BAKA Application Author Email
$config['baka_app_author_email']	= 'ferywardiyanto@gmail.com';
// BAKA Application Author Url
$config['baka_app_author_url']		= 'http://github.com/feryardiant';
// BAKA Application Documentation
$config['baka_app_doc_url']			= '';
// BAKA Application Description
$config['baka_app_desc']			= 'Aplikasi pengelolaan data perijinan di BPMPPT Kab. Pekalongan';
// BAKA Application Description
$config['baka_app_client']			= 'BPMPPT Kab. Pekalongan';

// BAKA Minimal Web Browser Version
$config['baka_app_min_browser']		= array(
	'Firefox'			=> 4,
	'Chrome'			=> 8,
	'Internet Explorer'	=> 8,
	);

/*
|--------------------------------------------------------------------------
| Table name configurations
|--------------------------------------------------------------------------
*/
// BAKA media table name
$config['baka_media_table']			= 'media';
// BAKA data table name
$config['baka_data_table']			= 'data';
// BAKA data_meta table name
$config['baka_data_meta_table']		= 'data_meta';
// BAKA system_opt table name
$config['baka_system_opt_table']	= 'system_opt';
// BAKA system_env table name
$config['baka_system_env_table']	= 'system_env';
// BAKA users table name
$config['baka_users_table']			= 'users';
// BAKA user_group table name
$config['baka_user_group_table']	= 'user_group';
// BAKA user_meta table name
$config['baka_user_meta_table']		= 'user_meta';
// BAKA user_permission table name
$config['baka_user_perms_table']	= 'user_permission';

/*
|--------------------------------------------------------------------------
| Table name configurations
|--------------------------------------------------------------------------
*/
$config['baka_default_meta_fields']	= array(
	'firstname'	=> '',
	'lastname'	=> '',
	'phone'		=> '',
	'address'	=> ''
	);

/* End of file aplikasi.php */
/* Location: ./application/config/aplikasi.php */