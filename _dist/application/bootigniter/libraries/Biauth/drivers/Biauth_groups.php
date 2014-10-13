<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Biauth_groups
 * @category    Drivers
 */

// -----------------------------------------------------------------------------

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

    public function add($group_data)
    {
        $group_perms = array();
        $group_data = array_set_defaults($group_data, array(
            'perms' => array(),
            ));

        if (!empty($group_data['perms']))
        {
            $group_perms = $group_data['perms'];
            unset($group_data['perms']);
        }

        $this->_ci->db->trans_start();

        $this->_ci->db->insert($this->table['groups'], $group_data);
        $group_id = $this->_ci->db->insert_id();
        $this->set_perms($group_id, $group_perms);

        $this->_ci->db->trans_complete();

        if ($this->_ci->db->trans_status() === FALSE)
        {
            $this->_ci->db->trans_rollback();
            log_message('error', '#Biauth: Groups->add failed adding new group.');
            return FALSE;
        }

        log_message('info', '#Biauth: Groups->add success adding new group.');
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
    public function edit($group_id, $group_data)
    {
        $group_perms = array();
        $group_data = array_set_defaults($group_data, array(
            'perms' => array(),
            ));

        if (!empty($group_data['perms']))
        {
            $group_perms = $group_data['perms'];
            unset($group_data['perms']);
        }

        $this->_ci->db->trans_start();

        $this->_ci->db->update($this->table['groups'], $group_data, array('id' => $group_id));
        $return = $this->edit_perms($group_id, $group_perms);

        $this->_ci->db->trans_complete();

        if ($this->_ci->db->trans_status() === FALSE)
        {
            $this->_ci->db->trans_rollback();
            log_message('error', '#Biauth: Groups->edit failed updating existing group.');
            return FALSE;
        }

        log_message('info', '#Biauth: Groups->edit success updating existing group.');
        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Switch default groups
     *
     * @param  integer  $group_id  Group Id
     */
    public function set_default($group_id)
    {
        if (!$this->_ci->db->update($this->table['groups'], array('default' => 0), array('default' => 1)))
        {
            log_message('error', '#Biauth: Groups->set_default failed unset existing default group.');
            return FALSE;
        }

        if (!$this->_ci->db->update($this->table['groups'], array('default' => 1), array('id' => $group_id)))
        {
            log_message('error', '#Biauth: Groups->set_default failed setup new default group.');
            return FALSE;
        }

        log_message('info', '#Biauth: Groups->set_default success setup new default group.');
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
     * Set permissions of group_id relation
     *
     * @param   integer  $group_id  Group ID
     *
     * @return  array
     */
    public function set_perms($group_id, $new_perms, $old_perms = array())
    {
        if (empty($old_perms) and ($perms = $this->_ci->db->get($this->table['permissions'])))
        {
            $old_perms = array();
            foreach ($perms->result() as $perm)
            {
                $old_perms[] = $perm->id;
            }
        }

        foreach ($new_perms as $perm_id)
        {
            if (in_array($perm_id, $old_perms))
            {
                $perms_data[] = array('group_id' => $group_id, 'perms_id' => $perm_id);
            }

            $this->_ci->db->insert_batch($this->table['group_perms'], $perms_data);
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Get permissions of group_id relation
     *
     * @param   integer  $group_id  Group ID
     *
     * @return  array
     */
    public function get_perms($group_id)
    {
        $query = $this->_ci->db->get_where($this->table['group_perms'], array('group_id' => $group_id));

        if ($query and $query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $result[] = $row->perms_id;
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
    public function edit_perms($group_id, $new_perms = array())
    {
        if (empty($new_perms))
        {
            return FALSE;
        }

        $old_perms = $this->get_perms($group_id);
        $this->_ci->db->trans_start();

        foreach (array_diff($old_perms, $new_perms) as $key => $old_id)
        {
            unset($old_perms[$key]);
            $this->delete_perm($group_id, $old_id);
        }

        $this->set_perms($group_id, $new_perms, $old_perms);

        $this->_ci->db->trans_complete();

        if ($this->_ci->db->trans_status() === FALSE)
        {
            $this->_ci->db->trans_rollback();
            log_message('error', '#Biauth: Groups->edit_perms failed updating existing groupperms.');
            return FALSE;
        }

        log_message('info', '#Biauth: Groups->edit_perms success updating existing groupperms.');
        return TRUE;
    }

    public function delete_perm($group_id, $perm_id)
    {
        return $this->_ci->db->delete($this->table['group_perms'], array(
            'group_id' => $group_id,
            'perm_id' => $perm_id
            ));
    }
}

/* End of file Biauth_groups.php */
/* Location: ./bootigniter/libraries/Biauth/driver/Biauth_groups.php */
