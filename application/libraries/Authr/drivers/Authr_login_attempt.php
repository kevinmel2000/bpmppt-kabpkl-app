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
 * @package     CodeIgniter Baka Authr
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
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