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
 * Biauth Groups Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Biauth_groups extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Biauth: Groups Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Groups
    // -------------------------------------------------------------------------

    public function fetch()
    {
        return $this->_ci->db->select("a.*")
                             ->select("count(c.id) perm_count")
                             ->select("group_concat(distinct c.id) perm_id")
                             ->select("group_concat(distinct c.description) perm_desc")
                             ->from($this->table['groups'].' a')
                             ->join($this->table['group_perms'].' b','b.group_id = a.id', 'inner')
                             ->join($this->table['permissions'].' c','c.id = b.perms_id', 'inner')
                             ->group_by('a.id');
    }

    // -------------------------------------------------------------------------

    public function fetch_assoc()
    {
        $query = $this->_ci->db->get($this->table['groups']);

        $ret = array();

        foreach ($query->result() as $row)
        {
            $ret[$row->id] = $row->description;
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    public function get($group_id)
    {
        if ($result = $this->fetch()->where('a.id', $group_id)->get())
        {
            return $result->row();
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    public function set($group_data = array(), $user_id)
    {
        return TRUE;
    }

    // -------------------------------------------------------------------------

    public function add($group_data = array(), $user_id)
    {
        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Updating group fields
     *
     * @param   int     $group_id        Group id that wanna be updated
     * @param   array   $group_data      Array of new group data
     * @param   array   $permissions    Array of new permission data
     *
     * @return  bool
     */
    public function edit($group_data, $group_id = NULL, $perms = array())
    {
        $this->_ci->db->trans_start();

        if (!is_null($group_id))
        {
            $this->_ci->db->update($this->table['groups'], $group_data, array('id' => $group_id));
        }
        else
        {
            $this->_ci->db->insert($this->table['groups'], $group_data);
            $group_id = $this->_ci->db->insert_id();
        }

        if (count($perms) > 0)
        {
            $return = $this->update_group_perm($perms, $group_id);
        }

        $this->_ci->db->trans_complete();

        if (!($return = $this->_ci->db->trans_status()))
        {
            $this->_ci->db->trans_rollback();
        }

        return $return;
    }

    // -------------------------------------------------------------------------

    public function change($group_id, $group_data = array())
    {
        return TRUE;
    }

    // -------------------------------------------------------------------------

    public function delete($group_id)
    {
        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Check is Group ID Exists?
     *
     * @param   int   $group_id  Group ID
     *
     * @return  bool
     */
    public function is_exists($group_id)
    {
        $query = $this->_ci->db->get_where($this->table['groups'], array('id' => $group_id), 1);

        return (bool) $query->num_rows();
    }

    // -------------------------------------------------------------------------
    // Group Permissions Relation
    // -------------------------------------------------------------------------

    /**
     * Get related permissions of group_id
     *
     * @param   integer  $group_id  Group ID
     *
     * @return  array
     */
    public function fetch_perms($group_id)
    {
        $query = $this->_ci->db->get_where($this->table['group_perms'], array('group_id' => $group_id));

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $result[] = $row->permission_id;
            }

            return $result;
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Update relation of groups and permissions table
     *
     * @param   array    $permission   Array of new permissions
     * @param   integer  $group_id     Id of group
     *
     * @return  mixed
     */
    public function update_perms($permissions = array(), $group_id)
    {
        if (count($permissions) > 0)
        {
            $related_permission = $this->fetch($group_id);

            foreach ($permissions as $perm_id)
            {
                if (!in_array($perm_id, $related_permission))
                {
                    $return = $this->_ci->db->insert($this->table['group_perms'], array(
                        'group_id'       => $group_id,
                        'permission_id' => $perm_id));
                }
            }

            if ($related_permission)
            {
                foreach ($related_permission as $rel_id)
                {
                    if (!in_array($rel_id, $permissions))
                    {
                        $return = $this->_ci->db->delete($this->table['group_perms'], array(
                            'permission_id' => $rel_id));
                    }
                }
            }

            return $return;
        }
    }
}

/* End of file Biauth_groups.php */
/* Location: ./bootigniter/libraries/Biauth/driver/Biauth_groups.php */
