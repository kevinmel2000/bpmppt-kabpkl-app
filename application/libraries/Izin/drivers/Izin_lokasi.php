<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Izin_lokasi Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Lokasi
| ------------------------------------------------------------------------------
*/

class Izin_lokasi extends CI_Driver
{
    public
        $alias = 'izin_lokasi',
        $name = 'Izin Lokasi';

    public function _form()
    {
        $fields['fieldset_data_pemohon'] = array(
            'label' => 'Data Pemohon',
            'type'  => 'fieldset',
            );

        $fields['pemohon_nama'] = array(
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['pemohon_jabatan'] = array(
            'label' => 'Jabatan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['pemohon_usaha'] = array(
            'label' => 'Perusahaan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['pemohon_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['fieldset_data_lokasi'] = array(
            'label' => 'Data Lokasi',
            'type'  => 'fieldset',
            );

        $fields['lokasi_tujuan'] = array(
            'label' => 'Jenis Permohonan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['lokasi_alamat'] = array(
            'label' => 'Alamat Lokasi',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['lokasi_luas'] = array(
            'label' => 'Luas Area (M<sup>2</sup>)',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['lokasi_area_hijau'] = array(
            'label' => 'Area terbuka hijau',
            'type'  => 'text',
            'validation' => 'required'
            );

        return $fields;
    }
}

/* End of file Izin_lokasi.php */
/* Location: ./application/libraries/Izin/drivers/Izin_lokasi.php */
