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

	// Default constructor class
	public function __construct()
	{
		parent::__construct();

		$this->_list = $this->get_type_list();

		$this->initialize();

		log_message('debug', "App_data model Class Initialized");
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

	// get modul name
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
	public function get_form( $data_model, $data_id = '', $link )
	{
		$form = $this->baka_form->add_form( current_url(), $data_model )
								->add_fields( $this->$data_model->form( $data_id ) );

		if ( $form->validate_submition() )
		{
			if ( $this->create_data( $this->get_slug($data_model), $form->submited_data() ) )
			{
				redirect( $link );
			}
		}

		return $form->render();
	}

	// get all moduls grid
	public function get_grids()
	{
		foreach ( $this->_list as $data )
		{
			$output[$data] = $this->get_grid( $data );
		}

		return $output;
	}

	// get single modul grid
	public function get_grid( $data_model = '', $form_link = '', $delete_link = '' )
	{
		$query = $this->get_data_by_type( $this->get_slug( $data_model ) );

		if ( ! $this->load->is_loaded('table'))
			$this->load->library('table');

		if ( $query->num_rows() > 0 )
		{
			$head1 = array( 'data'	=> anchor('somelink', 'ID'),
							'class'	=> 'head-id',
							'width'	=> '10%' );

			$head2 = array( 'data'	=> anchor('somelink', 'Pengajuan'),
							'class'	=> 'head-value',
							'width'	=> '30%' );

			$head3 = array( 'data'	=> anchor('somelink', 'Pemohon'),
							'class'	=> 'head-value',
							'width'	=> '30%' );

			$head4 = array( 'data'	=> 'Status',
							'class'	=> 'head-status',
							'width'	=> '10%' );

			$head5 = array( 'data'	=> 'Aksi',
							'class'	=> 'head-action',
							'width'	=> '20%' );

			$this->table->set_heading( $head1, $head2, $head3, $head4, $head5);

			foreach ( $query->result() as $row )
			{
				$col_1 = array( 'data'	=> anchor($form_link.'/'.$row->id, '#'.$row->id),
								'class'	=> 'data-id',
								'width'	=> '5%' );

				$col_2 = array( 'data'	=> '<strong>'.anchor($form_link.'/'.$row->id, 'No. '.$row->no_agenda).'</strong><br><small class="text-muted">'.format_datetime($row->created_on).'</small>',
								'class'	=> 'data-value',
								'width'	=> '30%' );

				$col_3 = array( 'data'	=> '<strong>'.$row->petitioner.'</strong><br><small class="text-muted">'.format_datetime($row->adopted_on).'</small>',
								'class'	=> 'data-value',
								'width'	=> '30%' );

				$col_4 = array( 'data'	=> $row->status,
								'class'	=> '',
								'width'	=> '15%' );

				$class = 'class="btn btn-default btn-sm"';

				$col_5 = array( 'data'	=> '<div class="btn-group btn-group-justified">'.anchor($form_link.'/'.$row->id, 'Edit', $class ).anchor($delete_link.'/'.$row->id, 'Hapus', $class).'</div>',
								'class'	=> 'data-action',
								'width'	=> '20%' );

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
				$obj->{$row->meta_key} = $row->meta_value;
			}

			return $obj;
		}

		return FALSE;
	}

	public function create_data( $data_type, $submited_data )
	{
		$petitioner	= $data_type.'_pemohon_nama';
		$no_agenda	= $data_type.'_surat_nomor';

		$data['no_agenda']	= $submited_data[$no_agenda];
		$data['created_on']	= string_to_datetime();
		$data['created_by']	= 1;
		$data['type']		= $data_type;
		$data['label']		= '-';
		$data['petitioner']	= $submited_data[$petitioner];
		$data['adopted_on']	= string_to_datetime();
		$data['status']		= 'pending';
		$data['desc']		= '';

		if ( $this->db->insert( $this->_data_table, $data ) )
		{
			$data_id = $this->db->insert_id();

			if ( $this->_create_datameta( $data_id, $data_type, $submited_data ) )
			{
				$this->message[] = 'Permohonan dari saudara/i '.$submited_data[$petitioner].' berhasil disimpan.';

				log_message('debug', 'Berhasil membuat data meta untuk permohonan #'.$data_id);

				return $data_id;
			}
		}
		else
		{
			$this->errors[] = 'Terjadi kegagalan penginputan data.';

			return FALSE;
		}
	}

	public function delete_data( $data_id, $data_type )
	{
		if ( $data = $this->db->delete( $this->_data_table, array( 'id' => $data_id, 'type' => $this->get_slug( $data_type ) ) ) )
		{
			if ( $this->_delete_datameta( $data_id, $data_type ) )
			{
				$this->message[] = 'Permohonan dari saudara/i '.$submited_data[$petitioner].' berhasil disimpan.';

				log_message('debug', 'Berhasil membuat data meta untuk permohonan #'.$data_id);

				return $this;
			}
		}
		else
		{
			$this->errors[] = 'Terjadi kegagalan penghapusan data.';

			return FALSE;
		}
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

		if ( $this->db->insert_batch( $this->_datameta_table, $meta_data ) )
		{
			log_message('debug', 'Berhasil membuat data meta untuk permohonan #'.$data_id);
		}
		else
		{
			$this->errors[] = 'Terjadi kegagalan penginputan data.';
			return ;
		}

	}

	/**
	 * Delete user datameta
	 *
	 * @param	int
	 * @return	void
	 */
	private function _delete_datameta( $data_id, $data_type )
	{
		$this->db->delete( $this->_datameta_table, array( 'data_id' => $data_id, 'data_type' => $data_type ) );
	}

	private function _get_where( $table_name, $wheres )
	{
		$query = $this->db->get_where( $table_name, $wheres );

		if ( $query->num_rows() == 1 )
			return $query->row();

		return NULL;
	}
}

/* End of file App_data.php */
/* Location: ./application/models/Baka_pack/App_data.php */