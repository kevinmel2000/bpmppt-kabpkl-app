<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class App_data extends CI_Model
{
	// Direktori penyimpanan modul
	private $_data_dir = 'perijinan/';

	// Nama table
	private $_data_table		= 'data';
	private $_datameta_table	= 'data_meta';

	// Daftar modul
	private $_list = array();

	// Daftar tipe modul
	private $_type = array();

	private $_messages = array();

	// Default constructor class
	public function __construct()
	{
		parent::__construct();

		$this->_list = $this->get_type_list();

		$this->initialize();

		log_message('debug', "#Baka_pack: Application data model Class Initialized");
	}

	// Loading moduls
	public function initialize()
	{
		foreach ( $this->_list as $data )
		{
			if (!$this->load->is_loaded( $this->_data_dir.$data ) )
				$this->load->model( $this->_data_dir.$data );

			$this->_type[$data]['slug'] = ( property_exists($this->$data, 'slug') ? $this->$data->slug : NULL );
			$this->_type[$data]['code'] = ( property_exists($this->$data, 'kode') ? $this->$data->kode : NULL );
			$this->_type[$data]['name'] = ( property_exists($this->$data, 'nama') ? $this->$data->nama : NULL );
		}
	}

	/**
	 * Mendapatkan nama model
	 * 
	 * @param string $data_model
	 */
	public function get_name( $data_model )
	{
		return $this->_type[$data_model]['name'];
	}

	// get modul code
	public function get_code( $data_model )
	{
		return $this->_type[$data_model]['code'];
	}

	// get modul slug
	public function get_slug( $data_model )
	{
		return $this->_type[$data_model]['slug'];
	}

	// get moduls list from dir
	public function get_type_list()
	{
		$this->load->helper('directory');
		$ret = array();

		foreach (directory_map( APPPATH.'models/'.$this->_data_dir) as $data_model)
		{
			if (substr($data_model, 0, 1) !== '_')
				$ret[] = strtolower(str_replace(EXT, '', $data_model));
		}

		return $ret;
	}

	// get moduls associative list from dir
	public function get_type_list_assoc()
	{
		$ret = array();

		foreach ( $this->_list as $data_model )
		{
			$name = $this->get_name( $data_model );

			if ( $this->get_code( $data_model ) !== NULL)
				$name .= ' ('.$this->get_code( $data_model ).')';

			$ret[$data_model] = $name;
		}

		return $ret;
	}

	// get all moduls form
	public function get_forms()
	{
		foreach ( $this->_list as $data )
		{
			$output[$data] = $this->get_single_form( $data );
		}

		return $output;
	}

	// get single modul form
	public function get_form( $data_model, $data_id = NULL, $link )
	{
		$data_type	= $this->get_slug( $data_model );
		$data_obj	= ( $data_id != '' ? $this->app_data->get_fulldata_by_id( $data_id ) : NULL );

		if ( ! is_null($data_id) )
		{
			$status	= $data_obj->status;
			$date	= ( $status != 'pending' ? ' pada: '.format_datetime( $data_obj->{$status.'_on'} ) : '' );

			$fields[]	= array(
				'name'	=> $data_type.'_pemohon_jabatan',
				'label'	=> 'Status Pengajuan',
				'type'	=> 'static',
				'std'	=> '<span class="label label-'.$status.'">'._x('status_'.$status).'</span>'.$date );
		}

		$fields[]	= array(
			'name'	=> $data_type.'_surat',
			'label'	=> 'Nomor &amp; Tanggal Permohonan',
			'type'	=> 'subfield',
			'attr'	=> ( ! is_null($data_id) ? 'disabled' : ''),
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'nomor',
					'label'	=> 'Nomor',
					'type'	=> 'text',
					'std'	=> ( ! is_null($data_id) ? $data_obj->surat_nomor : ''),
					'validation'=> 'required' ),
				array(
					'col'	=> '6',
					'name'	=> 'tanggal',
					'label'	=> 'Tanggal',
					'type'	=> 'datepicker',
					'std'	=> ( ! is_null($data_id) ? format_date( $data_obj->surat_tanggal ) : ''),
					'validation'=> 'required',
					'callback'=> 'string_to_date' ),
				)
			);

		$form = $this->baka_form->add_form( current_url(), $data_model )
								->add_fields( array_merge( $fields, $this->$data_model->form( $data_obj )) );

		if ( $data_id != '' )
			$form->disable_buttons();

		if ( $form->validate_submition() )
		{
			$form_data	= $form->submited_data();

			if ( $data = $this->create_data( $data_type, $form_data ) )
			{
				$this->session->set_flashdata( 'success', $this->_messages['success'] );
			}
			else
			{
				$this->session->set_flashdata( 'error', $this->_messages['error'] );
			}

			return redirect( $link.'/'.$data );
		}
		else
		{
			$this->session->set_flashdata( 'error', $form->validation_errors() );

			return $form->render();
		}
	}

	// get all moduls grid
	public function get_tables( $page_link = '' )
	{
		foreach ( $this->_list as $data )
		{
			$output[$data] = $this->get_table( $data, $page_link.'ijin/'.$data.'/' );
		}

		return $output;
	}

	// get single modul grid
	public function get_table( $data_model = '', $page_link = '' )
	{
		$data_type = $this->get_slug( $data_model );

		switch ( $this->uri->segment(6) ) {
			case 'status':
				$query = $this->get_data_by_status( $this->uri->segment(7), $data_type );
				break;
			
			case 'page':
				$query = $this->get_data_by_type( $data_type );
				break;
			
			default:
				$query = $this->get_data_by_type( $data_type );
				break;
		}

		if ( ! $this->load->is_loaded('table'))
			$this->load->library('table');

		if ( $query->num_rows() > 0 )
		{
			$head1 = array( 'data'	=> 'ID',
							'class'	=> 'head-id',
							'width'	=> '5%' );

			$head2 = array( 'data'	=> 'Pengajuan',
							'class'	=> 'head-value',
							'width'	=> '30%' );

			$head3 = array( 'data'	=> 'Pemohon',
							'class'	=> 'head-value',
							'width'	=> '40%' );

			$head4 = array( 'data'	=> 'Status',
							'class'	=> 'head-status',
							'width'	=> '10%' );

			$head5 = array( 'data'	=> 'Aksi',
							'class'	=> 'head-action',
							'width'	=> '15%' );

			$this->table->set_heading( $head1, $head2, $head3, $head4, $head5);

			foreach ( $query->result() as $row )
			{
				$col_1 = array( 'data'	=> anchor($page_link.'form/'.$row->id, '#'.$row->id),
								'class'	=> 'data-id',
								'width'	=> '5%' );

				$col_2 = array( 'data'	=> '<strong>'.anchor($page_link.'form/'.$row->id, 'No. '.$row->no_agenda).'</strong><br><small class="text-muted">Diajukan pada: '.format_datetime($row->created_on).'</small>',
								'class'	=> 'data-value',
								'width'	=> '30%' );

				$status = $row->status;

				$col_3 = array( 'data'	=> '<strong>'.$row->petitioner.'</strong>'.( $status != 'pending' ? '<br><small class="text-muted">'._x('status_'.$status).' pada: '.format_datetime( $row->{$status.'_on'} ).'</small>' : '' ),
								'class'	=> 'data-value',
								'width'	=> '40%' );

				$col_4 = array( 'data'	=> '<span class="label label-'.$status.'">'._x('status_'.$status).'</span>',
								'class'	=> '',
								'width'	=> '10%' );

				$class = 'btn btn-sm';

				$col_5 = array( 'data'	=> '<div class="btn-group btn-group-justified">'
											.anchor($page_link.'form/'.$row->id, '<span class="glyphicon glyphicon-eye-open">', 'title="Lihat data" class="bs-tooltip btn-primary '.$class.'"' )
											.anchor($page_link.'delete/'.$row->id, '<span class="glyphicon glyphicon-trash">', 'title="Hapus data" class="bs-tooltip btn-danger '.$class.'"')
											.'</div>',
								'class'	=> 'data-action',
								'width'	=> '15%' );

				$this->table->add_row( $col_1, $col_2, $col_3, $col_4, $col_5 );
			}
		}
		else
		{
			$this->table->add_row( array( 
				'data'		=> '<span class="text-muted text-center">'.$this->get_name( $data_model ).' belum memiliki data apapun</span>',
				'class'		=> 'active',
				'colspan'	=> 5 ));
		}

		$this->table->set_template( array('table_open' => '<table class="table table-striped table-hover table-condensed">' ) );

		$generate = $this->table->generate();

		$this->table->clear();

		return $generate;
		// return $query;
	}

	public function get_print( $data_type, $data_id )
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
	public function get_data_by_type( $data_type )
	{
		return $this->db->get_where($this->_data_table, array('type' => $data_type));
	}

	// get data by label
	public function get_data_by_status( $data_status, $data_type = '' )
	{
		if ( $data_status != 'semua' )
			$where['status'] = $data_status;

		if ($data_type != '')
			$where['type'] = $data_type;

		return $this->db->get_where( $this->_data_table, $where );
	}

	// get data by author
	public function get_data_by_author( $data_created_by, $data_type = '' )
	{
		$where['created_by'] = $data_created_by;

		if ($data_type != '')
			$where['type'] = $data_type;

		return $this->_get_where( $this->_data_table, $where );
	}

	// get data by label
	public function get_data_by_label( $data_label, $data_type = '' )
	{
		$where['label'] = $data_label;

		if ($data_type != '')
			$where['type'] = $data_type;

		return $this->_get_where( $this->_data_table, $where );
	}

	// get data by petitioner
	public function get_data_by_petitioner( $data_petitioner, $data_type = '' )
	{
		$where['petitioner'] = $data_petitioner;

		if ($data_type != '')
			$where['type'] = $data_type;

		return $this->_get_where( $this->_data_table, $where );
	}

	// find data by petitioner
	public function find_data_by_petitioner( $data_petitioner, $data_type = '' )
	{
		if ($data_type != '')
			$this->db->where('type', $data_type);

		$this->db->like('petitioner', $data_petitioner);

		return $this->db->get($this->_data_table);
	}

	// find datameta by key
	public function find_data_by_meta_value( $data_type, $datameta_key, $datameta_value )
	{
		return $this->db->where('data_type', $data_type)
						->where('meta_key', $datameta_key)
						->like('meta_value', $datameta_value)
						->group_by('data_id')
						->get($this->_datameta_table);
	}

	// count data
	public function count_data( $data_type = '' )
	{
		if ( $data_type == '' )
		{
			foreach ( $this->_list as $data )
			{
				$out[$data] = $this->count_data( $data );
			}
		}
		else
		{
			$out = $this->db->where('type', $this->get_slug( $data_type ))
							  ->count_all_results($this->_data_table);
		}

		return $out;
	}

	// get datameta
	public function get_datameta( $data_id, $data_type )
	{
		if ($query = $this->db->get_where( $this->_datameta_table, array( 'data_id' => $data_id, 'data_type' => $data_type ) ))
		{
			$obj	= new stdClass;

			foreach ( $query->result() as $row )
			{
				$meta_key = str_replace($data_type.'_', '', $row->meta_key);
				$obj->{$meta_key} = $row->meta_value;
			}

			return $obj;
		}

		return FALSE;
	}

	public function create_data( $data_type, $form_data )
	{
		$data['no_agenda']	= $form_data[$data_type.'_surat_nomor'];
		$data['created_on']	= string_to_datetime();
		$data['created_by']	= $this->baka_auth->get_user_id();
		$data['type']		= $data_type;
		$data['label']		= '-';
		$data['petitioner']	= $form_data[$data_type.'_pemohon_nama'];
		$data['status']		= 'pending';
		$data['desc']		= '';

		if ( $this->db->insert( $this->_data_table, $data ) )
		{
			$data_id = $this->db->insert_id();

			if ( $this->_create_datameta( $data_id, $data_type, $form_data ) )
			{
				$this->_messages['success'] = 'Permohonan dari saudara/i '.$form_data[$petitioner].' berhasil disimpan.';

				return $data_id;
			}
		}
		else
		{
			$this->_messages['error'] =  'Terjadi kegagalan penginputan data.' ;

			return FALSE;
		}
	}

	public function delete_data( $data_id, $data_type )
	{
		if ( $data = $this->db->delete( $this->_data_table, array( 'id' => $data_id, 'type' => $this->get_slug( $data_type ) ) ) )
		{
			if ( $this->db->delete( $this->_datameta_table, array( 'data_id' => $data_id, 'data_type' => $data_type ) ) )
			{
				$this->_messages['success'] = 'Data dengan id #'.$data_id.' berhasil dihapus.';

				return TRUE;
			}
		}
		else
		{
			$this->_messages['error'] = 'Terjadi kegagalan penghapusan data.';

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
	public function update_datameta( $data_id, $data_type, $meta_key, $meta_value )
	{
		$this->db->update(  $this->_datameta_table,
							array( 'meta_value' => $meta_value ),
							array( 'data_id' => $data_id, 'data_type' => $data_type, 'meta_key' => $meta_key ) );
	}

	/**
	 * Create an empty datameta for a new user
	 *
	 * @param	int
	 * @return	bool
	 */
	private function _create_datameta( $data_id, $data_type, $meta_fields )
	{
		$i = 0;
		$meta_data = array();

		foreach ($meta_fields as $meta_key => $meta_value)
		{
			$meta_data[$i]['data_id']	= $data_id;
			$meta_data[$i]['data_type']	= $data_type;
			$meta_data[$i]['meta_key']	= $meta_key;
			$meta_data[$i]['meta_value']= $meta_value;

			$i++;
		}

		return $this->db->insert_batch( $this->_datameta_table, $meta_data );
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