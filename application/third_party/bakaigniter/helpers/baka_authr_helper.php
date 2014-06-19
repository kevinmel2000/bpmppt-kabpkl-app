<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package     Baka Igniter Pack
 * @subpackage  Authentication
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

// function is_permited( $permission )
// {
// 	$authen =& get_instance()->authen;

// 	return $authen->permit( $permission );
// }

// -----------------------------------------------------------------------------

/**
 * Get login method
 *
 * @return  string
 */
function login_by()
{
    $login_by_username  = ( (bool) get_setting('auth_login_by_username') AND (bool) get_setting('auth_use_username') );
    $login_by_email     = (bool) get_setting('auth_login_by_email');

    if ( $login_by_username AND $login_by_email )
    {
        return 'login';
    }
    else if ( $login_by_username )
    {
        return 'username';
    }
    else
    {
        return 'email';
    }
}

/* End of file authen_helper.php */
/* Location: ./application/third_party/bakaigniter/helpers/authen_helper.php */