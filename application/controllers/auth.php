<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

        $this->data['desc_title'] = $this->bakaigniter->get_setting('welcome_title');

        $this->load->library('former');
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

        $attempts = ( $this->bakaigniter->get_setting('auth_login_count_attempts') AND ($attempts = $this->input->post('username'))) ? $this->security->xss_clean($attempts) : '';

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

        if ( $this->authr->login_attempt->is_max_exceeded( $attempts ) )
        {
            $captcha = (bool) $this->bakaigniter->get_setting('auth_use_recaptcha') ? 'recaptcha' : 'captcha';

            $fields[]   = array(
                'name'  => $captcha,
                'type'  => $captcha,
                'label' => 'Validasi',
                'validation'=> 'required|valid_'.$captcha);
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

        if ( (bool) $this->bakaigniter->get_setting('auth_allow_registration') )
        {
            $buttons[]  = array(
                'name'  => 'register',
                'type'  => 'anchor',
                'label' => 'Register',
                'url'   => 'register',
                'class' => 'btn-default pull-right' );
        }

        $form = $this->former->init( array(
            'name'     => 'login',
            'action'   => current_url(),
            'fields'   => $fields,
            'hiddens'  => array(
                'goto' => $this->input->get('from'),
                ),
            'extras'   => array(
                'autocomplete' => 'off',
                ),
            'buttons'  => $buttons,
            'is_hform' => FALSE ));

        if ( $input = $form->validate_submition() )
        {
            $goto = $this->authr->login( $input['username'], $input['password'], $input['remember'] ) ? $input['goto'] : current_url();

            foreach ( get_message() as $level => $item )
            {
                $this->session->set_flashdata( $level, $item );
            }

            if (strlen($goto) == 0)
            {
                $goto = 'data/utama/';
            }

            redirect( $goto );
        }

        $this->set_panel_body($form->generate());

        $this->data['desc_body'] = $this->bakaigniter->get_setting('welcome_login');

        $this->load->theme('pages/auth', $this->data, 'auth');
    }

    public function register()
    {
        $this->verify_status();

        $this->set_panel_title('Register Pengguna');

        if ( !$this->bakaigniter->get_setting('auth_allow_registration') )
        {
            $this->_notice('registration-disabled');
        }

        if ( (bool) $this->bakaigniter->get_setting('auth_use_username') )
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

        if ( (bool) $this->bakaigniter->get_setting('auth_captcha_registration') )
        {
            $captcha = (bool) $this->bakaigniter->get_setting('auth_use_recaptcha') ? 'recaptcha' : 'captcha';

            $fields[]   = array(
                'name'  => $captcha,
                'type'  => $captcha,
                'label' => 'Validasi',
                'validation'=> 'required|valid_'.$captcha);
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

            foreach ( get_message() as $level => $item )
            {
                $this->session->set_flashdata( $level, $item );
            }

            redirect( $goto );
        }

        $this->data['desc_body'] = $this->bakaigniter->get_setting('welcome_register');

        $this->set_panel_body($form->generate());

        $this->load->theme('pages/auth', $this->data, 'auth');
    }

    public function resend()
    {
        if ( $this->authr->is_logged_in() )
        {
            redirect('data/utama');
        }

        // not logged in or activated
        if ( !$this->authr->is_logged_in(FALSE) )
        {
            redirect('login');
        }

        $this->set_panel_title('Kirim ulang aktivasi');

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
            if ( $data = $this->authr->change_email( $form_data['email'] ) )
            {
                // success
                $data['activation_period'] = $this->bakaigniter->get_setting('auth_email_activation_expire') / 3600;

                $this->bakaigniter->send_email( $form_data['email'], 'lang:activate', $data );

                $this->_notice('activation-sent');
            }
            else
            {
                $this->session->set_flashdata( 'error', get_message('error') );

                redirect(current_url());
            }
        }

        $this->data['desc_body'] = $this->bakaigniter->get_setting('welcome_resend');

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

            if ( $data = $this->authr->forgot_password( $form_data['forgot_login']) )
            {
                // Send email with password activation link
                $this->bakaigniter->send_email( $data['email'], 'lang:forgot_password', $data );

                $this->_notice('password-sent');
            }
            else
            {
                $this->session->set_flashdata('error', get_message('error'));

                redirect( current_url() );
            }
        }

        $this->data['desc_body'] = $this->bakaigniter->get_setting('welcome_forgot');

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
            if ( $data = $this->authr->reset_password( $user_id, $email_key, $form_data['reset_password'] ) )
            {
                // success
                if ( $this->bakaigniter->send_email( $data['email'], 'lang:activate', $data ) )
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
