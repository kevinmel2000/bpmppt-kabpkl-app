<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     CodeIgniter Baka Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

/*
|--------------------------------------------------------------------------
| Default application configurations
|--------------------------------------------------------------------------
*/
// BAKA Application Name
$config['baka_app_name']            = 'BPMPPT App';
// BAKA Application Version
$config['baka_app_version']         = '0.1.4';
// BAKA Application Author
$config['baka_app_author']          = 'Fery Wardiyanto';
// BAKA Application Author Email
$config['baka_app_author_email']    = 'ferywardiyanto@gmail.com';
// BAKA Application Author Url
$config['baka_app_author_url']      = 'http://github.com/feryardiant';
// BAKA Application Documentation
$config['baka_app_doc_url']         = '';
// BAKA Application Description
$config['baka_app_desc']            = 'Aplikasi pengelolaan data perijinan di BPMPPT Kab. Pekalongan';
// BAKA Application Description
$config['baka_app_client']          = 'BPMPPT Kab. Pekalongan';

// BAKA Minimal Web Browser Version
$config['baka_app_min_browser']     = array(
    'Firefox'           => 4,
    'Chrome'            => 8,
    'Internet Explorer' => 8,
    );

/*
|--------------------------------------------------------------------------
| Table name configurations
|--------------------------------------------------------------------------
*/
// BAKA media table name
$config['baka_media_table']             = 'media';

// BAKA system_opt table name
$config['baka_system_opt_table']        = 'system_opt';
// BAKA system_env table name
$config['baka_system_env_table']        = 'system_env';

// BAKA users table name
$config['baka_users_table']             = 'auth_users';
// BAKA user_meta table name
$config['baka_user_meta_table']         = 'auth_usermeta';
// BAKA user_profiles table name
$config['baka_user_profile_table']      = 'auth_user_profiles';
// BAKA user_group table name
$config['baka_user_role_table']         = 'auth_user_roles';
// BAKA user_meta table name
$config['baka_roles_table']             = 'auth_roles';
// BAKA user_permission table name
$config['baka_permissions_table']       = 'auth_permissions';
// BAKA user_permission table name
$config['baka_role_perms_table']        = 'auth_role_permissions';
// BAKA user_permission table name
$config['baka_overrides_table']         = 'auth_overrides';
// BAKA users table name
$config['baka_user_autologin_table']    = 'auth_user_autologin';
// BAKA users table name
$config['baka_login_attempts_table']    = 'auth_login_attempts';

/*
|--------------------------------------------------------------------------
| Table name configurations
|--------------------------------------------------------------------------
*/
$config['baka_default_meta_fields'] = array(
    'firstname' => '',
    'lastname'  => '',
    'phone'     => '',
    'address'   => ''
    );


/*
|--------------------------------------------------------------------------
| File Upload configuration
|--------------------------------------------------------------------------
*/
// BAKA temporary folder name
$config['baka_temp_path']           = APPPATH.'storage/tmp/';
// BAKA upload folder name
$config['baka_upload_path']         = APPPATH.'storage/upload/';
// BAKA allowed file types
$config['baka_allowed_types']       = 'gif|jpg|jpeg|png';
$config['baka_thumb_height']        = 100;
$config['baka_thumb_width']         = 100;

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
$config['baka_cool_captcha_folder'] = APPPATH.'libraries/vendor/captcha/';

/*
|--------------------------------------------------------------------------
| Security settings
|
| The library uses PasswordHash library for operating with hashed passwords.
| 'phpass_hash_portable' = Can passwords be dumped and exported to another server.
|                           If set to FALSE then you won't be able to use this database on another server.
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
$config['baka_allow_registration']      = TRUE;
$config['baka_captcha_registration']    = TRUE;
$config['baka_email_activation']        = FALSE;
$config['baka_email_activation_expire'] = 60*60*24*2;
$config['baka_email_account_details']   = FALSE;
$config['baka_use_username']            = TRUE;

// To manually approve accounts, set this to FALSE
$config['baka_acct_approval']           = TRUE;

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
$config['baka_login_by_username']       = TRUE;
$config['baka_login_by_email']          = TRUE;
$config['baka_login_record_ip']         = TRUE;
$config['baka_login_record_time']       = TRUE;
$config['baka_login_count_attempts']    = TRUE;
$config['baka_login_max_attempts']      = 5;
$config['baka_login_attempt_expire']    = 60*60*24;

/*
|--------------------------------------------------------------------------
| Auto login settings
|
| 'autologin_cookie_name' = Auto login cookie name.
| 'autologin_cookie_life' = Auto login cookie life before expired. Default is 2 months (60*60*24*31*2).
|--------------------------------------------------------------------------
*/
$config['baka_autologin_cookie_name']   = 'autologin';
$config['baka_autologin_cookie_life']   = 60*60*24*31*2;

/*
|--------------------------------------------------------------------------
| Forgot password settings
|
| 'forgot_password_expire' = Time before forgot password key become invalid. Default is 15 minutes (60*15).
|--------------------------------------------------------------------------
*/
$config['baka_forgot_password_expire']  = 60*15;


/* End of file baka_pack.php */
/* Location: ./application/config/baka_pack.php */