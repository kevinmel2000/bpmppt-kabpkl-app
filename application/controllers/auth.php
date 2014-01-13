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
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * Auth Class
 *
 * @subpackage  Controller
 */
class Auth extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('baka_pack/former');

        $this->themee->set_title('User Authentication');
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        $this->verify_status();

        $this->data['panel_title'] = $this->themee->set_title('Login Pengguna');

        if ( login_by() == 'login' )
            $label  = 'Email atau Username';
        else if ( login_by() == 'username' )
            $label  = 'Username';
        else 
            $label  = 'Email';

        $login = ( Setting::get('auth_login_count_attempts') AND ($login = $this->input->post('login-username'))) ?
                $this->security->xss_clean($login) : '';

        $fields[]   = array(
            'name'  => 'login-username',
            'type'  => 'text',
            'label' => $label,
            'validation'=> 'required' );

        $fields[]   = array(
            'name'  => 'login-password',
            'type'  => 'password',
            'label' => 'Password',
            'validation'=> 'required' );

        $fields[]   = array(
            'name'  => 'login-remember',
            'type'  => 'checkbox',
            'label' => '',
            'option'=> array( 1 => 'Ingat saya dikomputer ini.' ) );

        if ( $this->authen->is_max_attempts_exceeded( $login ) )
        {
            if ( (bool) Setting::get('auth_use_recaptcha') )
            {
                $fields[]   = array(
                    'name'  => 'login-recaptcha',
                    'type'  => 'recaptcha',
                    'label' => 'Validasi',
                    'validation'=> 'required|valid_recaptcha');
            }
            else
            {
                $fields[]   = array(
                    'name'  => 'login-captcha',
                    'type'  => 'captcha',
                    'label' => 'Validasi',
                    'validation'=> 'required|valid_captcha');
            }
        }

        $buttons[]  = array(
            'name'  => 'login',
            'type'  => 'submit',
            'label' => 'Login',
            'class' => 'btn-primary pull-left' );

        $buttons[]  = array(
            'name'  => 'forgot',
            'type'  => 'anchor',
            'label' => 'Lupa Login',
            'url'   => 'forgot',
            'class' => 'btn-default pull-right' );

        if ( (bool) Setting::get('auth_allow_registration') )
        {
            $buttons[]  = array(
                'name'  => 'register',
                'type'  => 'anchor',
                'label' => 'Register',
                'url'   => 'register',
                'class' => 'btn-default pull-right' );
        }

        $form = $this->former->init( array(
            'name'      => 'login',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            'is_hform'  => FALSE ));

        // var_dump( $_SESSION );

        if ( $form->validate_submition() )
        {
            $user_data = $form->submited_data();

            if ( $this->authen->login( $user_data['login-username'], $user_data['login-password'], $user_data['login-remember'] ) )
            {
                redirect('dashboard');
            }
            else
            {
                redirect( current_url() );
            }

            foreach ( $this->authen->messages() as $level => $item )
            {
                $this->session->set_flashdata( $level, $item );
            }
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/auth', $this->data);
    }

    public function register()
    {
        $this->verify_status();

        $this->data['panel_title'] = $this->themee->set_title('Register Pengguna');

        if ( !Setting::get('auth_allow_registration') )
            $this->_notice('registration-disabled');

        $use_username = (bool) Setting::get('auth_use_username');

        if ( (bool) Setting::get('auth_use_username') )
        {
            $fields[]   = array(
                'name'  => 'register-username',
                'type'  => 'text',
                'label' => 'Username',
                'validation'=> 'required|valid_username_length|is_username_blacklist|is_username_available' );
        }

        $fields[]   = array(
            'name'  => 'register-email',
            'type'  => 'text',
            'label' => 'Email',
            'validation'=> 'required|valid_email' );

        $fields[]   = array(
            'name'  => 'register-password',
            'type'  => 'password',
            'label' => 'Password',
            'validation'=> 'required|valid_password_length' );

        $fields[]   = array(
            'name'  => 'register-confirm-password',
            'type'  => 'password',
            'label' => 'Ulangi Password',
            'validation'=> 'required|matches[register-password]' );

        if ( (bool) Setting::get('auth_captcha_registration') )
        {
            if ( (bool) Setting::get('auth_use_recaptcha') )
            {
                $fields[]   = array(
                    'name'  => 'register-recaptcha',
                    'type'  => 'recaptcha',
                    'label' => 'Confirmation Code',
                    'validation'=> 'required|valid_recaptcha' );
            }
            else
            {
                $fields[]   = array(
                    'name'  => 'register-captcha',
                    'type'  => 'captcha',
                    'label' => 'Confirmation Code',
                    'validation'=> 'required|valid_captcha' );
            }
        }

        $buttons[]  = array(
            'name'  => 'register',
            'type'  => 'submit',
            'label' => 'Register',
            'class' => 'btn-primary pull-left' );

        $buttons[]  = array(
            'name'  => 'forgot',
            'type'  => 'anchor',
            'label' => 'Lupa Login',
            'url'   => 'forgot',
            'class' => 'btn-default pull-right' );

        $form = $this->former->init( array(
            'name'      => 'register',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            'is_hform'  => FALSE,
            ));

        if ( $form->validate_submition() )
        {
            $form_data  =  $form->submited_data();

            $username  = $form_data['register-username'];
            $email     = $form_data['register-email'];
            $password  = $form_data['register-password'];

            if ( $this->authen->create_user( $username, $email, $password ) )
            {
                $this->_notice('registration-success');
            }
            else
            {
                $this->session->set_flashdata('error', $this->authen->errors());

                redirect( current_url() );
            }
        }
        
        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/auth', $this->data);
    }

    public function resend()
    {
        if ( Authen::is_logged_in() )
            redirect( 'dashboard' );

        $this->data['panel_title'] = $this->themee->set_title('Kirim ulang aktivasi');

        // not logged in or activated
        if ( !Authen::is_logged_in(FALSE) )
            redirect('login');

        $fields[]   = array(
            'name'  => 'resend',
            'type'  => 'email',
            'label' => 'Email',
            'validation'=> 'required|valid_email',
            'desc'  => 'Masukan alamat email yang anda gunakan untuk aplikasi ini.' );

        $buttons[]  = array(
            'name'  => 'submit',
            'type'  => 'submit',
            'label' => 'resend',
            'class' => 'btn-primary pull-left' );

        $buttons[]  = array(
            'name'  => 'forgot',
            'type'  => 'anchor',
            'label' => 'Lupa Login',
            'url'   => 'auth/forgot',
            'class' => 'btn-default pull-right' );

        $form = $this->former->init( array(
            'name'      => 'resend',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            'is_hform'  => FALSE
            ));

        if ( $form->validate_submition() )
        {
            $user_data = $form->submited_data();

            if ( $data = $this->authen->change_email( $user_data['email'] ) )
            {
                // success
                $data['activation_period'] = Setting::get('auth_email_activation_expire') / 3600;

                $this->send_email( $user_data['email'], 'activate', $data );
                $this->_notice('activation-sent');
            }
            else
            {
                $this->session->set_flashdata( 'error', $this->authen->errors() );

                redirect( current_url() );
            }
        }
        
        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/auth', $this->data);
    }

    public function forgot()
    {
        if ( Authen::is_logged_in() )
            redirect( 'dashboard' );

        $this->data['panel_title'] = $this->themee->set_title('Lupa login');

        $fields[]   = array(
            'name'  => 'forgot_login',
            'type'  => 'text',
            'label' => 'Email atau Username',
            'validation'=> 'required',
            'desc'  => 'Masukan alamat email atau username yang anda gunakan untuk aplikasi ini.' );

        $buttons[]  = array(
            'name'  => 'submit',
            'type'  => 'submit',
            'label' => 'Kirim',
            'class' => 'btn-primary pull-left' );

        $buttons[]  = array(
            'name'  => 'login',
            'type'  => 'anchor',
            'label' => 'Login',
            'url'   => 'login',
            'class' => 'btn-default pull-right' );

        $form = $this->former->init( array(
            'name'      => 'forgot',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            'is_hform'  => FALSE,
            ));

        if ( $form->validate_submition() )
        {
            $user_data = $form->submited_data();


            if ( $data = $this->authen->forgot_password( $user_data['forgot_login']) )
            {
                // Send email with password activation link
                $this->send_email( $data['email'], 'forgot_password', $data );
                    
                $this->_notice('password-sent');
            }
            else
            {
                $this->session->set_flashdata('error', $this->authen->errors());

                redirect( current_url() );
            }
        }
        
        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/auth', $this->data);
    }

    public function activate( $user_id = NULL, $email_key = NULL )
    {
        if ( is_null($user_id) AND is_null($email_key) )
            redirect('login');

        // Activate user
        if ( $this->authen->activate( $user_id, $email_key ) )
        {
            // success
            $this->authen->logout();
            $this->_notice('activation-complete');
        }
        else
        {
            // fail
            $this->_notice('activation-failed');
        }
    }

    public function reset_password( $user_id = NULL, $email_key = NULL )
    {
        $this->data['panel_title'] = $this->themee->set_title('Kirim ulang aktivasi');

        // not logged in or activated
        if ( is_null($user_id) AND is_null($email_key) )
            redirect('login');

        $fields[]   = array(
            'name'  => 'reset_password',
            'type'  => 'password',
            'label' => 'Password baru',
            'validation'=> 'required|valid_password_length' );

        $fields[]   = array(
            'name'  => 'confirm_reset_password',
            'type'  => 'password',
            'label' => 'Password Konfirmasi',
            'validation'=> 'required|matches[reset_password]' );

        $buttons[]  = array(
            'name'  => 'submit',
            'type'  => 'submit',
            'label' => 'Atur ulang',
            'class' => 'btn-primary pull-left' );

        $buttons[]  = array(
            'name'  => 'login',
            'type'  => 'anchor',
            'label' => 'Login',
            'url'   => 'login',
            'class' => 'btn-default pull-right' );

        $form = $this->former->init( array(
            'name'      => 'reset',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            'is_hform'  => FALSE,
            ));

        if ( $form->validate_submition() )
        {
            $user_data = $form->submited_data();

            if ( $data = $this->authen->reset_password( $user_id, $email_key, $user_data['reset_password'] ) )
            {
                // success
                $this->send_email( $data['email'], 'activate', $data );
                $this->_notice('password-reset');
            }
            else
            {
                $this->session->set_flashdata('error', $this->authen->errors());
                redirect( current_url() );
            }
        }
        
        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/auth', $this->data);
    }

    public function logout()
    {
        $this->authen->logout();
        
        redirect('login');
    }
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */