<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->lang->load('tank_auth');

		$this->baka_theme->set_title('User Authentication');
	}

	public function index()
	{
		$this->login();
	}

	public function login()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Login Pengguna');

		if ($this->tank_auth->is_logged_in())								// logged in
			redirect($this->config->item('login-success', 'tank_auth'));
		elseif ($this->tank_auth->is_logged_in(FALSE))						// logged in, not activated
			redirect('auth/resend');

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
								1 => 'Ingat saya dikomputer ini.' ),
							'validation'=> 'integer' );

		if ($this->tank_auth->is_max_login_attempts_exceeded($login))
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
							'url'	=> 'auth/forgot',
							'class'	=> 'btn-default pull-right' );

		if ( (bool) get_app_setting('auth_allow_registration') )
		{
			$buttons[]	= array('name'	=> 'register',
								'type'	=> 'anchor',
								'label'	=> 'Register',
								'url'	=> 'auth/register',
								'class'	=> 'btn-default pull-right' );
		}

		$form = $this->baka_form->add_form( current_url(), 'login', '', 'form')
								->add_fields( $fields )
								->add_buttons( $buttons );

		if ( $form->validate_submition() )
		{
			$user_data = $form->submited_data();

			if ( $this->tank_auth->login( $user_data['login-username'], $user_data['login-password'], $user_data['login-remember'], $login_by_username, $login_by_email) )
			{
				if($this->tank_auth->is_approved())
				{
					redirect($this->config->item('login-success', 'tank_auth'));
				}
				else
				{
					$this->tank_auth->logout();
					$this->tank_auth->notice('acct-unapproved');
				}
			}
			else
			{
				$errors = $this->tank_auth->get_error_message();
				
				if (isset($errors['banned']))
				{								// banned user
					$this->tank_auth->notice('user-banned');
				}
				elseif (isset($errors['not_activated']))
				{				// not activated user
					redirect('auth/resend');
				}
				else
				{													// fail
					foreach ($errors as $k => $v)
						$data['errors'][$k] = $this->lang->line($v);
				}
			}
		}

		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/auth', $this->data);
	}

	public function logout()
	{
		$this->tank_auth->logout();
		
		redirect('auth/login');
	}

	public function register()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Register Pengguna');

		if ( $this->tank_auth->is_logged_in() )									// logged in
			redirect($this->config->item('register_redirect', 'tank_auth'));
		elseif ( $this->tank_auth->is_logged_in(FALSE) )						// logged in, not activated
			redirect('auth/resend');
		elseif (!$this->config->item('allow_registration', 'tank_auth'))		// registration is off
			$this->tank_auth->notice('registration-disabled');

		$use_username = (bool) $this->config->item('use_username', 'tank_auth');
		
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

		$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
		$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');

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

		$email_activation = $this->config->item('email_activation', 'tank_auth');

		$buttons[]	= array('name'	=> 'register',
							'type'	=> 'submit',
							'label'	=> 'Register',
							'class'	=> 'btn-primary pull-left' );

		$buttons[]	= array('name'	=> 'forgot',
							'type'	=> 'anchor',
							'label'	=> 'Lupa Login',
							'url'	=> 'auth/forgot',
							'class'	=> 'btn-default pull-right' );

		$form = $this->baka_form->add_form( current_url(), 'register', '', 'form')
								->add_fields( $fields )
								->add_buttons( $buttons );

		if ( $form->validate_submition() )
		{
			$user_data = $form->submited_data();

			if (!is_null($data = $this->tank_auth->create_user(
				$use_username ? $user_data['register-username'] : '',
				$user_data['register-email'],
				$user_data['register-password'],
				$email_activation )))
			{
				$this->data['site_name'] = get_app_config('app_name');

				if ($email_activation)													// send "activate" email
				{
					$this->data['activation_period'] = get_app_setting('auth_email_activation_expire') / 3600;
					$this->_send_email('activate', $user_data['register_email'], $data);
					unset($user_data['register_password']); // Clear password (just for any case)
				}
				else
				{
					if ($this->config->item('email_account_details', 'tank_auth'))		// send "welcome" email
						$this->_send_email('welcome', $user_data['email'], $data);

					unset($user_data['register_password']); // Clear password (just for any case)
				}
				
				$this->tank_auth->notice('registration-success');
			}
			else
			{
				$errors = $this->tank_auth->get_error_message();
				
				foreach ($errors as $k => $v)
					$this->data['errors'][$k] = $this->lang->line($v);
			}
		}
		
		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/auth', $this->data);
	}

	public function resend()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Kirim ulang aktivasi');

		if (!$this->tank_auth->is_logged_in(FALSE))							// not logged in or activated
			redirect('auth/login');

		$fields[]	= array('name'	=> 'resend',
							'type'	=> 'email',
							'label'	=> 'Email',
							'validation'=> 'required|valid_email' );

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

			if (!is_null($data = $this->tank_auth->change_email( $user_data('email') ))) {			// success

				$this->data['site_name'] = get_app_config('app_name');
				$this->data['activation_period'] = get_app_setting('auth_email_activation_expire') / 3600;

				$this->_send_email('activate', $this->data['email'], $data);
				$this->tank_auth->notice('activation-sent', $data);

			}
			else
			{
				$errors = $this->tank_auth->get_error_message();

				foreach ($errors as $k => $v)
					$this->data['errors'][$k] = $this->lang->line($v);
			}
		}

		$this->data['errors'] = array();
		
		$data['logout_link'] = site_url().'auth/logout';
		
		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/auth', $this->data);
	}

	public function forgot()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Lupa login');
		
		$fields[]	= array('name'	=> 'login-email',
							'type'	=> 'text',
							'label'	=> 'Email',
							'validation'=> 'required' );

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
		}
		
		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/auth', $this->data);
	}

	public function activate( $user_id, $new_email_key )
	{
		if(!$this->uri->segment(4))
			redirect('/auth/login');

		// Activate user
		if ($this->tank_auth->activate_user($user_id, $new_email_key))
		{		// success
			$this->tank_auth->logout();
			$this->tank_auth->notice('activation-complete');

		}
		else
		{																// fail
			$this->tank_auth->notice('activation-failed');
		}
	}

	function _check_captcha( $code )
	{
		session_start();
		if($_SESSION['captcha'] != $code){
			$this->form_validation->set_message('_check_captcha', 'The Confirmation Code is wrong.');
			return FALSE;
		}
		
		return TRUE;
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */