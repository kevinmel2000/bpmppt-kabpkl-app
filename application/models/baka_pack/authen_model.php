<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter core library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
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
     * User ID
     *
     * @var  int
     */
    private $user_id = NULL;

    /**
     * Role ID
     *
     * @var  int
     */
    private $role_id = NULL;

    /**
     * Permission ID
     *
     * @var  int
     */
    private $perm_id = NULL;

    /**
     * Tables definition
     *
     * @var  array
     */
    protected $table = array();

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
    // Unsorted
    // @todo  sort it later
    // -------------------------------------------------------------------------

    public function check_login( $login )
    {
        $query = $this->db->where('lower(username)', strtolower($login))
                          ->or_where('lower(email)', strtolower($login))
                          ->get($this->table['users'], 1);

        if ( $query->num_rows() > 0 )
            return $query->row()->id;

        return NULL;
    }

    // -------------------------------------------------------------------------

    public function check_username( $username )
    {
        $query = $this->db->where('lower(username)', strtolower($username))
                          ->get($this->table['users'], 1);

        if ( $query->num_rows() > 0 )
            return $query->row()->id;

        return NULL;
    }

    // -------------------------------------------------------------------------

    public function check_email( $email )
    {
        $query = $this->db->or_where('lower(email)', strtolower($email))
                          ->get($this->table['users'], 1);

        if ( $query->num_rows() > 0 )
            return $query->row()->id;

        return NULL;
    }

    // -------------------------------------------------------------------------
    // Setup relations
    // -------------------------------------------------------------------------

    /**
     * Setup table related with $user_id
     *
     * @param   string      $key  User Identifier Field (id|login|username|email)
     * @param   string|int  $val  User Identifier Value
     *
     * @return  mixed
     */
    public function &user( $key, $val )
    {
        if ( !in_array( $key, array( 'id', 'login', 'username', 'email' ) ) )
        {
            log_message('error', '#Baka_pack: Authen->get_user failed identifying user using '.$key.' field.');
            return FALSE;
        }

        $this->user_id = $val;

        if ( $key != 'id' )
        {
            $this->user_id = $this->{'check_'.$key}( $val );
        }

        return $this;
    }

    /**
     * Setup table related with $role_id
     *
     * @param   int  $role_id  Role ID
     *
     * @return  mixed
     */
    public function role_id( $role_id )
    {
        $this->role_id = $role_id;

        return $this;
    }

    /**
     * Setup table related with $perm_id
     *
     * @param   int  $perm_id  Permission ID
     *
     * @return  mixed
     */
    public function perm_id( $perm_id )
    {
        $this->perm_id = $perm_id;

        return $this;
    }

    // -------------------------------------------------------------------------
    // Users
    // -------------------------------------------------------------------------

    /**
     * Users Active Record Query
     *
     * @return  mixed
     */
    protected function _user_query()
    {
        return $this->db->select("a.id, a.username, a.email")
                        ->select("a.activated, a.banned, a.ban_reason, a.deleted")
                        ->select("a.last_ip, a.last_login, a.created, a.modified")
                        ->select("group_concat(distinct c.role_id) role_id")
                        ->select("group_concat(distinct c.role) role_name")
                        ->select("group_concat(distinct c.full) role_fullname")
                        ->from($this->table['users'].' a')
                        ->join($this->table['user_role'].' b','b.user_id = a.id', 'inner')
                        ->join($this->table['roles'].' c','c.role_id = b.role_id', 'inner');
    }

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
     * @param   string  $key  Key of user field (id|login|username|email)
     * @param   string  $val  Value of user field
     *
     * @return  object
     */
    public function get_data()
    {
        if ( is_null( $this->user_id ) )
            return FALSE;

        return $this->db->get_where( $this->table['users'],
            array('id' => $this->user_id), 1)->row();
    }

    // -------------------------------------------------------------------------

    /**
     * Make sure that $username is available for new users
     *
     * @param   string  $username  New username
     *
     * @return  bool
     */
    public function is_username_available( $username )
    {
        $query = $this->db->get_where( $this->table['users'],
                 array('lower(username)=' => strtolower($username)), 1);

        return $query->num_rows() == 0;
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
        $user_data['created']       = date('Y-m-d H:i:s');
        $user_data['last_login']    = date('Y-m-d H:i:s');
        $user_data['activated']     = $activated ? 1 : 0;

        if ( $this->db->insert( $this->table['users'], $user_data ) )
        {
            $user_id = $this->db->insert_id();
            
            if ( $activated )
                $this->create_profile( $user_id, $roles );
            
            return array('user_id' => $user_id);
        }
        
        return FALSE;
    }

    // -------------------------------------------------------------------------

    public function update( $user_data = array() )
    {
        if ( is_null( $user_id = $this->user_id ) )
            return FALSE;

        if ( $update = $this->db->update( $this->table['users'], $user_data, array( 'id' => $user_id ) ) )
        {
            foreach ( $user_data as $field => $value )
                log_message( 'info', '#Baka_pack: Authen_model->update #'.$user_id.': '.$field.' = '.$value.'.');
        }

        return $update;
    }

    // -------------------------------------------------------------------------

    public function delete_user( $user_id, $purge = FALSE )
    {
        if ( $purge )
        {
            $this->db->trans_start();
            $this->db->delete($this->table['users'],    array('id'      => $user_id));
            $this->db->delete($this->table['user_role'],array('user_id' => $user_id));
            $this->db->delete($this->table['overrides'],array('user_id' => $user_id));
            $this->db->trans_complete();
            
            return $this->db->trans_status() ? TRUE : FALSE;
        }
        else
        {
            return $this->edit_user( $user_id,
                array( 'activated' => 0, 'banned' => 0, 'deleted' => 1 ) );
        }
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

        return $this->edit_user( $user_id, array('activated' => 1, $key => NULL) );
    }

    // -------------------------------------------------------------------------

    /**
     * Activating inactivated specified user
     *
     * @param   int   $user_id  User id who want to be activate
     *
     * @return  bool
     */
    public function inactivate_user( $user_id )
    {
        return $this->edit_user( $user_id, array( 'activated' => 0 ) );
    }

    // -------------------------------------------------------------------------

    /**
     * Clean up dumb users (non-active users)
     *
     * @param   int   $expire_period  Expiration period
     *
     * @return  bool
     */
    public function purge_na( $expire_period = null )
    {
        if ( is_null( $expire_period ) )
            $expire_period = 172800;

        $this->db->delete( $this->table['users'], array(
            'activated' => 0,
            'unix_timestamp(created) <' => (time() - $expire_period) ) );

        return $this->db->affected_rows() > 0;
    }

    // -------------------------------------------------------------------------
    // Password
    // -------------------------------------------------------------------------

    public function set_password_key($user_id, $new_pass_key)
    {
        $this->db->update( $this->table['users'],
            array('new_password_key' => $new_pass_key, 'new_password_requested' => date('Y-m-d H:i:s')),
            array('id' => $user_id));

        return $this->db->affected_rows() > 0;
    }

    // -------------------------------------------------------------------------

    public function can_reset_password($user_id, $new_pass_key, $expire_period = 900)
    {
        $query = $this->db->get( $this->table['users'], array(
                 'id' => $user_id,
                 'new_password_key' => $new_pass_key,
                 'UNIX_TIMESTAMP(new_password_requested) >' => (time() - $expire_period)))->limit(1);

        return $query->num_rows() == 1;
    }

    // -------------------------------------------------------------------------

    /**
     * Change user password if password key is valid and user is authenticated.
     *
     * @param   int     $user_id        User ID
     * @param   string  $new_pass       New Password
     * @param   string  $new_pass_key   New Password key
     * @param   int     $expire_period  Expiration Period
     *
     * @return  bool
     */
    public function reset_password($user_id, $new_pass, $new_pass_key, $expire_period = 900)
    {
        $this->db->update( $this->table['users'],
            array(  'password' => $new_pass,
                    'new_password_key' => NULL,
                    'new_password_requested' => NULL),
            array(  'id' => $user_id,
                    'new_password_key' => $new_pass_key,
                    'unix_timestamp(new_password_requested) >=' => (time() - $expire_period)) );

        return $this->db->affected_rows() > 0;
    }

    // -------------------------------------------------------------------------

    /**
     * Change user password
     *
     * @param   int
     * @param   string
     * 
     * @return  bool
     */
    public function change_password($user_id, $new_pass)
    {
        $this->db->update( $this->table['users'],
            array( 'password'   => $new_pass ),
            array( 'id'         => $user_id ));

        return $this->db->affected_rows() > 0;
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
     * @param   int
     * @param   string
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
     * Make sure that $email is available for new users
     *
     * @param   string  $email  New email
     *
     * @return  bool
     */
    public function is_email_available( $email )
    {
        $query = $this->db->where('lower(email)=', strtolower($email))
                          ->or_where('lower(new_email)=', strtolower($email))
                          ->limit(1)
                          ->get($this->table['users']);

        return $query->num_rows() == 0;
    }

    // -------------------------------------------------------------------------
    // Login
    // -------------------------------------------------------------------------

    /**
     * Update user login info, such as IP-address or login time, and
     * clear previously generated (but not activated) passwords.
     *
     * @param   int
     * @param   bool
     * @param   bool
     * 
     * @return  void
     */
    public function update_login_info()
    {
        $user_data['new_password_key']       = NULL;
        $user_data['new_password_requested'] = NULL;

        if ( get_conf('login_record_ip') )
            $user_data['last_ip']    = $this->input->ip_address();
        
        if ( get_conf('login_record_time') )
            $user_data['last_login'] = date('Y-m-d H:i:s');

        return $this->update( $user_data );
    }

    // -------------------------------------------------------------------------
    // Ban
    // -------------------------------------------------------------------------

    /**
     * Ban user
     *
     * @param   int
     * @param   string
     * 
     * @return  void
     */
    public function ban_user( $user_id, $reason = NULL )
    {
        $this->db->update( $this->table['users'],
            array( 'banned' => 1, 'ban_reason' => $reason ),
            array( 'id'     => $user_id ));
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
        $this->db->update( $this->table['users'],
            array( 'banned' => 0, 'ban_reason' => NULL ),
            array( 'id'     => $user_id ) );
    }

    // -------------------------------------------------------------------------
    // User metas
    // -------------------------------------------------------------------------

    public function get_metas()
    {}

    // -------------------------------------------------------------------------

    public function get_meta( $key, $val )
    {}

    // -------------------------------------------------------------------------

    public function add_meta( $meta_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function edit_meta( $meta_id, $meta_data = array() )
    {}

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
     * @param   int  $user_id  User ID
     *
     * @return  obj
     */
    public function get_user_roles( $user_id )
    {
        return $this->db->select("b.role_id, b.role, b.full, b.default")
                        ->from($this->table['user_role'].' a')
                        ->join($this->table['roles'].' b', 'b.role_id = a.role_id')
                        ->where('user_id', $user_id);
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
        $count_roles = count( $roles_id );

        if ( $count_roles > 0 )
        {
            for ( $i=0; $i<$count_roles; $i++ )
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
        $query = $this->db->select("b.role_id id, b.role name, b.full, b.default")
                          ->from($this->table['user_role'].' a')
                          ->join($this->table['roles'].' b', 'b.role_id = a.role_id');

        if ( !is_null( $this->user_id ) )
        {
            return $query->where('a.user_id', $this->user_id)->get()->row();
        }
        else
        {
            return $query;
        }
    }

    // -------------------------------------------------------------------------

    public function get_role( $key, $val )
    {}

    // -------------------------------------------------------------------------

    public function set_role( $role_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function add_role( $role_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function update_role( $role_id, $role_data = array() )
    {}

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
        $query = $this->db->select("permission")
                          ->from($this->table['permissions'].' a')
                          ->join($this->table['role_perms'].' b', 'b.permission_id = a.permission_id', 'inner')
                          ->where('role_id', $role_id);

        return $query->result();
    }

    // -------------------------------------------------------------------------
    // Permissions
    // -------------------------------------------------------------------------

    public function get_perms()
    {
        $query = $this->db->select("d.parent")
                          ->select("group_concat(distinct d.permission_id) perm_id")
                          ->select("group_concat(distinct d.permission) perm_name")
                          ->select("group_concat(distinct d.description) perm_desc");

        if ( is_null( $this->user_id ) )
        {
            return $query->from( $this->table['permissions'] )->group_by('parent');
        }
        else
        {
            $query = $query->from($this->table['user_role'].' a')
                           ->join($this->table['roles'].' b', 'b.role_id = a.role_id')
                           ->join($this->table['role_perms'].' c', 'c.role_id = b.role_id')
                           ->join($this->table['permissions'].' d', 'd.permission_id = c.permission_id')
                           ->where('a.user_id', $this->user_id)
                           ->get();

            return explode(',', $query->row()->perm_name);
        }
    }

    // -------------------------------------------------------------------------

    public function get_perm( $key, $val )
    {}

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
    public function get_autologin( $key )
    {
        if ( is_null( $this->user_id ) )
            return FALSE;

        $query = $this->db->select('a.id, a.username')
                          ->from($this->table['users'].' a')
                          ->join($this->table['user_autologin'].' b', 'b.user_id = a.id')
                          ->where('b.user_id', $this->user_id)
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
        if ( get_conf('login_count_attempts') )
        {
            if ( !$this->is_max_attempts_exceeded( $login ) )
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

    // -------------------------------------------------------------------------

    /**
     * Check if login attempts exceeded max login attempts (specified in config)
     *
     * @param   string
     * @return  bool
     */
    public function is_max_attempts_exceeded( $login )
    {
        return $this->get_attempts_num( $login ) >= get_conf('login_max_attempts');
    }

    public function clear()
    {
        $this->user_id = NULL;
        $this->role_id = NULL;
        $this->perm_id = NULL;
    }
}

/* End of file Authen_model.php */
/* Location: ./system/application/models/baka_pack/Authen_model.php */