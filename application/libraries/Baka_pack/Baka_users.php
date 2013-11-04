<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BAKA Users Class
 *
 * @package     Baka_pack
 * @subpackage  Libraries
 * @category    Security
 * @author      Fery Wardiyanto (http://github.com/feryardiant/)
 */
class Baka_users extends Baka_lib
{
	private $users_table          = 'auth_users';             // user accounts
	private $user_profile_table   = 'auth_user_profiles';     // user profiles
	private $user_role_table      = 'auth_user_roles';        // user roles
	private $roles_table          = 'auth_roles';             // roles
	private $permissions_table    = 'auth_permissions';       // permissions
	private $role_perms_table     = 'auth_role_permissions';  // role permissions
	private $overrides_table      = 'auth_overrides';         // overrides

	private $table_prefix;

	public function __construct()
	{
		$this->table_prefix = $this->db->dbprefix;

		log_message('debug', "#Baka_pack: Users Class Initialized");
	}

	public function get_users_table()
	{
		return $this->users_table;
	}

	public function get_users( $user_id = NULL )
	{
		$query = $this->db->select("a.id, b.name fullname, a.username, b.gender, a.email")
						  ->select("a.activated, a.banned, a.ban_reason, a.approved, a.last_ip, a.last_login, a.created, a.modified")
						  ->select("GROUP_CONCAT(DISTINCT d.role) role_name")
						  ->select("GROUP_CONCAT(DISTINCT d.full) role_fullname")
						  ->from($this->users_table.' a')
						  ->join($this->user_profile_table.' b','b.id = a.id', 'inner')
						  ->join($this->user_role_table.' c','c.user_id = b.id', 'inner')
						  ->join($this->roles_table.' d','d.role_id = c.role_id', 'inner');

		if ( ! is_null( $user_id ) )
			$query->where('a.id', $user_id);
		else
			$query->group_by('a.id');

		return $query->get();
	}
	public function get_roles_query()
	{
		return $this->db->get( $this->roles_table );
	}

	public function get_perms_query()
	{
		return $this->db->get( $this->permissions_table );
	}
	
	/**
	 * Get user profiles data
	 */
	public function get_user_profiles($user_id)
	{
		if ( $user = $this->get_user_by_id( $user_id, TRUE ) )
		{
			return (object) array_merge( (array) $user, (array) $this->get_user_profile( $user_id ) );
		}
	}

	/**
	 * Get user record by Id
	 *
	 * @param   int
	 * @param   bool
	 * @return  object
	 */
	public function get_user_by_id($user_id, $activated)
	{
		$query = $this->db->get_where( $this->users_table, array( 'id' => $user_id, 'activated' => ($activated ? 1 : 0) ));

		if ($query->num_rows() == 1)
			return $query->row();
		
		return FALSE;
	}

	/**
	 * Get user record by login (username or email)
	 *
	 * @param   string
	 * @return  object
	 */
	public function get_user_by_login($login)
	{
		$query = $this->db->where('LOWER(username)=', strtolower($login))
						  ->or_where('LOWER(email)=', strtolower($login))
						  ->get($this->users_table);

		if ($query->num_rows() == 1)
			return $query->row();
		
		return FALSE;
	}

	/**
	 * Get user record by username
	 *
	 * @param   string
	 * @return  object
	 */
	public function get_user_by_username($username)
	{
		$query = $this->db->get_where( $this->users_table, array( 'LOWER(username)=' => strtolower($username) ));

		if ($query->num_rows() == 1)
			return $query->row();
		
		return FALSE;
	}

	/**
	 * Get user record by email
	 *
	 * @param   string
	 * @return  object
	 */
	public function get_user_by_email($email)
	{
		$query = $this->db->get_where( $this->users_table, array(
			'LOWER(email)=' => strtolower($email) ));

		if ($query->num_rows() == 1)
			return $query->row();
		
		return NULL;
	}

	/**
	 * Check if username available for registering
	 *
	 * @param   string
	 * @return  bool
	 */
	public function is_username_available($username)
	{
		$query = $this->db->limit(1)->get_where($this->users_table, array('LOWER(username)=' => strtolower($username)));

		return $query->num_rows() == 0;
	}

	/**
	 * Check if email available for registering
	 *
	 * @param   string
	 * @return  bool
	 */
	public function is_email_available($email)
	{
		$query = $this->db->where('LOWER(email)=', strtolower($email))
						  ->or_where('LOWER(new_email)=', strtolower($email))
						  ->limit(1)
						  ->get($this->users_table);

		return $query->num_rows() == 0;
	}

	/**
	 * Create new user record
	 *
	 * @param   array
	 * @param   bool
	 * @return  array
	 */
	public function create_user($user_data, $activated = FALSE, $roles = array())
	{
		$user_data['created']		= date('Y-m-d H:i:s');
		$user_data['last_login']	= date('Y-m-d H:i:s');
		$user_data['activated']		= $activated ? 1 : 0;

		if ($this->db->insert($this->users_table, $user_data))
		{
			$user_id = $this->db->insert_id();
			
			if ( $activated )
				$this->create_profile($user_id, $user_data['meta']);
			
			return array('user_id' => $user_id);
		}
		
		return FALSE;
	}

	/**
	 * Activate user if activation key is valid.
	 * Can be called for not activated users only.
	 *
	 * @param   int
	 * @param   string
	 * @param   bool
	 * @return  bool
	 */
	public function activate_user($user_id, $activation_key, $activate_by_email)
	{
		$wheres['id'] = $user_id;
		
		if ($activate_by_email)
			$wheres['new_email_key']    = $activation_key;
		else
			$wheres['new_password_key'] = $activation_key;

		$wheres['activated'] = 0;

		$query = $this->db->limit(1)->get_where($this->users_table, $wheres);

		if ($query->num_rows() > 0)
		{
			$this->db->update( $this->users_table,
				array('activated' => 1, 'new_email_key' => NULL),
				array('id' => $user_id) );

			$this->create_profile($user_id, $this->get_user_meta($user_id));

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Purge table of non-activated users
	 *
	 * @param   int
	 * @return  void
	 */
	public function purge_na($expire_period = 172800)
	{
		$this->db->delete( $this->users_table, array(
			'activated' => 0,
			'UNIX_TIMESTAMP(created) <' => (time() - $expire_period) ) );
	}

	/**
	 * Delete user record
	 *
	 * @param   int
	 * @return  bool
	 */
	public function delete_user($user_id)
	{
		$this->db->trans_start();
		$this->db->delete($this->users_table,           array('id'      => $user_id));
		$this->db->delete($this->user_profile_table,    array('id'      => $user_id));
		$this->db->delete($this->user_role_table,       array('user_id' => $user_id));
		$this->db->delete($this->overrides_table,       array('user_id' => $user_id));
		$this->db->trans_complete();
		
		return $this->db->trans_status() ? TRUE : FALSE;
	}

	/**
	 * Set new password key for user.
	 * This key can be used for authentication when resetting user's password.
	 *
	 * @param   int
	 * @param   string
	 * @return  bool
	 */
	public function set_password_key($user_id, $new_pass_key)
	{
		$this->db->update($this->users_table,
			array('new_password_key' => $new_pass_key, 'new_password_requested' => date('Y-m-d H:i:s')),
			array('id' => $user_id));

		return $this->db->affected_rows() > 0;
	}

	/**
	 * Check if given password key is valid and user is authenticated.
	 *
	 * @param   int
	 * @param   string
	 * @param   int
	 * @return  void
	 */
	public function can_reset_password($user_id, $new_pass_key, $expire_period = 900)
	{
		$query = $this->db->get( $this->users_table, array(
				'id' => $user_id,
				'new_password_key' => $new_pass_key,
				'UNIX_TIMESTAMP(new_password_requested) >' => (time() - $expire_period)))->limit(1);

		return $query->num_rows() == 1;
	}

	/**
	 * Change user password if password key is valid and user is authenticated.
	 *
	 * @param   int
	 * @param   string
	 * @param   string
	 * @param   int
	 * @return  bool
	 */
	public function reset_password($user_id, $new_pass, $new_pass_key, $expire_period = 900)
	{
		$this->db->update( $this->users_table,
			array(  'password' => $new_pass,
					'new_password_key' => NULL,
					'new_password_requested' => NULL),
			array(  'id' => $user_id,
					'new_password_key' => $new_pass_key,
					'UNIX_TIMESTAMP(new_password_requested) >=' => (time() - $expire_period)) );

		return $this->db->affected_rows() > 0;
	}

	/**
	 * Change user password
	 *
	 * @param   int
	 * @param   string
	 * @return  bool
	 */
	public function change_password($user_id, $new_pass)
	{
		$this->db->update( $this->users_table,
			array( 'password'   => $new_pass ),
			array( 'id'         => $user_id ));

		return $this->db->affected_rows() > 0;
	}

	/**
	 * Set new email for user (may be activated or not).
	 * The new email cannot be used for login or notification before it is activated.
	 *
	 * @param   int
	 * @param   string
	 * @param   string
	 * @param   bool
	 * @return  bool
	 */
	public function set_new_email($user_id, $new_email, $new_email_key, $activated)
	{
		$this->db->set($activated ? 'new_email' : 'email', $new_email);
		$this->db->set('new_email_key', $new_email_key);
		$this->db->where('id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);

		$this->db->update($this->users_table);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Activate new email (replace old email with new one) if activation key is valid.
	 *
	 * @param   int
	 * @param   string
	 * @return  bool
	 */
	public function activate_new_email($user_id, $new_email_key)
	{
		$this->db->set('email', 'new_email', FALSE);
		$this->db->set('new_email', NULL);
		$this->db->set('new_email_key', NULL);
		$this->db->where('id', $user_id);
		$this->db->where('new_email_key', $new_email_key);

		$this->db->update($this->users_table);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Update user login info, such as IP-address or login time, and
	 * clear previously generated (but not activated) passwords.
	 *
	 * @param   int
	 * @param   bool
	 * @param   bool
	 * @return  void
	 */
	public function update_login_info($user_id, $record_ip, $record_time)
	{
		$set_data['new_password_key']       = NULL;
		$set_data['new_password_requested'] = NULL;

		if ($record_ip)
			$set_data['last_ip']    = $this->input->ip_address();
		
		if ($record_time)
			$set_data['last_login'] = date('Y-m-d H:i:s');

		$this->db->update($this->users_table, $set_data, array('id' => $user_id));
	}

	/**
	 * Ban user
	 *
	 * @param   int
	 * @param   string
	 * @return  void
	 */
	public function ban_user($user_id, $reason = NULL)
	{
		$this->db->update( $this->users_table,
			array( 'banned' => 1, 'ban_reason' => $reason ),
			array( 'id'     => $user_id ));
	}

	/**
	 * Unban user
	 *
	 * @param   int
	 * @return  void
	 */
	public function unban_user($user_id)
	{
		$this->db->update( $this->users_table,
			array( 'banned' => 0, 'ban_reason' => NULL ),
			array( 'id'     => $user_id ));
	}
	
	/**
	 * Get user profile data
	 */
	public function get_user_profile($user_id)
	{
		return $this->db->get_where($this->user_profile_table, array('id'=>$user_id))->row();
	}

	/**
	 * Create an empty profile for a new user
	 *
	 * @param   int
	 * @return  bool
	 */
	private function create_profile($user_id, $meta, $roles_id = array())
	{
		$user_data['id'] = $user_id;

		if ($meta)
		{
			$meta = unserialize($meta);

			foreach ($meta as $key=>$val)
			{
				if ($val === '1' || $val === '0')
					$meta[$key] = (int)$val;
			}
			
			$user_data = array_merge($user_data, $meta);            
		}

		if ( count($roles_id) > 0 )
			$this->set_user_roles( $user_id, $roles_id );

		return $this->db->insert($this->user_profile_table, $user_data);
	}

	/**
	 * Setup roles to user
	 * 
	 * @param	int
	 * @param	array
	 * @return  bool
	 */
	public function set_user_roles( $user_id, $roles_id = array() )
	{
		$count_roles = count($roles_id);

		if ( $count_roles > 0 )
		{
			for ( $i=0; $i<$count_roles; $i++ )
			{
				$role_data[$i]['user_id']	= $user_id;
				$role_data[$i]['role_id']	= $roles_id[$i];
			}

			return $this->db->insert_batch($this->user_role_table, $role_data);
		}
		else
		{
			$q_admin = $this->db->get_where( $this->user_role_table, array('role_id' => 1))->limit(1);

			if ( $q_admin->num_rows() > 0 )
			{
				// If admin exists, use the default role
				$q_role = $this->db->get_where( $this->roles_table, array('default' => 1))->limit(1)->row();
				
				return $this->db->insert($this->user_role_table, array('user_id' => $user_id, 'role_id' => $q_role->role_id));
			}
			else
			{
				// If there's no admin then make this person the admin
				return $this->db->insert($this->user_role_table, array('user_id' => $user_id, 'role_id' => 1));
			}
		}
	}
	
	/**
	 * Gets the datatype of a table
	 *
	 * @deprecated useless (at least for me :P)
	 */
	public function get_profile_datatypes()
	{
		$query = $this->db->query('SELECT column_name, data_type FROM information_schema.columns WHERE table_name=?', array($this->user_profile_table));
		return $query->result_array();
	}
	
	/**
	 * @deprecated useless (at least for me :P)
	 */
	private function get_user_meta($user_id)
	{
		$q      = $this->db->query("SELECT meta FROM {$this->users_table} WHERE id=?", array($user_id));
		$row    = $q->row_array();

		return $row['meta'];
	}
		
	/**
	 * Checks if a role exists
	 */
	private function role_exists($role)
	{
		if (is_int($role))
			$query = $this->db->get_where( $this->roles_table, array('role_id'=>$role));
		elseif (is_string($role))
			$query = $this->db->get_where( $this->roles_table, array('role'=>$role));
		
		return (bool) $query->num_rows();
	}
	
	/**
	 * Gets the permissions assigned to a role
	 *
	 * @param int $role_id
	 */
	public function get_role_permissions($role_id)
	{
		$query	= $this->db->query("SELECT permission FROM ".$this->table_prefix.$this->permissions_table." INNER JOIN ".$this->table_prefix.$this->role_perms_table." USING(permission_id) WHERE role_id={$role_id}");
		
		return $query->result();
	}
	
	/**
	 * Get any overrides a user may have
	 */
	public function get_permission_overrides($user_id)
	{
		$query	= $this->db->query("SELECT permission, allow FROM ".$this->table_prefix.$this->permissions_table." INNER JOIN ".$this->table_prefix.$this->overrides_table." USING(permission_id) WHERE user_id={$user_id}");
		
		return $query->result();
	}
	
	/**
	 * Gets all the permissions of a user based on his role/s
	 */
	public function get_permissions($user_id)
	{
		// Does not include overrites yet
		$query	= $this->db->query("SELECT GROUP_CONCAT(DISTINCT permission) permission FROM ".$this->table_prefix.$this->user_role_table." JOIN ".$this->table_prefix.$this->roles_table." USING(role_id) JOIN ".$this->table_prefix.$this->role_perms_table." USING(role_id) JOIN ".$this->table_prefix.$this->permissions_table." USING(permission_id) WHERE user_id=?", array($user_id));
		$row	= $query->row();
		
		return explode(',', $row->permission);
	}
	
	/**
	 * Returns a multidimensional array with info on the user's roles in associative format
	 * Keys: 'role_id', 'role', 'full', 'default'
	 * 
	 */
	public function get_user_roles($user_id)
	{
		return $this->db->query("SELECT b.role_id, b.role, b.full, b.default FROM ".$this->table_prefix.$this->user_role_table." a INNER JOIN ".$this->table_prefix.$this->roles_table." b USING(role_id) WHERE a.user_id=?", array($user_id));
	}
		
	/**
	 * Returns a multidimensional array with info on the user's roles in associative format
	 * Keys: 'role_id', 'role', 'full', 'default'
	 * 
	 */
	public function get_roles()
	{
		return $this->db->query("SELECT b.role_id, b.role, b.full, b.default FROM ".$this->table_prefix.$this->user_role_table." a INNER JOIN ".$this->table_prefix.$this->roles_table." b USING(role_id)");
	}
	
	/**
	 * Add permission to the `overrides` table
	 */
	public function add_override($user_id, $permission, $allow)
	{
		if (is_string($permission))
		{
			$this->db->insert($this->overrides_table, array($user_id, $this->get_permission_id($permission), $allow));
		}
		elseif (is_array($permission))
		{
			$this->db->trans_start();

			foreach ($permission as $val)
			{
				$this->db->insert($this->overrides_table, array($user_id, $this->get_permission_id($val), $allow));
			}

			$this->db->trans_complete();
			
			return $this->db->trans_status();
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Remove permission from the `overrides` table
	 */
	public function remove_override($user_id, $permission)
	{
		if (is_string($permission))
		{
			$this->db->delete($this->overrides_table, array('user_id' => $user_id, 'permission_id' => $this->get_permission_id($permission)));
			
			return $this->db->trans_status();
		}
		elseif (is_array($permission))
		{
			$this->db->trans_start();

			foreach ($permission as $val)
			{
				$this->db->delete($this->overrides_table, array('user_id' => $user_id, 'permission_id' => $this->get_permission_id($val)));
			}

			$this->db->trans_complete();
			
			return $this->db->trans_status();
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Flip the override `allow` column from 1 to 0 and vice versa
	 */
	public function flip_override($user_id, $permission)
	{
		$permission_id = $this->get_permission_id($permission);

		// Get the current value
		$row = $this->db->get_where($this->overrides_table, array('user_id' => $user_id, 'permission_id' => $permission_id))
						->limit(1)
						->row();
		
		// Flip it
		$allow = (int) $row->allow ? 0 : 1;
		
		// Save it
		return $this->db->update( $this->overrides_table,
								  array('allow'     => $allow ),
								  array('user_id'   => $user_id, 'permission_id' => $permission_id));
	}
	
	/**
	 * Get the permission_id of any permission
	 * @param string $permission
	 */
	public function get_permission_id($permission)
	{
		return $this->db->get_where($this->permissions_table, array('permission' => $permission))
						->row()
						->permission_id;
	}
	
	/**
	 * Add role to user
	 * @param int $user_id
	 * @param multi $role: int `role_id` or string `role` (not full)
	 */
	public function add_role($user_id, $role)
	{
		// Do nothing if $role is int
		if (is_string($role))
			$role = $this->get_role_id(trim($role));
		
		return $this->db->insert($this->user_role_table, array($user_id, $role));
	}
	
	/**
	 * Remove role from user. Cannot remove role if user only has 1 role
	 * @param int $user_id
	 * @param multi $role: int `role_id` or string `role` (not full)
	 */
	public function remove_role($user_id, $role)
	{
		if ($this->has_role($user_id, $role))
			return TRUE;
		
		// If there's only 1 role then removal is denied
		$this->db->get_where( $this->user_role_table,
							  array('user_id' => $user_id));

		if ($this->db->count_all_results() <= 1)
			return FALSE;

		// Do nothing if $role is int
		if (is_string($role))
			$role = $this->get_role_id(trim($role));
		
		return $this->db->delete( $this->user_role_table,
								  array('user_id' => $user_id, 'role_id' => $role_id));
	}
	
	/**
	 * Change a user's role for another
	 */
	public function change_role($user_id, $old, $new)
	{
		// Do nothing if $role is int
		if (is_string($old))
			$old = $this->get_role_id(trim($old));

		if (is_string($new))
			$new = $this->get_role_id(trim($new));
		
		return $this->db->update( $this->user_role_table,
								  array('role_id' => $new),
								  array('role_id' => $old, 'user_id' => $user_id) );
	}
	
	/**
	 * Does user already have this role?
	 *
	 * @param int $user_id
	 * @param multi $role: int `role_id` or string `role` (not full)
	 * @return bool
	 */
	private function has_role($user_id, $role)
	{
		$query = $this->db->get_where( $this->user_role_table, array('user_id' => $user_id, 'role_id' => $this->get_role_id($role)) )
						  ->limit(1);
		
		return $query->num_rows() ? TRUE : FALSE;
	}
	
	/**
	 * Get the role_id of a role
	 *
	 * @param string $role: The `role` value of the role
	 */
	private function get_role_id($role)
	{
		$query = $this->db->get_where($this->roles_table, array('role' => $role))
						  ->limit(1);
		
		return $query->row()->role_id;
	}
	
	/**
	 * Check if user account is approved
	 */
	public function is_approved($user_id)
	{
		$row = $this->db->get_where( $this->users_table, array('id' => $user_id))->row();
		
		return (bool) $row->approved;
	}
	
	/**
	 * Add permission to role
	 */
	public function add_permission($permission, $role)
	{
		$role_id = $this->get_role_id($role);
		
		if (is_array($permission))
		{
			$this->db->trans_start();

			foreach ($permission as $val)
			{
				$this->db->insert($this->role_perms_table, array( $role_id, $this->get_permission_id($val) ));
			}

			$this->db->trans_complete();
			
			return $this->db->trans_status();
		}
		elseif (is_string($permission))
		{
			return $this->db->insert($this->role_perms_table, array( $role_id, $this->get_permission_id($permission) ));
		}
	}
	
	/**
	 * Remove permission from role
	 */
	public function remove_permission($permission, $role)
	{
		$role_id = $this->get_role_id($role);
		
		if (is_array($permission))
		{
			$this->db->trans_start();

			foreach ($permission as $val)
			{
				$this->db->delete( $this->role_perms_table,
								   array( 'role_id' => $role_id, 'permission_id' => $this->get_permission_id($val) ));
			}

			$this->db->trans_complete();
			
			return $this->db->trans_status();
		}
		elseif (is_string($permission))
		{
			return $this->db->delete( $this->role_perms_table,
									  array( 'role_id' => $role_id, 'permission_id' => $this->get_permission_id($permission) ));
		}
	}
	
	/**
	 * Add a new permission to the `permissions` table
	 */
	public function new_permission($permission, $description, $parent = '', $sort = NULL)
	{
		$query = $this->db->get_where($this->permissions_table, array('permission' => $permission));
		
		if (!$query->num_rows())
			return $this->db->insert($this->permissions_table, array(NULL, $permission, $description, $parent, $sort));
		
		return TRUE;
	}
	
	/**
	 * Delete permission from the `permissions` table
	 */
	public function clear_permission($permission)
	{
		if (is_array($permission))
		{
			// Get the ids
			$row    = $this->db->where_in('permission', $permission)->get($this->permissions_table)->result_array();
			
			// Convert to single array (same as tank_auth->multi_to_single())
			$keys   = array_keys($row[0]);
			foreach ($row as $val)
			{
				$ids[] = $val[$keys[0]];
			}
			
			$this->db->trans_start();
			$this->db->where_in('permission', $permission)->delete($this->permissions_table);
			$this->db->where_in('permission_id', $ids)->delete($this->role_perms_table);
			$this->db->trans_complete();
			
			return $this->db->trans_status();
		}
		elseif (is_string($permission))
		{
			$this->db->trans_start();
			$this->db->delete($this->permissions_table, array('permission'      => $permission));
			$this->db->delete($this->role_perms_table,  array('permission_id'   => $this->get_permission_id($permission)));
			$this->db->trans_complete();

			return $this->db->trans_status();
		}
	}
	
	/**
	 * Save permission
	 */
	public function save_permission($data)
	{
		extract($data);

		$permission_id = is_string($permission_ident) ? $this->get_permission_id($permission_ident) : $permission_ident;

		unset($data['permission_ident']);

		return $this->db->update($this->permissions_table, $data, array('permission_id' => $permission_id));
	}
	
	/**
	 * Approve a user
	 * @param int $user_id User ID
	 * @return bool
	 */
	public function approve_user($user_id)
	{
		return $this->db->update($this->users_table, array('approved' => 1), array('id' => $user_id));
	}
	
	/**
	 * Unapprove a user
	 * @param int $user_id User ID
	 * @return bool
	 */
	public function unapprove_user($user_id)
	{
		return $this->db->update($this->users_table, array('approved' => 0), array('id' => $user_id));
	}
}

/* End of file users.php */
/* Location: ./system/application/libraries/Baka_pack/rbac/Baka_users.php */