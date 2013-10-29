<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
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

		$form = $this->baka_form->add_form( current_url(), 'login', '', 'form')
								->add_fields(array(
									array(
										'name'	=> 'login-username',
										'type'	=> 'text',
										'label'	=> 'Username',
										'validation'=> 'required',
										),
									array(
										'name'	=> 'login-password',
										'type'	=> 'password',
										'label'	=> 'Password',
										'validation'=> 'required',
										),
									array(
										'name'	=> 'login-remember',
										'type'	=> 'checkbox',
										'label'	=> '',
										'option'=> array('remember' => 'Ingat saya dikomputer ini.'),
										),
									))
								->add_buttons(array(
									array(
										'name'	=> 'login',
										'type'	=> 'submit',
										'value'	=> 'Login',
										'class'	=> 'btn-primary pull-left',
										),
									array(
										'name'	=> 'app_date_format',
										'type'	=> 'reset',
										'value'	=> 'Batal',
										'class'	=> 'btn-default pull-right',
										),
									));

		if (!$form->validate_submition())
			$this->data['panel_body'] = $form->render();
		else
			$this->data['panel_body'] = $form->submited_data();

		$this->baka_theme->load('page/auth', $this->data);
	}

	public function register()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Register Pengguna');

		$form = $this->baka_form->add_form( current_url(), 'register', '', 'form')
								->add_fields(array(
									array(
										'name'	=> 'register-fullname',
										'type'	=> 'text',
										'label'	=> 'Nama lengkap',
										'validation'=> 'required',
										),
									array(
										'name'	=> 'register-username',
										'type'	=> 'text',
										'label'	=> 'Username',
										'validation'=> 'required',
										),
									array(
										'name'	=> 'register-email',
										'type'	=> 'text',
										'label'	=> 'Email',
										'validation'=> 'required',
										),
									array(
										'name'	=> 'register-password',
										'type'	=> 'password',
										'label'	=> 'Password',
										'validation'=> 'required',
										),
									array(
										'name'	=> 'register-remember',
										'type'	=> 'checkbox',
										'label'	=> '',
										'option'=> array('remember' => 'Ingat saya dikomputer ini.'),
										),
									))
								->add_buttons(array(
									array(
										'name'	=> 'submit',
										'type'	=> 'submit',
										'value'	=> 'Login',
										'class'	=> 'btn-primary pull-left',
										),
									array(
										'name'	=> 'app_date_format',
										'type'	=> 'reset',
										'value'	=> 'Batal',
										'class'	=> 'btn-default pull-right',
										),
									));

		if (!$form->validate_submition())
			$this->data['panel_body'] = $form->render();
		else
			$this->data['panel_body'] = $form->submited_data();

		$this->baka_theme->load('page/auth', $this->data);
	}

	public function forgot()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Forgot Password');

		$form = $this->baka_form->add_form( current_url(), 'forgot', '', 'form')
								->add_fields(array(
									array(
										'name'	=> 'login-email',
										'type'	=> 'text',
										'label'	=> 'Email',
										'validation'=> 'required',
										),
									))
								->add_buttons(array(
									array(
										'name'	=> 'submit',
										'type'	=> 'submit',
										'value'	=> 'Kirim',
										'class'	=> 'btn-primary pull-left',
										),
									));

		if (!$form->validate_submition())
			$this->data['panel_body'] = $form->render();
		else
			$this->data['panel_body'] = $form->submited_data();

		$this->baka_theme->load('page/auth', $this->data);
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */