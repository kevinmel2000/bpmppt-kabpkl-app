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
 * Authr Permissions Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_permissions extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: Permissions Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Permissions
    // -------------------------------------------------------------------------

    public function fetch()
    {
        // $query = $this->db->select("parent")
        //                   ->select("group_concat(distinct permission_id) perm_id")
        //                   ->select("group_concat(distinct permission) perm_name")
        //                   ->select("group_concat(distinct description) perm_desc");

        return $this->db->select('*')->from( $this->table['permissions'] );;
    }

    // -------------------------------------------------------------------------

    public function fetch_grouped()
    {
        return $this->db->select("parent")
                        ->select("group_concat(distinct permission_id) perm_id")
                        ->select("group_concat(distinct permission) perm_name")
                        ->select("group_concat(distinct description) perm_desc")
                        ->from( $this->table['permissions'] )
                        ->group_by('parent')
                        ->get()->result();
    }

    // -------------------------------------------------------------------------

    public function fetch_parents()
    {
        $ret = array();

        foreach ( $this->fetch_grouped() as $row )
        {
            $ret[$row->parent] = $row->parent;
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    public function get( $perm_id )
    {
        return $this->db->get_where( $this->table['permissions'], array('permission_id' => $perm_id) )->row();
    }

    // -------------------------------------------------------------------------

    public function add( $perm_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function edit( $perm_id, $perm_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function delete( $perm_id )
    {}

    // -------------------------------------------------------------------------

    /**
     * Check is Permission exists?
     *
     * @param   string  $permission  Permission Name
     *
     * @return  bool
     */
    public function is_exists( $permission )
    {
        $query = $this->db->get_where( $this->table['permissions'],
                 array('permission' => $permission), 1);

        return (bool) $query->num_rows();
    }
}

/* End of file Authr_permissions.php */
/* Location: ./application/libraries/Authr/driver/Authr_permissions.php */