<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
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
 * @package     Authr
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Authr User Log Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_user_log extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: User Log Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Login
    // -------------------------------------------------------------------------

    /**
     * Update user login info, such as IP-address or login time, and
     * clear previously generated (but not activated) passwords.
     *
     * @param   int   $user_id  User ID
     *
     * @return  bool
     */
    public function update_login_info( $user_id )
    {
        $user_data['new_password_key']       = NULL;
        $user_data['new_password_requested'] = NULL;
        $user_data['last_login'] 			 = date('Y-m-d H:i:s');

        if ( Setting::get('auth_login_record_ip') )
        {
            $user_data['last_ip'] = $this->_ci->input->ip_address();
        }

        return $this->users->edit( $user_id, $user_data );
    }
}

/* End of file Authr_user_log.php */
/* Location: ./application/libraries/Authr/driver/Authr_user_log.php */