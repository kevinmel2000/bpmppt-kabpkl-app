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
/* Location: ./application/third_party/bakaigniter/libraries/Authr/driver/Authr_role_perms.php */