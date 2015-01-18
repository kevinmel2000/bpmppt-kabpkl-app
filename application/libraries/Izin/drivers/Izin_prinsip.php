<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Izin_prinsip Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Persetujuan
| ------------------------------------------------------------------------------
*/

class Izin_prinsip extends CI_Driver
{
    public
        $alias = 'persetujuan_prinsip',
        $name = 'Persetujuan Prinsip';

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
            'label' => 'Tujuan Permohonan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['lokasi_alamat'] = array(
            'label' => 'Alamat Lokasi',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['lokasi_nama'] = array(
            'label' => 'Luas Area (M<sup>2</sup>)',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['lokasi_area_hijau'] = array(
            'label' => 'Area terbuka hijau',
            'type'  => 'text',
            'validation' => 'required',
            );

        return $fields;
    }
}

/* End of file Izin_prinsip.php */
/* Location: ./application/libraries/Izin/drivers/Izin_prinsip.php */
