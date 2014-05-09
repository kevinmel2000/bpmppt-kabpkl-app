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
 * BPMPPT Izin Usaha Industri Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_iui extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'IUI';
    public $alias = 'izin_usaha_industri';
    public $name = 'Izin Usaha Industri';

    /**
     * Default field
     *
     * @var  array
     */
    public $fields = array(
        'permohonan_jenis'  => '',
        'pemohon_nama'      => '',
        'pemohon_kerja'     => '',
        'pemohon_alamat'    => '',
        'pemohon_telp'      => '',
        'pemilik_nama'      => '',
        'pemilik_alamat'    => '',
        'pemilik_telp'      => '',
        'usaha_nama'        => '',
        'usaha_skala'       => '',
        'usaha_npwp'        => '',
        'usaha_alamat'      => '',
        'usaha_telp'        => '',
        'usaha_kawasan'     => '',
        'usaha_pj'          => '',
        'usaha_npwp'        => '',
        'usaha_jenis_kbli'  => '',
        'usaha_jenis_kki'   => '',
        'usaha_akta_ntrs'   => '',
        'usaha_akta_nomor'  => '',
        'usaha_direksi'     => '',
        'usaha_lokasi'      => '',
        'usaha_nama'        => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Usaha_industri Class Initialized");
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
            'name'  => $this->alias.'_permohonan_jenis',
            'label' => 'Jenis Pengajuan',
            'type'  => 'dropdown',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->permohonan_jenis : ''),
            'option'=> array(
                'br' => 'Pendaftaran Baru',
                'bn' => 'Balik Nama',
                'du' => 'Daftar Ulang' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            'type'  => 'fieldset',
            'attr'  => ( $data_obj ? 'disabled' : '' ));

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_kerja',
            'label' => 'Pekerjaan',
            'type'  => 'dropdown',
            'std'   => ( $data_obj ? $data_obj->pemohon_kerja : ''),
            'option'=> array(
                'kerja'=> 'Pekerjaan' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_telp',
            'label' => 'No. Telp',
            'type'  => 'tel',
            'std'   => ( $data_obj ? $data_obj->pemohon_telp : ''),
            'validation'=> 'numeric' );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_pemilik',
            'label' => 'Data Pemilik Perusahaan',
            'type'  => 'fieldset',
            'attr'  => ( $data_obj ? 'disabled' : '' ));

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemilik_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemilik_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_telp',
            'label' => 'No. Telp',
            'type'  => 'tel',
            'std'   => ( $data_obj ? $data_obj->pemilik_telp : ''),
            'validation'=> 'numeric' );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_usaha',
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset',
            'attr'  => ( $data_obj ? 'disabled' : '' ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_nama',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_skala',
            'label' => 'Skala',
            'type'  => 'dropdown',
            'std'   => ( $data_obj ? $data_obj->usaha_skala : ''),
            'option'=> array(
                'kecil'     => 'Perusahaan Kecil',
                'menengah'  => 'Perusahaan Menengah',
                'besar'     => 'Perusahaan Besar' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_npwp',
            'label' => 'No. NPWP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_npwp : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_telp',
            'label' => 'No. Telp',
            'type'  => 'tel',
            'std'   => ( $data_obj ? $data_obj->usaha_telp : ''),
            'validation'=> 'numeric' );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_kawasan',
            'label' => 'Kawasan Industri',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_kawasan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_pj',
            'label' => 'Nama Penanggungjawab',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_pj : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_npwp',
            'label' => 'No. NPWP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_npwp : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_jenis',
            'label' => 'Jenis Perusahaan',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'kbli',
                    'label' => 'KBLI',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_jenis_kbli : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'col'   => '6',
                    'name'  => 'kki',
                    'label' => 'KKI',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_jenis_kki : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                )
            );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_akta',
            'label' => 'Pendirian',
            'type'  => 'subfield',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'ntrs',
                    'label' => 'Nama Notaris',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_ntrs : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'col'   => '6',
                    'name'  => 'nomor',
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_nomor : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                )
            );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_direksi',
            'label' => 'Nama Direksi',
            'type'  => 'text',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_direksi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_lokasi',
            'label' => 'Lokasi Pabrik',
            'type'  => 'textarea',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_nama',
            'label' => 'Luas Tanah (M<sup>2</sup>)',
            'type'  => 'number',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
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

/* End of file Bpmppt_iui.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_iui.php */