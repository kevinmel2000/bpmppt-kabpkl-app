<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Biauth
 * @category    Controller
 */

// -----------------------------------------------------------------------------

class Auth extends BI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['desc_title'] = $this->bi_setting('welcome_title');

        $this->load->library('biform');
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

        $attempts = ( $this->bi_setting('auth_login_count_attempts') AND ($attempts = $this->input->post('username'))) ? $this->security->xss_clean($attempts) : '';
        $fields['username'] = array(
            'type'  => 'text',
            'label' => _x('biauth_login_by_'.$this->bi_setting('auth_login_by')),
            'validation'=> 'required'
            );

        $fields['password'] = array(
            'type'  => 'password',
            'label' => 'Password',
            'validation'=> 'required'
            );

        $fields['remember'] = array(
            'type'  => 'checkbox',
            'label' => '',
            'option'=> array( 1 => 'Ingat saya dikomputer ini.' )
            );

        if ( $this->biauth->login_attempt->is_max_exceeded( $attempts ) )
        {
            $captcha = (bool) $this->bi_setting('auth_use_recaptcha') ? 'recaptcha' : 'captcha';
            $fields[$captcha] = array(
                'type'  => $captcha,
                'label' => 'Validasi',
                'validation'=> 'required|valid_'.$captcha
                );
        }

        $buttons['login'] = array(
            'type'  => 'submit',
            'label' => 'Login',
            'class' => 'btn-primary pull-left'
            );

        $buttons['forgot'] = array(
            'type'  => 'anchor',
            'label' => 'Lupa Login',
            'url'   => 'forgot',
            'class' => 'btn-default pull-right'
            );

        if ( (bool) $this->bi_setting('auth_allow_registration') )
        {
            $buttons['register'] = array(
                'type'  => 'anchor',
                'label' => 'Register',
                'url'   => 'register',
                'class' => 'btn-default pull-right'
                );
        }

        $form = $this->biform->initialize( array(
            'name'     => 'login',
            'action'   => current_url(),
            'fields'   => $fields,
            'extras'   => array( 'autocomplete' => 'off' ),
            'buttons'  => $buttons,
            'is_hform' => FALSE,
            'hiddens'  => array(
                'goto' => $this->input->get('from'),
                )
            ));

        if ( $input = $form->validate_submition() )
        {
            $goto = $this->biauth->login( $input['username'], $input['password'], $input['remember'] ) ? $input['goto'] : current_url();
            foreach ( get_message() as $level => $item )
            {
                $this->session->set_flashdata( $level, $item );
            }

            if (strlen($goto) == 0)
            {
                $goto = $this->_defCon;
            }

            redirect( $goto );
        }

        $this->set_panel_body($form->generate());

        $this->data['desc_body'] = $this->bi_setting('welcome_login');

        $this->load->theme('auth', $this->data, 'auth');
    }

    public function register()
    {
        $this->verify_status();
        $this->set_panel_title('Register Pengguna');
        if ( !$this->bi_setting('auth_allow_registration') )
        {
            $this->_notice('registration-disabled');
        }

        $login_by = $this->bi_setting('auth_login_by');
        if ( in_array($login_by, array('login', 'username')) )
        {
            $fields['username'] = array(
                'type'  => 'text',
                'label' => 'Username',
                'validation'=> 'required|valid_username_length|is_username_blacklist|is_username_available'
                );
        }

        $fields['email'] = array(
            'type'  => 'text',
            'label' => 'Email',
            'validation'=> 'required|valid_email'
            );

        $fields['password'] = array(
            'type'  => 'password',
            'label' => 'Password',
            'validation'=> 'required|valid_password_length'
            );

        $fields['confirm-password'] = array(
            'type'  => 'password',
            'label' => 'Ulangi Password',
            'validation'=> 'required|matches[password]'
            );

        if ( (bool) $this->bi_setting('auth_captcha_registration') )
        {
            $captcha = (bool) $this->bi_setting('auth_use_recaptcha') ? 'recaptcha' : 'captcha';
            $fields[$captcha] = array(
                'type'  => 'captcha',
                'label' => 'Validasi',
                'mode'  => $captcha,
                'validation'=> 'required|valid_'.$captcha
                );
        }

        $buttons['register'] = array(
            'type'  => 'submit',
            'label' => 'Register',
            'class' => 'btn-primary pull-left'
            );

        $buttons['login'] = array(
            'type'  => 'anchor',
            'label' => 'Login',
            'url'   => 'login',
            'class' => 'btn-default pull-right'
            );

        $buttons['forgot'] = array(
            'type'  => 'anchor',
            'label' => 'Lupa Login',
            'url'   => 'forgot',
            'class' => 'btn-default pull-right'
            );

        $form = $this->biform->initialize( array(
            'name'      => 'register',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            'is_hform'  => FALSE,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $user_data = array(
                'username' => $form_data['username'],
                'email'    => $form_data['email'],
                'password' => $form_data['password'],
                );

            $goto = $this->biauth->create_user($user_data) ? 'notice/registration-success' : current_url();

            foreach ( get_message() as $level => $item )
            {
                $this->session->set_flashdata( $level, $item );
            }

            redirect( $goto );
        }

        $this->data['desc_body'] = $this->bi_setting('welcome_register');

        $this->set_panel_body($form->generate());

        $this->load->theme('auth', $this->data, 'auth');
    }

    public function resend()
    {
        if ( $this->biauth->is_logged_in() )
        {
            redirect($this->_defCon);
        }

        // not logged in or activated
        if ( !$this->biauth->is_logged_in(FALSE) )
        {
            redirect('login');
        }

        $this->set_panel_title('Kirim ulang aktivasi');

        $fields['resend'] = array(
            'type'  => 'email',
            'label' => 'Email',
            'validation'=> 'required|valid_email|is_email_exists',
            'desc'  => 'Masukan alamat email yang anda gunakan untuk aplikasi ini.'
            );

        $buttons['submit'] = array(
            'type'  => 'submit',
            'label' => 'resend',
            'class' => 'btn-primary pull-left'
            );

        $buttons['forgot'] = array(
            'type'  => 'anchor',
            'label' => 'Lupa Login',
            'url'   => 'auth/forgot',
            'class' => 'btn-default pull-right'
            );

        $form = $this->biform->initialize( array(
            'name'      => 'resend',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            'is_hform'  => FALSE
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $data = $this->biauth->resend($form_data['email']) )
            {
                $this->_notice('activation-sent');
            }
            else
            {
                $this->session->set_flashdata( 'error', get_message('error') );
                redirect(current_url());
            }
        }

        $this->data['desc_body'] = $this->bi_setting('welcome_resend');

        $this->set_panel_body($form->generate());

        $this->load->theme('auth', $this->data, 'auth');
    }

    public function forgot()
    {
        if ( $this->biauth->is_logged_in() )
        {
            redirect($this->_defCon);
        }

        $this->set_panel_title('Lupa login');

        $fields['forgot_login'] = array(
            'type'  => 'text',
            'label' => 'Email atau Username',
            'validation'=> 'required',
            'desc'  => 'Masukan alamat email atau username yang anda gunakan untuk aplikasi ini.'
            );

        $buttons['submit'] = array(
            'type'  => 'submit',
            'label' => 'Kirim',
            'class' => 'btn-primary pull-left'
            );

        $buttons['login'] = array(
            'type'  => 'anchor',
            'label' => 'Login',
            'url'   => 'login',
            'class' => 'btn-default pull-right'
            );

        $form = $this->biform->initialize( array(
            'name'      => 'forgot',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            'is_hform'  => FALSE,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $data = $this->biauth->forgot_password( $form_data['forgot_login']) )
            {
                // Send email with password activation link
                $this->bootigniter->send_email( $data['email'], 'lang:forgot_password', $data );

                $this->_notice('password-sent');
            }
            else
            {
                $this->session->set_flashdata('error', get_message('error'));

                redirect( current_url() );
            }
        }

        $this->data['desc_body'] = $this->bi_setting('welcome_forgot');

        $this->set_panel_body($form->generate());

        $this->load->theme('auth', $this->data, 'auth');
    }

    public function activate( $user_id = NULL, $email_key = NULL )
    {
        if ( is_null($user_id) AND is_null($email_key) )
        {
            redirect('login');
        }

        // Activate user
        if ( $this->biauth->activate( $user_id, $email_key ) )
        {
            // success
            $this->biauth->logout();
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

        $fields['reset_password'] = array(
            'type'  => 'password',
            'label' => 'Password baru',
            'validation'=> 'required|valid_password_length'
            );

        $fields['confirm_reset_password'] = array(
            'type'  => 'password',
            'label' => 'Password Konfirmasi',
            'validation'=> 'required|matches[reset_password]'
            );

        $buttons['submit'] = array(
            'type'  => 'submit',
            'label' => 'Atur ulang',
            'class' => 'btn-primary pull-left'
            );

        $buttons['login'] = array(
            'type'  => 'anchor',
            'label' => 'Login',
            'url'   => 'login',
            'class' => 'btn-default pull-right'
            );

        $form = $this->biform->initialize( array(
            'name'      => 'reset',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            'is_hform'  => FALSE,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $data = $this->biauth->reset_password( $user_id, $email_key, $form_data['reset_password'] ) )
            {
                // success
                if ( $this->bootigniter->send_email( $data['email'], 'lang:activate', $data ) )
                {
                    $this->_notice('password-reset');
                }
            }
            else
            {
                $this->session->set_flashdata('error', get_message('error'));
                redirect( current_url() );
            }
        }

        $this->data['desc_body'] = '';

        $this->set_panel_body($form->generate());

        $this->load->theme('auth', $this->data, 'auth');
    }

    public function logout()
    {
        $this->biauth->logout();

        redirect('login');
    }
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
