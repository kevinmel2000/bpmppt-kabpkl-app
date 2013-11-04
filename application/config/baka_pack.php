<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| Default application configurations
|--------------------------------------------------------------------------
*/
// BAKA Application Name
$config['baka_app_name']			= 'BPMPPT App';
// BAKA Application Version
$config['baka_app_version']			= '0.1.3';
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


/*
|--------------------------------------------------------------------------
| File Upload configuration
|--------------------------------------------------------------------------
*/
// BAKA temporary folder name
$config['baka_temp_path']	= APPPATH.'storage/tmp/';
// BAKA upload folder name
$config['baka_upload_path']	= APPPATH.'storage/upload/';

/*
|--------------------------------------------------------------------------
| Tank auth implementation
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Cool Captcha settings
|
| When upgraidng Cool Captcha, simple replace the contents of the captcha folder
| with the new version. No editing required.
|--------------------------------------------------------------------------
*/
$config['baka_cool_captcha_folder'] = APPPATH.'third_party/captcha/';

/*
|--------------------------------------------------------------------------
| Security settings
|
| The library uses PasswordHash library for operating with hashed passwords.
| 'phpass_hash_portable' = Can passwords be dumped and exported to another server. If set to FALSE then you won't be able to use this database on another server.
| 'phpass_hash_strength' = Password hash strength.
|--------------------------------------------------------------------------
*/
$config['baka_phpass_hash_portable'] = FALSE;
$config['baka_phpass_hash_strength'] = 8;

/*
|--------------------------------------------------------------------------
| Registration settings
|
| 'allow_registration' = Registration is enabled or not
| 'captcha_registration' = Registration uses CAPTCHA
| 'email_activation' = Requires user to activate their account using email after registration.
| 'email_activation_expire' = Time before users who don't activate their account getting deleted from database. Default is 48 hours (60*60*24*2).
| 'email_account_details' = Email with account details is sent after registration (only when 'email_activation' is FALSE).
| 'use_username' = Username is required or not.
|
| 'username_min_length' = Min length of user's username.
| 'username_max_length' = Max length of user's username.
| 'password_min_length' = Min length of user's password.
| 'password_max_length' = Max length of user's password.
|--------------------------------------------------------------------------
*/
$config['baka_allow_registration']		= TRUE;
$config['baka_captcha_registration']	= TRUE;
$config['baka_email_activation']		= FALSE;
$config['baka_email_activation_expire']	= 60*60*24*2;
$config['baka_email_account_details']	= FALSE;
$config['baka_use_username']			= TRUE;

// To manually approve accounts, set this to FALSE
$config['baka_acct_approval']			= TRUE;

/*
|--------------------------------------------------------------------------
| Login settings
|
| 'login_by_username' = Username can be used to login.
| 'login_by_email' = Email can be used to login.
| You have to set at least one of 2 settings above to TRUE.
| 'login_by_username' makes sense only when 'use_username' is TRUE.
|
| 'login_record_ip' = Save in database user IP address on user login.
| 'login_record_time' = Save in database current time on user login.
|
| 'login_count_attempts' = Count failed login attempts.
| 'login_max_attempts' = Number of failed login attempts before CAPTCHA will be shown.
| 'login_attempt_expire' = Time to live for every attempt to login. Default is 24 hours (60*60*24).
|--------------------------------------------------------------------------
*/
$config['baka_login_by_username']		= TRUE;
$config['baka_login_by_email']			= TRUE;
$config['baka_login_record_ip']			= TRUE;
$config['baka_login_record_time']		= TRUE;
$config['baka_login_count_attempts']	= TRUE;
$config['baka_login_max_attempts']		= 5;
$config['baka_login_attempt_expire']	= 60*60*24;

/*
|--------------------------------------------------------------------------
| Auto login settings
|
| 'autologin_cookie_name' = Auto login cookie name.
| 'autologin_cookie_life' = Auto login cookie life before expired. Default is 2 months (60*60*24*31*2).
|--------------------------------------------------------------------------
*/
$config['baka_autologin_cookie_name']	= 'autologin';
$config['baka_autologin_cookie_life']	= 60*60*24*31*2;

/*
|--------------------------------------------------------------------------
| Forgot password settings
|
| 'forgot_password_expire' = Time before forgot password key become invalid. Default is 15 minutes (60*15).
|--------------------------------------------------------------------------
*/
$config['baka_forgot_password_expire']	= 60*15;


/* End of file tank_auth.php */
/* Location: ./application/config/tank_auth.php */

/* End of file aplikasi.php */
/* Location: ./application/config/aplikasi.php */