<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bpmppt_model extends CI_Model
{
	/**
	 * Tables name declaration
	 * @var string
	 */
	private $_data_table		= 'data';
	private $_datameta_table	= 'data_meta';

	/**
	 * Messages wrapper
	 * @var array
	 */
	private $_messages = array();

	/**
	 * base class constructor
	 */
	public function __construct()
	{
		parent::__construct();

		log_message('debug', "#BPMPPT: model class loaded");
	}

	/**
	 * Get data
	 * 
	 * @param	string	$data_type	Data type
	 * @param	array	$where		Data filter
	 * @return	object
	 */
	public function get_data( $data_type, $wheres = array() )
	{
		$wheres['type'] = $data_type;

		$query = $this->db->from( $this->_data_table );

		if ( !isset($wheres['status']) )
			$query->where_not_in( 'status', array('deleted') );

		foreach ( $wheres as $field => $value )
			$query->where( $field, $value );

		return $query;
	}

	/**
	 * get data by id
	 * @param  integer $data_id Data id
	 * @return mixed            Data object from ID
	 */
	public function get_data_by_id( $data_id )
	{
		return $this->db->get_where( $this->_data_table, array('id' => $data_id) )->row();
	}

	// get data by type
	public function get_data_by_type( $module_name )
	{
		return $this->get_where( array( 'type' => $module_name ) );
	}

	// get data by label
	public function get_data_by_status( $data_status, $module_name = '' )
	{
		if ( $data_status != 'semua' )
			$where['status'] = $data_status;

		if ($module_name != '')
			$where['type'] = $module_name;

		return $this->get_where( $where );
	}

	// get data by author
	public function get_data_by_author( $data_created_by, $module_name = '' )
	{
		$where['created_by'] = $data_created_by;

		if ($module_name != '')
			$where['type'] = $module_name;

		return $this->get_where( $where );
	}

	// get data by petitioner
	public function get_data_by_petitioner( $data_petitioner, $module_name = '' )
	{
		$where['petitioner'] = $data_petitioner;

		if ($module_name != '')
			$where['type'] = $module_name;

		return $this->get_where( $where );
	}

	// find data by petitioner
	public function find_data_by_petitioner( $data_petitioner, $module_name = '' )
	{
		if ($module_name != '')
			$this->db->where('type', $module_name);

		$this->db->like('petitioner', $data_petitioner);

		return $this->db->get($this->_data_table);
	}

	public function get_report( $data_type, $filter )
	{
		$wheres['type']		= $data_type;
		$wheres['status']	= $filter['data_status'];
		$wheres['month']	= $filter['data_date_month'];
		$wheres['year']		= $filter['data_date_year'];

		return $this->get_where( $wheres );
	}

	public function get_where( $wheres, $is_single = FALSE )
	{
		if ( isset($wheres['month']) )
		{
			$wheres['MONTH(created_on)'] = $wheres['month'];
			unset($wheres['month']);
		}

		if ( isset($wheres['year']) )
		{
			$wheres['YEAR(created_on)'] = $wheres['year'];
			unset($wheres['year']);
		}

		$query = $this->db->get_where($this->_data_table, $wheres);

		if ( $is_single )
		{
			return ( $query->num_rows() == 1 )
				? $query->row()
				: FALSE;
		}
		else
		{
			return $query;
		}

	}

	// find datameta by key
	public function find_data_by_meta_value( $module_name, $datameta_key, $datameta_value )
	{
		return $this->db->where('data_type', $module_name)
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
	public function get_datameta( $data_id, $module_alias )
	{
		if ($query = $this->db->get_where( $this->_datameta_table, array( 'data_id' => $data_id, 'data_type' => $module_alias ) ))
		{
			$obj = new bakaObject;

			foreach ( $query->result() as $row )
			{
				$meta_key		= str_replace($module_alias.'_', '', $row->meta_key);
				$obj->$meta_key	= $row->meta_value;
			}

			return $obj;
		}

		return FALSE;
	}

	/**
	 * Create data
	 * @param  string $module_name
	 * @param  array  $form_data
	 * @return mixed
	 */
	public function create_data( $module_name, $form_data )
	{
		$data['no_agenda']	= $form_data[$module_name.'_surat_nomor'];
		$data['created_on']	= string_to_datetime();
		$data['created_by']	= $this->baka_auth->get_user_id();
		$data['type']		= $module_name;
		$data['label']		= '-';
		$data['petitioner']	= $form_data[$module_name.'_pemohon_nama'];
		$data['status']		= 'pending';
		$data['desc']		= '';

		if ( $this->db->insert( $this->_data_table, $data ) )
		{
			$data_id = $this->db->insert_id();

			if ( $this->_create_datameta( $data_id, $module_name, $form_data ) )
			{
				$this->messages['success'] = array(
					'Permohonan dari saudara/i '.$data[$petitioner].' berhasil disimpan.',
					'Klik cetak jika anda ingin langsung mencetaknya.');

				return $data_id;
			}
		}
		else
		{
			$this->messages['error'] =  'Terjadi kegagalan penginputan data.' ;

			return FALSE;
		}
	}

	public function delete_data( $data_id, $module_name )
	{
		if ( $data = $this->db->delete( $this->_data_table, array( 'id' => $data_id, 'type' => $this->get_alias($module_name) ) ) )
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
	public function update_datameta( $data_id, $module_name, $meta_key, $meta_value )
	{
		$this->db->update(
			$this->_datameta_table,
			array(	'meta_value' => $meta_value ),
			array(	'data_id'	=> $data_id,
					'data_type'	=> $module_name,
					'meta_key'	=> $meta_key )
			);
	}

	/**
	 * Create an empty datameta for a new user
	 *
	 * @param	int
	 * @return	bool
	 */
	private function _create_datameta( $data_id, $module_name, $meta_fields )
	{
		$this->db->trans_start();

		foreach ($meta_fields as $meta_key => $meta_value)
		{
			$this->db->insert( $this->_datameta_table, array(
				'data_id'	=> $data_id,
				'data_type'	=> $module_name,
				'meta_key'	=> $meta_key,
				'meta_value'=> $meta_value ) );
		}

		$this->db->trans_complete();

		return $this->db->trans_status();
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

/* End of file bpmppt_model.php */
/* Location: ./application/models/bpmppt_model.php */