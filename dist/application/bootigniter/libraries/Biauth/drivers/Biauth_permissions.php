<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package     BootIgniter Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     https://github.com/feryardiant/bootigniter/blob/master/license.md
 * @since       Version 0.1.5
 */

// -----------------------------------------------------------------------------

/**
 * Biauth Permissions Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Biauth_permissions extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Biauth: Permissions Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Permissions
    // -------------------------------------------------------------------------

    public function fetch($is_assoc = FALSE)
    {
        $query = $this->_ci->db->select('*')->from($this->table['permissions']);

        if ($is_assoc)
        {
            $perms = array();

            foreach ($query->get()->result() as $perm)
            {
                $perms[$perm->id] = $perm->description;
            }

            return $perms;
        }

        return $query;
    }

    // -------------------------------------------------------------------------

    public function fetch_grouped()
    {
        return $this->_ci->db->select("group_concat(distinct id) id")
                             ->select("group_concat(distinct name) name")
                             ->select("group_concat(distinct description) description")
                             ->from($this->table['permissions'])
                             ->get()->result();
    }

    // -------------------------------------------------------------------------

    public function fetch_parents()
    {
        $ret = array();

        foreach ($this->fetch_grouped() as $row)
        {
            $ret[$row->parent] = $row->parent;
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    public function get($perm_id)
    {
        return $this->_ci->db->get_where($this->table['permissions'], array('id' => $perm_id))->row();
    }

    // -------------------------------------------------------------------------

    public function add($perm_data = array())
    {}

    // -------------------------------------------------------------------------

    public function edit($perm_id, $perm_data = array())
    {}

    // -------------------------------------------------------------------------

    public function delete($perm_id)
    {}

    // -------------------------------------------------------------------------

    /**
     * Check is Permission exists?
     *
     * @param   string  $permission  Permission Name
     *
     * @return  bool
     */
    public function is_exists($permission)
    {
        $query = $this->_ci->db->get_where($this->table['permissions'],
                 array('permission' => $permission), 1);

        return (bool) $query->num_rows();
    }
}

/* End of file Biauth_permissions.php */
/* Location: ./bootigniter/libraries/Biauth/driver/Biauth_permissions.php */
