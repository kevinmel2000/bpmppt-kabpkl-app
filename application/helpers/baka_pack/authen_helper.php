<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter core library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

function is_permited( $permission )
{
	$authen =& get_instance()->authen;

	return $authen->permit( $permission );
}

// -----------------------------------------------------------------------------

/**
 * Get login method
 *
 * @return  string
 */
function login_by()
{
    $login_by_username  = ( (bool) Setting::get('auth_login_by_username') AND (bool) Setting::get('auth_use_username') );
    $login_by_email     = (bool) Setting::get('auth_login_by_email');

    if ( $login_by_username AND $login_by_email )
        return 'login';
    else if ( $login_by_username )
        return 'username';
    else 
        return 'email';
}

/* End of file authen_helper.php */
/* Location: ./application/helpers/baka_pack/authen_helper.php */