<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT
 * @subpackage  Bpmppt_prinsip Driver
 * @category    Drivers
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) BPMPPT Kab. Pekalongan
 * @license     http://github.com/feryardiant/bpmppt/blob/master/LICENSE
 * @since       Version 0.1.5
 */

/*
| ------------------------------------------------------------------------------
| Persetujuan
| ------------------------------------------------------------------------------
*/

class Bpmppt_prinsip extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $alias
     * @var  string  $name
     */
    public $alias = 'persetujuan_prinsip';
    public $name = 'Persetujuan Prinsip';

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
        log_message('debug', "#BPMPPT_driver: Persetujuan_prinsip Class Initialized");
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
            'type'  => 'number',
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

/* End of file Bpmppt_prinsip.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_prinsip.php */
