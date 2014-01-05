<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter core library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

class App_data extends CI_Model
{
    // Direktori penyimpanan modul
    public $module_dir          = 'perijinan/';

    // Nama table
    private $_data_table        = 'data';
    private $_datameta_table    = 'data_meta';

    private $_dashboard_view    = FALSE;

    public $app_modules = array();

    public $messages = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->load_moduls();

        log_message('debug', "#Baka_pack: Application data model Class Initialized");
    }

    /**
     * Load all modules that available to logged in users
     * 
     * @return  void
     */
    private function load_moduls()
    {
        if ( ! $this->load->is_loaded('directory') )
            $this->load->helper('directory');

        foreach ( directory_map( APPPATH.'models/'.$this->module_dir ) as $module_file)
        {
            if (substr($module_file, 0, 1) !== '_')
                $module_name = strtolower(str_replace(EXT, '', $module_file));

            if ( is_permited('doc_'.$module_name.'_manage') )
            {
                if (!$this->load->is_loaded( $this->module_dir.$module_name ) )
                    $this->load->model( $this->module_dir.$module_name );

                $modul  = $this->$module_name;
                $kode   = (property_exists( $modul, 'kode' )) ? $modul->kode : FALSE;

                $this->app_modules[$module_name] = array(
                    'nama'  => $modul->nama,
                    'alias' => $modul->slug,
                    'label' => $modul->nama.( $kode ? ' ('.$kode.')' : '' ),
                    'kode'  => $kode,
                    'link'  => $module_name );
            }
        }
    }

    /**
     * Get an accosiative array of modules
     * 
     * @return array
     */
    public function get_modules_assoc( $key = '', $val = '' )
    {
        $ret = array();
        $key || $key = 'alias';
        $val || $val = 'nama';

        foreach ( $this->app_modules as $modul )
            $ret[$modul[$key]] = $modul[$val];

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
    public function get_modul( $module_name )
    {
        return $this->app_modules[$module_name];
    }

    /**
     * Get Module name
     * 
     * @param string $module_name
     */
    public function get_name( $module_name )
    {
        return $this->app_modules[$module_name]['nama'];
    }

    /**
     * Get Module alias
     * 
     * @param string $module_name
     */
    public function get_alias( $module_name )
    {
        return $this->app_modules[$module_name]['alias'];
    }

    /**
     * Get Module code
     * 
     * @param string $module_name
     */
    public function get_code( $module_name )
    {
        return $this->app_modules[$module_name]['kode'];
    }

    /**
     * Get Module label
     * 
     * @param string $module_name
     */
    public function get_label( $module_name )
    {
        return $this->app_modules[$module_name]['label'];
    }

    /**
     * Get Module link
     * 
     * @param string $module_name
     */
    public function get_link( $module_name )
    {
        return $this->app_modules[$module_name]['link'];
    }

    // get all moduls grid
    public function get_tables( $page_link = '' )
    {
        $out = array();

        $this->_dashboard_view = TRUE;

        foreach ( $this->get_modules_assoc('alias', 'link') as $mod_alias => $mod_link )
        {
            $out[$mod_alias] = $this->get_table( $mod_link, $page_link.$mod_link.'/' );
        }

        return $out;
    }

    // get single modul grid
    public function get_table( $module_name = '', $page_link = '' )
    {
        $module_slug = $this->get_alias( $module_name );

        switch ( $this->uri->segment(6) )
        {
            case 'status':
                $query = $this->get_data_by_status( $this->uri->segment(7), $module_slug );
                break;

            case 'page':
            default:
                $query = $this->get_data_by_type( $module_slug );
                break;
        }

        $this->load->library('baka_pack/gridr');

        $grid = $this->gridr->identifier('id')
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

    public function skpd_properties()
    {
        $prop = array(
                'skpd_name', 'skpd_address', 'skpd_city', 'skpd_prov',
                'skpd_telp', 'skpd_fax', 'skpd_pos', 'skpd_web', 'skpd_email',
                'skpd_logo','skpd_lead_name','skpd_lead_nip'
                );

        foreach ( $prop as $property )
        {
            $data[$property] = Setting::get( $property );
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
        return $this->get_where( array( 'id' => $data_id ), TRUE );
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
        $wheres['type']     = $data_type;
        $wheres['status']   = $filter['data_status'];
        $wheres['month']    = $filter['data_date_month'];
        $wheres['year']     = $filter['data_date_year'];

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
                $meta_key       = str_replace($module_alias.'_', '', $row->meta_key);
                $obj->$meta_key = $row->meta_value;
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
        $data['no_agenda']  = $form_data[$module_name.'_surat_nomor'];
        $data['created_on'] = string_to_datetime();
        $data['created_by'] = $this->authen->get_user_id();
        $data['type']       = $module_name;
        $data['label']      = '-';
        $data['petitioner'] = $form_data[$module_name.'_pemohon_nama'];
        $data['status']     = 'pending';
        $data['desc']       = '';

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
     * @param   int
     * @return  bool
     */
    public function update_datameta( $data_id, $module_name, $meta_key, $meta_value )
    {
        $this->db->update(
            $this->_datameta_table,
            array(  'meta_value' => $meta_value ),
            array(  'data_id'   => $data_id,
                    'data_type' => $module_name,
                    'meta_key'  => $meta_key )
            );
    }

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
            $this->db->insert( $this->_datameta_table, array(
                'data_id'   => $data_id,
                'data_type' => $module_name,
                'meta_key'  => $meta_key,
                'meta_value'=> $meta_value ) );
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    private function _write_datalog( $data_id, $log_message )
    {
        $data = $this->db->get_where( $this->_data_table, array('id' => $data_id) )->row();

        $log[] = array(
            'user_id'   => $this->authen->get_user_id(),
            'date'      => string_to_datetime(),
            'message'   => $log_message,
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