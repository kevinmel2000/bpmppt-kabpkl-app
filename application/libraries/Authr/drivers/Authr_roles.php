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
 * Authr Roles Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_roles extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: Roles Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Roles
    // -------------------------------------------------------------------------

    public function fetch()
    {
        return $this->db->select("a.role_id id, a.role name, a.full, a.default")
                        ->select("count(c.permission_id) perm_count")
                        ->select("group_concat(distinct c.permission_id) perm_id")
                        ->select("group_concat(distinct c.description) perm_desc")
                        ->from($this->table['roles'].' a')
                        ->join($this->table['role_perms'].' b','b.role_id = a.role_id', 'inner')
                        ->join($this->table['permissions'].' c','c.permission_id = b.permission_id', 'inner')
                        ->group_by('a.role_id');
    }

    // -------------------------------------------------------------------------
    
    public function fetch_assoc()
    {
        $query = $this->db->get($this->table['roles']);

        $ret = array();

        foreach ( $query->result() as $row )
        {
            $ret[$row->role_id] = $row->full;
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    public function get( $group_id )
    {
        $query = $this->fetch();

        return $query->where('a.role_id', $group_id)->get()->row();
    }

    // -------------------------------------------------------------------------

    public function set( $role_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function add( $role_data = array() )
    {}

    // -------------------------------------------------------------------------

    /**
     * Updating role fields
     * 
     * @param   int     $role_id        Role id that wanna be updated
     * @param   array   $role_data      Array of new role data
     * @param   array   $permissions    Array of new permission data
     * 
     * @return  bool
     */
    public function edit( $role_data, $role_id = NULL, $perms = array() )
    {
        $this->db->trans_start();

        if ( !is_null($role_id) )
        {
            $this->db->update( $this->table['roles'], $role_data, array('role_id' => $role_id ));
        }
        else
        {
            $this->db->insert( $this->table['roles'], $role_data );
            $role_id = $this->db->insert_id();
        }

        if ( count($perms) > 0 )
        {
            $return = $this->update_role_perm( $perms, $role_id );
        }

        $this->db->trans_complete();

        if ( !( $return = $this->db->trans_status() ) )
        {
            $this->db->trans_rollback();
        }

        return $return;
    }

    // -------------------------------------------------------------------------

    public function change( $role_id, $role_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function delete( $role_id )
    {}

    // -------------------------------------------------------------------------

    /**
     * Check is Role ID Exists?
     *
     * @param   int   $role_id  Role ID
     *
     * @return  bool
     */
    public function is_exists( $role_id )
    {
        $query = $this->db->get_where( $this->table['roles'], array('role_id' => $role), 1);

        return (bool) $query->num_rows();
    }
}

/* End of file Authr_roles.php */
/* Location: ./application/libraries/Authr/driver/Authr_roles.php */