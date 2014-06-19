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
 * Authr User Permissions Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_user_perms extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: User Permissions Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // User Permissions Relation
    // -------------------------------------------------------------------------

    public function fetch( $user_id )
    {
        $query = $this->db->select("d.permission_id id, d.permission perm, d.description")
                          ->from($this->table['user_role'].' a')
                          ->join($this->table['roles'].' b', 'b.role_id = a.role_id')
                          ->join($this->table['role_perms'].' c', 'c.role_id = b.role_id')
                          ->join($this->table['permissions'].' d', 'd.permission_id = c.permission_id')
                          ->where('a.user_id', $user_id)
                          ->get();

        if ( $query->num_rows() > 0 )
        {
            $ret = array();

            foreach ( $query->result() as $row )
            {
                $ret[$row->id] = $row->perm;
            }

            return $ret;
        }

        return FALSE;
    }
}

/* End of file Authr_user_perms.php */
/* Location: ./application/third_party/bakaigniter/libraries/Authr/driver/Authr_user_perms.php */