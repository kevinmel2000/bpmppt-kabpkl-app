<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->baka_theme->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->admin_navbar( 'admin_sidebar', 'side' );

		if ( ! $this->load->is_loaded('table'))
			$this->load->library('table');

		$this->table->set_template( array('table_open' => '<table class="table table-striped table-hover table-condensed">' ) );

		$this->load->model('baka_pack/app_users');
	}

	public function index()
	{
		$this->data();
	}

	public function data( $page = '', $user_id = '' )
	{
		$this->data['load_toolbar']	= TRUE;

		switch ( $page ) {
			case 'form':
				$this->_user_form( $user_id );
				break;

			case 'data':
			default:
				$this->_user_table();
				break;
		}
	}

	private function _user_table()
	{
		$page_link = 'admin/pengguna/data/';
		$query = $this->baka_users->get_users();

		$this->data['tool_buttons'][$page_link.'form'] = 'Baru|primary';

		$this->data['panel_title']	= $this->baka_theme->set_title('Semua data pengguna');
		$this->data['counter']		= $query->num_rows();

		if ( $this->data['counter'] > 0 )
		{
			$heading[]	= array(
				'data'	=> 'ID',
				'class'	=> 'head-id',
				'width'	=> '10%' );

			$heading[]	= array(
				'data'	=> 'Pengguna',
				'class'	=> 'head-value',
				'width'	=> '35%' );

			$heading[]	= array(
				'data'	=> 'Email',
				'class'	=> 'head-value',
				'width'	=> '35%' );

			$heading[]	= array(
				'data'	=> 'Aksi',
				'class'	=> 'head-action',
				'width'	=> '25%' );

			$this->table->set_heading( $heading );

			foreach ( $query->result() as $user )
			{
				$cell[$user->id][]	= array(
					'data'	=> anchor($page_link.'form/'.$user->id, '#'.$user->id),
					'class'	=> 'user-id',
					'width'	=> '5%' );

				$username = ( $user->fullname != '' ? $user->fullname : $user->username );

				$cell[$user->id][]	= array(
					'data'	=> '<strong>'.anchor($page_link.'form/'.$user->id, $username).'</strong><br><small class="text-muted">'.mailto($user->email, $user->email).'</small>',
					'class'	=> 'data-value',
					'width'	=> '35%' );

				$status = ( $user->activated == 1 ? 'Aktif mulai '.format_datetime($user->created) : 'Tidak aktif mulai '.format_datetime($user->modified) );

				$cell[$user->id][]	= array(
					'data'	=> '<span class="badge">'.$user->role_fullname.'</span><br><small class="text-muted">'.$status.'</small>',
					'class'	=> 'data-value',
					'width'	=> '35%' );

				$class = 'class="btn btn-default btn-sm"';

				$cell[$user->id][]	= array(
					'data'	=> '<div class="btn-group btn-group-justified">'.anchor($page_link.'form/'.$user->id, 'Edit', $class ).anchor($page_link.'delete/'.$user->id, 'Hapus', $class).'</div>',
					'class'	=> 'data-action',
					'width'	=> '25%' );

				// $this->table->add_row( $cell );
			}
		}
		else
		{
			$cell[0][]	= array(
				'data'		=> '<span class="text-muted text-center">Belum ada 1 pun pengguna</span>',
				'class'		=> 'active',
				'colspan'	=> 4 );

			// $this->table->add_row( $cell );
		}

		$this->data['panel_body'] = $this->table->generate( $cell );

		$this->baka_theme->load('pages/panel_data', $this->data);
	}

	public function profile()
	{
		$this->_user_form( $this->baka_auth->get_user_id() );
	}

	private function _user_form( $user_id = '' )
	{
		$page_link = 'admin/pengguna/data/';
		$user = ( $user_id != '' ? $this->baka_users->get_users( $user_id )->row() : '' );

		$this->data['panel_title'] = $this->baka_theme->set_title('Data pengguna '.( $user_id != '' ? ' '.$user->fullname : '' ));
		$this->data['tool_buttons'][$page_link.'data'] = 'Kembali|default';

		$use_username = (bool) get_app_config('use_username');

		if ( $user_id != '' )
		{
			$fields[]	= array('name'	=> 'user-fullname',
								'type'	=> 'text',
								'label'	=> 'Nama lengkap',
								'std'	=> ( $user_id != '' ? $user->fullname : '' ) );
		}

		if ( $use_username )
		{
			$fields[]	= array('name'	=> 'user-username',
								'type'	=> 'text',
								'label'	=> 'Username',
								'std'	=> ( $user_id != '' ? $user->username : '' ),
								'validation'=> ( $user_id == '' ? 'required|is_username_blacklist|is_username_available|min_length['.get_app_setting('auth_username_min_length').']|max_length['.get_app_setting('auth_username_max_length').']' : '' ) );
		}

		$fields[]	= array('name'	=> 'user-email',
							'type'	=> 'email',
							'label'	=> 'Email',
							'std'	=> ( $user_id != '' ? $user->email : '' ),
							'validation'=> 'valid_email'.( $user_id == '' ? '|required|is_email_available' : '' ) );

		if ( $user_id != '' )
		{
			$fields[]	= array('name'	=> 'app-fieldset-data',
								'type'	=> 'fieldset',
								'label'	=> 'Data pengguna' );

			$fields[]	= array('name'	=> 'user-last-login',
								'type'	=> 'static',
								'label'	=> 'Login terakhir',
								'std'	=> $user->last_login );

			$fields[]	= array('name'	=> 'user-last-login',
								'type'	=> 'static',
								'label'	=> 'Dibuat pada',
								'std'	=> $user->created );

			$fields[]	= array('name'	=> 'user-last-login',
								'type'	=> 'static',
								'label'	=> 'Diedit pada',
								'std'	=> $user->modified );

			$fields[]	= array('name'	=> 'app-fieldset-password',
								'type'	=> 'fieldset',
								'label'	=> 'Ganti password' );

			$fields[]	= array('name'	=> 'user-last-password',
								'type'	=> 'password',
								'label'	=> 'Password lama' );
		}

		$fields[]	= array('name'	=> 'user-new-password',
							'type'	=> 'password',
							'label'	=> ( $user_id == '' ? 'Password' : 'Password baru' ),
							'validation'=> ( $user_id == '' ? 'required|' : '' ).'min_length['.get_app_setting('auth_password_min_length').']|max_length['.get_app_setting('auth_password_max_length').']');

		$fields[]	= array('name'	=> 'user-confirm-password',
							'type'	=> 'password',
							'label'	=> 'Konfirmasi Password',
							'validation'=> ( $user_id == '' ? 'required|' : '' ).'matches[user-new-password]');

		if ( $user_id != '' )
		{
			$fields[]	= array('name'	=> 'app-fieldset-status',
								'type'	=> 'fieldset',
								'label'	=> 'Status' );

			$fields[]	= array('name'	=> 'user-activated',
								'type'	=> 'radiobox',
								'label'	=> 'Aktif',
								'option'=> array(
									0	=> 'Non-aktif',
									1	=> 'Aktif' ),
								'std'	=> $user->activated );

			$fields[]	= array('name'	=> 'user-banned',
								'type'	=> 'radiobox',
								'label'	=> 'Dicekal',
								'option'=> array(
									0	=> 'Tidak dicekal',
									1	=> 'Dicekal' ),
								'std'	=> $user->banned );

			$fields[]	= array('name'	=> 'user-ban-reason',
								'type'	=> 'textarea',
								'label'	=> 'Alasan pencekalan',
								'std'	=> $user->ban_reason );
		}

		if ( $user_id != '' )
		{
			$fields[]	= array('name'	=> 'app-fieldset-roles',
								'type'	=> 'fieldset',
								'label'	=> 'Hak Akses' );

			$roles_option = array();

			foreach ( $this->baka_users->get_roles_query()->result() as $role )
			{
				$roles_option[$role->role_id] = $role->full;
			}

			$user_roles = array();

			foreach ( $this->baka_users->get_user_roles( $user->id )->result() as $user_role )
			{
				$user_roles[] = $user_role->role_id;
			}

			$fields[]	= array('name'	=> 'user-roles',
								'type'	=> 'checkbox',
								'label'	=> 'Kelompok pengguna',
								'option'=> $roles_option,
								'std'	=> ( $user_id != '' ? $user_roles : '' ),
								'validation'=> ( $user_id == '' ? 'required' : '' ) );
		}

		$form = $this->baka_form->add_form( current_url(), 'user' )
								->add_fields( $fields );

		if ( $form->validate_submition() )
		{
			if ( $user_id == '' )
			{
				$form_data	=  $form->submited_data();

				$user_data['username']	= $form_data['user-username'];
				$user_data['email'] 	= $form_data['user-email'];
				$user_data['password']	= $form_data['user-new-password'];

				$result		= $this->app_users->create_user( $user_data, $use_username );
				$redirect	= $page_link;
			}
			else
			{
				$result		= $this->app_users->update_user( $user_id, $form->submited_data(), $use_username );
				$redirect	= current_url();
			}

			if ( $result )
			{
				$this->session->set_flashdata('success', $this->baka_lib->message());

				redirect( $page_link );
			}
			else
			{
				$this->session->set_flashdata('error', $this->baka_lib->errors());

				redirect( current_url() );
			}
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
				$this->_group_table();
				break;
		}
	}

	private function _group_table()
	{
		$page_link = 'admin/pengguna/groups/';
		$query = $this->baka_users->get_roles_query();

		$this->data['panel_title'] = $this->baka_theme->set_title('Semua data kelompok pengguna');

		$this->data['counter']		= $query->num_rows();

		if ( $this->data['counter'] > 0 )
		{
			$head1 = array( 'data'	=> 'ID',
							'class'	=> 'head-id',
							'width'	=> '10%' );

			$head2 = array( 'data'	=> 'Kelompok',
							'class'	=> 'head-value',
							'width'	=> '60%' );

			$head3 = array( 'data'	=> 'Default',
							'class'	=> 'head-value',
							'width'	=> '10%' );

			$head4 = array( 'data'	=> 'Aksi',
							'class'	=> 'head-action',
							'width'	=> '25%' );

			$this->table->set_heading( $head1, $head2, $head3, $head4 );

			foreach ( $query->result() as $role )
			{
				$col_1 = array( 'data'	=> anchor($page_link.'form/'.$role->role_id, '#'.$role->role_id),
								'class'	=> 'user-id',
								'width'	=> '5%' );

				$col_2 = array( 'data'	=> $role->full.' ('.$role->role.')',
								'class'	=> 'data-value',
								'width'	=> '60%' );

				$col_3 = array( 'data'	=> ($role->default == 1 ? '<span class="badge">Default</span>' : ''),
								'class'	=> 'data-value',
								'width'	=> '10%' );

				$class = 'class="btn btn-default btn-sm"';

				$col_4 = array( 'data'	=> '<div class="btn-group btn-group-justified">'.anchor($page_link.'form/'.$role->role_id, 'Edit', $class ).anchor($page_link.'delete/'.$role->role_id, 'Hapus', $class).'</div>',
								'class'	=> 'data-action',
								'width'	=> '25%' );

				$this->table->add_row( $col_1, $col_2, $col_3, $col_4 );
			}
		}
		else
		{
			$this->table->add_row( array( 
				'data'		=> '<span class="text-muted text-center">Belum ada 1 pun data kelompok</span>',
				'class'		=> 'active',
				'colspan'	=> 4 ));
		}

		$this->data['panel_body']	= $this->table->generate();

		$this->baka_theme->load('pages/panel_data', $this->data);
	}

	public function permission( $page = '', $role_id = '' )
	{
		switch ( $page ) {
			case 'form':
				$this->_role_form( $role_id );
				break;
			
			default:
				$this->_perm_table();
				break;
		}
	}

	private function _perm_table()
	{
		$page_link = 'admin/pengguna/permission/';
		$query = $this->baka_users->get_perms_query();

		$this->data['panel_title']	= $this->baka_theme->set_title('Semua data hak akses pengguna');
		$this->data['counter']		= $query->num_rows();

		if ( $this->data['counter'] > 0 )
		{
			$head1 = array( 'data'	=> 'ID',
							'class'	=> 'head-id',
							'width'	=> '10%' );

			$head2 = array( 'data'	=> 'Hak akses',
							'class'	=> 'head-value',
							'width'	=> '35%' );

			$head3 = array( 'data'	=> 'Keterangan',
							'class'	=> 'head-value',
							'width'	=> '35%' );

			$head4 = array( 'data'	=> 'Aksi',
							'class'	=> 'head-action',
							'width'	=> '25%' );

			$this->table->set_heading( $head1, $head2, $head3, $head4 );

			foreach ( $query->result() as $perm )
			{
				$col_1 = array( 'data'	=> anchor($page_link.'form/'.$perm->permission_id, '#'.$perm->permission_id),
								'class'	=> 'user-id',
								'width'	=> '5%' );

				$col_2 = array( 'data'	=> $perm->permission.'<br><small class="text-muted">'.$perm->description.'</small>',
								'class'	=> 'data-value',
								'width'	=> '35%' );

				$col_3 = array( 'data'	=> $perm->parent,
								'class'	=> 'data-value',
								'width'	=> '35%' );

				$class = 'class="btn btn-default btn-sm"';

				$col_4 = array( 'data'	=> '<div class="btn-group btn-group-justified">'.anchor($page_link.'form/'.$perm->permission_id, 'Edit', $class ).anchor($page_link.'delete/'.$perm->permission_id, 'Hapus', $class).'</div>',
								'class'	=> 'data-action',
								'width'	=> '25%' );

				$this->table->add_row( $col_1, $col_2, $col_3, $col_4 );
			}
		}
		else
		{
			$this->table->add_row( array( 
				'data'		=> '<span class="text-muted text-center">Belum ada 1 pun data hak akses</span>',
				'class'		=> 'active',
				'colspan'	=> 4 ));
		}

		$this->data['panel_body'] = $this->table->generate();

		$this->baka_theme->load('pages/panel_data', $this->data);
	}
}

/* End of file pengguna.php */
/* Location: ./application/controllers/pengguna.php */