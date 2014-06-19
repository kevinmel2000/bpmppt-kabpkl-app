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
/* Location: ./application/third_party/bakaigniter/libraries/Authr/driver/Authr_roles.php */