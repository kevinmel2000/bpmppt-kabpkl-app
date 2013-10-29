<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->baka_theme->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->admin_navbar( 'admin_sidebar', 'side' );
	}

	public function index()
	{
		$this->all();
	}

	public function all()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Semua data pengguna');

		$form = $this->baka_form->add_form( current_url(), 'register' )
								->add_fields(array(
									array(
										'name'	=> 'register-fullname',
										'type'	=> 'text',
										'label'	=> 'Nama lengkap',
										'validation'=> 'required',
										),
									));

		if (!$form->validate_submition())
			$this->data['panel_body'] = $form->render();
		else
			$this->data['panel_body'] = $form->submited_data();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function groups()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Semua Group Pengguna');

		$form = $this->baka_form->add_form( current_url(), 'register' )
								->add_fields(array(
									array(
										'name'	=> 'register-fullname',
										'type'	=> 'text',
										'label'	=> 'Nama lengkap',
										'validation'=> 'required',
										),
									));

		if (!$form->validate_submition())
		{
			$all_users	= $this->baka_users->get_all();
			$users		= null;

			// $this->baka_users->delete(3);

			if ( $all_users->num_rows() > 0 )
			{
				// $users = $this->baka_users->get_profile_by_id(3);
			}
			else
			{
				$this->baka_users->create(array(
					'group_id' => 0,
					'username' => 'me',
					'email' => 'me@mail.com',
					'password' => 'pass',
					));
			}

			$this->data['panel_body'] = $users;
		}
		else
			$this->data['panel_body'] = $form->submited_data();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function permission()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Hak akses pengguna');

		$form = $this->baka_form->add_form( current_url(), 'register' )
								->add_fields(array(
									array(
										'name'	=> 'register-fullname',
										'type'	=> 'text',
										'label'	=> 'Nama lengkap',
										'validation'=> 'required',
										),
									));

		if (!$form->validate_submition())
			$this->data['panel_body'] = $form->render();
		else
			$this->data['panel_body'] = $form->submited_data();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function profile()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Profil anda');

		$form = $this->baka_form->add_form( current_url(), 'register' )
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
									));

		if (!$form->validate_submition())
			$this->data['panel_body'] = $form->render();
		else
			$this->data['panel_body'] = $form->submited_data();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	function _test()
	{
		$grid = $this->baka_grid->set_query( $query )
								->set_column_label( 'Label 1', 'Label 2', 'Label 3' )
								->set_column_width( 10, 60, 30 )
								->set_cell_display( '<b>%0</b><br>%1', 'callback__anchor(%1, %3)', '%1' );
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */