<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Biauth_users
 * @category    Drivers
 */

// -----------------------------------------------------------------------------

class Biauth_users extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Biauth: Users Driver Initialized");
    }

    /**
     * Get list of all users
     *
     * @param   string  $status  Users status (activated|banned|deleted)
     *
     * @return  object
     */
    public function fetch($status = '')
    {
        $status || $status = 'activated';

        if (!in_array($status, array('activated', 'banned', 'deleted')))
        {
            log_message('error', '#Biauth: Users->fetch failed identify users using '.$status.' field.');
            return FALSE;
        }

        return $this->_ci->db->select("a.*")
            ->select("group_concat(distinct c.id) group_id")
            ->select("group_concat(distinct c.name) group_name")
            ->select("group_concat(distinct c.description) group_desc")
            ->from($this->table['users'].' a')
            ->join($this->table['user_group'].' b','b.user_id = a.id', 'inner')
            ->join($this->table['groups'].' c','c.id = b.group_id', 'inner')
            ->where('a.'.$status, 1)
            ->group_by('a.id');
    }

    // -------------------------------------------------------------------------

    /**
     * Get user data by $key
     *
     * @param   string  $term  The terms of users that you looking for
     * @param   string  $key   The parameter key that use by term (id|login|username|email)
     *
     * @return  mixed
     */
    public function get($term, $field = '')
    {
        $field || $field = 'id';

        if (is_array($term))
        {
            $this->_ci->db->where($term);
        }
        else
        {
            switch ($field)
            {
                case 'login':
                    $this->_ci->db->where('lower(username)', strtolower($term));
                    $this->_ci->db->or_where('lower(email)', strtolower($term));
                    break;

                case 'username':
                    $this->_ci->db->where('lower(username)', strtolower($term));
                    break;

                case 'email':
                    $this->_ci->db->where('lower(email)', strtolower($term));
                    break;

                default:
                    $this->_ci->db->where($field, $term);
                    break;
            }
        }

        $query = $this->_ci->db->get($this->table['users'], 1);

        if ($query->num_rows() > 0)
        {
            return $query->row();
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Create new user
     *
     * @param  array  $user_data  User data fields
     * @param  bool   $activated  Set it `True` if you want to directly activate
     *                            this user, and `False` for otherwise
     * @return bool
     */
    public function add(array $user_data)
    {
        $meta_data = array();
        $group_data = array();
        $user_data = array_set_defaults($user_data, array(
            'meta' => array(),
            'groups' => array(),
            'activated' => 1,
            ));

        $user_data['created'] = date('Y-m-d H:i:s');

        if (isset($user_data['request_key']) and !empty($user_data['request_key']))
        {
            $user_data['request_value'] = serialize(array('activated' => 1));
            $user_data['activated'] = 0;
        }

        if (isset($user_data['meta']))
        {
            $meta_data = $user_data['meta'];
            unset($user_data['meta']);
        }

        if (isset($user_data['groups']))
        {
            $group_data = $user_data['groups'];
            unset($user_data['groups']);
        }

        if (!$this->_ci->db->insert($this->table['users'], $user_data))
        {
            log_message('error', '#Biauth: Users->add failed creating new user.');
            return FALSE;
        }

        $user_id = $this->_ci->db->insert_id();

        if (!$this->set_meta($user_id, $meta_data))
        {
            log_message('error', '#Biauth: Users->add failed creating new usermeta.');
            return FALSE;
        }

        if (!$this->set_groups($user_id, $group_data))
        {
            log_message('error', '#Biauth: Users->add failed creating new usergroup.');
            return FALSE;
        }

        return $user_id;
    }

    // -------------------------------------------------------------------------

    /**
     * Update user data
     *
     * @param   int     $user_id    User ID
     * @param   array   $user_data  User Datas
     *
     * @return  bool
     */
    public function edit($user_id, array $user_data)
    {
        $meta_data = array();
        $group_data = array();
        $user_data = array_set_defaults($user_data, array(
            'meta' => array(),
            'groups' => array(),
            ));

        if (isset($user_data['meta']))
        {
            $meta_data = $user_data['meta'];
            unset($user_data['meta']);
        }

        if (isset($user_data['groups']))
        {
            $group_data = $user_data['groups'];
            unset($user_data['groups']);
        }

        $this->_ci->db->trans_start();


        if (!$this->_ci->db->update($this->table['users'], $user_data, array('id' => $user_id)))
        {
            log_message('error', '#Biauth: Users->edit failed updating user data');
            return FALSE;
        }

        if (!$this->edit_meta($user_id, $meta_data))
        {
            return FALSE;
        }

        if (!$this->edit_groups($user_id, $group_data))
        {
            log_message('error', '#Biauth: Users->edit_groups failed updating user data');
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Delete User data
     *
     * @param   integer  $user_id  User ID
     *
     * @return  bool
     */
    public function delete($user_id)
    {
        if (!$this->_ci->db->delete($this->table['users'], array('id' => $user_id)))
        {
            log_message('error', '#Biauth: Users->delete failed deleting user "'.$user_id.'" from "'.$this->table['users'].'" - '.$db->_error_message());
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Change User Status
     *
     * @param   int     $user_id     User ID
     * @param   string  $new_status  New User status (activated|banned|deleted)
     * @param   bool    $invert      Invert default value of new status
     * @param   array   $extra       Extra field values
     *
     * @return  bool
     */
    public function change_status($user_id, $status, $value = FALSE, array $extras = array())
    {
        $statuses = array('activated', 'banned', 'deleted');

        if (!in_array($status, $statuses))
        {
            log_message('error', '#Biauth: Users->change_status invalid user status.');
            return FALSE;
        }

        $value = bool_to_int($value);
        $user_data[$status] = $value;

        if (!empty($extras))
        {
            foreach ($extras as $ex_field => $ex_value)
            {
                $user_data[$ex_field] = $ex_value;
            }
        }

        return $this->edit($user_id, $user_data);
    }

    // -------------------------------------------------------------------------

    /**
     * Clean up dumb users (non-active users)
     *
     * @return  void
     */
    public function purge_na()
    {
        $expired = time() - Bootigniter::get_setting('auth_email_act_expire');

        $this->_ci->db->delete($this->table['users'], array(
            'activated' => 0,
            'unix_timestamp(created) <' => $expired
            ));
    }

    // -------------------------------------------------------------------------
    // Email
    // -------------------------------------------------------------------------

    /**
     * Set new email for user (may be activated or not).
     * The new email cannot be used for login or notification before it is activated.
     *
     * @param   int
     * @param   string
     * @param   string
     * @param   bool
     *
     * @return  bool
     */
    public function set_new_email($user_id, $new_email, $new_email_key)
    {
        return $this->edit($user_id,
            array('new_email' => $new_email, 'new_email_key' => $new_email_key)
            );
    }

    // -------------------------------------------------------------------------

    /**
     * Activate new email (replace old email with new one) if activation key is valid.
     *
     * @param   int     $user_id        User ID
     * @param   string  $new_email_key  Email Activation Key
     *
     * @return  bool
     */
    public function activate_new_email($user_id, $new_email_key)
    {
        $this->_ci->db->update($this->table['users'],
            array(
                'email' => 'new_email',
                'new_email' => NULL,
                'new_email_key' => NULL),
            array(
                'id' => $user_id,
                'new_email_key', $new_email_key)
            );

        return $this->_ci->db->affected_rows() > 0;
    }

    // -------------------------------------------------------------------------
    // User meta Relations
    // -------------------------------------------------------------------------

    /**
     * Get user meta by User ID
     *
     * @param   int    $user_id  User ID
     *
     * @return  mixed
     */
    public function get_meta($user_id, $is_assoc = FALSE)
    {
        $query = $this->_ci->db->get_where($this->table['user_meta'], array('user_id' => $user_id));

        if ($query->num_rows() > 0)
        {
            $metas = $query->row();

            if ($is_assoc == TRUE)
            {
                $output = array();

                foreach ($metas as $meta)
                {
                    $output[$meta->key] = $meta->value;
                }

                return $output;
            }

            return $metas;
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup user meta by User ID
     *
     * @param  int     $user_id    User ID
     * @param  array   $meta_data  User Metas
     *
     * @return bool
     */
    public function set_meta($user_id, $meta_data = array())
    {
        if (empty($meta_data))
        {
            $meta_data = array(
                'first_name' => '',
                'last_name'  => '',
                );
        }

        $data = array();

        foreach ($meta_data as $meta_key => $meta_value)
        {
            $data[] = array(
                'user_id' => $user_id,
                'key'     => $meta_key,
                'name'    => str_replace('_', ' ', ucfirst($meta_key)),
                'value'   => $meta_value,
                );
        }

        return $this->_ci->db->insert_batch($this->table['user_meta'], $data);
    }

    // -------------------------------------------------------------------------

    /**
     * Edit User Meta by User ID
     *
     * @param   int           $user_id     User ID
     * @param   array|string  $meta_key    Meta Data or Meta Key Field name
     * @param   string        $meta_value  Meta Value
     *
     * @return  bool
     */
    public function edit_meta($user_id, $meta_key, $meta_value = '')
    {
        if (is_array($meta_key) and empty($meta_value))
        {
            $this->_ci->db->trans_start();

            foreach ($meta_key as $key => $value)
            {
                if (!$this->edit_meta($user_id, $key, $value))
                {
                    log_message('error', '#Biauth: Users->edit_meta failed updating existing usermeta key: '.$key.' value: '.$value);
                    break;
                }
            }

            $this->_ci->db->trans_complete();

            if ($this->_ci->db->trans_status() === FALSE)
            {
                $this->_ci->db->trans_rollback();
                $return = FALSE;
            }

            $return = TRUE;
        }
        else
        {
            $return = $this->_ci->db->update(
                $this->table['user_meta'],
                array('value' => $meta_value),
                array('user_id' => $user_id, 'key' => $meta_key)
                );
        }

        if (!$return)
        {
            log_message('error', '#Biauth: Users->edit_meta failed updating existing usermeta.');
        }

        return $return;
    }

    // -------------------------------------------------------------------------

    /**
     * Clear user meta by User ID
     *
     * @param   int   $user_id  User ID
     *
     * @return  bool
     */
    public function clear_meta($user_id)
    {
        if (!$this->_ci->db->delete($this->table['user_meta'], array('user_id' => $user_id)))
        {
            log_message('error', '#Biauth: Users->delete failed deleting user "'.$user_id.'" from "'.$this->table['user_meta'].'" - '.$db->_error_message());
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------
    // User Groups Relation
    // -------------------------------------------------------------------------

    /**
     * Returns a multidimensional array with info on the user's groups in associative format
     * Keys: 'group_id', 'group', 'full', 'default'
     *
     * @param   int    $user_id  User ID
     *
     * @return  array
     */
    public function get_groups($user_id)
    {
        $query = $this->_ci->db->select("a.*")
                               ->from($this->table['groups'].' a')
                               ->join($this->table['user_group'].' b', 'b.group_id = a.id', 'inner')
                               ->where('b.user_id', $user_id);

        if ($get = $query->get())
        {
            $groups = array();

            foreach ($get->result() as $row)
            {
                $groups[$row->id] = $row->name;
            }

            return $groups;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Set Groups to User
     *
     * @param   int    $user_id   User ID
     * @param   array  $groups_id  Groups ID
     *
     * @return  bool
     */
    public function set_groups($user_id, $groups_id = array())
    {
        if (!empty($groups_id))
        {
            foreach ($groups_id as $group_name)
            {
                if (($id = array_search($group_name, $this->fetch_groups_assoc())) !== false)
                {
                    $group_id = $id;
                }

                $usergroup_data[] = array(
                    'user_id' => $user_id,
                    'group_id' => $group_id,
                    );

                log_message('debug', 'Assign user '.$user_id.' to group '.$group_id);
            }

            return $this->_ci->db->insert_batch($this->table['user_group'], $usergroup_data);
        }
        else
        {
            $q_admin = $this->_ci->db->get_where($this->table['user_group'], array('group_id' => 1), 1);

            if ($q_admin->num_rows() > 0)
            {
                $q_group = $this->_ci->db->get_where($this->table['groups'], array('default' => 1), 1)->row();
                $group_id = $q_group->id;
            }
            else
            {
                $group_id = 1;
            }

            return $this->_ci->db->insert($this->table['user_group'], array(
                'user_id' => $user_id,
                'group_id' => $group_id,
                ));
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Edit a user's groups
     *
     * @param   [type]  $user_id    [description]
     * @param   [type]  $new_groups  [description]
     * @return  [type]
     */
    public function edit_groups($user_id, $new_groups)
    {
        if (empty($new_groups))
        {
            return FALSE;
        }

        $old_groups = array_keys($this->get_groups($user_id));
        $this->_ci->db->trans_start();

        foreach (array_diff($old_groups, $new_groups) as $key => $old_id)
        {
            unset($old_groups[$key]);
            $this->_ci->db->delete($this->table['user_group'], array(
                'user_id' => $user_id,
                'group_id' => $old_id
                ));
        }

        foreach ($new_groups as $new_id)
        {
            if (!in_array($new_id, $old_groups))
            {
                $this->_ci->db->insert($this->table['user_group'], array(
                    'user_id' => $user_id,
                    'group_id' => $new_id
                    ));
            }
        }

        $this->_ci->db->trans_complete();

        if ($this->_ci->db->trans_status() === FALSE)
        {
            $this->_ci->db->trans_rollback();
            log_message('error', '#Biauth: Users->edit_groups failed updating existing usergroup.');
            return FALSE;
        }

        log_message('info', '#Biauth: Users->edit_groups success updating existing usergroup.');
        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Clear user meta by User ID
     *
     * @param   int   $user_id  User ID
     *
     * @return  bool
     */
    public function clear_groups($user_id)
    {
        if (!$this->_ci->db->delete($this->table['user_group'], array('user_id' => $user_id)))
        {
            log_message('error', '#Biauth: Users->delete failed deleting user "'.$user_id.'" from "'.$this->table['user_group'].'" - '.$db->_error_message());
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------
    // User Permissions Relation
    // -------------------------------------------------------------------------

    /**
     * Grab all permissions for $user_id
     *
     * @param   int    $user_id   User ID
     * @param   bool   $is_assoc  Did you need associative array?
     * @return  object
     */
    public function get_perms($user_id, $is_assoc = FALSE)
    {
        $query = $this->_ci->db->select("d.*")
            ->from($this->table['user_group'].' a')
            ->join($this->table['groups'].' b', 'b.id = a.group_id')
            ->join($this->table['group_perms'].' c', 'c.group_id = b.id')
            ->join($this->table['permissions'].' d', 'd.id = c.perms_id')
            ->where('a.user_id', $user_id)
            ->get();

        if ($query && $query->num_rows() > 0)
        {
            $perms = $query->result();

            if ($is_assoc = TRUE)
            {
                $output = array();

                foreach ($perms as $perm)
                {
                    $output[$perm->id] = $perm->name;
                }

                return $output;
            }

            return $perms;
        }

        return FALSE;
    }
}

/* End of file Biauth_users.php */
/* Location: ./bootigniter/libraries/Biauth/driver/Biauth_users.php */
