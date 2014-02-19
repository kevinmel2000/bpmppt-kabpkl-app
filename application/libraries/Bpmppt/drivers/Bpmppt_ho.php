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
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 1.0
 * @filesource
 */

// =============================================================================

/**
 * BPMPPT Izin Gangguan Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_ho extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'HO';
    public $alias = 'izin_gangguan';
    public $name = 'Izin Gangguan';

    /**
     * Default field
     *
     * @var  array
     */
    public $fields = array(
        'surat_jenis_pengajuan'     => '',
        'pemohon_nama'              => '',
        'pemohon_nama'              => '',
        'pemohon_alamat'            => '',
        'pemohon_telp'              => '',
        'usaha_nama'                => '',
        'usaha_jenis'               => '',
        'usaha_alamat'              => '',
        'usaha_lokasi'              => '',
        'usaha_luas'                => '',
        'usaha_pekerja'             => '',
        'usaha_tetangga_timur'      => '',
        'usaha_tetangga_utara'      => '',
        'usaha_tetangga_selatan'    => '',
        'usaha_tetangga_barat'      => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        // $this->baka_auth->permit( 'manage_'.$this->alias );

        log_message('debug', "#BPMPPT_driver: Gangguan Class Initialized");
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
            'name'  => $this->alias.'_surat_jenis_pengajuan',
            'label' => 'Jenis Pengajuan',
            'type'  => 'dropdown',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->surat_jenis_pengajuan : ''),
            'option'=> array(
                'br' => 'Pendaftaran baru',
                'bn' => 'Balik nama',
                'du' => 'Daftar ulang' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_nama',
            'label' => 'Nama Lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_kerja',
            'label' => 'Pekerjaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_telp',
            'label' => 'Nomor Telpon/HP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_telp : ''),
            'validation'=> 'numeric|max_length[12]' );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_perusahaan',
            'label' => 'Data Perusahaan',
            'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_nama',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_jenis',
            'label' => 'Jenis Usaha',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_alamat',
            'label' => 'Alamat Kantor',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_lokasi',
            'label' => 'Lokasi Perusahaan',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_luas',
            'label' => 'Luas perusahaan (M<sup>2</sup>)',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->usaha_luas : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_pekerja',
            'label' => 'Jumlah pekerja',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->usaha_pekerja : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_tetangga',
            'label' => 'Data Tetangga',
            'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_tetangga_timur',
            'label' => 'Tetangga sebelah timur',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_tetangga_timur : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_tetangga_utara',
            'label' => 'Tetangga sebelah utara',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_tetangga_utara : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_tetangga_selatan',
            'label' => 'Tetangga sebelah selatan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_tetangga_selatan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_tetangga_barat',
            'label' => 'Tetangga sebelah barat',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_tetangga_barat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );
        
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

/* End of file Bpmppt_ho.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_ho.php */