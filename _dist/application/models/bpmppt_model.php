<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bpmppt Model
 * @category    Models
 */

// -----------------------------------------------------------------------------

class Bpmppt_model extends CI_Model
{
    /**
     * Nama table
     *
     * @var  array
     */
    private $_table = array();

    private $_dashboard_view = FALSE;

    public $app_modules = array();

    public $messages = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->config->load('bpmppt');

        foreach ( array('data', 'datameta') as $table )
        {
            $this->_table[$table] = config_item('bpmppt_'.$table.'_table');
        }

        log_message('debug', "#BPMPPT: model Class Initialized");
    }

    // -------------------------------------------------------------------------

    public function skpd_properties()
    {
        $prop = array(
                'skpd_name', 'skpd_address', 'skpd_kab', 'skpd_city', 'skpd_prov',
                'skpd_telp', 'skpd_fax', 'skpd_pos', 'skpd_web', 'skpd_email',
                'skpd_logo', 'skpd_lead_name', 'skpd_lead_nip', 'skpd_lead_jabatan'
                );

        foreach ( $prop as $property )
        {
            $data[$property] = Bootigniter::get_setting( $property );
        }

        return $data;
    }

    // -------------------------------------------------------------------------

    /**
     * get full data by id
     *
     * @param   int  $data_id  Data ID
     *
     * @return  obj
     */
    public function get_fulldata_by_id( $data_id )
    {
        if ($data = $this->get_data_by_id( $data_id ))
        {
            $meta = $this->get_datameta( $data_id, $data->type );

            return (object) array_merge( (array) $data, (array) $meta );
        }
    }

    // -------------------------------------------------------------------------

    // get data by id
    public function get_data_by_id( $data_id )
    {
        return $this->get_where( array( 'id' => $data_id ), TRUE );
    }

    // -------------------------------------------------------------------------

    // get data by type
    public function get_data_by_type( $module_name )
    {
        return $this->get_where( array( 'type' => $module_name ) );
    }

    // -------------------------------------------------------------------------

    // get data by label
    public function get_data_by_status( $data_status, $module_name = '' )
    {
        if ( $data_status != 'semua' )
        {
            $where['status'] = $data_status;
        }

        if ($module_name != '')
        {
            $where['type'] = $module_name;
        }

        return $this->get_where( $where );
    }

    // -------------------------------------------------------------------------

    // get data by author
    public function get_data_by_author( $data_created_by, $module_name = '' )
    {
        $where['created_by'] = $data_created_by;

        if ($module_name != '')
        {
            $where['type'] = $module_name;
        }

        return $this->get_where( $where );
    }

    // -------------------------------------------------------------------------

    // get data by petitioner
    public function get_data_by_petitioner( $data_petitioner, $module_name = '' )
    {
        $where['petitioner'] = $data_petitioner;

        if ($module_name != '')
        {
            $where['type'] = $module_name;
        }

        return $this->get_where( $where );
    }

    // -------------------------------------------------------------------------

    /**
     * find data by petitioner
     *
     * @param   string  $data_petitioner  Petitioner data
     * @param   string  $module_name      Module Name
     *
     * @return  obj
     */
    public function find_data_by_petitioner( $data_petitioner, $module_name = '' )
    {
        if ($module_name != '')
        {
            $this->db->where('type', $module_name);
        }

        $this->db->like('petitioner', $data_petitioner);

        return $this->db->get($this->_table['data']);
    }

    // -------------------------------------------------------------------------

    /**
     * Default get where data
     *
     * @param   array   $wheres     Data Filter
     * @param   bool    $is_single  Is Singular
     *
     * @return  mixed
     */
    public function get_where( $wheres, $is_single = FALSE )
    {
        // If filtered by created month
        if ( isset($wheres['month']) )
        {
            $wheres['MONTH(created_on)'] = (int) $wheres['month'];
            unset($wheres['month']);
        }

        // If filtered by created year
        if ( isset($wheres['year']) )
        {
            $wheres['YEAR(created_on)'] = (int) $wheres['year'];
            unset($wheres['year']);
        }

        // Selecting data
        $query = $this->db->select('*')->from($this->_table['data']);

        // If not filtered by specified status
        if ( !isset( $wheres['status'] ) and $is_single == FALSE )
        {
            $query->where( 'status !=', 'deleted' );
            // unset($wheres['status']);
        }

        // Loop the filter
        foreach ( $wheres as $key => $val )
        {
            $query->where( $key, $val );
        }

        // Is it a singular result
        if ( $is_single )
        {
            $get_query = $query->get();
            return ( $get_query->num_rows() == 1 ) ? $get_query->row() : FALSE;
        }
        else
        {
            // var_dump($wheres);
            return $query;
        }
    }

    // -------------------------------------------------------------------------

    // find datameta by key
    public function find_data_by_meta_value( $module_name, $datameta_key, $datameta_value )
    {
        return $this->db->where('data_type', $module_name)
                        ->where('meta_key', $datameta_key)
                        ->like('meta_value', $datameta_value)
                        ->group_by('data_id')
                        ->get($this->_table['datameta']);
    }

    // -------------------------------------------------------------------------

    // count data
    public function count_data( $module_alias, $wheres = array() )
    {
        $out = NULL;

        if (!empty($wheres))
        {
            foreach($wheres as $key => $val)
            {
                $this->db->where($key, $val);
            }
        }

        $out = $this->db->where('type', $module_alias)
                        ->count_all_results($this->_table['data']);

        return $out;
    }

    // -------------------------------------------------------------------------

    // get datameta
    public function get_datameta( $data_id, $module_alias )
    {
        if ($query = $this->db->get_where( $this->_table['datameta'], array( 'data_id' => $data_id, 'data_type' => $module_alias ) ))
        {
            $obj = new stdClass;

            foreach ( $query->result() as $row )
            {
                $meta_key       = str_replace($module_alias.'_', '', $row->meta_key);
                $obj->$meta_key = $row->meta_value;
            }

            return $obj;
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Create new data
     *
     * @param   string  $module_alias  Module Alias
     * @param   array   $main_data     Main Data
     * @param   array   $meta_data     Meta Data
     *
     * @return  bool|int
     */
    public function create_data( $module_alias, $main_data, $meta_data )
    {
        if ( $this->db->insert( $this->_table['data'], $main_data ) )
        {
            $data_id = $this->db->insert_id();

            if ( $this->_create_datameta( $data_id, $module_alias, $meta_data ) )
            {
                return $data_id;
            }
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Save data
     *
     * @param   string  $module_alias  Module Alias
     * @param   array   $main_data     Main Data
     * @param   array   $meta_data     Meta Data
     *
     * @return  bool|int
     */
    public function save_data( $module_alias, $main_data, $meta_data, $data_id = FALSE )
    {
        if ( $data_id )
        {
            $this->db->update( $this->_table['data'], $main_data, array('id' => $data_id) );
            $return = FALSE;

            foreach ( $meta_data as $meta_key => $meta_value)
            {
                $return = $this->update_datameta( $data_id, $module_alias, $meta_key, $meta_value );
            }

            if ( $return !== FALSE )
            {
                return $data_id;
            }
        }
        else
        {
            if ( $this->db->insert( $this->_table['data'], $main_data ) )
            {
                $data_id = $this->db->insert_id();

                if ( $this->_create_datameta( $data_id, $module_alias, $meta_data ) )
                {
                    return $data_id;
                }
            }
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    public function delete_data( $data_id, $module_name )
    {
        if ( $data = $this->db->delete( $this->_table['data'], array( 'id' => $data_id, 'type' => $module_name ) ) )
        {
            if ( $this->db->delete( $this->_table['datameta'], array( 'data_id' => $data_id, 'data_type' => $module_name ) ) )
            {
                return TRUE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    public function change_status( $data_id, $new_status )
    {
        $new_data['status'] = $new_status;

        if ( $new_status != 'pending' )
            $new_data[$new_status.'_on'] = string_to_datetime();

        $this->db->update( $this->_table['data'], $new_data, array('id' => $data_id) );

        $this->_write_datalog( $data_id, 'Mengubah status dokumen menjadi '._x('status_'.$new_status) );

        return $this->db->affected_rows() > 0;
    }

    // -------------------------------------------------------------------------

    /**
     * Update datameta for a new user
     *
     * @param   int
     * @return  bool
     */
    public function update_datameta( $data_id, $module_name, $meta_key, $meta_value )
    {
        if ( is_array($meta_value) )
        {
            $meta_value = serialize($meta_value);
        }

        return $this->db->update(
            $this->_table['datameta'],
            array(  'meta_value' => $meta_value ),
            array(  'data_id'   => $data_id,
                    'data_type' => $module_name,
                    'meta_key'  => $meta_key )
            );
    }

    // -------------------------------------------------------------------------

    /**
     * Create an empty datameta for a new user
     *
     * @param   int
     * @return  bool
     */
    private function _create_datameta( $data_id, $module_name, $meta_fields )
    {
        $this->db->trans_start();

        foreach ($meta_fields as $meta_key => $meta_value)
        {
            if ( is_array($meta_value) )
            {
                $meta_value = serialize($meta_value);
            }

            $this->db->insert( $this->_table['datameta'], array(
                'data_id'   => $data_id,
                'data_type' => $module_name,
                'meta_key'  => $meta_key,
                'meta_value'=> $meta_value ) );
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // -------------------------------------------------------------------------

    private function _write_datalog( $data_id, $log_message )
    {
        $data = $this->db->get_where( $this->_table['data'], array('id' => $data_id) )->row();

        $log[] = array(
            'user_id'   => $this->biauth->get_user_id(),
            'date'      => string_to_datetime(),
            'message'   => $log_message,
            );

        if ( !is_null( $data->logs ) )
        {
            $log = array_merge( unserialize( $data->logs ), $log );
        }

        $this->db->update(
            $this->_table['data'],
            array( 'logs' => serialize( $log ) ),
            array( 'id' => $data_id )
            );
    }

    // -------------------------------------------------------------------------

    /**
     * Get Reports properties from child driver (if available)
     *
     * @param   string  $driver  Driver name
     *
     * @return  array|false
     */
    public function get_report( $where = array() )
    {
        $query = $this->get_where( $where )->get();

        if ( $query->num_rows() > 0 )
        {
            $main_data = $query->result();

            foreach ( $main_data as $row )
            {
                $meta = $this->get_datameta( $row->id, $row->type );
                $result[] = (object) array_merge( (array) $row, (array) $meta );
            }

            return $result;
        }

        return FALSE;
    }
}

/* End of file bpmppt_model.php */
/* Location: ./application/models/Baka_pack/bpmppt_model.php */
