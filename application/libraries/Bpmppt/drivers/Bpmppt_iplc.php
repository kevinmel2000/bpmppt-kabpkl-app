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
 * @copyright   Copyright (c) Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kab. Pekalongan
 * @license     http://dbad-license.org
 * @since       Version 1.0
 */

// =============================================================================

/**
 * BPMPPT Izin Pembuangan Air Limbah ke Air atau Sumber Air Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_iplc extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'IPLC';
    public $alias = 'izin_pembuangan_air_limbah';
    public $name = 'Izin Pembuangan Air Limbah ke Air atau Sumber Air';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'pemohon_nama'              => '',
        'pemohon_jabatan'           => '',
        'pemohon_usaha'             => '',
        'pemohon_alamat'            => '',
        'limbah_kapasitas_produksi' => '',
        'limbah_debit_max_proses'   => '',
        'limbah_debit_max_kond'     => '',
        'limbah_target_buang'       => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Pembuangan_limbah Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Form fields from this driver
     *
     * @param   bool    $data_obj  Data field
     *
     * @return  array
     */
    public function form( $data_obj = FALSE )
    {
        $fields[] = array(
            'name'  => 'fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_jabatan',
            'label' => 'Jabatan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_jabatan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_usaha',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_usaha : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'fieldset_data_lokasi',
            'label' => 'Data Lokasi',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'limbah_kapasitas_produksi',
            'label' => 'Kapasitas Produksi',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->limbah_kapasitas_produksi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'limbah_debit_max',
            'label' => 'Debit max limbah',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'proses',
                    'label' => 'proses',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->limbah_debit_max_proses : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'kond',
                    'label' => 'kondensor',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->limbah_debit_max_kond : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                )
            );

        $fields[] = array(
            'name'  => 'limbah_kadar_max_proses',
            'label' => 'Kadar max proses',
            'type'  => 'subfield',
            'fields'=> $this->subfield_limbah( 'limbah_kadar_max_proses_', $data_obj ) );

        $fields[] = array(
            'name'  => 'limbah_beban_max_proses',
            'label' => 'Beban pencemaran proses',
            'type'  => 'subfield',
            'fields'=> $this->subfield_limbah( 'limbah_beban_max_proses_', $data_obj ) );

        $fields[] = array(
            'name'  => 'limbah_kadar_max_kond',
            'label' => 'Kadar max kondensor',
            'type'  => 'subfield',
            'fields'=> $this->subfield_limbah( 'limbah_kadar_max_kond_', $data_obj ) );

        $fields[] = array(
            'name'  => 'limbah_beban_max_kond',
            'label' => 'Beban pencemaran kondensor',
            'type'  => 'subfield',
            'fields'=> $this->subfield_limbah( 'limbah_beban_max_kond_', $data_obj ) );

        $fields[] = array(
            'name'  => 'limbah_target_buang',
            'label' => 'Target pembuangan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->limbah_target_buang : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        return $fields;
    }

    // -------------------------------------------------------------------------

    protected function subfield_limbah( $parent, $data_obj = FALSE )
    {
        
        $this->defaults[$parent.'bod']        = '';
        $this->defaults[$parent.'cod']        = '';
        $this->defaults[$parent.'tts']        = '';
        $this->defaults[$parent.'minyak']     = '';
        $this->defaults[$parent.'sulfida']    = '';
        $this->defaults[$parent.'ph']         = '';

        $subs[] = array(
            'name'  => 'bod',
            'label' => 'BOD',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->{$parent.'bod'} : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );
        
        $subs[] = array(
            'name'  => 'cod',
            'label' => 'COD',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->{$parent.'cod'} : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );
        
        $subs[] = array(
            'name'  => 'tts',
            'label' => 'TTS',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->{$parent.'tts'} : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );
        
        $subs[] = array(
            'name'  => 'minyak',
            'label' => 'Minyak',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->{$parent.'minyak'} : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );
        
        $subs[] = array(
            'name'  => 'sulfida',
            'label' => 'Silfida',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->{$parent.'sulfida'} : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );
        
        $subs[] = array(
            'name'  => 'ph',
            'label' => 'pH',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->{$parent.'ph'} : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        return $subs;
    }

    // -------------------------------------------------------------------------

    /**
     * Format cetak produk perijinan
     *
     * @return  mixed
     */
    public function produk()
    {
        return false;
    }

    // -------------------------------------------------------------------------

    /**
     * Format output laporan
     *
     * @return  mixed
     */
    public function laporan()
    {
        return false;
    }
}

/* End of file Bpmppt_iplc.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_iplc.php */