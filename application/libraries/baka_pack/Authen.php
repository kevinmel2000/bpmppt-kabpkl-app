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
 * BAKA Auth Class
 *
 * @subpackage  Libraries
 * @category    Security
 */
class Authen
{
    /**
     * Codeigniter superobject
     * 
     * @var  mixed
     */
    protected static $_ci;

    protected static $user_perms = array();

    public $messages = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        self::$_ci =& get_instance();

        self::$_ci->load->helper('cookie');
        self::$_ci->load->library('session');
        self::$_ci->load->helper('baka_pack/authen');
        self::$_ci->load->model('baka_pack/authen_model');

        $this->_autologin();

        log_message('debug', "#Baka_pack: Authen Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * @param   string  $method  Method name
     * @param   mixed   $args    Method Arguments
     *
     * @return  mixed
     */
    public function __call( $method, $args )
    {
        if ( !method_exists( self::$_ci->authen_model, $method ) )
        {
            show_error('Undefined method Authen::'.$method.'() called', 500, 'An Error Eas Encountered');
        }

        return call_user_func_array( array( self::$_ci->authen_model, $method ), $args );
    }

    // -------------------------------------------------------------------------

    /**
     * phpass-0.3 hashing
     *
     * @param   string      $pass  Password to be hashed
     *
     * @return  obj|string
     */
    protected function do_hash( $pass = '' )
    {
        require_once(APPPATH.'libraries/vendor/PasswordHash.php');

        $phpass = new PasswordHash( get_conf('phpass_hash_strength'), get_conf('phpass_hash_portable') );

        if ( $pass != '' )
            return $phpass->HashPassword( $pass );

        return $phpass;
    }

    // -------------------------------------------------------------------------

    /**
     * phpass-0.3 check hash
     *
     * @param   string  $new_pass  New Password
     * @param   string  $old_pass  Old Password
     *
     * @return  bool
     */
    protected function validate( $new_pass, $old_pass )
    {
        return $this->do_hash()->CheckPassword( $new_pass, $old_pass );
    }

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
    public function login( $login, $password, $remember )
    {
        // fail - wrong login
        if ( !( $user = $this->get_user( $login, login_by() ) ) )
        {
            $this->increase_login_attempt( $login );
            $this->set_message( 'error', _x('auth_incorrect_login') );
            return FALSE;
        }

        // fail - wrong password
        if ( !$this->validate( $password, $user->password ) )
        {
            $this->increase_login_attempt( $login );
            $this->set_message( 'error', _x('auth_incorrect_password') );
            return FALSE;
        }

        // fail - banned
        if ( $user->banned == 1 )
        {
            $this->set_message( 'error', _x('auth_banned_account', $user->ban_reason) );
            return FALSE;
        }

        // fail - deleted
        if ( $user->deleted == 1 )
        {
            $this->set_message( 'error', _x('auth_deleted_account') );
            return FALSE;
        }

        // Save to session
        self::$_ci->session->set_userdata( array(
            'user_id'   => $user->id,
            'username'  => $user->username,
            'status'    => (int) $user->activated
            ));

        // fail - not activated
        if ( $user->activated == 0 )
        {
            $this->set_message( 'error', _x('auth_inactivated_account') );
            return FALSE;
        }

        // success
        // $user_profile = '';
        // $this->get_user_profile($user->id);
        // self::$_ci->session->set_userdata('user_profile', $user_profile);

        if ( $user->activated == 1 and ($user_perms = $this->get_user_perms( $user->id )) )
            self::$_ci->session->set_userdata('user_perms', $user_perms);

        if ( (bool) $remember )
            $this->create_autologin( $user->id );

        $this->clear_login_attempts( $user->username );

        $this->update_login_info( $user->id );

        $this->set_message( 'success', _x('auth_login_success') );
        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Logout user from the site
     *
     * @return  void
     */
    public function logout()
    {
        $this->delete_autologin();
        
        // See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
        self::$_ci->session->set_userdata( array('user_id' => '', 'username' => '', 'status' => NULL) );
        self::$_ci->session->sess_destroy();
    }

    // -------------------------------------------------------------------------

    /**
     * Check if user logged in. Also test if user is activated and approved.
     * User can log in only if acct has been approved.
     *
     * @param   bool  $activated  Is user activated
     *
     * @return  bool
     */
    public static function is_logged_in( $activated = TRUE )
    {
        return self::$_ci->session->userdata('status') === bool_to_int( $activated );
    }

    // -------------------------------------------------------------------------
    
    /**
     * Get logged in User ID
     *
     * @return  int
     */
    public function get_user_id()
    {
        return self::$_ci->session->userdata('user_id');
    }

    // -------------------------------------------------------------------------

    /**
     * Get username
     *
     * @return  string
     */
    public function get_username()
    {
        return self::$_ci->session->userdata('username');
    }

    // -------------------------------------------------------------------------
    
    /**
     * Get all data of current logged in user
     *
     * @return  array
     */
    public function get_current_user()
    {
        return self::$_ci->session->all_userdata();
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
    public function create_user( $username, $email, $password, $roles = array() )
    {
        if ( $this->check_username( $username ) )
        {
            $this->set_message( 'error', _x('auth_username_in_use') );
            return FALSE;
        }

        if ( $this->check_email( $email ) )
        {
            $this->set_message( 'error', _x('auth_email_in_use') );
            return FALSE;
        }

        $user_data = array(
            'username'  => $username,
            'password'  => $this->do_hash( $password ),
            'email'     => $email );

        $email_activation = (bool) Setting::get('auth_email_activation');

        if ( $email_activation )
        {
            $user_data['new_email_key'] = $this->generate_random_key();
        }

        if ( !($user_id = $this->add_user( $user_data, !$email_activation, $roles )) )
        {
            return FALSE;
        }

        if ( $email_activation )
        {
            $user_data['user_id']    = $user_id;
            $user_data['password']   = $password;

            emailer_send( $email, 'activate', $user_data );
        }

        return TRUE;
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
     * @param   array   $roles     User Roles
     *
     * @return  bool
     */
    public function update_user( $user_id, $username, $email, $old_pass, $new_pass, $roles = array() )
    {
        $user = $this->get_user( $user_id );
        $data = array();

        if ( strtolower( $user->username ) != strtolower( $username ) and $this->check_username( $username ) === FALSE )
        {
            $data['username'] = $username;
        }

        if ( strtolower( $user->email ) != strtolower( $email ) and $this->check_email( $email ) === FALSE )
        {
            $data['email'] = $email;
        }

        if ( strlen( $old_pass ) > 0 and strlen( $new_pass ) > 0 )
        {
            if ( !$this->validate( $old_pass, $user->password ) )
            {
                $this->set_message( 'error', _x('auth_incorrect_password') );
                return FALSE;
            }
            else if ( $this->validate( $new_pass, $user->password ) )
            {
                $this->set_message( 'error', _x('auth_current_password') );
                return FALSE;
            }
            else
            {
                $data['password'] = $this->do_hash( $new_pass );
            }
        }

        if ( count( $data ) > 0 and ( $return = $this->edit_user( $user_id, $data ) ) )
        {
            $this->set_message( 'success', 'Selamat' );
        }

        // if ( count( $roles ) > 0 )
        // {
        //     $return = TRUE;
        //     foreach ( $roles as $role )
        //         $this->set_message( 'success', $role );
        // }

        return $return;
    }

    // -------------------------------------------------------------------------

    /**
     * Change email for activation and return some data about user:
     * user_id, username, email, new_email_key.
     * Can be called for not activated users only.
     *
     * @param   string  $email  User Email
     *
     * @return  bool|array
     */
    public function change_email( $email )
    {
        $user_id = $this->get_user_id();

        if ( !( $user = $this->get_user( $user_id ) ) )
            return FALSE;

        $data = array(
            'user_id'   => $user_id,
            'username'  => $user->username,
            'email'     => $email );

        // leave activation key as is
        if ( strtolower( $user->email ) == strtolower( $email ) )
        {
            $data['new_email_key'] = $user->new_email_key;
            
            return $data;
        }
        elseif ( $this->is_email_available( $email ) )
        {
            $data['new_email_key'] = $this->generate_random_key();
            $this->set_new_email( $user_id, $email, $data['new_email_key'], FALSE );
            
            return $data;
        }
        else
        {
            $this->set_message( 'error', _x('auth_email_in_use') );

            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Activate user using given key
     *
     * @param   int     $user_id         User ID
     * @param   string  $activation_key  Activation Key
     *
     * @return  bool
     */
    public function activate( $user_id, $activation_key )
    {
        $this->purge_na();

        return $this->activate_user( $user_id, $activation_key );
    }

    // -------------------------------------------------------------------------

    /**
     * Set new password key for user and return some data about user:
     * user_id, username, email, new_pass_key.
     * The password key can be used to verify user when resetting his/her password.
     *
     * @param   string
     * @return  array
     */
    public function forgot_pass($login)
    {
        if ( !($user = $this->get_user_by_login($login)) )
        {
            $this->set_message( 'error', _x('auth_incorrect_login') );
            return FALSE;
        }

        $data = array(
            'user_id'       => $user->id,
            'username'      => $user->username,
            'email'         => $user->email,
            'new_pass_key'  => $this->generate_random_key(),
            );

        $this->set_password_key($user->id, $data['new_pass_key']);
        
        return $data;
    }

    // -------------------------------------------------------------------------

    /**
     * Replace user password (forgotten) with a new one (set by user)
     * and return some data about it: user_id, username, new_password, email.
     *
     * @param   string
     * @param   string
     * @return  bool
     */
    public function reset_pass( $user_id, $new_pass_key, $new_password )
    {
        if (!($user = $this->get_user_by_id($user_id, TRUE)))
            return FALSE;

        if ($this->reset_password(
            $user_id,
            $this->do_hash($new_password),
            $new_pass_key,
            get_conf('forgot_password_expire')))
        {
            // success
            // Clear all user's autologins
            $this->clear_autologin($user->id);

            return array(
                'user_id'       => $user_id,
                'username'      => $user->username,
                'email'         => $user->email,
                'new_password'  => $new_password );
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Change user password (only when user is logged in)
     *
     * @deprecated
     * @param   string  $old_pass  Old Password
     * @param   string  $new_pass  New Password
     *
     * @return  bool
     */
    public function change_pass($old_pass, $new_pass)
    {
        $user_id = $this->get_user_id();

        if ( !($user = $this->get_user_by_id($user_id, TRUE)))
            return FALSE;

        // Check if old password incorrect
        if (!$this->validate($old_pass, $user->password))
        {
            $this->set_message( 'error', _x('auth_incorrect_password') );
            return FALSE;
        }

        // Replace old password with new one
        return $this->change_password($user_id, $this->do_hash($new_pass));
    }

    // -------------------------------------------------------------------------

    /**
     * Change user email (only when user is logged in) and return some data about user:
     * user_id, username, new_email, new_email_key.
     * The new email cannot be used for login or notification before it is activated.
     *
     * @param   string
     * @param   string
     * @return  array
     */
    public function set_new_email( $new_email, $password )
    {
        $user_id = $this->get_user_id();

        if (is_null($user = $this->get_user_by_id($user_id, TRUE)))
            return FALSE;

        // Check if password incorrect
        if (!$this->validate($password, $user->password))
        {
            $this->set_message( 'error', _x('auth_incorrect_password') );
            return FALSE;
        }

        // success
        $data = array(
            'user_id'   => $user_id,
            'username'  => $user->username,
            'new_email' => $new_email,
            );

        if ($user->email == $new_email)
        {
            $this->set_message( 'error', _x('auth_current_email') );
            return FALSE;
        }
        elseif ($user->new_email == $new_email)
        {
            // leave email key as is
            $data['new_email_key'] = $user->new_email_key;
            return $data;
        }
        elseif ($this->is_email_available($new_email))
        {
            $data['new_email_key'] = $this->generate_random_key();
            $this->set_new_email($user_id, $new_email, $data['new_email_key'], TRUE);
            return $data;
        }
        else
        {
            $this->set_message( 'error', _x('auth_email_in_use') );
            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Delete user from the site (only when user is logged in)
     *
     * @param   string
     * @return  bool
     */
    public function _delete_user( $password )
    {
        $user_id = $this->get_user_id();

        if ( is_null($user = $this->get_user_by_id($user_id, TRUE)) )
            return FALSE;
            
        if ( !$this->validate($password, $user->password) )
        {   
            $this->set_message( 'error', _x('auth_incorrect_password') );
            return FALSE;
        }

        // success
        $this->delete_user($user_id);
        $this->logout();
        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Login user automatically if he/she provides correct autologin verification
     *
     * @return  void
     */
    private function _autologin()
    {
        if ( self::is_logged_in() AND self::is_logged_in(FALSE) )
            return FALSE;

        $cookie_name = get_conf('autologin_cookie_name');

        // not logged in (as any user)
        if ( $cookie = get_cookie( $cookie_name, TRUE ) )
        {
            $data = unserialize( $cookie );

            if ( isset($data['key']) AND isset($data['user_id']) )
            {
                if ( $user = $this->get_autologin( $data['user_id'], md5($data['key']) ) )
                {
                    $activated = $user->activated;

                    // Login user
                    self::$_ci->session->set_userdata( array(
                        'user_id'   => $user->id,
                        'username'  => $user->username,
                        'status'    => (int) $activated,
                        ));

                    if ( $activated == 1 and ($user_perms = $this->get_user_perms( $user->id )) )
                    {
                        self::$_ci->session->set_userdata( 'user_perms', $user_perms );
                    }

                    // Renew users cookie to prevent it from expiring
                    $this->set_cookie( $cookie );

                    $this->update_login_info( $user->id );
                }
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
    public function create_autologin( $user_id )
    {
        $key = substr(md5(uniqid(mt_rand().get_cookie(config_item('sess_cookie_name')))), 0, 16);

        $this->purge_autologin( $user_id );

        if ( $this->set_autologin( $user_id, md5($key) ) )
        {
            $this->set_cookie( serialize(array('user_id' => $user_id, 'key' => $key)) );
            
            return TRUE;
        }
        
        return FALSE;
    }

    // -------------------------------------------------------------------------

    protected function set_cookie( $value )
    {
        set_cookie( array(
            'name'   => get_conf('autologin_cookie_name'),
            'value'  => $value,
            'expire' => get_conf('autologin_cookie_life')
            ));
    }

    // -------------------------------------------------------------------------

    public function update_role( $role_data, $role_id = NULL, $perms = array() )
    {
        if ( !( $return = $this->edit_role( $role_data, $role_id = NULL, $perms = array() ) ) )
        {
            $this->set_message('error', 'Something Wrong!');
        }

        return $return;
    }

    // -------------------------------------------------------------------------

    /**
     * Check if user has permission to do an action
     *
     * @param string $permission: The permission you want to check for from the `permissions.permission` table.
     * @return bool
     */
    public function permit( $permission )
    {
        // if ( !$this->perm_exists($permission) )
            // $this->new_permission($permission, '-');

        $allow  = FALSE;

        if ( $user_perms = self::$_ci->session->userdata('user_perms') )
        {
            // Check role permissions
            foreach( $user_perms as $p_key => $p_val )
            {
                if( $p_val == $permission )
                {
                    $allow = TRUE;
                    break;
                }
            }
        }

        // Check if there are overrides and overturn the result as needed
        // if( $overrides = $user->get_perm_overrides() )
        // {
        //     foreach( $overrides as $o_val )
        //     {
        //         if( $o_val['permission'] == $permission )
        //         {
        //             $allow = (bool)$o_val['allow'];
        //             break;
        //         }
        //     }
        // }
        
        return $allow;
    }

    // -------------------------------------------------------------------------

    /**
     * Generate a random string based on kernel's random number generator
     * 
     * @return string
     */
    public function generate_random_key()
    {
        if ( function_exists('openssl_random_pseudo_bytes') )
        {
            $key = openssl_random_pseudo_bytes(1024, $cstrong).microtime().mt_rand();
        }
        else
        {
            $randomizer = file_exists('/dev/urandom') ? '/dev/urandom' : '/dev/random';
            $key = file_get_contents($randomizer, NULL, NULL, 0, 1024).microtime().mt_rand();
        }

        return md5($key);
    }

    // -------------------------------------------------------------------------

    protected function set_message( $level, $msg_item )
    {
        $this->messages[$level][] = $msg_item;

        log_message( 'debug', '#Baka_pack: Authen `'.$level.'` > '.$msg_item.'.' );
    }

    // -------------------------------------------------------------------------

    public function messages( $level = '' )
    {
        if ( $level != '' )
            return $this->messages[$level];

        return $this->messages;
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
        return $this->get_attempts_num( $login ) >= Setting::get('auth_login_max_attempts');
    }
}

/* End of file Authen.php */
/* Location: ./application/libraries/baka_pack/Authen.php */