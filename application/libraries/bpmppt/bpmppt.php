<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BAKA Form Validation Class
 *
 * Pre-processes global input data for security
 * Extending native CI Form Validation
 *
 * @package		BPMPPT
 * @subpackage	Libraries
 * @category	Validation
 * @author		Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @license		GNU GPL v3 license. See file COPYRIGHT for details.
 */
class bpmppt
{
	// Base CI Instances
	private $ci;

	// Table declaration
	private $data_table;
	private $datameta_table;

	// Modules
	private $modules = array();

	// Message wrapper
	private $messages = array();

	/**
	 * Base class constructor
	 */
	public function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->config('bpmppt', true);

		$this->data_table = config_item( 'bpmppt_data_table', 'bpmppt' );
		$this->datameta_table = config_item( 'bpmppt_datameta_table', 'bpmppt' );

		$this->initialize();

		log_message('debug', "#BPMPPT: Main class loaded");
	}

	/**
	 * Initializing sub 'perizinan' class
	 * @return void
	 */
	private function initialize()
	{
		if ( ! $this->ci->load->is_loaded('directory') )
			$this->ci->load->helper('directory');

		$modules_dir = dirname(__FILE__).'/perijinan/';

		foreach ( directory_map( $modules_dir ) as $module_file )
		{
			if ( substr( $module_file, 0, 1 ) !== '_' )
				$module_name = strtolower(str_replace(EXT, '', $module_file));

			if ( $this->ci->baka_auth->permit('doc_'.$module_name.'_manage') )
			{
				require_once $modules_dir.$module_name.EXT;

				if ( class_exists( $module_name ) )
					$this->$module_name = new $module_name;
			}

			$this->modules = new bakaObject;

			$kode = ( property_exists( $module_name, 'kode' ) )
				? $module_name->kode
				: FALSE;

			$this->modules->$module_name = array(
				'nama'	=> $module_name->nama,
				'alias'	=> $module_name->slug,
				'label'	=> $module_name->nama.( $kode ? ' ('.$kode.')' : '' ),
				'kode'	=> $kode,
				'link'	=> $module_name );
		}
	}

	/**
	 * Get modules property in accociative array
	 *
	 * @param	string
	 * @param	string
	 * @return	array
	 */
	public function get_modules_assoc( $key = '', $val = '' )
	{
		$ret = array();
		$key || $key = 'alias';
		$val || $val = 'nama';

		foreach ( $this->modules as $modul )
			$ret[$modul[$key]] = $modul[$val];

		return $ret;
	}

	/**
	 * Get all modules as is
	 * 
	 * @return array
	 */
	public function get_moduls_array()
	{
		return (array) $this->modules;
	}

	/**
	 * Get all modules in object
	 * 
	 * @return object
	 */
	public function get_modules_object()
	{
		return array_to_object( $this->modules );
	}

	/**
	 * Get modul data
	 * 
	 * @param  string
	 * @return mixed
	 */
	public function get_module( $module_name )
	{
		return $this->modules->$module_name;
	}

	/**
	 * Get Module name
	 * 
	 * @param string $module_name
	 */
	public function get_name( $module_name )
	{
		return $this->modules->$module_name['nama'];
	}

	/**
	 * Get Module alias
	 * 
	 * @param string $module_name
	 */
	public function get_alias( $module_name )
	{
		return $this->modules->$module_name['alias'];
	}

	/**
	 * Get Module code
	 * 
	 * @param string $module_name
	 */
	public function get_code( $module_name )
	{
		return $this->modules->$module_name['kode'];
	}

	/**
	 * Get Module label
	 * 
	 * @param string $module_name
	 */
	public function get_label( $module_name )
	{
		return $this->modules->$module_name['label'];
	}

	/**
	 * Get Module link
	 * 
	 * @param string $module_name
	 */
	public function get_link( $module_name )
	{
		return $this->modules->$module_name['link'];
	}

	// get single modul grid
	public function get_grid( $module_name = '', $page_link = '' )
	{
		$slug = $this->get_alias( $module_name );

		switch ( $this->uri->segment(6) ) {
			case 'status':
				$query = $this->get_data_by_status( $this->uri->segment(7), $slug );
				break;
			
			case 'page':
				$query = $this->get_data_by_type( $slug );
				break;
			
			default:
				$query = $this->get_data_by_type( $slug );
				break;
		}

		$this->ci->load->library('Baka_pack/baka_grid');

		$grid = $this->baka_grid->identifier('id')
								->set_baseurl($page_link)
								->set_column('Pengajuan',
									'no_agenda, callback_format_datetime:created_on',
									'30%',
									FALSE,
									'<strong>%s</strong><br><small class="text-muted">Diajukan pada: %s</small>')
								->set_column('Pemohon', 'petitioner', '40%', FALSE, '<strong>%s</strong>')
								->set_column('Status', 'status, callback__x:status', '10%', FALSE, '<span class="label label-%s">%s</span>');

		if ( !$this->_dashboard_view )
		{
			$grid->set_buttons('form/', 'eye-open', 'primary', 'Lihat data')
				 ->set_buttons('hapus/', 'trash', 'danger', 'Hapus data');
		}

		return $grid->make_table( $query );
	}

	public function get_skpd_props()
	{
		$prop = array(
				'skpd_name', 'skpd_address', 'skpd_city', 'skpd_prov',
				'skpd_telp', 'skpd_fax', 'skpd_pos', 'skpd_web', 'skpd_email',
				'skpd_logo','skpd_lead_name','skpd_lead_nip'
				);

		foreach ( $prop as $property )
		{
			$data[$property] = get_app_setting( $property );
		}

		return $data;
	}
}

/* End of file bpmppt.php */
/* Location: ./libraries/bpmppt/bpmppt.php */