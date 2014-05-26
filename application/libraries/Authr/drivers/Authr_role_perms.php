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
 * Authr Role Permissions Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_role_perms extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: Role Permissions Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Role Permissions Relation
    // -------------------------------------------------------------------------

    /**
     * Gets the permissions assigned to a role
     *
     * @param   int  $role_id  Role ID
     *
     * @return  obj
     */
    public function fetch( $role_id )
    {
        // $query = $this->db->select("permission")
        //                   ->from($this->table['permissions'].' a')
        //                   ->join($this->table['role_perms'].' b', 'b.permission_id = a.permission_id', 'inner')
        //                   ->where('role_id', $role_id);

        // return $query->result();

        $query = $this->db->get_where( $this->table['role_perms'], array('role_id' => $role_id ));

        if ( $query->num_rows() > 0 )
        {
            foreach ( $query->result() as $row )
            {
                $result[] = $row->permission_id;
            }

            return $result;
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Get related permissions of role_id
     * 
     * @param   int     $role_id    ID of role
     * @return  array               list of related permissions
     */
    public function get_role_related_perms( $role_id )
    {
        $query = $this->db->get_where( $this->table['role_perms'], array('role_id' => $role_id ));

        if ( $query->num_rows() > 0 )
        {
            foreach ( $query->result() as $row )
            {
                $result[] = $row->permission_id;
            }

            return $result;
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------
    
    /**
     * Update relation of roles and permissions table
     * 
     * @param   array   $permission  array of new permissions
     * @param   int     $role_id     id of role
     * 
     * @return  mixed
     */
    public function update( $permissions = array(), $role_id)
    {
        if ( count( $permissions ) > 0 )
        {
            $related_permission = $this->get_role_perms( $role_id );

            foreach ($permissions as $perm_id)
            {
                if ( !in_array( $perm_id, $related_permission ) )
                {
                    $return = $this->db->insert( $this->table['role_perms'], array(
                        'role_id'       => $role_id,
                        'permission_id' => $perm_id ));
                }
            }

            if ( $related_permission )
            {
                foreach ( $related_permission as $rel_id )
                {
                    if ( !in_array( $rel_id, $permissions ) )
                    {
                        $return = $this->db->delete( $this->table['role_perms'], array(
                            'permission_id' => $rel_id ));
                    }
                }
            }

            return $return;
        }
    }
}

/* End of file Authr_role_perms.php */
/* Location: ./application/libraries/Authr/driver/Authr_role_perms.php */