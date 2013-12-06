<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_main extends CI_Model
{
	private $username;

	public function __construct()
	{
		parent::__construct();

		$this->username = $this->baka_auth->get_username();

		$this->load->model('baka_pack/app_data');

		// Adding main navbar
		$this->baka_theme->add_navbar( 'main_navbar', 'navbar-nav' );
		// Adding user navbar
		$this->baka_theme->add_navbar( 'user_navbar', 'navbar-nav navbar-right' );
		// Adding sub of main and user navbar
		$this->navbar();

		log_message('debug', "#Baka_pack: Main Application model Class Initialized");
	}

	public function navbar()
	{
		if ( is_permited('doc_manage') )
		{
			// Adding dashboard menu to main navbar
			$this->baka_theme->add_navmenu( 'main_navbar', 'dashboard', 'link', 'dashboard', 'Dashboard' );
			// Adding data menu to main navbar
			$this->baka_theme->add_navmenu( 'main_navbar', 'master', 'link', 'data', 'Data Perijinan' );

			// Adding submenu to main_navbar-data
			$this->data_navbar( 'main_navbar-master', 'top' );
		}

		// Adding admin menu to main navbar
		$this->baka_theme->add_navmenu( 'main_navbar', 'admin', 'link', 'admin', 'Administrasi' );
		// Adding account menu to user navbar
		$this->baka_theme->add_navmenu( 'user_navbar', 'account', 'link', 'profile', $this->username );
		// Adding submenu to main_navbar-admin
		$this->admin_navbar( 'main_navbar-admin', 'top' );
		// Adding submenu to user_navbar-account
		$this->account_navbar( 'user_navbar-account', 'top' );
	}

	public function data_navbar( $parent, $position = 'top' )
	{
		$link	= 'data/layanan/';
		$nama	= str_replace('/', '_', $link);

		if ( count($this->app_data->get_moduls_array()) > 0 )
		{
			$this->baka_theme->add_navmenu( $parent, 'dashboard', 'link', 'dashboard', 'Statistik', array(), $position );
			// $this->baka_theme->add_navmenu( $parent, $nama.'laporan', 'link', 'data/utama/laporan', 'Laporan', array(), $position );
			$this->baka_theme->add_navmenu( $parent, $nama.'d', 'devider', '', '', array(), $position );

			foreach ($this->app_data->get_moduls_array() as $modul)
			{
				$this->baka_theme->add_navmenu(
					$parent,
					$nama.$modul['alias'],
					'link',
					$link.'index/'.$modul['link'],
					$modul['label'],
					array(),
					$position );
			}
		}
	}

	public function admin_navbar( $parent_id, $position )
	{
		// Internal settings sub-menu
		// =====================================================================
		// Adding skpd sub-menu (if permited)
		if ( is_permited('internal_skpd_manage') )
			$this->baka_theme->add_navmenu(
				$parent_id, 'ai_skpd', 'link', 'admin/internal/skpd', 'SKPD', array(), $position );

		// Adding application sub-menu (if permited)
		if ( is_permited('internal_application_manage') )
			$this->baka_theme->add_navmenu(
				$parent_id, 'ai_application', 'link', 'admin/internal/app', 'Aplikasi', array(), $position );

		// Adding security sub-menu (if permited)
		if ( is_permited('internal_security_manage') )
			$this->baka_theme->add_navmenu(
				$parent_id, 'ai_security', 'link', 'admin/internal/keamanan', 'Keamanan', array(), $position );

		// $this->baka_theme->add_navmenu(
		// $parent_id, 'ai_property', 'link', 'admin/internal/prop', 'Properti', array(), $position );

		// Users Management sub-menu (if permited)
		// =====================================================================
		// if ( is_permited('auth_manage') )
		// {
			// Adding Users menu header
			$this->baka_theme->add_navmenu( $parent_id, 'au_def', 'devider', '', '', array(), $position);
			$this->baka_theme->add_navmenu(
				$parent_id, 'au_head', 'header', '', 'Pengguna', array(), $position);
			
			// Adding Self Profile sub-menu
			$this->baka_theme->add_navmenu(
				$parent_id, 'au_me', 'link', 'profile', 'Profil Saya', array(), $position );

			// Adding Users sub-menu (if permited)
			if ( is_permited('auth_users_manage') )
				$this->baka_theme->add_navmenu(
					$parent_id, 'au_users', 'link', 'admin/pengguna/data', 'Semua Pengguna', array(), $position );

			// Adding Groups sub-menu (if permited)
			// if ( is_permited('auth_groups_manage') )
				$this->baka_theme->add_navmenu(
					$parent_id, 'au_groups', 'link', 'admin/pengguna/groups', 'Kelompok', array(), $position );

			// Adding Perms sub-menu (if permited)
			if ( is_permited('auth_perms_manage') )
				$this->baka_theme->add_navmenu(
					$parent_id, 'a_permission', 'link', 'admin/pengguna/permission', 'Hak akses', array(), $position );
		// }

		// Application Mantenances sub-menu
		// =====================================================================
		if ( is_permited('sys_manage') )
		{
			// Adding System sub-menu (if permited)
			$this->baka_theme->add_navmenu( $parent_id, 'ad_def', 'devider', '', '', array(), $position);
			$this->baka_theme->add_navmenu(
				$parent_id, 'ad_head', 'header', '', 'Perbaikan', array(), $position);

			// Adding Backup & Restore sub-menu (if permited)
			if ( is_permited('sys_backstore_manage') )
			{
				// Backup sub-menu
				$this->baka_theme->add_navmenu(
					$parent_id, 'ad_backup', 'link', 'admin/maintenance/dbbackup', 'Backup Database', array(), $position );
				// Restore sub-menu
				$this->baka_theme->add_navmenu(
					$parent_id, 'ad_restore', 'link', 'admin/maintenance/dbrestore', 'Restore Restore', array(), $position );
			}

			// Adding System Log sub-menu (if permited)
			if ( is_permited('sys_logs_manage') )
				$this->baka_theme->add_navmenu(
					$parent_id, 'ad_syslogs', 'link', 'admin/maintenance/syslogs', 'Aktifitas sistem', array(), $position );
		}
	}

	public function account_navbar( $parent_id, $position )
	{
		// Adding submenu to user navbar profile
		$this->baka_theme->add_navmenu( $parent_id, 'profilse', 'link', 'profile', $this->username, array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'user_s', 'devider', '', '', array(), $position);
		$this->baka_theme->add_navmenu( $parent_id, 'user_logout', 'link', 'logout', 'Logout', array(), $position );
	}
}

/* End of file App_main.php */
/* Location: ./application/models/aplikasi/App_main.php */