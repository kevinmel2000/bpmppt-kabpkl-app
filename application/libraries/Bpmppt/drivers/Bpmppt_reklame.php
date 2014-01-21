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
 * BPMPPT Izin Reklame Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_reklame extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $alias
     * @var  string  $name
     */
    public $alias = 'izin_reklame';
    public $name = 'Izin Reklame';

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Reklame Class Initialized");
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
            'name'  => $this->alias.'_fieldset_data_reklame',
            'label' => 'Data Reklame',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_lokasi_jenis',
            'label' => 'Jenis Reklame',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->reklame_jenis : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_reklame_juml',
            'label' => 'Jumlah',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->reklame_juml : ''),
            'validation'=> 'required|numeric' );

        $fields[]   = array(
            'name'  => $this->alias.'_reklame_lokasi',
            'label' => 'Lokasi pemasangan',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->reklame_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_reklame_ukuran',
            'label' => 'Ukuran (P x L)',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'panjang',
                    'label' => 'Panjang',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->reklame_ukuran_panjang : ''),
                    'validation'=> 'required|numerik' ),
                array(
                    'col'   => '6',
                    'name'  => 'lebar',
                    'label' => 'Lebar',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->reklame_ukuran_lebar : ''),
                    'validation'=> 'required|numerik' ),
                )
            );

        $fields[]   = array(
            'name'  => $this->alias.'_reklame_range',
            'label' => 'Jangka waktu',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'tgl_mulai',
                    'label' => 'Mulai Tanggal',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->reklame_range_tgl_mulai : ''),
                    'validation'=> 'required|numerik' ),
                array(
                    'col'   => '6',
                    'name'  => 'tgl_selesai',
                    'label' => 'Sampai Tanggal',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->reklame_range_tgl_selesai : ''),
                    'validation'=> 'required|numerik' ),
                )
            );

        $fields[]   = array(
            'name'  => $this->alias.'_reklame_tema',
            'label' => 'Tema/Isi',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->reklame_tema : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_reklame_ket',
            'label' => 'Keterangan',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->reklame_ket : ''),
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

/* End of file Bpmppt_reklame.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_reklame.php */