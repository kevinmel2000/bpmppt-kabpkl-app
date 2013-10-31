<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('baka_pack/baka_users');

		$this->baka_theme->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->admin_navbar( 'admin_sidebar', 'side' );
	}

	public function index()
	{
		$this->data();
	}

	public function data( $page = '', $user_id = '' )
	{
		switch ( $page ) {
			case 'form':
				$this->_user_form( $user_id );
				break;
			
			default:
				$this->data['panel_title'] = $this->baka_theme->set_title('Semua data pengguna');
					
				$this->data['panel_body']	= $this->baka_users->get_users_grid('admin/pengguna/data/');
				$this->data['counter']		= $this->baka_users->user_count;

				$this->baka_theme->load('pages/panel_data', $this->data);
				break;
		}
	}

	public function profile()
	{
		$this->_user_form( $this->baka_users->get_user_id() );
	}

	private function _user_form( $user_id = '' )
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Profil anda');

		$user = ( $user_id != '' ? $this->baka_users->get_user_profiles( $user_id ) : '' );

		$fields[]	= array('name'	=> 'user-fullname',
							'type'	=> 'text',
							'label'	=> 'Nama lengkap',
							'std'	=> ( $user_id != '' ? $user->name : '' ) );

		$fields[]	= array('name'	=> 'user-username',
							'type'	=> 'text',
							'label'	=> 'Username',
							'std'	=> ( $user_id != '' ? $user->username : '' ) );

		$fields[]	= array('name'	=> 'user-email',
							'type'	=> 'email',
							'label'	=> 'Email',
							'std'	=> ( $user_id != '' ? $user->email : '' ),
							'validation'=> 'valid_email' );

		$fields[]	= array('name'	=> 'app_fieldset_data',
							'type'	=> 'fieldset',
							'label'	=> 'Data pengguna' );

		$fields[]	= array('name'	=> 'user-last-login',
							'type'	=> 'email',
							'label'	=> 'Login terakhir',
							'attr'	=> 'readonly',
							'std'	=> ( $user_id != '' ? $user->last_login : '' ) );

		$fields[]	= array('name'	=> 'user-last-login',
							'type'	=> 'email',
							'label'	=> 'Dibuat pada',
							'attr'	=> 'readonly',
							'std'	=> ( $user_id != '' ? $user->created : '' ) );

		$fields[]	= array('name'	=> 'user-last-login',
							'type'	=> 'email',
							'label'	=> 'Diedit pada',
							'attr'	=> 'readonly',
							'std'	=> ( $user_id != '' ? $user->modified : '' ) );

		$fields[]	= array('name'	=> 'app_fieldset_password',
							'type'	=> 'fieldset',
							'label'	=> 'Ganti password' );

		$fields[]	= array('name'	=> 'user-last-password',
							'type'	=> 'password',
							'label'	=> 'Password lama' );

		$fields[]	= array('name'	=> 'user-new-password',
							'type'	=> 'password',
							'label'	=> 'Password baru',
							'validation'=> 'min_length['.get_app_setting('auth_password_min_length').']|max_length['.get_app_setting('auth_password_max_length').']');

		$fields[]	= array('name'	=> 'user-confirm-password',
							'type'	=> 'password',
							'label'	=> 'Konfirmasi Password',
							'validation'=> 'matches[user-new-password]');

		$fields[]	= array('name'	=> 'app_fieldset_status',
							'type'	=> 'fieldset',
							'label'	=> 'Status' );

		$fields[]	= array('name'	=> 'user-activated',
							'type'	=> 'radiobox',
							'label'	=> 'Aktif',
							'option'=> array(
								0	=> 'Non-aktif',
								1	=> 'Aktif' ),
							'std'	=> ( $user_id != '' ? $user->activated : '' ) );

		$fields[]	= array('name'	=> 'user-banned',
							'type'	=> 'radiobox',
							'label'	=> 'Dicekal',
							'option'=> array(
								0	=> 'Tidak dicekal',
								1	=> 'Dicekal' ),
							'std'	=> ( $user_id != '' ? $user->banned : '' ) );

		$fields[]	= array('name'	=> 'user-ban-reason',
							'type'	=> 'textarea',
							'label'	=> 'Alasan pencekalan',
							'std'	=> ( $user_id != '' ? $user->ban_reason : '' ) );

		$fields[]	= array('name'	=> 'app_fieldset_roles',
							'type'	=> 'fieldset',
							'label'	=> 'Hak Akses' );

		$roles_option = array();

		foreach ( $this->baka_users->get_roles() as $role )
		{
			$roles_option[$role->role_id] = $role->full;
		}

		$user_roles = array();

		foreach ( $this->baka_users->get_user_roles( $user->id ) as $user_role )
		{
			$user_roles[] = $user_role['role_id'];
		}

		$fields[]	= array('name'	=> 'user-roles',
							'type'	=> 'checkbox',
							'label'	=> 'Kelompok pengguna',
							'option'=> $roles_option,
							'std'	=> ( $user_id != '' ? $user_roles : '' ) );

		$form = $this->baka_form->add_form( current_url(), 'user' )
								->add_fields( $fields );

		if ( $form->validate_submition() )
		{
			$this->data['panel_body'] = $form->submited_data();
		}

		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function groups( $page = '', $role_id = '' )
	{
		switch ( $page ) {
			case 'form':
				$this->_role_form( $role_id );
				break;
			
			default:
				$this->data['panel_title'] = $this->baka_theme->set_title('Semua data kelompok pengguna');
					
				$this->data['panel_body']	= $this->baka_users->get_roles_grid('admin/pengguna/groups/');
				$this->data['counter']		= $this->baka_users->role_count;

				$this->baka_theme->load('pages/panel_data', $this->data);
				break;
		}
	}

	public function permission( $page = '', $role_id = '' )
	{
		switch ( $page ) {
			case 'form':
				$this->_role_form( $role_id );
				break;
			
			default:
				$this->data['panel_title'] = $this->baka_theme->set_title('Semua data hak akses pengguna');
					
				$this->data['panel_body']	= $this->baka_users->get_perms_grid('admin/pengguna/groups/');
				$this->data['counter']		= $this->baka_users->perm_count;

				$this->baka_theme->load('pages/panel_data', $this->data);
				break;
		}
	}

	function _test()
	{
		$grid = $this->baka_grid->set_query( $query )
								->set_column_label( 'Label 1', 'Label 2', 'Label 3' )
								->set_column_width( 10, 60, 30 )
								->set_cell_display( '<b>%0</b><br>%1', 'callback__anchor(%1, %3)', '%1' );
	}
}

/* End of file pengguna.php */
/* Location: ./application/controllers/pengguna.php */