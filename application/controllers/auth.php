<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     CodeIgniter Baka Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
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

        $this->data['desc_title'] = 'Selamat Datang di '.$this->data['footer_right'];
        $this->data['desc_body']  = array(
            'Aplikasi ini sepenuhnya adalah milik dari '.$this->data['footer_left'].' dan url ini sepenuhnya hanya untuk tujuan Demo dan Testing semata.',
            );

        $this->load->library('baka_pack/former');
        $this->set_panel_title('User Authentication');
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        $this->verify_status();
        $this->set_panel_title('Login Pengguna');

        $attempts = ( Setting::get('auth_login_count_attempts') AND ($attempts = $this->input->post('username'))) ? $this->security->xss_clean($attempts) : '';

        $fields[]   = array(
            'name'  => 'username',
            'type'  => 'text',
            'label' => _x('auth_login_by_'.login_by()),
            'validation'=> 'required' );

        $fields[]   = array(
            'name'  => 'password',
            'type'  => 'password',
            'label' => 'Password',
            'validation'=> 'required' );

        $fields[]   = array(
            'name'  => 'remember',
            'type'  => 'checkbox',
            'label' => '',
            'option'=> array( 1 => 'Ingat saya dikomputer ini.' ) );

        if ( $this->authr->is_max_attempts_exceeded( $attempts ) )
        {
            if ( (bool) Setting::get('auth_use_recaptcha') )
            {
                $fields[]   = array(
                    'name'  => 'recaptcha',
                    'type'  => 'recaptcha',
                    'label' => 'Validasi',
                    'validation'=> 'required|valid_recaptcha');
            }
            else
            {
                $fields[]   = array(
                    'name'  => 'captcha',
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
            'hiddens'   => array(
                'goto' => $this->input->get('from'),
                ),
            'buttons'   => $buttons,
            'is_hform'  => FALSE ));

        if ( $input = $form->validate_submition() )
        {
            $goto = $this->authr->login( $input['username'], $input['password'], $input['remember'] ) ? $input['goto'] : '';

            foreach ( Messg::get() as $level => $item )
            {
                $this->session->set_flashdata( $level, $item );
            }

            redirect( $goto );  
        }

        $this->set_panel_body($form->generate());

        $this->data['desc_body'] = array_merge($this->data['desc_body'], array(
            'Untul login sebagai Administrator silahkan gunakan',
            array(
                'Username: <b>admin</b>',
                'password: <b>password</b>',
                ),
            'Untul login sebagai Pengguna silahkan gunakan',
            array(
                'Username: <b>pengguna1</b>',
                'password: <b>1234</b>',
                ),
            ));

        $this->load->theme('pages/auth', $this->data, 'auth');
    }

    public function register()
    {
        $this->verify_status();

        $this->set_panel_title('Register Pengguna');

        if ( !Setting::get('auth_allow_registration') )
        {
            $this->_notice('registration-disabled');
        }

        if ( (bool) Setting::get('auth_use_username') )
        {
            $fields[]   = array(
                'name'  => 'username',
                'type'  => 'text',
                'label' => 'Username',
                'validation'=> 'required|valid_username_length|is_username_blacklist|is_username_available' );
        }

        $fields[]   = array(
            'name'  => 'email',
            'type'  => 'text',
            'label' => 'Email',
            'validation'=> 'required|valid_email' );

        $fields[]   = array(
            'name'  => 'password',
            'type'  => 'password',
            'label' => 'Password',
            'validation'=> 'required|valid_password_length' );

        $fields[]   = array(
            'name'  => 'confirm-password',
            'type'  => 'password',
            'label' => 'Ulangi Password',
            'validation'=> 'required|matches[password]' );

        if ( (bool) Setting::get('auth_captcha_registration') )
        {
            if ( (bool) Setting::get('auth_use_recaptcha') )
            {
                $fields[]   = array(
                    'name'  => 'recaptcha',
                    'type'  => 'recaptcha',
                    'label' => 'Confirmation Code',
                    'validation'=> 'required|valid_recaptcha' );
            }
            else
            {
                $fields[]   = array(
                    'name'  => 'captcha',
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
            'name'  => 'login',
            'type'  => 'anchor',
            'label' => 'Login',
            'url'   => 'login',
            'class' => 'btn-default pull-right' );

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

        if ( $form_data = $form->validate_submition() )
        {
            $goto = $this->authr->create_user( $form_data['username'], $form_data['email'], $form_data['password'] ) ? 'notice/registration-success' : current_url();

            foreach ( Messg::get() as $level => $item )
            {
                $this->session->set_flashdata( $level, $item );
            }

            redirect( $goto );
        }

        $this->data['desc_body'] = array_merge($this->data['desc_body'], array(
            'Silahkan daftarkan diri anda dengan mengisi formulir disamping.',
            ));
        
        $this->set_panel_body($form->generate());

        $this->load->theme('pages/auth', $this->data, 'auth');
    }

    public function resend()
    {
        if ( $this->authr->is_logged_in() )
        {
            redirect('data/utama');
        }

        $this->set_panel_title('Kirim ulang aktivasi');

        // not logged in or activated
        if ( !$this->authr->is_logged_in(FALSE) )
        {
            redirect('login');
        }

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

        if ( $form_data = $form->validate_submition() )
        {
            if ( $data = $this->authr->change_email( $user_data['email'] ) )
            {
                // success
                $data['activation_period'] = Setting::get('auth_email_activation_expire') / 3600;

                $this->send_email( $user_data['email'], 'activate', $data );
                $this->_notice('activation-sent');
            }
            else
            {
                $this->session->set_flashdata( 'error', $this->authr->errors() );

                redirect( current_url() );
            }
        }

        $this->data['desc_body'] = array_merge($this->data['desc_body'], array(
            'Nampaknya akun anda belum diaktifkan, mungkin karena anda belum mengkonfirmasi email aktifasi yang kami kirimkan?. Silahkan coba kirim ulang aktifasi agar anda dapat segera menggunakan aplikasi ini.',
            'Dengan cara isikan alamat email (aktif) anda ke formulir disamping lalu tekan "Kirim". Maka kami akan mengirimkan aktifasi yang baru.',
            ));
        
        $this->set_panel_body($form->generate());

        $this->load->theme('pages/auth', $this->data, 'auth');
    }

    public function forgot()
    {
        if ( $this->authr->is_logged_in() )
        {
            redirect('data/utama');
        }

        $this->set_panel_title('Lupa login');

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

        if ( $form_data = $form->validate_submition() )
        {

            if ( $data = $this->authr->forgot_password( $user_data['forgot_login']) )
            {
                // Send email with password activation link
                $this->send_email( $data['email'], 'forgot_password', $data );
                    
                $this->_notice('password-sent');
            }
            else
            {
                $this->session->set_flashdata('error', $this->authr->errors());

                redirect( current_url() );
            }
        }

        $this->data['desc_body'] = array_merge($this->data['desc_body'], array(
            'Jika anda lupa Username atau Password login, silahkan isi form disamping dengan email anda. Maka kami akan segera mengirim sebuah url untuk mengatur ulang password dan username anda.',
            ));
        
        $this->set_panel_body($form->generate());

        $this->load->theme('pages/auth', $this->data, 'auth');
    }

    public function activate( $user_id = NULL, $email_key = NULL )
    {
        if ( is_null($user_id) AND is_null($email_key) )
        {
            redirect('login');
        }

        // Activate user
        if ( $this->authr->activate( $user_id, $email_key ) )
        {
            // success
            $this->authr->logout();
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
        $this->set_panel_title('Kirim ulang aktivasi');

        // not logged in or activated
        if ( is_null($user_id) AND is_null($email_key) )
        {
            redirect('login');
        }

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

        if ( $form_data = $form->validate_submition() )
        {
            if ( $data = $this->authr->reset_password( $user_id, $email_key, $user_data['reset_password'] ) )
            {
                // success
                $this->send_email( $data['email'], 'activate', $data );
                $this->_notice('password-reset');
            }
            else
            {
                $this->session->set_flashdata('error', $this->authr->errors());
                redirect( current_url() );
            }
        }

        $this->data['desc_body'] = array_merge($this->data['desc_body'], array(
            'Untul login sebagai Administrator silahkan gunakan',
            'Username: admin',
            'password: password',
            ));
        
        $this->set_panel_body($form->generate());

        $this->load->theme('pages/auth', $this->data, 'auth');
    }

    public function logout()
    {
        $this->authr->logout();
        
        redirect('login');
    }
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */