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
 * Authr Autologin Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_autologin extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: Autologin Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Autologin
    // -------------------------------------------------------------------------

    /**
     * Get user data for auto-logged in user.
     * Return FALSE if given key or user ID is invalid.
     *
     * @param   string    $key  Autologin Key
     *
     * @return  obj|bool
     */
    public function get( $user_id, $key )
    {
        $query = $this->db->select('a.id, a.username, a.activated')
                          ->from($this->table['users'].' a')
                          ->join($this->table['user_autologin'].' b', 'b.user_id = a.id')
                          ->where('b.user_id', $user_id)
                          ->where('b.key_id', $key)
                          ->get();

        if ( $query->num_rows() == 1 )
            return $query->row();
        
        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Save data for user's autologin
     *
     * @param   int
     * @param   string
     * @return  bool
     */
    public function set( $user_id, $key )
    {
        return $this->db->insert( $this->table['user_autologin'], array(
            'user_id'       => $user_id,
            'key_id'        => $key,
            'user_agent'    => substr($this->_ci->input->user_agent(), 0, 149),
            'last_ip'       => $this->_ci->input->ip_address() ));
    }

    // -------------------------------------------------------------------------

    /**
     * Purge autologin data for given user and login conditions
     *
     * @param   int
     * @return  void
     */
    public function purge( $user_id )
    {
        $this->db->delete($this->table['user_autologin'], array(
            'user_id'   => $user_id,
            'user_agent'=> substr($this->_ci->input->user_agent(), 0, 149),
            'last_ip'   => $this->_ci->input->ip_address() ));
    }

    // -------------------------------------------------------------------------

    /**
     * Clear user's autologin data
     *
     * @return  void
     */
    public function delete()
    {
        if ( $cookie = get_cookie( get_conf('autologin_cookie_name'), TRUE ) )
        {
            $data = unserialize( $cookie );

            $this->db->delete(
                $this->table['user_autologin'],
                array(
                    'user_id'   => $data['user_id'],
                    'key_id'    => md5($data['key'])
                    )
                );

            delete_cookie( get_conf('autologin_cookie_name') );
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Delete all autologin data for given user
     *
     * @param   int
     * @return  void
     */
    public function clear( $user_id )
    {
        $this->db->delete($this->table['user_autologin'], array( 'user_id' => $user_id ));
    }
}

/* End of file Authr_autologin.php */
/* Location: ./application/libraries/Authr/driver/Authr_autologin.php */