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
 * Authr Login Attempt Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_login_attempt extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: Login Attempt Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Login Attempt
    // -------------------------------------------------------------------------

    /**
     * Increase number of attempts for given IP-address and login
     * (if attempts to login is being counted)
     *
     * @param   string
     * @return  void
     */
    public function increase( $login )
    {
        if ( Setting::get('auth_login_count_attempts') )
        {
            if ( !$this->is_max_attempts_exceeded( $login ) )
            {
                $this->_ci->db->insert( $this->table['login_attempts'],
                    array('ip_address' => $this->_ci->input->ip_address(), 'login' => $login));
            }
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Clear all attempt records for given IP-address and login.
     * Also purge obsolete login attempts (to keep DB clear).
     *
     * @param   string
     * @param   string
     * @param   int
     * @return  void
     */
    public function clear( $login )
    {
        // Purge obsolete login attempts
        $this->_ci->db->where( array('ip_address' => $this->_ci->input->ip_address(), 'login' => $login) )
                      ->or_where('unix_timestamp(time) <', time()-Setting::get('auth_login_attempt_expire'))
                      ->delete( $this->table['login_attempts'] );
    }

    // -------------------------------------------------------------------------

    /**
     * Get number of attempts to login occured from given IP-address or login
     *
     * @param   string
     * @param   string
     * @return  int
     */
    public function get_num( $login )
    {
        $query = $this->_ci->db->select('1', FALSE)
                               ->where('ip_address', $this->_ci->input->ip_address())
                               ->or_where('login', $login)
                               ->get( $this->table['login_attempts'] );

        return $query->num_rows();
    }
}

/* End of file Authr_login_attempt.php */
/* Location: ./application/libraries/Authr/driver/Authr_login_attempt.php */