<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Izin_wisata Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Usaha Pariwisata
| ------------------------------------------------------------------------------
*/

class Izin_wisata extends CI_Driver
{
    public
        $alias = 'pariwisata',
        $name = 'Izin Usaha Pariwisata';

    public function _form()
    {
        $fields['penetapan'] = array(
            'label' => 'No. &amp; Tgl. Ditetapkan',
            'type'  => 'subfield',
            'fields'=> array(
                'nomor' => array(
                    'label' => 'Nomor Ditetapkan',
                    'type'  => 'text',
                    ),
                'tgl' => array(
                    'label' => 'Tanggal Ditetapkan',
                    'type'  => 'datepicker',
                    ),
                )
            );

        $fields['fieldset_data_pemohon'] = array(
            'label' => 'Data Pemohon',
            'type'  => 'fieldset',
            );

        $fields['pemohon_nama'] = array(
            'label' => 'Nama lengkap',
            'type'  => 'text',
            );

        $fields['pemohon_kerja'] = array(
            'label' => 'Pekerjaan',
            'type'  => 'text',
            );

        $fields['pemohon_jabatan'] = array(
            'label' => 'Jabatan',
            'type'  => 'text',
            );

        $fields['pemohon_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            );

        $fields['pemohon_telp'] = array(
            'label' => 'Nomor Telpon/HP',
            'type'  => 'text',
            );

        $fields['fieldset_data_perusahaan'] = array(
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset',
            );

        $fields['usaha_nama'] = array(
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            );

        $fields['usaha_jenis'] = array(
            'label' => 'Jenis Usaha',
            'type'  => 'text',
            );

        $fields['usaha_alamat'] = array(
            'label' => 'Alamat Kantor',
            'type'  => 'textarea',
            );

        $fields['usaha_luas'] = array(
            'label' => 'Luas perusahaan (M<sup>2</sup>)',
            'type'  => 'text',
            );

        $fields['usaha_an'] = array(
            'label' => 'Atas Nama Pendirian',
            'type'  => 'text',
            );

        $fields['usaha_ket'] = array(
            'label' => 'Keterangan Lain',
            'type'  => 'textarea',
            );

        return $fields;
    }
}

/* End of file Izin_wisata.php */
/* Location: ./application/libraries/Izin/drivers/Izin_wisata.php */
