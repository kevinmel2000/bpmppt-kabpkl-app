<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     Bapa Pack BPMPPT
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
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

    public function simpan( $driver_alias, $form_data, $data_id = NULL )
    {
        // $driver_alias = $this->get_alias( $driver );

        $data['no_agenda']  = $form_data[$driver_alias.'_surat_nomor'];
        $data['created_on'] = string_to_datetime();
        $data['created_by'] = $this->_ci->authr->get_user_id();
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