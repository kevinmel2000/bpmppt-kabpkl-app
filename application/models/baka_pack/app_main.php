<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_main extends CI_Model
{
	private $username;

	public $data_layanan = array();

	public function __construct()
	{
		parent::__construct();

		$this->username = $this->baka_auth->get_username();

		$this->initialize();

		log_message('debug', "#Baka_pack: Main Application model Class Initialized");
	}

	protected function initialize()
	{
		$this->load->model('baka_pack/app_data');

		$this->navbar();
	}

	public function navbar()
	{
		// Adding main navbar
		$this->baka_theme->add_navbar( 'main_navbar', 'navbar-nav' );
		// Adding user navbar
		$this->baka_theme->add_navbar( 'user_navbar', 'navbar-nav navbar-right' );

		// Adding dashboard menu to main navbar
		$this->baka_theme->add_navmenu( 'main_navbar', 'dashboard', 'link', 'dashboard', 'Dashboard' );
		// Adding data menu to main navbar
		$this->baka_theme->add_navmenu( 'main_navbar', 'master', 'link', 'data', 'Data Perijinan' );
		// Adding admin menu to main navbar
		$this->baka_theme->add_navmenu( 'main_navbar', 'admin', 'link', 'admin', 'Administrasi' );
		// Adding account menu to user navbar
		$this->baka_theme->add_navmenu( 'user_navbar', 'account', 'link', 'profile', $this->username );

		// Adding submenu to main_navbar-data
		$this->data_navbar( 'main_navbar-master', 'top' );
		// Adding submenu to main_navbar-admin
		$this->admin_navbar( 'main_navbar-admin', 'top' );
		// Adding submenu to user_navbar-account
		$this->account_navbar( 'user_navbar-account', 'top' );
	}

	public function data_navbar( $parent, $position = 'top' )
	{
		$link	= 'data/layanan/';
		$nama	= str_replace('/', '_', $link);

		$this->baka_theme->add_navmenu( $parent, 'dashboard', 'link', 'dashboard', 'Statistik', array(), $position );
		$this->baka_theme->add_navmenu( $parent, $nama.'laporan', 'link', 'data/utama/laporan', 'Laporan', array(), $position );
		$this->baka_theme->add_navmenu( $parent, $nama.'d', 'devider', '', '', array(), $position );

		foreach ($this->app_data->get_type_list() as $modul)
		{
			$layanan = $this->app_data->get_modul( $modul );

			$this->baka_theme->add_navmenu(
				$parent,
				$nama.$layanan['slug'],
				'link',
				$link.'ijin/'.$modul,
				$this->app_data->get_label( $modul ),
				array(),
				$position );

			$this->data_layanan[$layanan['slug']] = $layanan['nama'];
		}
	}

	public function admin_navbar( $parent_id, $position )
	{
		// ===========================
		$this->baka_theme->add_navmenu( $parent_id, 'ai_skpd', 'link', 'admin/internal/skpd', 'SKPD', array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'ai_application', 'link', 'admin/internal/app', 'Aplikasi', array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'ai_security', 'link', 'admin/internal/keamanan', 'Keamanan', array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'ai_property', 'link', 'admin/internal/prop', 'Properti', array(), $position );
		// ===========================
		$this->baka_theme->add_navmenu( $parent_id, 'au_def', 'devider', '', '', array(), $position);
		$this->baka_theme->add_navmenu( $parent_id, 'au_head', 'header', '', 'Pengguna', array(), $position);
		$this->baka_theme->add_navmenu( $parent_id, 'au_me', 'link', 'profile', 'Profil Saya', array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'au_users', 'link', 'admin/pengguna/data', 'Semua Pengguna', array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'au_groups', 'link', 'admin/pengguna/groups', 'Kelompok', array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'a_permission', 'link', 'admin/pengguna/permission', 'Hak akses', array(), $position );
		// ===========================
		$this->baka_theme->add_navmenu( $parent_id, 'ad_def', 'devider', '', '', array(), $position);
		$this->baka_theme->add_navmenu( $parent_id, 'ad_head', 'header', '', 'Perbaikan', array(), $position);
		$this->baka_theme->add_navmenu( $parent_id, 'ad_backup', 'link', 'admin/maintenance/dbbackup', 'Backup Database', array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'ad_restore', 'link', 'admin/maintenance/dbrestore', 'Restore Restore', array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'ad_syslogs', 'link', 'admin/maintenance/syslogs', 'Aktifitas sistem', array(), $position );
	}

	public function account_navbar( $parent_id, $position )
	{
		// Adding submenu to user navbar profile
		$this->baka_theme->add_navmenu( $parent_id, 'profilse', 'link', 'profile', $this->username, array(), $position );
		$this->baka_theme->add_navmenu( $parent_id, 'user_s', 'devider', '', '', array(), $position);
		$this->baka_theme->add_navmenu( $parent_id, 'user_logout', 'link', 'logout', 'Logout', array(), $position );
	}

	public function daftar_perijinan()
	{
		$ret = array();

		foreach (directory_map( APPPATH.'models/perijinan/') as $layanan)
		{
			$ret[] = strtolower(str_replace(EXT, '', $layanan));
		}

		return $ret;
	}
}

/* End of file App_main.php */
/* Location: ./application/models/aplikasi/App_main.php */