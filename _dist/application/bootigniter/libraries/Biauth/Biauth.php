<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Biauth
 * @category    Drivers
 */

// -----------------------------------------------------------------------------

// Requiring PHPASS-0.3 file
require_once config_item('bi_base_path').'libraries/vendor/PasswordHash.php';

class Biauth extends CI_Driver_Library
{
    /**
     * Codeigniter Instance
     *
     * @var  mixed
     */
    public $_ci;

    /**
     * PHPASS-0.3 Instance
     *
     * @var  mixed
     */
    public $_phpass = array();

    /**
     * Tables definition
     *
     * @var  array
     */
    public $table = array();

    /**
     * Valid drivers that will be loaded
     *
     * @var  array
     */
    public $valid_drivers = array(
        'biauth_users',
        'biauth_groups',
        'biauth_permissions',
        'biauth_autologin',
        'biauth_login_attempt',
        );

    /**
     * Default class constructor
     */
    public function __construct()
    {
        $this->_ci =& get_instance();

        // Loading base configuration
        $this->_ci->config->load('biauth');
        // Loading base language translation
        $this->_ci->lang->load('biauth');
        // Loading Session library
        $this->_ci->load->library('session');
        // Loading required helpers
        $this->_ci->load->helpers(array('cookie', 'biauth'));

        // Instaciating PHPASS-0.3 class
        $this->_phpass = new PasswordHash(config_item('biauth_hash_strength'), config_item('biauth_hash_portable'));

        // Initializing available tables by config
        $tables = array(
            'users',
            'user_meta',
            'user_group',
            'groups',
            'permissions',
            'group_perms',
            'overrides',
            'autologin',
            'login_attempts',
            );

        foreach ($tables as $table)
        {
            $this->table[$table] = config_item('biauth_'.$table.'_table');
        }

        // Trying autologin user
        if (!$this->is_logged_in() and !$this->is_logged_in(FALSE))
        {
            $this->_autologin();
        }

        log_message('debug', "#Biauth: Driver Class Initialized");
    }

    // -------------------------------------------------------------------------
    // PHPASS-0.3
    // -------------------------------------------------------------------------

    /**
     * Hashing password using PHPASS-0.3
     *
     * @param   string  $password  The password that need to be hashed
     *
     * @return  string
     */
    protected function do_hash($password)
    {
        return $this->_phpass->HashPassword($password);
    }

    // -------------------------------------------------------------------------

    /**
     * Validating password hash using PHPASS-0.3
     *
     * @param   string  $new_pass  New Password that need to be check
     * @param   string  $old_pass  Old Password as refrence
     *
     * @return  bool
     */
    protected function validate_hash($new_pass, $old_pass)
    {
        return $this->_phpass->CheckPassword($new_pass, $old_pass);
    }

    // -------------------------------------------------------------------------
    // Login
    // -------------------------------------------------------------------------

    /**
     * Login user on the site. Return TRUE if login is successful
     * (user exists and activated, password is correct), otherwise FALSE.
     *
     * @param   string  $login     Username or Email are depending on config file
     * @param   string  $password  User Password
     * @param   bool    $remember  Enable autologin
     *
     * @return  bool
     */
    public function login($login, $password, $remember)
    {
        // Fail - wrong login
        if (!($user = $this->get_user($login, login_by())))
        {
            $this->login_attempt->increase($login);
            set_message('error', _x('biauth_incorrect_login'));
            return FALSE;
        }

        // Fail - wrong password
        if (!$this->validate_hash($password, $user->password))
        {
            $this->login_attempt->increase($login);
            set_message('error', _x('biauth_incorrect_password'));
            return FALSE;
        }

        if ($logged_in = $this->_validate_user($user))
        {
            // Clean up attemptions for this user
            $this->login_attempt->clear($login);

            // Creating autologin, if needed
            if ((bool) $remember)
            {
                $this->create_autologin($user->id);
            }

            set_message('success', _x('biauth_login_success'));
        }

        return $logged_in;
    }

    // -------------------------------------------------------------------------

    /**
     * Validating user objects
     *
     * @param   object  $user  User Object
     * @return  bool
     */
    protected function _validate_user(&$user)
    {
        $return = TRUE;

        // Fail - banned
        if ($user->banned == 1)
        {
            set_message('error', _x('biauth_banned_account', $user->ban_reason));
            $return = FALSE;
        }

        // Fail - deleted
        if ($user->deleted == 1)
        {
            set_message('error', _x('biauth_deleted_account'));
            $return = FALSE;
        }

        // Save to session
        $user_data = array(
            'user_id'   => $user->id,
            'username'  => $user->username,
            'display'   => $user->display,
            'status'    => (int) $user->activated
            );

        // Fail - not activated
        if ($user->activated == 0)
        {
            set_message('error', _x('biauth_inactivated_account'));
            $return = FALSE;
        }
        else
        {
            // grab all permissions
            $user_data['user_perms'] = $this->users->get_perms($user->id, TRUE);
        }

        $this->_ci->session->set_userdata($user_data);

        if ($return !== FALSE)
        {
            // update login info
            $login_data = array('last_login' => date('Y-m-d H:i:s'));

            if (Bootigniter::get_setting('auth_login_record_ip'))
            {
                $login_data['last_ip'] = $this->_ci->input->ip_address();
            }

            $this->users->edit($user->id, $login_data);
        }

        return $return;
    }

    // -------------------------------------------------------------------------

    /**
     * Logout user from the site
     *
     * @return  void
     */
    public function logout()
    {
        $this->autologin->delete();

        // See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
        $this->_ci->session->set_userdata(array(
            'user_id'    => '',
            'username'   => '',
            'display'    => '',
            'status'     => NULL,
            'user_perms' => array()
            ));

        $this->_ci->session->sess_destroy();
    }

    // -------------------------------------------------------------------------

    /**
     * Check if user logged in. Also test if user is activated and approved.
     * User can log in only if acct has been approved.
     *
     * @param   bool  $activated  Is user activated
     * @return  bool
     */
    public function is_logged_in($activated = TRUE)
    {
        return $this->_ci->session->userdata('status') === bool_to_int($activated) and !IS_CLI;
    }

    // -------------------------------------------------------------------------

    /**
     * Getting current user session data
     *
     * @param   string        $data_key  Permission key
     * @return  string|array
     */
    public function get_current_user($user_key = '')
    {
        if (!$this->is_logged_in() and !$this->is_logged_in(FALSE))
        {
            return FALSE;
        }

        $user_data = $this->_ci->session->all_userdata();

        if (!empty($user_key) and isset($user_data[$user_key]))
        {
            return $user_data[$data_key];
        }

        return $user_data;
    }

    // -------------------------------------------------------------------------

    /**
     * Get logged in User ID
     *
     * @return  int
     */
    public function get_user_id()
    {
        return $this->_ci->session->userdata('user_id');
    }

    // -------------------------------------------------------------------------

    /**
     * Get username
     *
     * @return  string
     */
    public function get_username()
    {
        return $this->_ci->session->userdata('username');
    }

    // -------------------------------------------------------------------------

    /**
     * Get User display name
     *
     * @return  string
     */
    public function get_display()
    {
        return $this->_ci->session->userdata('display');
    }

    // -------------------------------------------------------------------------

    /**
     * Login user automatically if he/she provides correct autologin verification
     *
     * @return  void
     */
    private function _autologin()
    {
        // not logged in (as any user)
        if (($cookie = biauth_get_cookie()) and isset($cookie['key']) and isset($cookie['user_id']))
        {
            if ($user = $this->autologin->get($cookie['user_id'], md5($cookie['key'])))
            {
                $this->_validate_user($user);
                biauth_set_cookie($cookie['user_id'], $cookie['key']);
            }
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Save data for user's autologin
     *
     * @param   int
     * @return  bool
     */
    public function create_autologin($user_id)
    {
        // somehow i need to use biauth_keygen()
        $key = substr(md5(uniqid(mt_rand().get_cookie(config_item('sess_cookie_name')))), 0, 16);
        // var_dump($key);

        $this->autologin->purge($user_id);

        if ($this->autologin->set($user_id, md5($key)))
        {
            biauth_set_cookie($user_id, $key);
            return TRUE;
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------
    // User
    // -------------------------------------------------------------------------

    public function get_user($term, $field = '')
    {
        if ($user = $this->users->get($term, $field))
        {
            $user->groups = $this->users->get_groups($user->id);
            $user->perms = $this->users->get_perms($user->id, TRUE);

            return $user;
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Create new user on the site and return some data about it:
     * user_id, username, password, email, new_email_key (if any).
     *
     * @param   string
     * @param   string
     * @param   string
     * @param   bool
     * @return  array
     */
    public function create_user($user_data)
    {
        $user_data['password'] = $this->do_hash($user_data['password']);
        $user_data = $this->_filter_user_request('activation', $user_data);
        $display = isset($user_data['display']) ? $user_data['display'] : $user_data['username'];

        if ($user_id = $this->users->add($user_data))
        {
            set_message('success', 'Berhasil menambahkan "'.$display.'" sebagai pengguna baru.');
            return $user_id;
        }
        else
        {
            set_message('error', 'Gagal menambahkan "'.$display.'" sebagai pengguna baru.');
            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Update User data
     *
     * @param   int     $user_id   User ID
     * @param   string  $username  New Username
     * @param   string  $email     New Email
     * @param   string  $old_pass  Old Password
     * @param   string  $new_pass  New Password
     * @param   array   $groups     User Roles
     *
     * @return  bool
     */
    public function edit_user($user_id, $user_data)
    {
        $user = $this->users->get($user_id);
        $request_types = array();

        // If user want to change their password
        if (!empty($user_data['old_pass']) and !empty($user_data['new_pass']))
        {
            // If their old password is invalid
            if (!$this->validate_hash($user_data['old_pass'], $user->password))
            {
                set_message('error', _x('biauth_incorrect_password'));
                return FALSE;
            }

            // If their new password is same as before
            if ($this->validate_hash($user_data['new_pass'], $user->password))
            {
                set_message('error', _x('biauth_current_password'));
                return FALSE;
            }

            // Set new request
            $request_types[] = 'change_pass';
            $user_data['password'] = $this->do_hash($user_data['new_pass']);
        }

        // If user want to change their email address
        if (strtolower($user_data['username']) != strtolower($user->username))
        {
            if ($this->is_username_exists($user_data['username']))
            {
                set_message('error', _x('biauth_username_in_use'));
                return FALSE;
            }

            if (!$this->is_username_allowed($user_data['username']))
            {
                set_message('error', _x('biauth_username_blacklisted'));
                return FALSE;
            }
        }

        // If user want to change their email address
        if (strtolower($user_data['email']) != strtolower($user->email))
        {
            if ($this->is_email_exists($user_data['email']))
            {
                set_message('error', _x('biauth_email_in_use'));
                return FALSE;
            }

            // Add new request
            $request_types[] = 'change_email';
        }

        // If user has special request
        if (!empty($request_types))
        {
            $user_data = $this->_filter_user_request($request_types, $user_data);
        }

        unset($user_data['old_pass'], $user_data['new_pass']);

        // If user need to confirm their special request
        if (isset($user_data['request_key']) and !empty($user_data['request_key']))
        {
            unset($user_data['password'], $user_data['email']);
        }

        if ($this->users->edit($user_id, $user_data))
        {
            set_message('success', 'Berhasil mengubah data pengguna '.$user->display);
            return TRUE;
        }
        else
        {
            set_message('error', 'Terjadi kesalahan dalam mengubah data pengguna '.$user->display);
            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Delete user from the site
     *
     * @param   string
     * @return  bool
     */
    public function delete_user($user_id, $purge = FALSE)
    {
        if ($purge == TRUE)
        {
            if (!$this->users->delete($user_id))
            {
                set_message('error', 'Terjadi masalah dalam penghapusan data pengguna');
                return FALSE;
            }

            if (!$this->users->clear_meta($user_id))
            {
                set_message('error', 'Terjadi masalah dalam penghapusan meta data pengguna');
                return FALSE;
            }

            if (!$this->users->clear_groups($user_id))
            {
                set_message('error', 'Terjadi masalah dalam penghapusan group pengguna');
                return FALSE;
            }

            set_message('success', 'Berhasil menghapus pengguna secara permanen');
            return TRUE;
        }
        else
        {
            $return = $this->users->change_status($user_id, 'deleted', TRUE);
            set_message('success', 'Berhasil menghapus pengguna');
        }

        return $return;
    }

    // -------------------------------------------------------------------------

    /**
     * Filtering user request, e.g. registration activation, changing email address,
     * changing password. See `/bootigniter/config/biauth.php` for configurations
     *
     * @param   string|array  $type       User request type(s)
     * @param   array         $user_data  User data
     * @return  array
     */
    public function _filter_user_request($type, array $user_data)
    {
        $request_types = array('activation', 'change_email', 'change_pass');
        $type = !is_array($type) ? array($type) : $type;

        foreach ($request_types as $request_type)
        {
            if (config_item('biauth_request_email_'.$request_type) == TRUE and in_array($request_type, $type))
            {
                $user_data['request_type'] = serialize($type);
                $user_data['request_time'] = date('Y-m-d H:i:s');
                $user_data['request_key'] = biauth_keygen();

                $this->_ci->bootigniter->send_email($user_data['email'], 'lang:'.implode('+', $type), $user_data);
                break;
            }
        }

        return $user_data;
    }

    // -------------------------------------------------------------------------

    /**
     * Validating previous user(s) request by key
     *
     * @param   string  $request_key  User request key
     * @return  bool
     */
    public function _validate_user_request($request_key)
    {
        if ($user = $this->users->get($request_key, 'request_key'))
        {
            $expired = time() - config_item('biauth_request_life');

            if (strtotime($user->request_time) > $expired)
            {
                set_message('error', 'Key yang anda gunakan tidak valid atau sudah kadaluarsa.');
                return FALSE;
            }

            $request_value = unserialize($user->request_value);
            $user_data = array();

            if (isset($request_value['activated']))
            {
                $user_data['activated'] = $request_value['activated'];
            }

            if (isset($request_value['email']))
            {
                $user_data['email'] = $request_value['email'];
            }

            if (isset($request_value['password']))
            {
                $user_data['password'] = $request_value['password'];
            }

            if ($this->users->edit($user->id, $user_data))
            {
                $user_data = array_keys($user_data);
                set_message('success', 'Berhasil mengubah data "'.implode('" dan "', $user_data).'" dari '.$user->display);
                return TRUE;
            }
        }

        set_message('error', 'Key yang anda gunakan tidak valid atau sudah kadaluarsa.');
        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Check if user has permission to do an action
     *
     * @param string $permission: The permission you want to check for from the `permissions.permission` table.
     * @return bool
     */
    public function current_user_can($permission)
    {
        $allowed = FALSE;

        if (($user_perms = $this->_ci->session->userdata('user_perms')) !== FALSE)
        {
            $user_perms = array_values($user_perms);

            // Check group permissions
            if (in_array($permission, $user_perms))
            {
                $allowed = TRUE;
            }
        }

        // Check if there are overrides and overturn the result as needed
        // if($overrides = $user->get_perm_overrides())
        // {
        //     foreach($overrides as $o_val)
        //     {
        //         if($o_val['permission'] == $permission)
        //         {
        //             $allowed = (bool)$o_val['allowed'];
        //             break;
        //         }
        //     }
        // }

        return $allowed;
    }

    // -------------------------------------------------------------------------
    // Username
    // -------------------------------------------------------------------------

    public function is_username_exists($username)
    {
        return $this->get_user($username, 'username') !== FALSE;
    }

    public function is_username_allowed($username)
    {
        foreach (array('blacklist', 'blacklist_prepend', 'exceptions') as $setting)
        {
            $$setting  = array_map('trim', explode(',', Bootigniter::get_setting('auth_username_'.$setting)));
        }

        // Generate complete list of blacklisted names
        $full_blacklist = $blacklist;

        foreach ($blacklist as $val)
        {
            foreach ($blacklist_prepend as $v)
            {
                $full_blacklist[] = $v.' '.$val;
            }
        }

        // Remove exceptions
        foreach ($full_blacklist as $key => $name)
        {
            if (in_array($name, $exceptions))
            {
                unset($full_blacklist[$key]);
            }
        }

        $valid = TRUE;

        if (in_array($username, $full_blacklist))
        {
            $valid = FALSE;
        }

         return $valid;
    }

    // -------------------------------------------------------------------------
    // Email
    // -------------------------------------------------------------------------

    /**
     * Check is Email already exists
     *
     * @param   string  $login  Email
     *
     * @return  bool
     */
    public function is_email_exists($email)
    {
        return $this->get_user($email, 'email') !== FALSE;
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
    public function activate_user($user_id, $activation_key)
    {
        return $this->users->change_status($user_id, 'activated', TRUE);
    }

    // -------------------------------------------------------------------------

    /**
     * Activating an inactivated specified user
     *
     * @param   int   $user_id  User id who want to be activate
     *
     * @return  bool
     */
    public function deactivate_user($user_id)
    {
        return $this->users->change_status($user_id, 'activated', FALSE);
    }

    // -------------------------------------------------------------------------

    /**
     * Activating an inactivated specified user
     *
     * @param   int   $user_id  User id who want to be activate
     *
     * @return  bool
     */
    public function resend($login)
    {
        if ($user = $this->users->get($login, 'login'))
        {
            $user_data['display'] = $user->display;
            $user_data['username'] = $user->username;
            $user_data['request_type'] = $user->request_type;
            $user_data['request_time'] = date('Y-m-d H:i:s');
            $user_data['request_key'] = biauth_keygen();
            $user_data['request_value'] = $user->request_value;

            $this->_ci->bootigniter->send_email($user->email, 'lang:'.$user->request_type, $user_data);
            // set_message('error', 'Email atau Username yang anda masukan tidak terdaftar.');
            return $this->users->edit($user_id, $user_data);
        }

        set_message('error', 'Email atau Username yang anda masukan tidak terdaftar.');
        return FALSE;
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
    public function ban_user($user_id, $reason = NULL)
    {
        return $this->change_status($user_id, 'banned', FALSE, array('ban_reason' => $reason));
    }

    // -------------------------------------------------------------------------

    /**
     * Unban user
     *
     * @param   int
     *
     * @return  void
     */
    public function unban_user($user_id)
    {
        return $this->change_status($user_id, 'banned', TRUE, array('ban_reason' => NULL));
    }

    // -------------------------------------------------------------------------
    // Groups
    // -------------------------------------------------------------------------

    public function get_group($group_id)
    {
        if ($group = $this->groups->get($group_id))
        {
            return $group;
        }
    }

    // -------------------------------------------------------------------------

    public function edit_group($group_id, $group_data)
    {
        if ($group_id == 1 and $group_data['default'] == 1)
        {
            set_message('error', $group_data['name'].' tidak dapat dijadikan default.');
            return FALSE;
        }

        if ($this->groups->edit($group_id, $group_data))
        {
            set_message('success', 'Berhasil mengubah data pengguna '.$group_data['name']);
            return TRUE;
        }
        else
        {
            set_message('error', 'Terjadi kesalahan dalam mengubah data pengguna '.$group_data['name']);
            return FALSE;
        }
    }
}

/* End of file Biauth.php */
/* Location: ./bootigniter/libraries/Biauth/Biauth.php */
