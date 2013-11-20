<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->baka_theme->set_title('User Authentication');
	}

	public function index()
	{
		$this->login();
	}

	public function login()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Login Pengguna');

		$login_by_username	= ( (bool) get_app_setting('auth_login_by_username') AND (bool) get_app_setting('auth_use_username') );
		$login_by_email		= (bool) get_app_setting('auth_login_by_email');

		if ( $login_by_username AND $login_by_email )
			$label	= 'Email atau Username';
		else if ( $login_by_username )
			$label	= 'Username';
		else 
			$label	= 'Email';

		$login = ( get_app_setting('auth_login_count_attempts') AND ($login = $this->input->post('login'))) ?
				$this->security->xss_clean($login) : '';

		$fields[]	= array('name'	=> 'login-username',
							'type'	=> 'text',
							'label'	=> $label,
							'validation'=> 'required' );

		$fields[]	= array('name'	=> 'login-password',
							'type'	=> 'password',
							'label'	=> 'Password',
							'validation'=> 'required' );

		$fields[]	= array('name'	=> 'login-remember',
							'type'	=> 'checkbox',
							'label'	=> '',
							'option'=> array(
								1 => 'Ingat saya dikomputer ini.' ) );

		if ($this->baka_auth->is_max_login_attempts_exceeded($login))
		{
			if ( (bool) get_app_setting('auth_use_recaptcha') )
			{
				$fields[]	= array('name'	=> 'login-recaptcha',
									'type'	=> 'recaptcha',
									'label'	=> 'Validasi',
									'validation'=> 'required|callback__check_recaptcha');
			}
			else
			{
				$fields[]	= array('name'	=> 'login-captcha',
									'type'	=> 'captcha',
									'label'	=> 'Validasi',
									'validation'=> 'required|callback__check_captcha');
			}
		}

		$buttons[]	= array('name'	=> 'login',
							'type'	=> 'submit',
							'label'	=> 'Login',
							'class'	=> 'btn-primary pull-left' );

		$buttons[]	= array('name'	=> 'forgot',
							'type'	=> 'anchor',
							'label'	=> 'Lupa Login',
							'url'	=> 'forgot',
							'class'	=> 'btn-default pull-right' );

		if ( (bool) get_app_setting('auth_allow_registration') )
		{
			$buttons[]	= array('name'	=> 'register',
								'type'	=> 'anchor',
								'label'	=> 'Register',
								'url'	=> 'register',
								'class'	=> 'btn-default pull-right' );
		}

		$form = $this->baka_form->add_form( current_url(), 'login', '', 'form')
								->add_fields( $fields )
								->add_buttons( $buttons );

		if ( $form->validate_submition() )
		{
			$user_data = $form->submited_data();

			if ( $this->baka_auth->login( $user_data['login-username'], $user_data['login-password'], (bool) $user_data['login-remember'], $login_by_username, $login_by_email) )
			{
				$this->session->set_flashdata('success', $this->baka_auth->messages());

				redirect('dashboard');
			}
			else
			{
				$this->session->set_flashdata('error', $this->baka_auth->errors());

				redirect( current_url() );
			}
		}

		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/auth', $this->data);
	}

	public function register()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Register Pengguna');

		if ( ! get_app_config('allow_registration') )
			$this->_notice('registration-disabled');

		$use_username = (bool)  get_app_config('use_username');
		
		if ( $use_username )
		{
			$fields[]	= array('name'	=> 'register-username',
								'type'	=> 'text',
								'label'	=> 'Username',
								'validation'=> 'required|min_length['.get_app_setting('auth_username_min_length').']|max_length['.get_app_setting('auth_username_max_length').']|callback__check_username_blacklist|callback__check_username_exists' );
		}
		
		$fields[]	= array('name'	=> 'register-email',
							'type'	=> 'text',
							'label'	=> 'Email',
							'validation'=> 'required|valid_email' );
		
		$fields[]	= array('name'	=> 'register-password',
							'type'	=> 'password',
							'label'	=> 'Password',
							'validation'=> 'required|min_length['.get_app_setting('auth_password_min_length').']|max_length['.get_app_setting('auth_password_max_length').']' );
		
		$fields[]	= array('name'	=> 'register-confirm-password',
							'type'	=> 'password',
							'label'	=> 'Ulangi Password',
							'validation'=> 'required|matches[register-password]' );

		$captcha_registration	=  get_app_config('captcha_registration');
		$use_recaptcha			=  get_app_config('use_recaptcha');

		if ($captcha_registration)
		{
			if ($use_recaptcha)
			{
				$fields[]	= array('name'	=> 'register-recaptcha',
									'type'	=> 'recaptcha',
									'label'	=> 'Confirmation Code',
									'validation'=> 'required|callback__check_recaptcha' );
			}
			else
			{
				$fields[]	= array('name'	=> 'register-captcha',
									'type'	=> 'captcha',
									'label'	=> 'Confirmation Code',
									'validation'=> 'required|callback__check_captcha' );
			}
		}

		$data['errors'] = array();

		$email_activation =  get_app_config('email_activation');

		$buttons[]	= array('name'	=> 'register',
							'type'	=> 'submit',
							'label'	=> 'Register',
							'class'	=> 'btn-primary pull-left' );

		$buttons[]	= array('name'	=> 'forgot',
							'type'	=> 'anchor',
							'label'	=> 'Lupa Login',
							'url'	=> 'forgot',
							'class'	=> 'btn-default pull-right' );

		$form = $this->baka_form->add_form( current_url(), 'register', '', 'form')
								->add_fields( $fields )
								->add_buttons( $buttons );

		if ( $form->validate_submition() )
		{
			$form_data	=  $form->submited_data();

			$user_data['username']	= $form_data['register-username'];
			$user_data['email'] 	= $form_data['register-email'];
			$user_data['password']	= $form_data['register-password'];

			if ( $this->app_users->create_user( $user_data, $use_username ) )
			{
				$this->_notice('registration-success');
			}
			else
			{
				$this->session->set_flashdata('error', $this->baka_lib->errors());

				redirect( current_url() );
			}
		}
		
		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/auth', $this->data);
	}

	public function resend()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Kirim ulang aktivasi');

		if (!$this->baka_auth->is_logged_in(FALSE))							// not logged in or activated
			redirect('login');

		$fields[]	= array('name'	=> 'resend',
							'type'	=> 'email',
							'label'	=> 'Email',
							'validation'=> 'required|valid_email',
							'desc'	=> 'Masukan alamat email yang anda gunakan untuk aplikasi ini.' );

		$buttons[]	= array('name'	=> 'submit',
							'type'	=> 'submit',
							'label'	=> 'resend',
							'class'	=> 'btn-primary pull-left' );

		$buttons[]	= array('name'	=> 'forgot',
							'type'	=> 'anchor',
							'label'	=> 'Lupa Login',
							'url'	=> 'auth/forgot',
							'class'	=> 'btn-default pull-right' );

		$form = $this->baka_form->add_form( current_url(), 'forgot', '', 'form')
								->add_fields( $fields )
								->add_buttons( $buttons );

		if ( $form->validate_submition() )
		{
			$user_data = $form->submited_data();

			if ( $data = $this->baka_auth->change_email( $user_data['email'] ) )
			{
				// success
				$this->load->library('Baka_pack/baka_email');

				$data['activation_period'] = get_app_setting('auth_email_activation_expire') / 3600;

				$this->baka_email->send('activate', $user_data['email'], $data);
				$this->_notice('activation-sent');
			}
			else
			{
				$this->session->set_flashdata('error', $this->baka_lib->errors());

				redirect( current_url() );
			}
		}
		
		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/auth', $this->data);
	}

	public function forgot()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Lupa login');
		
		$fields[]	= array('name'	=> 'forgot_login',
							'type'	=> 'text',
							'label'	=> 'Email atau Username',
							'validation'=> 'required',
							'desc'	=> 'Masukan alamat email atau username yang anda gunakan untuk aplikasi ini.' );

		$buttons[]	= array('name'	=> 'submit',
							'type'	=> 'submit',
							'label'	=> 'Kirim',
							'class'	=> 'btn-primary pull-left' );

		$buttons[]	= array('name'	=> 'login',
							'type'	=> 'anchor',
							'label'	=> 'Login',
							'url'	=> 'auth/login',
							'class'	=> 'btn-default pull-right' );

		$form = $this->baka_form->add_form( current_url(), 'forgot', '', 'form')
								->add_fields( $fields )
								->add_buttons( $buttons );

		if ( $form->validate_submition() )
		{
			$user_data = $form->submited_data();

			$this->load->library('Baka_pack/baka_email');

			if ( $data = $this->baka_auth->forgot_password( $user_data['forgot_login']) )
			{
				// Send email with password activation link
				$this->baka_email->send( $data['email'], 'forgot_password', $data );
					
				$this->_notice('password-sent');

			}
			else
			{
				$this->session->set_flashdata('error', $this->baka_lib->errors());

				redirect( current_url() );
			}
		}
		
		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/auth', $this->data);
	}

	public function activate( $user_id = NULL, $email_key = NULL )
	{
		if ( is_null($user_id) AND is_null($email_key) )
			redirect('login');

		// Activate user
		if ($this->baka_auth->activate_user($user_id, $email_key))
		{
			// success
			$this->baka_auth->logout();
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
		$this->data['panel_title'] = $this->baka_theme->set_title('Kirim ulang aktivasi');

		// not logged in or activated
		if ( is_null($user_id) AND is_null($email_key) )
			redirect('login');

		$fields[]	= array('name'	=> 'reset_password',
							'type'	=> 'password',
							'label'	=> 'Password baru',
							'validation'=> 'required|min_length['.get_app_setting('auth_password_min_length').']|max_length['.get_app_setting('auth_password_max_length').']' );

		$fields[]	= array('name'	=> 'confirm_reset_password',
							'type'	=> 'password',
							'label'	=> 'Password Konfirmasi',
							'validation'=> 'required|matches[reset_password]' );

		$buttons[]	= array('name'	=> 'submit',
							'type'	=> 'submit',
							'label'	=> 'Atur ulang',
							'class'	=> 'btn-primary pull-left' );

		$buttons[]	= array('name'	=> 'login',
							'type'	=> 'anchor',
							'label'	=> 'Login',
							'url'	=> 'login',
							'class'	=> 'btn-default pull-right' );

		$form = $this->baka_form->add_form( current_url(), 'reset', '', 'form')
								->add_fields( $fields )
								->add_buttons( $buttons );

		if ( $form->validate_submition() )
		{
			$user_data = $form->submited_data();

			if ( $data = $this->baka_auth->reset_password(  $user_id, $email_key, $user_data['reset_password'] ) )
			{
				// success
				$this->load->library('Baka_pack/baka_email');

				$this->baka_email->send($data['email'], 'activate', $data);
				$this->_notice('password-reset');
			}
			else
			{
				$this->session->set_flashdata('error', $this->baka_lib->errors());

				redirect( current_url() );
			}
		}
		
		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/auth', $this->data);
	}

	private function _change_email(){}

	private function _change_password(){}

	private function _reset_password(){}

	private function _unregister(){}

	public function logout()
	{
		$this->baka_auth->logout();
		
		redirect('login');
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */