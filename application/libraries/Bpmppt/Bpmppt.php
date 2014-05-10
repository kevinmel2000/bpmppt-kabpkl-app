<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BPMPPT driver
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
 * @package     BPMPPT
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 1.0
 * @filesource
 */

// =============================================================================

/**
 * BPMPPT Driver
 *
 * @subpackage  Drivers
 * @category    Application
 */
class Bpmppt extends CI_Driver_Library
{
    /**
     * Base CI instance wrapper
     *
     * @var  string
     */
    public $_ci = '';

    /**
     * Valid drivers that will be loaded
     *
     * @var  array
     */
    public $valid_drivers = array();

    /**
     * All drivers that available to be load
     *
     * @var  array
     */
    private $available_drivers = array(
        'b3',
        'ho',
        'imb',
        'iplc',
        'iui',
        'iup',
        'lokasi',
        // 'obat',
        // 'prinsip',
        'reklame',
        'siup',
        'tdp',
        'wisata',
        );

    /**
     * All modules wrapper
     *
     * @var  array
     */
    private $modules = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        $this->_ci =& get_instance();

        $this->_ci->load->model('bpmppt_model');

        $self = get_class( $this );

        foreach ( $this->available_drivers as $module )
        {
            if ( $this->_ci->authr->is_permited( 'doc_'.$module.'_manage' ) )
            {
                $this->valid_drivers[] = $self.'_'.$module;

                $child  = $this->$module;
                $code   = ( property_exists( $this->$module, 'code' ) )
                    ? $child->code
                    : FALSE;

                $this->modules[$module] = array(
                    'name'  => $child->name,
                    'alias' => $child->alias,
                    'label' => $child->name.( $code ? ' ('.$code.')' : '' ),
                    'code'  => $code );
            }
        }

        log_message('debug', '#BPMPPT: Drivers Library initialized.');
    }

    // -------------------------------------------------------------------------

    /**
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * @param   string  $method  Method name
     * @param   mixed   $args    Method Arguments
     *
     * @return  mixed
     */
    public function __call( $method, $args )
    {
        if ( !method_exists( $this->_ci->bpmppt_model, $method ) )
        {
            show_error('Undefined method BPMPPT::'.$method.'() called', 500, 'An Error Eas Encountered');
        }

        return call_user_func_array( array( $this->_ci->bpmppt_model, $method ), $args );
    }

    // -------------------------------------------------------------------------

    /**
     * Get all modules properties
     *
     * @param   bool    $obj  return option
     *                        set it TRUE if you want return it as Object
     *                        set it FALSE or leave it empty to return it as is
     *
     * @return  mixed
     */
    public function get_modules( $obj = FALSE )
    {
        if ( $obj )
            return array_to_object( $this->modules );

        return (array) $this->modules;
    }

    // -------------------------------------------------------------------------

    /**
     * Get all modules in associative array
     *
     * @param   string  $key  Module prop that you want to use as return key
     * @param   string  $val  Module prop that you want to use as return val
     *
     * @return  array
     */
    public function get_modules_assoc( $key = '', $val = '' )
    {
        $ret = array();
        $key || $key = 'alias';
        $val || $val = 'name';

        foreach ( $this->modules as $module )
            $ret[$module[$key]] = $module[$val];

        return $ret;
    }

    // -------------------------------------------------------------------------

    /**
     * Get single module name
     *
     * @param   string  $name  Module name
     *
     * @return  array
     */
    public function get_module( $name )
    {
        return $this->modules[$name];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module name
     * 
     * @param   string  $name
     *
     * @return  string
     */
    public function get_name( $name )
    {
        return $this->modules[$name]['name'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module alias
     * 
     * @param   string  $name
     *
     * @return  string
     */
    public function get_alias( $name )
    {
        return $this->modules[$name]['alias'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module code
     * 
     * @param   string  $name
     *
     * @return  string
     */
    public function get_code( $name )
    {
        return $this->modules[$name]['code'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module label
     * 
     * @param   string  $name
     *
     * @return  string
     */
    public function get_label( $name )
    {
        return $this->modules[$name]['label'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get form properties from child driver (if available)
     *
     * @param   string  $driver  Driver name
     * @param   object  $driver  Data Object
     *
     * @return  array|false
     */
    public function get_form( $driver, $data_obj )
    {
        if (is_object($data_obj))
        {
            foreach ($this->$driver->fields as $key => $value)
            {
                if(!isset($data_obj->$key))
                {
                    $data_obj->$key = $value;
                }
            }
        }

        if ( method_exists( $this->$driver, 'form') )
        {
            return $this->$driver->form( $data_obj );
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Get Print properties from child driver (if available)
     *
     * @param   string  $driver  Driver name
     *
     * @return  array|false
     */
    public function get_print( $driver, $data_id )
    {
        $data = array_merge(
                    (array) $this->skpd_properties(),
                    (array) $this->get_fulldata_by_id($data_id)
                    );

        foreach ($this->$driver->fields as $key => $value)
        {
            if(!isset($data[$key]))
            {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    // -------------------------------------------------------------------------

    /**
     * Get Reports properties from child driver (if available)
     *
     * @param   string  $driver  Driver name
     *
     * @return  array|false
     */
    public function get_report( $driver, $where = array() )
    {
        $wheres = array(
            'type'                => $this->$driver->alias,
            'month(created_on)'   => (int) ( !empty($where['data_date_month']) ? $where['data_date_month'] : bdate('m') ),
            'year(created_on)'    => (int) ( !empty($where['data_date_year']) ? $where['data_date_year'] : bdate('Y') ),
            );

        if ( $where['data_status'] != 'all' )
        {
            $wheres['status'] = $where['data_status'];
        }

        return $this->q_report( $wheres );
    }

    // -------------------------------------------------------------------------

    public function simpan( $driver_alias, $form_data, $data_id = NULL )
    {
        // $driver_alias = $this->get_alias( $driver );

        $data['no_agenda']  = $form_data[$driver_alias.'_surat_nomor'];
        $data['created_on'] = string_to_datetime();
        $data['created_by'] = $this->authr->get_user_id();
        $data['type']       = $driver_alias;
        $data['label']      = '-';
        $data['petitioner'] = $form_data[$driver_alias.'_pemohon_nama'];
        $data['status']     = 'pending';

        if ( $result = $this->create_data( $driver_alias, $data, $form_data ) )
        {
            Messg::set('success', array(
                'Permohonan dari saudara/i '.$data['petitioner'].' berhasil disimpan.',
                'Klik cetak jika anda ingin langsung mencetaknya.'));

            return $result;
        }
        else
        {
            Messg::set('error', 'Terjadi kegagalan penginputan data.');

            return FALSE;
        }
    }
}

/* End of file Bpmppt.php */
/* Location: ./application/libraries/Bpmppt/Bpmppt.php */