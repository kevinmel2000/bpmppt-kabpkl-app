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

    // -------------------------------------------------------------------------
    // User Roles Relation
    // -------------------------------------------------------------------------

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
    public function set( $user_id, $roles_id = array() )
    {
        $cr = count( $roles_id );

        if ( $cr > 0 )
        {
            for ( $i=0; $i<$cr; $i++ )
            {
                $role_data[$i]['user_id']   = $user_id;
                $role_data[$i]['role_id']   = $roles_id[$i];
            }

            return $this->db->insert_batch( $this->table['user_role'], $role_data );
        }
        else
        {
            $q_admin = $this->db->get_where( $this->table['user_role'], array('role_id' => 1), 1);

            if ( $q_admin->num_rows() > 0 )
            {
                // If admin exists, use the default role
                $q_role = $this->db->get_where( $this->table['roles'], array('default' => 1), 1)->row();

                return $this->db->insert( $this->table['user_role'],
                    array('user_id' => $user_id, 'role_id' => $q_role->role_id));
            }
            else
            {
                // If there's no admin then make this person the admin
                return $this->db->insert( $this->table['user_role'],
                    array('user_id' => $user_id, 'role_id' => 1));
            }
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Edit a user's roles
     *
     * @todo    done it!
     *
     * @param   [type]  $user_id    [description]
     * @param   [type]  $new_roles  [description]
     * @return  [type]
     */
    public function edit( $user_id, $new_roles )
    {
        if ( count( $new_roles ) == 0 )
        {
            return FALSE;
        }

        $old_roles = array_keys( $this->get( $user_id ) );

        foreach ($new_roles as $role)
        {
            if (!in_array($role, $old_roles))
            {
                $this->db->insert( $this->table['user_role'],
                                   array('user_id' => $user_id, 'role_id' => $role_id));
            }
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Change a user's role for another
     *
     * @param   int  $user_id  User ID
     * @param   [type]  $old      [description]
     * @param   [type]  $new      [description]
     *
     * @return  [type]
     */
    public function change( $user_id, $old, $new )
    {
        // Do nothing if $role is int
        if (is_string($old))
            $old = $this->get_role_id(trim($old));

        if (is_string($new))
            $new = $this->get_role_id(trim($new));

        return $this->db->update( $this->table['user_role'],
                                  array('role_id' => $new),
                                  array('role_id' => $old, 'user_id' => $user_id) );
    }

    // -------------------------------------------------------------------------

    /**
     * Remove role from user. Cannot remove role if user only has 1 role
     *
     * @param   int    $user_id  User ID
     * @param   int    $role     User Role
     *
     * @return  mixed
     */
    public function remove( $user_id, $role )
    {
        if ( $this->has_role( $user_id, $role ) )
            return TRUE;

        // If there's only 1 role then removal is denied
        $this->db->get_where( $this->table['user_role'],
                              array('user_id' => $user_id) );

        if ( $this->db->count_all_results() <= 1 )
            return FALSE;

        // Do nothing if $role is int
        if ( is_string( $role ) )
            $role = $this->get_role_id(trim($role));

        return $this->db->delete( $this->table['user_role'],
                                  array('user_id' => $user_id, 'role_id' => $role_id));
    }
}

/* End of file Authr_user_roles.php */
/* Location: ./application/third_party/bakaigniter/libraries/Authr/driver/Authr_user_roles.php */
