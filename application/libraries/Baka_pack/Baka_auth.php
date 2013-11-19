<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'third_party/phpass-0.3/PasswordHash.php');

/**
 * BAKA Auth Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Security
 * @author		Fery Wardiyanto (http://github.com/feryardiant/)
 */
class Baka_auth Extends Baka_lib
{
	private	$status_activated		= 1;
	private	$status_not_activated	= 0;

	private $user_autologin_table	= 'auth_user_autologin';	// auto login
	private $login_attempts_table	= 'auth_login_attempts';	// login attemption

	private $table_prefix;

	public function __construct()
	{
		$this->load->helper('cookie');
		$this->load->library('session');

		$this->_autologin();

		log_message('debug', "#Baka_pack: Authentication Class Initialized");
	}

	/**
	 * phpass-0.3 hashing
	 *
	 * @param	string
	 * @return	object|string
	 */
	private function _do_hash( $pass = '' )
	{
		$phpass = new PasswordHash(
			$this->config_item('phpass_hash_strength'),
			$this->config_item('phpass_hash_portable'));

		if ( $pass != '' )
			return $phpass->HashPassword( $pass );

		return $phpass;
	}

	/**
	 * phpass-0.3 check hash
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	private function check_hash( $old_pass, $new_pass )
	{
		$phpass = $this->_do_hash();

		return $phpass->CheckPassword( $old_pass, $new_pass );
	}
	
	/**
	 * Login user on the site. Return TRUE if login is successful
	 * (user exists and activated, password is correct), otherwise FALSE.
	 *
	 * @param	string	(username or email or both depending on settings in config file)
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	public function login( $login, $password, $remember, $login_by_username, $login_by_email )
	{
		// Which function to use to login (based on config)
		if ($login_by_username AND $login_by_email)
			$get_user_func = 'get_user_by_login';
		else if ($login_by_username)
			$get_user_func = 'get_user_by_username';
		else
			$get_user_func = 'get_user_by_email';

		// fail - wrong login
		if ( is_null($user = $this->baka_users->$get_user_func($login)) )
		{
			$this->increase_login_attempt($login);
			$this->set_error('auth_incorrect_login');
			return FALSE;
		}

		// fail - wrong password
		if ( ! $this->check_hash($password, $user->password) )
		{
			$this->increase_login_attempt($login);
			$this->set_error('auth_incorrect_password');
			return FALSE;
		}

		// fail - banned
		if ( $user->banned == 1 )
		{
			$this->set_error('auth_banned_account', $user->ban_reason);
			return FALSE;
		}

		// Save to session
		$this->session->set_userdata( array(
			'user_id'	=> $user->id,
			'username'	=> $user->username,
			'status'	=> ($user->activated == 1 ? $this->status_activated : $this->status_not_activated),
			'roles'		=> $this->baka_users->get_roles( $user->id ) ));
		
		// fail - not activated
		if ($user->activated == 0)
		{
			$this->set_error('auth_inactivated_account');
			return FALSE;
		}

		if ( ! $this->is_approved($user->id) )
		{
			$this->set_error('auth_inapproved_account');
			$this->logout();
			return FALSE;
		}

		// success
		$user_profile = $this->baka_users->get_user_profile($user->id);
		$this->session->set_userdata('user_profile', $user_profile);
		
		if ( $remember )
			$this->_create_autologin( $user->id );

		$this->_clear_login_attempts( $login );

		$this->baka_users->update_login_info(
			$user->id,
			$this->config_item('login_record_ip'),
			$this->config_item('login_record_time') );

		$this->set_message('auth_login_success');
		return TRUE;
	}

	/**
	 * Logout user from the site
	 *
	 * @return	void
	 */
	public function logout()
	{
		$this->delete_autologin();
		
		// See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
		$this->session->set_userdata(array('user_id' => '', 'username' => '', 'status' => ''));
		$this->session->sess_destroy();
	}

	/**
	 * Check if user logged in. Also test if user is activated and approved.
	 * User can log in only if acct has been approved.
	 *
	 * @param	bool
	 * @return	bool
	 */
	public function is_logged_in($activated = TRUE)
	{
		return $this->session->userdata('status') === ( $activated ? $this->status_activated : $this->status_not_activated );
	}
	
	/**
	 * Get user_id
	 *
	 * @return	string
	 */
	public function get_user_id()
	{
		return $this->session->userdata('user_id');
	}

	/**
	 * Get username
	 *
	 * @return	string
	 */
	public function get_username()
	{
		return $this->session->userdata('username');
	}

	/**
	 * Create new user on the site and return some data about it:
	 * user_id, username, password, email, new_email_key (if any).
	 *
	 * @param	string
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	array
	 */
	public function create_user( $username, $email, $password, $email_activation )
	{
		if ( ! $this->baka_users->is_username_available( $username ) )
		{
			$this->set_error('auth_username_in_use');
			return FALSE;
		}
		
		if ( ! $this->baka_users->is_email_available( $email ) )
		{
			$this->set_error('auth_email_in_use');
			return FALSE;
		}
		
		$data = array(
			'username'	=> $username,
			'password'	=> $this->_do_hash($password),
			'email'		=> $email,
			'last_ip'	=> $this->input->ip_address(),
			'approved'	=> (int) $this->config_item('acct_approval') );
		
		if ($email_activation)
			$data['new_email_key'] = $this->generate_random_key();

		if (!is_null($res = $this->baka_users->create_user($data, !$email_activation)))
		{
			$data['user_id']	= $res['user_id'];
			$data['password']	= $password;
			unset($data['last_ip']);

			return $data;
		}
	}

	/**
	 * Change email for activation and return some data about user:
	 * user_id, username, email, new_email_key.
	 * Can be called for not activated users only.
	 *
	 * @param	string
	 * @return	array
	 */
	public function change_email( $email )
	{
		$user_id = $this->get_user_id();

		if ( is_null($user = $this->baka_users->get_user_by_id($user_id, FALSE)) )
			return FALSE;
		
		$data = array(
			'user_id'	=> $user_id,
			'username'	=> $user->username,
			'email'		=> $email );

		// leave activation key as is
		if (strtolower($user->email) == strtolower($email))
		{
			$data['new_email_key'] = $user->new_email_key;
			
			return $data;
		}
		elseif ($this->baka_users->is_email_available($email))
		{
			$data['new_email_key'] = $this->generate_random_key();
			$this->baka_users->set_new_email($user_id, $email, $data['new_email_key'], FALSE);
			
			return $data;
		}
		else
		{
			$this->set_error('auth_email_in_use');

			return FALSE;
		}
	}

	/**
	 * Activate user using given key
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	public function activate_user($user_id, $activation_key, $activate_by_email = TRUE)
	{
		$this->baka_users->purge_na($this->config_item('email_activation_expire'));

		return $this->baka_users->activate_user($user_id, $activation_key, $activate_by_email);
	}

	/**
	 * Set new password key for user and return some data about user:
	 * user_id, username, email, new_pass_key.
	 * The password key can be used to verify user when resetting his/her password.
	 *
	 * @param	string
	 * @return	array
	 */
	public function forgot_password($login)
	{
		if ( ! ($user = $this->baka_users->get_user_by_login($login)) )
		{
			$this->set_error('auth_incorrect_login');
			return FALSE;
		}

		$data = array(
			'user_id'		=> $user->id,
			'username'		=> $user->username,
			'email'			=> $user->email,
			'new_pass_key'	=> $this->generate_random_key(),
			);

		$this->baka_users->set_password_key($user->id, $data['new_pass_key']);
		
		return $data;
	}

	/**
	 * Check if given password key is valid and user is authenticated.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function can_reset_password($user_id, $new_pass_key)
	{
		return $this->baka_users->can_reset_password(
			$user_id,
			$new_pass_key,
			$this->config_item('forgot_password_expire'));
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user)
	 * and return some data about it: user_id, username, new_password, email.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function reset_password($user_id, $new_pass_key, $new_password)
	{
		if (!($user = $this->baka_users->get_user_by_id($user_id, TRUE)))
			return FALSE;

		if ($this->baka_users->reset_password(
			$user_id,
			$this->_do_hash($new_password),
			$new_pass_key,
			$this->config_item('forgot_password_expire')))
		{
			// success
			// Clear all user's autologins
			$this->clear_autologin($user->id);

			return array(
				'user_id'		=> $user_id,
				'username'		=> $user->username,
				'email'			=> $user->email,
				'new_password'	=> $new_password );
		}

		return FALSE;
	}

	/**
	 * Change user password (only when user is logged in)
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function change_password($old_pass, $new_pass)
	{
		$user_id = $this->get_user_id();

		if (is_null($user = $this->baka_users->get_user_by_id($user_id, TRUE)))
			return FALSE;

		// Check if old password incorrect
		if (!$this->check_hash($old_pass, $user->password))
		{
			$this->set_error('auth_incorrect_password');
			return FALSE;
		}

		// Replace old password with new one
		return $this->baka_users->change_password($user_id, $this->_do_hash($new_pass));
	}

	/**
	 * Change user email (only when user is logged in) and return some data about user:
	 * user_id, username, new_email, new_email_key.
	 * The new email cannot be used for login or notification before it is activated.
	 *
	 * @param	string
	 * @param	string
	 * @return	array
	 */
	public function set_new_email($new_email, $password)
	{
		$user_id = $this->get_user_id();

		if (is_null($user = $this->baka_users->get_user_by_id($user_id, TRUE)))
			return FALSE;

		// Check if password incorrect
		if (!$this->check_hash($password, $user->password))
		{
			$this->set_error('auth_incorrect_password');
			return FALSE;
		}
			
		// success
		$data = array(
			'user_id'	=> $user_id,
			'username'	=> $user->username,
			'new_email'	=> $new_email,
			);

		if ($user->email == $new_email)
		{
			$this->set_error('auth_current_email');
			return FALSE;
		}
		elseif ($user->new_email == $new_email)
		{
			// leave email key as is
			$data['new_email_key'] = $user->new_email_key;
			return $data;
		}
		elseif ($this->baka_users->is_email_available($new_email))
		{
			$data['new_email_key'] = $this->generate_random_key();
			$this->baka_users->set_new_email($user_id, $new_email, $data['new_email_key'], TRUE);
			return $data;
		}
		else
		{
			$this->set_error('auth_email_in_use');
			return FALSE;
		}
	}

	/**
	 * Activate new email, if email activation key is valid.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function activate_new_email($user_id, $new_email_key)
	{
		return $this->baka_users->activate_new_email($user_id, $new_email_key);
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @param	string
	 * @return	bool
	 */
	public function delete_user($password)
	{
		$user_id = $this->get_user_id();

		if (is_null($user = $this->baka_users->get_user_by_id($user_id, TRUE)))
			return FALSE;
			
		if (!$this->check_hash($password, $user->password))
		{	
			$this->set_error('auth_incorrect_password');
			return FALSE;
		}

		// success
		$this->baka_users->delete_user($user_id);
		$this->logout();
		return TRUE;
	}

	/**
	 * Login user automatically if he/she provides correct autologin verification
	 *
	 * @return	void
	 */
	private function _autologin()
	{
		if ($this->is_logged_in() AND $this->is_logged_in(FALSE))
		{
			return FALSE;
		}

		// not logged in (as any user)
		if ($cookie = get_cookie($this->config_item('autologin_cookie_name'), TRUE))
		{
			$data = unserialize($cookie);

			if (isset($data['key']) AND isset($data['user_id']))
			{
				if (!is_null($user = $this->_get_autologin($data['user_id'], md5($data['key']))))
				{
					// Login user
					$this->session->set_userdata(array(
						'user_id'	=> $user->id,
						'username'	=> $user->username,
						'status'	=> $this->status_activated ));

					// Renew users cookie to prevent it from expiring
					set_cookie(array(
						'name' 		=> $this->config_item('autologin_cookie_name'),
						'value'		=> $cookie,
						'expire'	=> $this->config_item('autologin_cookie_life') ));

					$this->baka_users->update_login_info(
						$user->id,
						$this->config_item('login_record_ip'),
						$this->config_item('login_record_time'));

					return TRUE;
				}
			}
		}
	}

	/**
	 * Get user data for auto-logged in user.
	 * Return FALSE if given key or user ID is invalid.
	 *
	 * @param	int
	 * @param	string
	 * @return	object
	 */
	private function _get_autologin($user_id, $key)
	{
		$users_table = $this->baka_users->get_users_table();

		$query	 = $this->db->select($users_table.'.id')
							->select($users_table.'.username')
							->from($users_table)
							->join($this->user_autologin_table, $this->user_autologin_table.'.user_id = '.$users_table.'.id')
							->where($this->user_autologin_table.'.user_id', $user_id)
							->where($this->user_autologin_table.'.key_id', $key)
							->get();

		if ($query->num_rows() == 1)
			return $query->row();
		
		return FALSE;
	}

	/**
	 * Save data for user's autologin
	 *
	 * @param	int
	 * @return	bool
	 */
	private function _create_autologin( $user_id )
	{
		$key = substr(md5(uniqid(mt_rand().get_cookie($this->config->item('sess_cookie_name')))), 0, 16);

		$this->purge_autologin($user_id);

		if ($this->_set_autologin($user_id, md5($key)))
		{
			set_cookie(array(
				'name' 	=> $this->config_item('autologin_cookie_name'),
				'value'	=> serialize(array('user_id' => $user_id, 'key' => $key)),
				'expire'=> $this->config_item('autologin_cookie_life'),
				));
			
			return TRUE;
		}
		
		return FALSE;
	}

	/**
	 * Save data for user's autologin
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	private function _set_autologin($user_id, $key)
	{
		return $this->db->insert($this->user_autologin_table, array(
			'user_id' 		=> $user_id,
			'key_id'	 	=> $key,
			'user_agent' 	=> substr($this->input->user_agent(), 0, 149),
			'last_ip' 		=> $this->input->ip_address() ));
	}

	/**
	 * Clear user's autologin data
	 *
	 * @return	void
	 */
	private function delete_autologin()
	{
		if ($cookie = get_cookie( $this->config_item('autologin_cookie_name'), TRUE))
		{
			$data = unserialize($cookie);

			$this->_delete_autologin($data['user_id'], md5($data['key']));

			delete_cookie($this->config_item('autologin_cookie_name'));
		}
	}

	/**
	 * Delete user's autologin data
	 *
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	private function _delete_autologin($user_id, $key)
	{
		$this->db->delete($this->user_autologin_table, array(
			'user_id'	=> $user_id,
			'key_id'	=> $key ));
	}

	/**
	 * Delete all autologin data for given user
	 *
	 * @param	int
	 * @return	void
	 */
	public function clear_autologin($user_id)
	{
		$this->db->delete($this->user_autologin_table, array(
			'user_id' => $user_id ));
	}

	/**
	 * Purge autologin data for given user and login conditions
	 *
	 * @param	int
	 * @return	void
	 */
	public function purge_autologin($user_id)
	{
		$this->db->delete($this->user_autologin_table, array(
			'user_id'	=> $user_id,
			'user_agent'=> substr($this->input->user_agent(), 0, 149),
			'last_ip'	=> $this->input->ip_address() ));
	}

	/**
	 * Check if login attempts exceeded max login attempts (specified in config)
	 *
	 * @param	string
	 * @return	bool
	 */
	public function is_max_login_attempts_exceeded($login)
	{
		if ($this->config_item('login_count_attempts'))
		{
			return $this->get_attempts_num($this->input->ip_address(), $login) >= $this->config_item('login_max_attempts');
		}

		return FALSE;
	}

	/**
	 * Get number of attempts to login occured from given IP-address or login
	 *
	 * @param	string
	 * @param	string
	 * @return	int
	 */
	public function get_attempts_num( $ip_address, $login )
	{
		$this->db->select('1', FALSE);
		$this->db->where('ip_address', $ip_address);
		$this->db->or_where('login', $login);

		return $this->db->get( $this->login_attempts_table )->num_rows();
	}

	/**
	 * Increase number of attempts for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function increase_login_attempt($login)
	{
		if ($this->config_item('login_count_attempts'))
		{
			if (!$this->is_max_login_attempts_exceeded($login))
			{
				$this->increase_attempt($this->input->ip_address(), $login);
			}
		}
	}

	/**
	 * Increase number of attempts for given IP-address and login
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function increase_attempt($ip_address, $login)
	{
		$this->db->insert($this->login_attempts_table, array('ip_address' => $ip_address, 'login' => $login));
	}

	/**
	 * Clear all attempt records for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function _clear_login_attempts($login)
	{
		if ($this->config_item('login_count_attempts'))
		{
			$this->clear_attempts(
				$this->input->ip_address(),
				$login,
				$this->config_item('login_attempt_expire'));
		}
	}

	/**
	 * Clear all attempt records for given IP-address and login.
	 * Also purge obsolete login attempts (to keep DB clear).
	 *
	 * @param	string
	 * @param	string
	 * @param	int
	 * @return	void
	 */
	public function clear_attempts($ip_address, $login, $expire_period = 86400)
	{
		$this->db->where(array('ip_address' => $ip_address, 'login' => $login));

		// Purge obsolete login attempts
		$this->db->or_where('UNIX_TIMESTAMP(time) <', time() - $expire_period);

		$this->db->delete( $this->login_attempts_table );
	}
	
	/**
	 * Gets the datatype of a table and converts it to the format $arr['column_name'] = 'datatype'
	 */
	public function get_profile_datatypes()
	{
		$result_array = $this->baka_users->get_profile_datatypes();
		return $this->multi_to_assoc($result_array);
	}
	
	/**
	 * Check if user has permission to do an action
	 *
	 * @param string $permission: The permission you want to check for from the `permissions.permission` table.
	 * @return bool
	 */
	public function permit($permission)
	{
		if ( !$this->baka_users->permission_exists($permission) )
			$this->baka_users->new_permission($permission, '-');

		$user_id			= $this->get_user_id();
		$user_permissions	= $this->baka_users->get_permissions($user_id);
		$overrides			= $this->baka_users->get_permission_overrides($user_id);
		$allow				= FALSE;
		
		// Check role permissions
		foreach($user_permissions as $val)
		{
			if($val == $permission)
			{
				$allow = TRUE;
				break;
			}
		}
		
		// Check if there are overrides and overturn the result as needed
		if($overrides)
		{
			foreach($overrides as $val)
			{
				if($val['permission'] == $permission)
				{
					$allow = (bool)$val['allow'];
					break;
				}
			}
		}
		
		return $allow;
	}
	
	/**
	 * Overriding permissions method
	 */
	public function add_override($user_id, $permission, $allow = 1)
	{
		return $this->baka_users->add_override($user_id, $permission, $allow);
	}

	public function remove_override($user_id, $permission)
	{
		return $this->baka_users->remove_override($user_id, $permission);
	}

	public function flip_override($user_id, $permission)
	{
		return $this->baka_users->flip_override($user_id, $permission);
	}
	
	/**
	 * Get a user's roles
	 *
	 * @param int $user_id
	 * @return array
	 */
	public function get_roles($user_id)
	{
		return $this->baka_users->get_roles($user_id);
	}
	
	/**
	 * Role management methods
	 */
	public function add_role($user_id, $role)
	{
		return $this->baka_users->add_role($user_id, $role);
	}

	public function remove_role($user_id, $role)
	{
		return $this->baka_users->remove_role($user_id, $role);
	}

	public function change_role($user_id, $old, $new)
	{
		return $this->baka_users->change_role($user_id, $old, $new);
	}
	
	/**
	 * Permission management methods
	 */
	public function add_permission($permission, $role)
	{
		return $this->baka_users->add_permission($permission, $role);
	}

	public function remove_permission($permission, $role)
	{
		return $this->baka_users->remove_permission($permission, $role);
	}

	public function new_permission($permission, $description)
	{
		return $this->baka_users->new_permission($permission, $description);
	}

	public function clear_permission($permission)
	{
		return $this->baka_users->clear_permission($permission);
	}

	public function save_permission($permission_ident, $permission = FALSE, $description = FALSE, $parent = FALSE, $sort = FALSE)
	{
		return $this->baka_users->save_permission(array(
			'permission_ident'	=> $permission_ident,
			'permission'		=> $permission,
			'description'		=> $description,
			'parent'			=> $parent,
			'sort'				=> $sort ));
	}
	
	/**
	 * Get user profile contents
	 */
	public function get_user_profile($user_id)
	{
		return $this->baka_users->get_user_profile($user_id);
	}
	
	/**
	 * Account approval methods
	 */
	public function is_approved($user_id)
	{
		return $this->baka_users->is_approved($user_id);
	}

	public function approve_user($user_id)
	{
		return $this->baka_users->approve_user($user_id);
	}

	public function unapprove_user($user_id)
	{
		return $this->baka_users->unapprove_user($user_id);
	}


	/**
	 * Generate a random string based on kernel's random number generator
	 * @return string
	 */
	public function generate_random_key()
	{
		if ( function_exists('openssl_random_pseudo_bytes') )
		{
			$key = md5(openssl_random_pseudo_bytes(1024, $cstrong) . microtime() . mt_rand() );
		}
		else
		{
			$randomizer = file_exists('/dev/urandom') ? '/dev/urandom' : '/dev/random';
			$key = md5(file_get_contents($randomizer, NULL, NULL, 0, 1024) . microtime() . mt_rand());
		}

		return $key;
	}
}

/* End of file Baka_auth.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_auth.php */