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
 * Authr User Roles Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_user_roles extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: User Roles Driver Initialized");
    }

    /**
     * Returns a multidimensional array with info on the user's roles in associative format
     * Keys: 'role_id', 'role', 'full', 'default'
     *
     * @param   int    $user_id  User ID
     *
     * @return  array
     */
    public function get( $user_id )
    {
        $query = $this->db->select("b.role_id, b.role, b.full, b.default")
                          ->from($this->table['user_role'].' a')
                          ->join($this->table['roles'].' b', 'b.role_id = a.role_id')
                          ->where('user_id', $user_id)
                          ->get();

        $ret = array();

        foreach ( $query->result() as $row )
        {
            $ret[$row->role_id] = $row->full;
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    /**
     * Set Roles to User
     *
     * @param   int    $user_id   User ID
     * @param   array  $roles_id  Roles ID
     *
     * @return  bool
     */
    public function set( $user_id, $roles = array() )
    {
        // If admin exists
        if ($this->db->get_where($this->table['user_role'], array('role_id' => 1), 1)->num_rows() > 0)
        {
            // If $roles is empty
            if (count($roles) == 0)
            {
                // Use default role
                $roles[] = $this->db->get_where($this->table['roles'], array('default' => 1), 1)->row()->role_id;
            }

            foreach ($roles as $role)
            {
                $role_data[] = array(
                    'user_id' => $user_id,
                    'role_id' => $role,
                    );
            }

            return $this->db->insert_batch($this->table['user_role'], $role_data);
        }
        else
        {
            // If admin not exists, set this $user_id as admin.
            return $this->db->insert($this->table['user_role'], array('user_id' => $user_id, 'role_id' => 1));
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Change a user's role for another
     *
     * @param   int    $user_id    User ID
     * @param   array  $new_roles  New user roles
     * @return  bool
     */
    public function edit( $user_id, $new_roles )
    {
        if ( count( $new_roles ) == 0 )
        {
            return FALSE;
        }

        // Fetch all user roles
        $old_roles = array_keys($this->get($user_id));
        // Grab user roles differences
        $deleted_roles = array_diff($new_roles, $old_roles);
        // Delete unused roles
        $this->remove($user_id, $deleted_roles);
        // Set them
        $this->set($user_id, $new_roles);

        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Remove role from user. Cannot remove role if user only has 1 role
     *
     * @param   int    $user_id  User ID
     * @param   int    $roles    User Roles
     *
     * @return  mixed
     */
    public function remove($user_id, $roles)
    {
        // If there's only 1 role then removal is denied
        if ($this->db->get_where($this->table['user_role'], array('user_id' => $user_id))->num_rows() <= 1)
        {
            return FALSE;
        }

        if (count($roles) > 0)
        {
            foreach ($roles as $role)
            {
                $this->db->delete($this->table['user_role'], array('user_id' => $user_id, 'role_id' => $role));
            }

            return TRUE;
        }

        return FALSE;
    }
}

/* End of file Authr_user_roles.php */
/* Location: ./bakaigniter/libraries/Authr/driver/Authr_user_roles.php */
