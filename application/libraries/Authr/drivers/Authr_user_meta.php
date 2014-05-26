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
 * Authr Users Meta Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_users_meta extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: Users Meta Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // User metas
    // -------------------------------------------------------------------------

    /**
     * Get user meta by User ID
     *
     * @param   int    $user_id  User ID
     *
     * @return  mixed
     */
    public function fetch( $user_id )
    {
        $query = $this->db->get_where( $this->table['user_meta'], array('user_id' => $user_id) );

        if ( $query->num_rows() > 0 )
            return $query->row();

        return FALSE;
    }

    // -------------------------------------------------------------------------

    public function get( $key, $val )
    {}

    // -------------------------------------------------------------------------

    /**
     * Setup user meta by User ID
     *
     * @param  int     $user_id    User ID
     * @param  array   $meta_data  User Metas
     *
     * @return bool
     */
    public function set( $user_id, $meta_data = array() )
    {
        if ( count( $meta_data ) == 0 )
        {
            $meta_data = get_conf('default_meta_fields');
        }

        $data = array();
        $i    = 0;

        foreach ( $meta_data as $meta_key => $meta_value )
        {
            $data[$i]['user_id']    = $user_id;
            $data[$i]['meta_key']   = $meta_key;
            $data[$i]['meta_value'] = $meta_value;

            $i++;
        }

        return $this->db->insert_batch( $this->table['user_meta'], $data );
    }

    // -------------------------------------------------------------------------

    /**
     * Edit User Meta by User ID
     *
     * @param   int           $user_id     User ID
     * @param   array|string  $meta_key    Meta Data or Meta Key Field name
     * @param   string        $meta_value  Meta Value
     *
     * @return  bool
     */
    public function edit( $user_id, $meta_key, $meta_value = '' )
    {
        if ( is_array( $meta_key ) and strlen( $meta_value ) == 0 )
        {
            $this->db->trans_start();

            foreach ( $meta_key as $key => $value )
            {
                $this->edit_user_meta( $user_id, $key, $value );
            }

            $this->db->trans_complete();
            
            if ( $this->db->trans_status() === FALSE )
            {
                $this->db->trans_rollback();
                return FALSE;
            }

            return TRUE;
        }
        else
        {
            return $this->db->update(
                $this->table['user_meta'],
                array('meta_value' => $meta_value),
                array('user_id' => $user_id, 'meta_key' => $meta_key)
                );
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Clear user meta by User ID
     *
     * @param   int   $user_id  User ID
     *
     * @return  bool
     */
    public function clear( $user_id )
    {
        return $this->db->delete( $this->table['user_meta'], array('user_id' => $user_id) );
    }

    // -------------------------------------------------------------------------

    public function delete( $meta_id )
    {}
}

/* End of file Authr_users_meta.php */
/* Location: ./application/libraries/Authr/driver/Authr_users_meta.php */