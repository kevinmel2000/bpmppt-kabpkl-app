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