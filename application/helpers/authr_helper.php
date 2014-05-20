<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
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
    $login_by_username  = ( (bool) Setting::get('auth_login_by_username') AND (bool) Setting::get('auth_use_username') );
    $login_by_email     = (bool) Setting::get('auth_login_by_email');

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
/* Location: ./application/helpers/baka_pack/authen_helper.php */