<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Baka_users Extends Baka_lib
{
	private $table_prefix;

	private $users_table	= 'users';
	private $profiles_table	= 'profiles';
	private $roles_table	= 'roles';
	private $perms_table	= 'permissions';

	public $user_count = 0;
	public $role_count = 0;
	public $perm_count = 0;

	public function __construct()
	{
		parent::__construct();

		$this->table_prefix	= $this->config->item('db_table_prefix', 'tank_auth');

		$this->users_table		= $this->table_prefix.$this->users_table;
		$this->profiles_table	= $this->table_prefix.$this->profiles_table;
		$this->roles_table		= $this->table_prefix.$this->roles_table;
		$this->perms_table		= $this->table_prefix.$this->perms_table;

		log_message('debug', "Baka_users Class Initialized");
	}

	public function get_users_grid( $page_link )
	{
		$query = $this->db->get( $this->users_table );

		if ( ! $this->load->is_loaded('table'))
			$this->load->library('table');

		$this->user_count = $query->num_rows();

		if ( $this->user_count > 0 )
		{
			$head1 = array( 'data'	=> 'ID',
							'class'	=> 'head-id',
							'width'	=> '10%' );

			$head2 = array( 'data'	=> 'Pengguna',
							'class'	=> 'head-value',
							'width'	=> '35%' );

			$head3 = array( 'data'	=> 'Email',
							'class'	=> 'head-value',
							'width'	=> '35%' );

			$head4 = array( 'data'	=> 'Aksi',
							'class'	=> 'head-action',
							'width'	=> '25%' );

			$this->table->set_heading( $head1, $head2, $head3, $head4 );

			foreach ( $query->result() as $user )
			{
				$profile = $this->get_user_profiles( $user->id );

				$col_1 = array( 'data'	=> anchor($page_link.'form/'.$profile->id, '#'.$profile->id),
								'class'	=> 'user-id',
								'width'	=> '5%' );

				$col_2 = array( 'data'	=> '<strong>'.anchor($page_link.'form/'.$profile->id, $profile->name).'</strong><br><small class="text-muted">'.mailto($profile->email, $profile->email).'</small>',
								'class'	=> 'data-value',
								'width'	=> '35%' );

				$roles	= $this->get_user_roles( $profile->id );

				$r		= '<span class="badge">';

				for ($i=0; $i<count($roles); $i++)
				{
					$r .= $roles[$i]['full'].( $i >= 1 ? ', ': '' );
				}

				$status = ( $profile->activated == 1 ? 'Aktif mulai '.format_datetime($profile->created) : 'Tidak aktif mulai '.format_datetime($profile->modified) );

				$status = ( $profile->banned == 1 ? 'Banned dengan alasan '.$profile->ban_reason : $status );

				$col_3 = array( 'data'	=> $r.'</span><br><small class="text-muted">'.$status.'</small>',
								'class'	=> 'data-value',
								'width'	=> '35%' );

				$class = 'class="btn btn-default btn-sm"';

				$col_4 = array( 'data'	=> '<div class="btn-group btn-group-justified">'.anchor($page_link.'form/'.$profile->id, 'Edit', $class ).anchor($page_link.'delete/'.$profile->id, 'Hapus', $class).'</div>',
								'class'	=> 'data-action',
								'width'	=> '25%' );

				$this->table->add_row( $col_1, $col_2, $col_3, $col_4 );
			}
		}
		else
		{
			$this->table->add_row( array( 
				'data'		=> '<span class="text-muted text-center">Belum ada 1 pun pengguna</span>',
				'class'		=> 'active',
				'colspan'	=> 4 ));
		}

		$this->table->set_template( array('table_open' => '<table class="table table-striped table-hover table-condensed">' ) );

		$generate = $this->table->generate();

		$this->table->clear();

		return $generate;
	}

	public function get_roles_grid( $page_link )
	{
		$query = $this->db->get( $this->roles_table );

		if ( ! $this->load->is_loaded('table'))
			$this->load->library('table');

		$this->role_count = $query->num_rows();

		if ( $this->role_count > 0 )
		{
			$head1 = array( 'data'	=> 'ID',
							'class'	=> 'head-id',
							'width'	=> '10%' );

			$head2 = array( 'data'	=> 'Kelompok',
							'class'	=> 'head-value',
							'width'	=> '35%' );

			$head3 = array( 'data'	=> 'Default',
							'class'	=> 'head-value',
							'width'	=> '35%' );

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
								'width'	=> '35%' );

				$col_3 = array( 'data'	=> ($role->default == 1 ? '<span class="badge">Default</span>' : ''),
								'class'	=> 'data-value',
								'width'	=> '35%' );

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

		$this->table->set_template( array('table_open' => '<table class="table table-striped table-hover table-condensed">' ) );

		$generate = $this->table->generate();

		$this->table->clear();

		return $generate;
	}

	public function get_perms_grid( $page_link )
	{
		$query = $this->db->get( $this->perms_table );

		if ( ! $this->load->is_loaded('table'))
			$this->load->library('table');

		$this->perm_count = $query->num_rows();

		if ( $this->perm_count > 0 )
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

		$this->table->set_template( array('table_open' => '<table class="table table-striped table-hover table-condensed">' ) );

		$generate = $this->table->generate();

		$this->table->clear();

		return $generate;
	}

	public function get_user_id()
	{
		return $this->tank_auth->get_user_id();
	}

	public function get_user_profile( $user_id )
	{
		return $this->users->get_user_profile( $user_id, TRUE );
	}

	public function get_user_profiles( $user_id )
	{
		if (NULL !== ($user = $this->users->get_user_by_id( $user_id, TRUE )) )
		{
			$profile = $this->get_user_profile( $user->id );
		}

		return (object) array_merge( (array) $user, (array) $profile );
	}

	public function get_roles()
	{
		$query = $this->db->get( $this->roles_table );
		return $query->result();
	}

	public function get_user_roles( $user_id )
	{
		return $this->users->get_roles( $user_id );
	}
}

/* End of file Baka_users.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_users.php */