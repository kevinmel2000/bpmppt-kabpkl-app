<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Everyone is permitted to copy and distribute verbatim or modified 
 * copies of this license document, and changing it is allowed as long 
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE 
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION 
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://www.wtfpl.net
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Authen_model Class
 *
 * @subpackage  Models
 * @category    Users
 */
class Authen_model extends CI_Model
{
    /**
     * Tables definition
     *
     * @var  array
     */
    protected $table = array();

    /**
     * Update expiration period
     *
     * @var  int
     */
    protected $update_expired = 900;

    /**
     * Class Constructor
     */
    function __construct()
    {
        parent::__construct();

        $tables = array(
            'users',
            'user_meta',
            'user_role',
            'roles',
            'permissions',
            'role_perms',
            'overrides',
            'user_autologin',
            'login_attempts',
            );

        foreach ( $tables as $table )
        {
            $this->table[$table] = get_conf( $table.'_table' );
        }

        log_message('debug', "#Baka_pack: Authen model Initialized");
    }

    // -------------------------------------------------------------------------
    // Users
    // -------------------------------------------------------------------------

    /**
     * Get list of all users
     *
     * @param   string  $status  Users status (activated|banned|deleted)
     *
     * @return  object
     */
    public function get_users( $status = '' )
    {
        $status || $status = 'activated';

        if ( !in_array( $status, array( 'activated', 'banned', 'deleted' ) ) )
        {
            log_message('error', '#Baka_pack: Authen->get_users failed identify users using '.$status.' field.');
            return FALSE;
        }

        return $this->db->select("a.id, a.username, a.email")
                        ->select("a.activated, a.banned, a.ban_reason, a.deleted")
                        ->select("a.last_ip, a.last_login, a.created, a.modified")
                        ->select("group_concat(distinct c.role_id) role_id")
                        ->select("group_concat(distinct c.role) role_name")
                        ->select("group_concat(distinct c.full) role_fullname")
                        ->from($this->table['users'].' a')
                        ->join($this->table['user_role'].' b','b.user_id = a.id', 'inner')
                        ->join($this->table['roles'].' c','c.role_id = b.role_id', 'inner')
                        ->where('a.'.$status, 1)
                        ->group_by('a.id');
    }

    // -------------------------------------------------------------------------

    /**
     * Get single user data
     *
     * @param   string  $val  Value of user field
     * @param   string  $key  Key of user field (id|login|username|email)
     *
     * @return  mixed
     */
    public function get_user( $val, $key = 'id' )
    {
        if ( !in_array( $key, array( 'id', 'login', 'username', 'email' ) ) )
        {
            log_message('error', '#Baka_pack: Authen->get_user failed identifying user using '.$key.' field.');
            return FALSE;
        }

        switch ( $key )
        {
            case 'login':
                $this->db->where( 'lower(username)', strtolower( $val ) );
                $this->db->or_where( 'lower(email)', strtolower( $val ) );
                break;

            case 'username':
                $this->db->where( 'lower(username)', strtolower( $val ) );
                break;

            case 'email':
                $this->db->where( 'lower(email)', strtolower( $val ) );
                break;

            case 'id':
                $this->db->where( 'id', $val );
                break;
        }

        $query = $this->db->get( $this->table['users'], 1 );

        if ( $query->num_rows() > 0 )
            return $query->row();

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Check is Username or Email already exists
     *
     * @param   string  $login  Username|Email
     *
     * @return  bool
     */
    public function check_login( $login )
    {
        return $this->get_user( $login, 'login' ) !== FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Check is Username already exists
     *
     * @param   string  $login  Username
     *
     * @return  bool
     */
    public function check_username( $username )
    {
        return $this->get_user( $username, 'username' ) !== FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Create new user
     *
     * @param  array  $user_data  User data fields
     * @param  bool   $activated  Set it `True` if you want to directly activate
     *                            this user, and `False` for otherwise
     * @param  array  $roles      User roles
     *
     * @return bool
     */
    public function add_user( array $user_data, $activated = FALSE, $roles = array() )
    {
        $user_data['last_ip']       = $this->input->ip_address();
        $user_data['created']       = date('Y-m-d H:i:s');
        $user_data['last_login']    = date('Y-m-d H:i:s');
        $user_data['activated']     = $activated ? 1 : 0;

        if ( !$this->db->insert( $this->table['users'], $user_data ) )
        {
            return FALSE;
        }

        $user_id = $this->db->insert_id();

        if ( $activated )
        {
            $this->set_user_meta( $user_id );

            if ( count( $roles ) > 0 )
            {
                $this->set_user_roles( $user_id, $roles );
            }
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
    public function edit_user( $user_id, $user_data = array() )
    {
        if ( count( $user_data ) == 0 )
            return FALSE;

        return $this->db->update( $this->table['users'], $user_data, array( 'id' => $user_id ) );
    }

    // -------------------------------------------------------------------------

    /**
     * Delete User data
     *
     * @param   int     $user_id  User ID
     * @param   bool    $purge    Purge option, set it to True if you want to completely remove
     *                            this user
     *
     * @return  bool
     */
    public function delete_user( $user_id, $purge = FALSE )
    {
        if ( $purge )
        {
            $this->db->trans_start();
            $this->db->delete($this->table['users'],     array('id'      => $user_id));
            $this->db->delete($this->table['user_role'], array('user_id' => $user_id));
            $this->db->delete($this->table['user_meta'], array('user_id' => $user_id));
            // $this->db->delete($this->table['overrides'], array('user_id' => $user_id));
            $this->db->trans_complete();

            if ( !$this->db->trans_status() )
            {
                $this->db->trans_rollback();
                return FALSE;
            }

            return TRUE;
        }
        else
        {
            return $this->change_user_status( $user_id, 'deleted' );
        }
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
    public function change_user_status( $user_id, $new_status, $invert = FALSE, $extra = array() )
    {
        $statuses = array('activated', 'banned', 'deleted');

        if ( !in_array($new_status, $statuses) )
        {
            log_message('error', '#Baka_pack: Authen->change_user_status failed to change status.');
            return FALSE;
        }

        $data = array();

        foreach ( $statuses as $status )
        {
            $data[$status] = ( $status == $new_status ? 1 : 0 );
        }

        if ( $invert )
        {
            $data[$new_status] = 0;
        }

        if ( count( $extra ) > 0 )
        {
            foreach ( $extra as $field => $value )
            {
                $data[$field] = $value;
            }
        }

        return $this->edit_user( $user_id, $data );
    }

    // -------------------------------------------------------------------------
    // Activation
    // -------------------------------------------------------------------------

    /**
     * Activating inactivated specified user
     *
     * @param   int     $user_id         User id who want to be activate
     * @param   string  $activation_key  Activation key
     *
     * @return  bool
     */
    public function activate_user( $user_id, $activation_key )
    {
        $key = (bool) Setting::get('auth_email_activation')
            ? 'new_email_key'
            : 'new_password_key';
        
        $wheres['id'] = $user_id;
        $wheres[$key] = $activation_key;
        $wheres['activated'] = 0;

        $query = $this->db->get_where( $this->table['users'], $wheres, 1 );

        if ( $query->num_rows() == 0 )
        {
            log_message( 'error', '#Authen: Can\'t find inactive user with ID='.$user_id.'.');
            return FALSE;
        }

        return $this->change_user_status( $user_id, 'activated', FALSE, array($key => NULL) );
    }

    // -------------------------------------------------------------------------

    /**
     * Activating an inactivated specified user
     *
     * @param   int   $user_id  User id who want to be activate
     *
     * @return  bool
     */
    public function inactivate_user( $user_id )
    {
        return $this->change_user_status( $user_id, 'activated', TRUE );
    }

    // -------------------------------------------------------------------------

    /**
     * Clean up dumb users (non-active users)
     *
     * @return  void
     */
    public function purge_na()
    {
        $expired = time() - Setting::get('auth_email_act_expire');

        $this->db->delete( $this->table['users'], array(
            'activated' => 0,
            'unix_timestamp(created) <' => $expired ) );
    }

    // -------------------------------------------------------------------------
    // Password
    // -------------------------------------------------------------------------

    /**
     * Set new password key
     *
     * @param  int     $user_id       User ID
     * @param  string  $new_pass_key  Password Key
     *
     * @return bool
     */
    public function set_password_key( $user_id, $new_pass_key )
    {
        $data = array(
            'new_password_key'       => $new_pass_key,
            'new_password_requested' => date('Y-m-d H:i:s')
            );

        return $this->edit_user( $user_id, $data );
    }

    // -------------------------------------------------------------------------

    /**
     * Check if given password key is valid and user is authenticated.
     *
     * @param   int     $user_id       User ID
     * @param   string  $new_pass_key  New Password Key
     *
     * @return  bool
     */
    public function can_reset_password( $user_id, $new_pass_key )
    {
        $expired = time() - get_conf('forgot_password_expire');

        $wheres = array(
            'id' => $user_id,
            'new_password_key' => $new_pass_key,
            'unix_timestamp(new_password_requested) >' => $expired
            );

        $query = $this->db->get_where( $this->table['users'], $wheres, 1);

        return $query->num_rows() > 0;
    }

    // -------------------------------------------------------------------------

    /**
     * Change user password if password key is valid and user is authenticated.
     *
     * @param   int     $user_id        User ID
     * @param   string  $new_pass       New Password
     * @param   string  $new_pass_key   New Password key
     *
     * @return  bool
     */
    public function reset_password( $user_id, $new_pass, $new_pass_key )
    {
        $data = array(
            'password'               => $new_pass,
            'new_password_key'       => NULL,
            'new_password_requested' => NULL
            );

        return $this->edit_user( $user_id, $data );
    }

    // -------------------------------------------------------------------------

    /**
     * Change user password
     *
     * @param   int     $user_id   User ID
     * @param   string  $new_pass  New Password
     *
     * @return  bool
     */
    public function change_password( $user_id, $new_pass )
    {
        $data = array(
            'password'               => $new_pass,
            'new_password_key'       => NULL,
            'new_password_requested' => NULL
            );

        return $this->edit_user( $user_id, $data );
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
    public function set_new_email( $user_id, $new_email, $new_email_key )
    {
        return $this->edit_user( $user_id,
            array( 'new_email' => $new_email, 'new_email_key' => $new_email_key )
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
    public function activate_new_email( $user_id, $new_email_key )
    {
        $this->db->update( $this->table['users'],
            array(
                'email' => 'new_email',
                'new_email' => NULL,
                'new_email_key' => NULL ),
            array(
                'id' => $user_id,
                'new_email_key', $new_email_key )
            );

        return $this->db->affected_rows() > 0;
    }

    // -------------------------------------------------------------------------

    /**
     * Check is Email already exists
     *
     * @param   string  $login  Email
     *
     * @return  bool
     */
    public function check_email( $email )
    {
        return $this->get_user( $email, 'email' ) !== FALSE;
    }

    // -------------------------------------------------------------------------
    // Login
    // -------------------------------------------------------------------------

    /**
     * Update user login info, such as IP-address or login time, and
     * clear previously generated (but not activated) passwords.
     *
     * @param   int   $user_id  User ID
     *
     * @return  bool
     */
    public function update_login_info( $user_id )
    {
        $user_data['new_password_key']       = NULL;
        $user_data['new_password_requested'] = NULL;
        $user_data['last_login'] = date('Y-m-d H:i:s');

        if ( Setting::get('auth_login_record_ip') )
            $user_data['last_ip']    = $this->input->ip_address();

        return $this->edit_user( $user_id, $user_data );
    }

    // -------------------------------------------------------------------------
    // Ban
    // -------------------------------------------------------------------------

    /**
     * Ban user
     *
     * @param   int     $user_id  User ID
     * @param   string  $reason   Ban Reasons
     *
     * @return  bool
     */
    public function ban_user( $user_id, $reason = NULL )
    {
        return $this->change_user_status( $user_id, 'banned', FALSE, array('ban_reason' => $reason) );
    }

    // -------------------------------------------------------------------------

    /**
     * Unban user
     *
     * @param   int
     * 
     * @return  void
     */
    public function unban_user( $user_id )
    {
        return $this->change_user_status( $user_id, 'banned', TRUE, array('ban_reason' => NULL) );
    }

    // -------------------------------------------------------------------------
    // User metas
    // -------------------------------------------------------------------------

    /**
     * Get user meta by User ID
     *
     * @param   int    $user_id  User ID
     *
     * @return  mixed
     */
    public function get_user_metas( $user_id )
    {
        $query = $this->db->get_where( $this->table['user_meta'], array('user_id' => $user_id) );

        if ( $query->num_rows() > 0 )
            return $query->row();

        return FALSE;
    }

    // -------------------------------------------------------------------------

    public function get_meta( $key, $val )
    {}

    // -------------------------------------------------------------------------

    /**
     * Setup user meta by User ID
     *
     * @param  int     $user_id    User ID
     * @param  array   $meta_data  User Metas
     *
     * @return bool
     */
    public function set_user_meta( $user_id, $meta_data = array() )
    {
        if ( count( $meta_data ) == 0 )
        {
            $meta_data = get_conf('default_meta_fields');
        }

        $data = array();
        $i    = 0;

        foreach ( $meta_data as $meta_key => $meta_value )
        {
            $data[$i]['user_id']    = $user_id;
            $data[$i]['meta_key']   = $meta_key;
            $data[$i]['meta_value'] = $meta_value;

            $i++;
        }

        return $this->db->insert_batch( $this->table['user_meta'], $data );
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
    public function edit_user_meta( $user_id, $meta_key, $meta_value = '' )
    {
        if ( is_array( $meta_key ) and strlen( $meta_value ) == 0 )
        {
            $this->db->trans_start();

            foreach ( $meta_key as $key => $value )
            {
                $this->edit_user_meta( $user_id, $key, $value );
            }

            $this->db->trans_complete();
            
            if ( $this->db->trans_status() === FALSE )
            {
                $this->db->trans_rollback();
                return FALSE;
            }

            return TRUE;
        }
        else
        {
            return $this->db->update(
                $this->table['user_meta'],
                array('meta_value' => $meta_value),
                array('user_id' => $user_id, 'meta_key' => $meta_key)
                );
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Clear user meta by User ID
     *
     * @param   int   $user_id  User ID
     *
     * @return  bool
     */
    public function clear_user_meta( $user_id )
    {
        return $this->db->delete( $this->table['user_meta'], array('user_id' => $user_id) );
    }

    // -------------------------------------------------------------------------

    public function delete_meta( $meta_id )
    {}

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
    public function get_user_roles( $user_id )
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
    public function set_user_roles( $user_id, $roles_id = array() )
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
     * Remove role from user. Cannot remove role if user only has 1 role
     *
     * @param   int    $user_id  User ID
     * @param   int    $role     User Role
     *
     * @return  mixed
     */
    public function remove_user_role( $user_id, $role )
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

    // -------------------------------------------------------------------------
    
    public function edit_user_roles( $user_id, $new_roles )
    {
        if ( count( $new_roles ) == 0 )
        {
            return FALSE;
        }

        $old_roles = array_keys( $this->get_user_roles( $user_id ) );
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
    public function change_user_role( $user_id, $old, $new )
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
    // Roles
    // -------------------------------------------------------------------------

    public function get_roles()
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
    
    public function get_roles_assoc()
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

    public function get_role( $group_id )
    {
        $query = $this->get_roles();

        return $query->where('a.role_id', $group_id)->get()->row();
    }

    // -------------------------------------------------------------------------

    public function set_role( $role_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function add_role( $role_data = array() )
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
    public function edit_role( $role_data, $role_id = NULL, $perms = array() )
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

    public function change_role( $role_id, $role_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function delete_role( $role_id )
    {}

    // -------------------------------------------------------------------------

    /**
     * Check is Role ID Exists?
     *
     * @param   int   $role_id  Role ID
     *
     * @return  bool
     */
    public function role_exists( $role_id )
    {
        $query = $this->db->get_where( $this->table['roles'], array('role_id' => $role), 1);

        return (bool) $query->num_rows();
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
    public function get_role_perms( $role_id )
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
    public function update_role_perm( $permissions = array(), $role_id)
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

    // -------------------------------------------------------------------------
    // User Permissions Relation
    // -------------------------------------------------------------------------

    public function get_user_perms( $user_id )
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

    // -------------------------------------------------------------------------
    // Permissions
    // -------------------------------------------------------------------------

    public function get_perms()
    {
        // $query = $this->db->select("parent")
        //                   ->select("group_concat(distinct permission_id) perm_id")
        //                   ->select("group_concat(distinct permission) perm_name")
        //                   ->select("group_concat(distinct description) perm_desc");

        return $this->db->select('*')->from( $this->table['permissions'] );;
    }

    // -------------------------------------------------------------------------

    public function get_grouped_perms()
    {
        return $this->db->select("parent")
                        ->select("group_concat(distinct permission_id) perm_id")
                        ->select("group_concat(distinct permission) perm_name")
                        ->select("group_concat(distinct description) perm_desc")
                        ->from( $this->table['permissions'] )
                        ->group_by('parent')
                        ->get()->result();
    }

    // -------------------------------------------------------------------------

    public function get_parent_perms()
    {
        $ret = array();

        foreach ( $this->get_grouped_perms() as $row )
        {
            $ret[$row->parent] = $row->parent;
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    public function get_perm( $perm_id )
    {
        return $this->db->get_where( $this->table['permissions'], array('permission_id' => $perm_id) )->row();
    }

    // -------------------------------------------------------------------------

    public function add_perm( $perm_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function edit_perm( $perm_id, $perm_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function delete_perm( $perm_id )
    {}

    // -------------------------------------------------------------------------

    /**
     * Check is Permission exists?
     *
     * @param   string  $permission  Permission Name
     *
     * @return  bool
     */
    public function perm_exists( $permission )
    {
        $query = $this->db->get_where( $this->table['permissions'],
                 array('permission' => $permission), 1);

        return (bool) $query->num_rows();
    }

    // -------------------------------------------------------------------------
    // Autologin
    // -------------------------------------------------------------------------

    /**
     * Get user data for auto-logged in user.
     * Return FALSE if given key or user ID is invalid.
     *
     * @param   string    $key  Autologin Key
     *
     * @return  obj|bool
     */
    public function get_autologin( $user_id, $key )
    {
        $query = $this->db->select('a.id, a.username, a.activated')
                          ->from($this->table['users'].' a')
                          ->join($this->table['user_autologin'].' b', 'b.user_id = a.id')
                          ->where('b.user_id', $user_id)
                          ->where('b.key_id', $key)
                          ->get();

        if ( $query->num_rows() == 1 )
            return $query->row();
        
        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Save data for user's autologin
     *
     * @param   int
     * @param   string
     * @return  bool
     */
    public function set_autologin( $user_id, $key )
    {
        return $this->db->insert( $this->table['user_autologin'], array(
            'user_id'       => $user_id,
            'key_id'        => $key,
            'user_agent'    => substr($this->input->user_agent(), 0, 149),
            'last_ip'       => $this->input->ip_address() ));
    }

    // -------------------------------------------------------------------------

    /**
     * Purge autologin data for given user and login conditions
     *
     * @param   int
     * @return  void
     */
    public function purge_autologin( $user_id )
    {
        $this->db->delete($this->table['user_autologin'], array(
            'user_id'   => $user_id,
            'user_agent'=> substr($this->input->user_agent(), 0, 149),
            'last_ip'   => $this->input->ip_address() ));
    }

    // -------------------------------------------------------------------------

    /**
     * Clear user's autologin data
     *
     * @return  void
     */
    public function delete_autologin()
    {
        if ( $cookie = get_cookie( get_conf('autologin_cookie_name'), TRUE ) )
        {
            $data = unserialize( $cookie );

            $this->db->delete(
                $this->table['user_autologin'],
                array(
                    'user_id'   => $data['user_id'],
                    'key_id'    => md5($data['key'])
                    )
                );

            delete_cookie( get_conf('autologin_cookie_name') );
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Delete all autologin data for given user
     *
     * @param   int
     * @return  void
     */
    public function clear_autologin( $user_id )
    {
        $this->db->delete($this->table['user_autologin'], array( 'user_id' => $user_id ));
    }

    // -------------------------------------------------------------------------
    // Overriding
    // -------------------------------------------------------------------------

    public function get_overrides()
    {}

    // -------------------------------------------------------------------------

    /**
     * Flip the override `allow` column from 1 to 0 and vice versa
     */
    public function flip_override( $user_id, $permission )
    {
        $permission_id = $this->get_permission_id( $permission );

        // Get the current value
        $row = $this->db->get_where( $this->table['overrides'], array('user_id' => $user_id, 'permission_id' => $permission_id))
                        ->limit(1)
                        ->row();
        
        // Flip it
        $allow = (int) $row->allow ? 0 : 1;
        
        // Save it
        return $this->db->update( $this->table['overrides'],
                                  array('allow'     => $allow ),
                                  array('user_id'   => $user_id, 'permission_id' => $permission_id));
    }

    // -------------------------------------------------------------------------

    /**
     * Add permission to the `overrides` table
     */
    public function add_override($user_id, $permission, $allow)
    {
        if (is_string($permission))
        {
            $this->db->insert($this->table['overrides'], array($user_id, $this->get_permission_id($permission), $allow));
        }
        elseif (is_array($permission))
        {
            $this->db->trans_start();

            foreach ($permission as $val)
            {
                $this->db->insert($this->table['overrides'], array($user_id, $this->get_permission_id($val), $allow));
            }

            $this->db->trans_complete();
            
            return $this->db->trans_status();
        }
        else
        {
            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Remove permission from the `overrides` table
     */
    public function remove_override( $user_id, $permission )
    {
        if ( is_array( $permission ) )
        {
            $this->db->trans_start();

            foreach ( $permission as $perm )
            {
                $this->remove_override( $user_id, $perm );
            }

            $this->db->trans_complete();
            
            return $this->db->trans_status();
        }
        else if ( is_string( $permission ) )
        {
            $this->db->delete( $this->table['overrides'],
                array('user_id' => $user_id, 'permission_id' => $this->get_permission_id($permission)));
        }
        else
        {
            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    public function get_override( $key, $val )
    {}

    // -------------------------------------------------------------------------

    public function edit_override( $override_id, $override_data = array() )
    {}

    // -------------------------------------------------------------------------
    // Login Attempt
    // -------------------------------------------------------------------------

    /**
     * Increase number of attempts for given IP-address and login
     * (if attempts to login is being counted)
     *
     * @param   string
     * @return  void
     */
    public function increase_login_attempt( $login )
    {
        if ( Setting::get('auth_login_count_attempts') )
        {
            if ( !$this->authen->is_max_attempts_exceeded( $login ) )
            {
                $this->db->insert( $this->table['login_attempts'],
                    array('ip_address' => $this->input->ip_address(), 'login' => $login));
            }
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Clear all attempt records for given IP-address and login.
     * Also purge obsolete login attempts (to keep DB clear).
     *
     * @param   string
     * @param   string
     * @param   int
     * @return  void
     */
    public function clear_login_attempts( $login )
    {
        // Purge obsolete login attempts
        $this->db->where( array('ip_address' => $this->input->ip_address(), 'login' => $login) )
                 ->or_where('unix_timestamp(time) <', time()-Setting::get('auth_login_attempt_expire'))
                 ->delete( $this->table['login_attempts'] );
    }

    // -------------------------------------------------------------------------

    /**
     * Get number of attempts to login occured from given IP-address or login
     *
     * @param   string
     * @param   string
     * @return  int
     */
    public function get_attempts_num( $login )
    {
        $query = $this->db->select('1', FALSE)
                      ->where('ip_address', $this->input->ip_address())
                      ->or_where('login', $login)
                      ->get( $this->table['login_attempts'] );

        return $query->num_rows();
    }
}

/* End of file Authen_model.php */
/* Location: ./system/application/models/baka_pack/Authen_model.php */