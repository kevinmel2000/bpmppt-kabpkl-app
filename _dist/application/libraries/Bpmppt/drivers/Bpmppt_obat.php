<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bpmppt_obat Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Pengobatan Tradisional
| ------------------------------------------------------------------------------
*/

class Bpmppt_obat extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $alias
     * @var  string  $name
     */
    public $alias = 'izin_obat_tradisional';
    public $name = 'Izin Pengobatan Tradisional';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'pemohon_nama'      => '',
        'pemohon_jabatan'   => '',
        'pemohon_usaha'     => '',
        'pemohon_alamat'    => '',
        'lokasi_tujuan'     => '',
        'lokasi_alamat'     => '',
        'lokasi_nama'       => '',
        'lokasi_area_hijau' => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Pengobatan_tradisional Class Initialized");
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
            'label' => 'Perusahaan',
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
            'name'  => 'lokasi_tujuan',
            'label' => 'Tujuan Permohonan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->lokasi_tujuan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'lokasi_alamat',
            'label' => 'Alamat Lokasi',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->lokasi_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'lokasi_nama',
            'label' => 'Luas Area (M<sup>2</sup>)',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->lokasi_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'lokasi_area_hijau',
            'label' => 'Area terbuka hijau',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->lokasi_area_hijau : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        return $fields;
    }
}

/* End of file Bpmppt_obat.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_obat.php */