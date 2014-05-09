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
            'type'  => 'dropdown',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'option'=> array(
                'baru'  => 'Mendirikan Bangunan Baru',
                'rehap' => 'Perbaikan/Rehab Bangunan Lama' ),
            'std'   => ( $data_obj ? $data_obj->bangunan_maksud : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_bangunan_guna',
            'label' => 'Penggunaan bangunan',
            'type'  => 'dropdown',
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