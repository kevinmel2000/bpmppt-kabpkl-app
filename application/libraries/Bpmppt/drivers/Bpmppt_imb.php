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
 * BPMPPT Izin Mendirikan Bangunan Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_imb extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'IMB';
    public $alias = 'izin_mendirikan_bangunan';
    public $name = 'Izin Mendirikan Bangunan';

    /**
     * Default field
     *
     * @var  array
     */
    public $fields = array(
        'bangunan_maksud'           => '',
        'bangunan_guna'             => '',
        'pemohon_nama'              => '',
        'pemohon_kerja'             => '',
        'pemohon_alamat'            => '',
        'bangunan_lokasi'           => '',
        'bangunan_tanah_luas'       => '',
        'bangunan_tanah_keadaan'    => '',
        'bangunan_tanah_status'     => '',
        'bangunan_milik_no'         => '',
        'bangunan_milik_an'         => '',
        'bangunan_luas'             => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Mendirikan_bangunan Class Initialized");
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
        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_maksud',
            'label' => 'Maksud Permohonan',
            'type'  => 'radio',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'option'=> array(
                'baru'  => 'Mendirikan Bangunan Baru',
                'rehap' => 'Perbaikan/Rehab Bangunan Lama' ),
            'std'   => ( $data_obj ? $data_obj->bangunan_maksud : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_guna',
            'label' => 'Penggunaan bangunan',
            'type'  => 'radio',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'option'=> array(
                'Rumah Tinggal' => 'Rumah Tinggal',
                'kios'  => 'Kios',
                'toko'  => 'Toko',
                'gudang'=> 'Gudang',
                'pabrik'=> 'Pabrik',
                'kantor'=> 'Kantor' ),
            'std'   => ( $data_obj ? $data_obj->bangunan_guna : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_kerja',
            'label' => 'Pekerjaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_kerja : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_bangunan',
            'label' => 'Data Bangunan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_lokasi',
            'label' => 'Lokasi bangunan',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->bangunan_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_tanah_luas',
            'label' => 'Luas Tanah Bangunan (M<sup>2</sup>)',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->bangunan_tanah_luas : ''),
            'validation'=> ( !$data_obj ? 'required|numeric' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_tanah_keadaan',
            'label' => 'Keadaan Tanah',
            'type'  => 'dropdown',
            'option'=> array(
                'd1'    => 'D I',
                'd2'    => 'D II',
                'd3'    => 'D III' ),
            'std'   => ( $data_obj ? $data_obj->bangunan_tanah_keadaan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_tanah_status',
            'label' => 'Status Tanah',
            'type'  => 'dropdown',
            'option'=> array(
                'hm'    => 'Hak milik',
                'hg'    => 'Hak guna bangunan' ),
            'std'   => ( $data_obj ? $data_obj->bangunan_tanah_status : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_milik_no',
            'label' => 'Nomor kepemilikan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->bangunan_milik_no : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_milik_an',
            'label' => 'Atas Nama kepemilikan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->bangunan_milik_an : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_luas',
            'label' => 'Luas bangunan (M<sup>2</sup>)',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->bangunan_luas : ''),
            'validation'=> 'required|numeric' );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_tembusan',
            'label' => 'Tembusan Dokumen',
            'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
            'type'  => 'fieldset' );

        $fields[] = $this->field_tembusan($data_obj, $this->alias);
        
        return $fields;
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

/* End of file Bpmppt_imb.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_imb.php */