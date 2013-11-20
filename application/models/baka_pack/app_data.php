<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class App_data extends CI_Model
{
	// Direktori penyimpanan modul
	public $modul_dir 			= 'perijinan/';

	// Nama table
	private $_data_table		= 'data';
	private $_datameta_table	= 'data_meta';

	// Daftar modul
	private $_list = array();

	// Daftar tipe modul
	private $_type = array();

	public $app_modules = array();

	public $messages = array();

	// Default constructor class
	public function __construct()
	{
		parent::__construct();

		$this->load_moduls();

		log_message('debug', "#Baka_pack: Application data model Class Initialized");
	}

	/**
	 * Load all modules that available to logged in users
	 * 
	 * @return	void
	 */
	private function load_moduls()
	{
		if ( ! $this->load->is_loaded('directory') )
			$this->load->helper('directory');

		foreach ( directory_map( APPPATH.'models/'.$this->modul_dir ) as $modul_file)
		{
			if (substr($modul_file, 0, 1) !== '_')
				$modul_name = strtolower(str_replace(EXT, '', $modul_file));

			if ( $this->baka_auth->permit('doc_'.$modul_name.'_manage') )
			{
				if (!$this->load->is_loaded( $this->modul_dir.$modul_name ) )
					$this->load->model( $this->modul_dir.$modul_name );

				$modul	= $this->$modul_name;
				$kode	= (property_exists( $modul, 'kode' )) ? $modul->kode : FALSE;

				$this->app_modules[$modul_name] = array(
					'nama'	=> $modul->nama,
					'alias'	=> $modul->slug,
					'label'	=> $modul->nama.( $kode ? ' ('.$kode.')' : '' ),
					'kode'	=> $kode,
					'link'	=> $modul_name );
			}
		}
	}

	/**
	 * Get an accosiative array of modules
	 * 
	 * @return array
	 */
	public function get_modules_assoc()
	{
		$ret = array();

		foreach ( $this->app_modules as $modul )
			$ret[$modul['alias']] = $modul['nama'];

		return $ret;
	}

	/**
	 * Get all modules in array
	 * 
	 * @return array
	 */
	public function get_moduls_array()
	{
		return (array) $this->app_modules;
	}

	/**
	 * Get all modules in object
	 * 
	 * @return object
	 */
	public function get_modules_object()
	{
		return array_to_object( $this->app_modules );
	}

	/**
	 * Get modul data
	 * 
	 * @param  string
	 * @return mixed
	 */
	public function get_modul( $modul_name )
	{
		return $this->app_modules[$modul_name];
	}

	/**
	 * Get Module name
	 * 
	 * @param string $modul_name
	 */
	public function get_name( $modul_name )
	{
		return $this->app_modules[$modul_name]['nama'];
	}

	/**
	 * Get Module name
	 * 
	 * @param string $modul_name
	 */
	public function get_alias( $modul_name )
	{
		return $this->app_modules[$modul_name]['alias'];
	}

	/**
	 * Get Module name
	 * 
	 * @param string $modul_name
	 */
	public function get_code( $modul_name )
	{
		return $this->app_modules[$modul_name]['kode'];
	}

	/**
	 * Get Module name
	 * 
	 * @param string $modul_name
	 */
	public function get_label( $modul_name )
	{
		return $this->app_modules[$modul_name]['label'];
	}

	// get moduls list from dir
	public function get_type_list()
	{
		if ( ! $this->load->is_loaded('directory') )
			$this->load->helper('directory');

		$ret = array();

		foreach (directory_map( APPPATH.'models/'.$this->modul_dir) as $modul_name)
		{
			if (substr($modul_name, 0, 1) !== '_')
				$modul = strtolower(str_replace(EXT, '', $modul_name));

			if ( $this->baka_auth->permit('doc_'.$modul.'_manage') )
				$ret[] = $modul;
		}

		return $ret;
	}

	// get moduls associative list from dir
	public function get_type_list_assoc()
	{
		$ret = array();

		foreach ( $this->_list as $modul_name )
		{
			$ret[$modul_name] = $this->get_label($modul_name);
		}

		return $ret;
	}

	// get all moduls grid
	public function get_tables( $page_link = '' )
	{
		$output = array();

		foreach ( $this->get_modules_object() as $modul_obj )
		{
			$output[$modul_obj->alias] = $this->get_table( $modul_obj->link, $page_link.$modul_obj->link.'/' );
		}

		return $output;
	}

	// get single modul grid
	public function get_table( $modul_name = '', $page_link = '' )
	{
		$modul_slug = $this->get_alias( $modul_name );

		switch ( $this->uri->segment(6) ) {
			case 'status':
				$query = $this->get_data_by_status( $this->uri->segment(7), $modul_slug );
				break;
			
			case 'page':
				$query = $this->get_data_by_type( $modul_slug );
				break;
			
			default:
				$query = $this->get_data_by_type( $modul_slug );
				break;
		}

		$this->load->library('Baka_pack/baka_grid');

		$grid = $this->baka_grid->identifier('id')
								->set_baseurl($page_link)
								->set_column('Pengajuan', 'no_agenda, callback_format_datetime:created_on', '30%', FALSE, '<strong>%s</strong><br><small class="text-muted">Diajukan pada: %s</small>')
								->set_column('Pemohon', 'petitioner', '40%', FALSE, '<strong>%s</strong>')
								->set_column('Status', 'status, callback__x:status', '10%', FALSE, '<span class="label label-%s">%s</span>')
								->set_buttons('form/', 'eye-open', 'primary', 'Lihat data')
								->set_buttons('hapus/', 'trash', 'danger', 'Hapus data');

		return $grid->make_table( $query );
		// return $query;
	}

	public function get_print( $modul_name, $data_id )
	{
		$data['skpd_name']		= get_app_setting('skpd_name');
		$data['skpd_address']	= get_app_setting('skpd_address');
		$data['skpd_city']		= get_app_setting('skpd_city');
		$data['skpd_prov']		= get_app_setting('skpd_prov');
		$data['skpd_telp']		= get_app_setting('skpd_telp');
		$data['skpd_fax']		= get_app_setting('skpd_fax');
		$data['skpd_pos']		= get_app_setting('skpd_pos');
		$data['skpd_web']		= get_app_setting('skpd_web');
		$data['skpd_email']		= get_app_setting('skpd_email');
		$data['skpd_logo']		= get_app_setting('skpd_logo');

		foreach ( $this->get_fulldata_by_id( $data_id ) as $field => $value )
		{
			$data[$field] = $value;
		}
		
		return $data;
	}

	// get full data by id
	public function get_fulldata_by_id( $data_id )
	{
		if ($data = $this->get_data_by_id( $data_id ))
		{
			$meta = $this->get_datameta( $data_id, $data->type );

			return (object) array_merge( (array) $data, (array) $meta );
		}
	}

	// get data by id
	public function get_data_by_id( $data_id )
	{
		return $this->_get_where( $this->_data_table, array( 'id' => $data_id ) );
	}

	// get data by type
	public function get_data_by_type( $modul_name )
	{
		return $this->db->get_where($this->_data_table, array('type' => $modul_name));
	}

	// get data by label
	public function get_data_by_status( $data_status, $modul_name = '' )
	{
		if ( $data_status != 'semua' )
			$where['status'] = $data_status;

		if ($modul_name != '')
			$where['type'] = $modul_name;

		return $this->db->get_where( $this->_data_table, $where );
	}

	// get data by author
	public function get_data_by_author( $data_created_by, $modul_name = '' )
	{
		$where['created_by'] = $data_created_by;

		if ($modul_name != '')
			$where['type'] = $modul_name;

		return $this->_get_where( $this->_data_table, $where );
	}

	// get data by label
	public function get_data_by_label( $data_label, $modul_name = '' )
	{
		$where['label'] = $data_label;

		if ($modul_name != '')
			$where['type'] = $modul_name;

		return $this->_get_where( $this->_data_table, $where );
	}

	// get data by petitioner
	public function get_data_by_petitioner( $data_petitioner, $modul_name = '' )
	{
		$where['petitioner'] = $data_petitioner;

		if ($modul_name != '')
			$where['type'] = $modul_name;

		return $this->_get_where( $this->_data_table, $where );
	}

	// find data by petitioner
	public function find_data_by_petitioner( $data_petitioner, $modul_name = '' )
	{
		if ($modul_name != '')
			$this->db->where('type', $modul_name);

		$this->db->like('petitioner', $data_petitioner);

		return $this->db->get($this->_data_table);
	}

	// find datameta by key
	public function find_data_by_meta_value( $modul_name, $datameta_key, $datameta_value )
	{
		return $this->db->where('data_type', $modul_name)
						->where('meta_key', $datameta_key)
						->like('meta_value', $datameta_value)
						->group_by('data_id')
						->get($this->_datameta_table);
	}

	// count data
	public function count_data( $module_alias = '' )
	{
		$out = NULL;

		if ( $module_alias == '' )
		{
			foreach ( $this->get_modules_assoc() as $alias => $name )
			{
				$out[$alias] = $this->count_data( $alias );
			}
		}
		else
		{
			$out = $this->db->where('type', $module_alias)
							->count_all_results($this->_data_table);
		}

		return $out;
	}

	// get datameta
	public function get_datameta( $data_id, $modul_name )
	{
		if ($query = $this->db->get_where( $this->_datameta_table, array( 'data_id' => $data_id, 'data_type' => $modul_name ) ))
		{
			$obj	= new stdClass;

			foreach ( $query->result() as $row )
			{
				$meta_key = str_replace($modul_name.'_', '', $row->meta_key);
				$obj->{$meta_key} = $row->meta_value;
			}

			return $obj;
		}

		return FALSE;
	}

	public function create_data( $modul_name, $form_data )
	{
		$data['no_agenda']	= $form_data[$modul_name.'_surat_nomor'];
		$data['created_on']	= string_to_datetime();
		$data['created_by']	= $this->baka_auth->get_user_id();
		$data['type']		= $modul_name;
		$data['label']		= '-';
		$data['petitioner']	= $form_data[$modul_name.'_pemohon_nama'];
		$data['status']		= 'pending';
		$data['desc']		= '';

		if ( $this->db->insert( $this->_data_table, $data ) )
		{
			$data_id = $this->db->insert_id();

			if ( $this->_create_datameta( $data_id, $modul_name, $form_data ) )
			{
				$this->messages['success'] = array('Permohonan dari saudara/i '.$data[$petitioner].' berhasil disimpan.', 'Klik cetak jika anda ingin langsung mencetaknya.');

				return $data_id;
			}
		}
		else
		{
			$this->messages['error'] =  'Terjadi kegagalan penginputan data.' ;

			return FALSE;
		}
	}

	public function delete_data( $data_id, $modul_name )
	{
		if ( $data = $this->db->delete( $this->_data_table, array( 'id' => $data_id, 'type' => $this->get_alias($modul_name) ) ) )
		{
			if ( $this->db->delete( $this->_datameta_table, array( 'data_id' => $data->id, 'data_type' => $data->type ) ) )
			{
				$this->messages['success'] = 'Data dengan id #'.$data_id.' berhasil dihapus.';

				return TRUE;
			}
		}
		else
		{
			$this->messages['error'] = 'Terjadi kegagalan penghapusan data.';

			return FALSE;
		}
	}

	public function change_status( $data_id, $new_status )
	{
		$this->db->update( $this->_data_table,
			array('status' => $new_status, $new_status.'_on' => string_to_datetime()),
			array('id' => $data_id) );

		$this->_write_datalog( $data_id, 'Mengubah status dokumen menjadi '._x('status_'.$new_status) );

		return $this->db->affected_rows() > 0;
	}

	/**
	 * Update datameta for a new user
	 *
	 * @param	int
	 * @return	bool
	 */
	public function update_datameta( $data_id, $modul_name, $meta_key, $meta_value )
	{
		$this->db->update(  $this->_datameta_table,
							array( 'meta_value' => $meta_value ),
							array( 'data_id' => $data_id, 'data_type' => $modul_name, 'meta_key' => $meta_key ) );
	}

	/**
	 * Create an empty datameta for a new user
	 *
	 * @param	int
	 * @return	bool
	 */
	private function _create_datameta( $data_id, $modul_name, $meta_fields )
	{
		$this->db->trans_start();

		foreach ($meta_fields as $meta_key => $meta_value)
		{
			$this->db->insert( $this->_datameta_table, array(
				'data_id'	=> $data_id,
				'data_type'	=> $modul_name,
				'meta_key'	=> $meta_key,
				'meta_value'=> $meta_value ) );
		}

		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	private function _get_where( $table_name, $wheres )
	{
		$query = $this->db->get_where( $table_name, $wheres );

		if ( $query->num_rows() == 1 )
			return $query->row();

		return NULL;
	}

	private function _write_datalog( $data_id, $log_message )
	{
		$data = $this->db->get_where( $this->_data_table, array('id' => $data_id) )->row();

		$log[] = array(
			'user_id'	=> $this->baka_auth->get_user_id(),
			'date'		=> string_to_datetime(),
			'message'	=> $log_message,
			);

		if ( !is_null( $data->logs ) )
		{
			$log = array_merge( unserialize( $data->logs ), $log );
		}

		$this->db->update( $this->_data_table,
			array( 'logs' => serialize( $log ) ),
			array( 'id' => $data_id ) );
	}
}

/* End of file App_data.php */
/* Location: ./application/models/Baka_pack/App_data.php */