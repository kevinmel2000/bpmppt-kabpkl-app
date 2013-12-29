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
     * @param   string  $pass  Password to be hashed
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
     * @param   string  $old_pass  Old Password
     * @param   string  $new_pass  New Password
     *
     * @return  bool
     */
    protected function validate( $old_pass, $new_pass )
    {
        return $this->do_hash()->CheckPassword( $old_pass, $new_pass );
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
        $user = $this->user( login_by(), $login );

        // fail - wrong login
        if ( !( $user_data = $user->get_data() ) )
        {
            $this->increase_login_attempt( $login );
            $this->set_message( 'error', _x('auth_incorrect_login') );
            return FALSE;
        }

        // fail - wrong password
        if ( !$this->validate( $password, $user_data->password ) )
        {
            $this->increase_login_attempt( $login );
            $this->set_message( 'error', _x('auth_incorrect_password') );
            return FALSE;
        }

        // fail - banned
        if ( $user_data->banned == 1 )
        {
            $this->set_message( 'error', _x('auth_banned_account', $user_data->ban_reason) );
            return FALSE;
        }

        // Save to session
        self::$_ci->session->set_userdata( array(
            'user_id'   => $user_data->id,
            'username'  => $user_data->username,
            'status'    => $user_data->activated,
            // 'roles'     => $user->get_roles()
            ));
        
        // fail - not activated
        if ( $user_data->activated == 0 )
        {
            $this->set_message( 'error', _x('auth_inactivated_account') );
            return FALSE;
        }

        // success
        // $user_profile = '';
        // $this->get_user_profile($user->id);
        // self::$_ci->session->set_userdata('user_profile', $user_profile);
        
        if ( (bool) $remember )
            $this->create_autologin( $user_data->id );

        $this->clear_login_attempts( $user_data->username );

        $this->update_login_info( $user_data->id );

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
        self::$_ci->session->set_userdata(array('user_id' => '', 'username' => '', 'status' => ''));
        self::$_ci->session->sess_destroy();
    }

    // -------------------------------------------------------------------------

    /**
     * Check if user logged in. Also test if user is activated and approved.
     * User can log in only if acct has been approved.
     *
     * @param   bool
     * 
     * @return  bool
     */
    public static function is_logged_in( $activated = TRUE )
    {
        return (int) self::$_ci->session->userdata('status') === bool_to_int( $activated );
    }

    // -------------------------------------------------------------------------
    
    /**
     * Get user_id
     *
     * @return  string
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
     * Create new user on the site and return some data about it:
     * user_id, username, password, email, new_email_key (if any).
     *
     * @param   string
     * @param   string
     * @param   string
     * @param   bool
     * @return  array
     */
    public function create_user( $username, $email, $password, $email_activation )
    {
        if ( ! $this->is_username_available( $username ) )
        {
            $this->set_error('auth_username_in_use');
            return FALSE;
        }
        
        if ( ! $this->is_email_available( $email ) )
        {
            $this->set_error('auth_email_in_use');
            return FALSE;
        }
        
        $data = array(
            'username'  => $username,
            'password'  => $this->do_hash($password),
            'email'     => $email,
            'last_ip'   => $this->input->ip_address(),
            'approved'  => (int) get_conf('acct_approval') );
        
        if ($email_activation)
            $data['new_email_key'] = $this->generate_random_key();

        if (!is_null($res = $this->create_user($data, !$email_activation)))
        {
            $data['user_id']    = $res['user_id'];
            $data['password']   = $password;
            unset($data['last_ip']);

            return $data;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Change email for activation and return some data about user:
     * user_id, username, email, new_email_key.
     * Can be called for not activated users only.
     *
     * @param   string
     * @return  array
     */
    public function change_email( $email )
    {
        $user_id = $this->get_user_id();

        if ( is_null($user = $this->get_user_by_id($user_id, FALSE)) )
            return FALSE;
        
        $data = array(
            'user_id'   => $user_id,
            'username'  => $user->username,
            'email'     => $email );

        // leave activation key as is
        if (strtolower($user->email) == strtolower($email))
        {
            $data['new_email_key'] = $user->new_email_key;
            
            return $data;
        }
        elseif ($this->is_email_available($email))
        {
            $data['new_email_key'] = $this->generate_random_key();
            $this->set_new_email($user_id, $email, $data['new_email_key'], FALSE);
            
            return $data;
        }
        else
        {
            $this->set_error('auth_email_in_use');

            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Activate user using given key
     *
     * @param   string
     * @param   string
     * @param   bool
     * @return  bool
     */
    public function activate_user($user_id, $activation_key, $activate_by_email = TRUE)
    {
        $this->purge_na( get_conf('email_activation_expire') );

        return $this->activate_user($user_id, $activation_key, $activate_by_email);
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
    public function forgot_password($login)
    {
        if ( ! ($user = $this->get_user_by_login($login)) )
        {
            $this->set_error('auth_incorrect_login');
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
     * Check if given password key is valid and user is authenticated.
     *
     * @param   string
     * @param   string
     * @return  bool
     */
    public function can_reset_password($user_id, $new_pass_key)
    {
        return $this->can_reset_password(
            $user_id,
            $new_pass_key,
            get_conf('forgot_password_expire'));
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
    public function reset_password($user_id, $new_pass_key, $new_password)
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
     * @param   string
     * @param   string
     * @return  bool
     */
    public function change_password($old_pass, $new_pass)
    {
        $user_id = $this->get_user_id();

        if (is_null($user = $this->get_user_by_id($user_id, TRUE)))
            return FALSE;

        // Check if old password incorrect
        if (!$this->validate($old_pass, $user->password))
        {
            $this->set_error('auth_incorrect_password');
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
    public function set_new_email($new_email, $password)
    {
        $user_id = $this->get_user_id();

        if (is_null($user = $this->get_user_by_id($user_id, TRUE)))
            return FALSE;

        // Check if password incorrect
        if (!$this->validate($password, $user->password))
        {
            $this->set_error('auth_incorrect_password');
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
            $this->set_error('auth_current_email');
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
            $this->set_error('auth_email_in_use');
            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Activate new email, if email activation key is valid.
     *
     * @param   string
     * @param   string
     * @return  bool
     */
    public function activate_new_email($user_id, $new_email_key)
    {
        return $this->activate_new_email($user_id, $new_email_key);
    }

    // -------------------------------------------------------------------------

    /**
     * Delete user from the site (only when user is logged in)
     *
     * @param   string
     * @return  bool
     */
    public function delete_user( $password )
    {
        $user_id = $this->get_user_id();

        if ( is_null($user = $this->get_user_by_id($user_id, TRUE)) )
            return FALSE;
            
        if ( !$this->validate($password, $user->password) )
        {   
            $this->set_error('auth_incorrect_password');
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
        if ( $this->is_logged_in() AND $this->is_logged_in(FALSE) )
            return FALSE;

        $cookie_name = get_conf('autologin_cookie_name');

        // not logged in (as any user)
        if ( $cookie = get_cookie( $cookie_name, TRUE ) )
        {
            $data = unserialize( $cookie );

            if ( isset($data['key']) AND isset($data['user_id']) )
            {
                if ( $user = $this->user( 'id', $data['user_id'] )->get_autologin( md5($data['key']) ) )
                {
                    // Login user
                    self::$_ci->session->set_userdata( array(
                        'user_id'   => $user->id,
                        'username'  => $user->username,
                        'status'    => 1 ));

                    // Renew users cookie to prevent it from expiring
                    $this->set_cookie( $cookie );

                    $this->update_login_info( $user->id );

                    return TRUE;
                }
            }
        }
    }

    // -------------------------------------------------------------------------

    protected function set_cookie( $value )
    {
        set_cookie( array(
            'name' => get_conf('autologin_cookie_name'),
            'value' => $value,
            'expire' => get_conf('autologin_cookie_life')
            ));
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

    /**
     * Check if user has permission to do an action
     *
     * @param string $permission: The permission you want to check for from the `permissions.permission` table.
     * @return bool
     */
    public function permit( $permission )
    {
        if ( !$this->perm_exists($permission) )
            $this->new_permission($permission, '-');

        $user   = $this->user( 'id', $this->get_user_id() );
        $allow  = FALSE;

        // Check role permissions
        foreach( $user->get_perms() as $p_val )
        {
            if( $p_val == $permission )
            {
                $allow = TRUE;
                break;
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
}

/* End of file Authen.php */
/* Location: ./application/libraries/baka_pack/Authen.php */