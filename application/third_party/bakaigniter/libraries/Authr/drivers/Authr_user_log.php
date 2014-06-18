<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package     Baka Igniter Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
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

        if ( get_setting('auth_login_record_ip') )
        {
            $user_data['last_ip'] = $this->_ci->input->ip_address();
        }

        return $this->users->edit( $user_id, $user_data );
    }
}

/* End of file Authr_user_log.php */
/* Location: ./application/third_party/bakaigniter/libraries/Authr/driver/Authr_user_log.php */