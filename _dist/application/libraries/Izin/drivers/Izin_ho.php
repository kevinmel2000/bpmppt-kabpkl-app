<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Izin_ho Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Gangguan
| ------------------------------------------------------------------------------
*/

class Izin_ho extends CI_Driver
{
    public
        $code = 'HO',
        $alias = 'izin_gangguan',
        $name = 'Izin Gangguan',
        $_prefield_label = 'No. &amp; Tgl. Input';

    public function __construct()
    {
        log_message('debug', '#Izin_driver: '.$this->name.' Class Initialized');
    }

    public function _form()
    {
        $fields['surat_kode'] = array(
            'label' => 'Kode Nomor',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['surat_jenis_pengajuan'] = array(
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'option'=> array('Pendaftaran Baru', 'Balik Nama', 'Daftar Ulang'),
            'validation' => 'required',
            );

        $fields['ho_lama'] = array(
            'label' => 'HO Lama',
            'type'  => 'subfield',
            'fold'  => array(
                'key'   => 'surat_jenis_pengajuan',
                'value' => 'Daftar Ulang'
                ),
            'validation' => 'required',
            'fields' => array(
                'no' => array(
                    'label' => 'No. HO Lama',
                    'type'  => 'text',
                    ),
                'tgl' => array(
                    'label' => 'Tanggal HO Lama',
                    'type'  => 'datepicker',
                    ),
                'ho' => array(
                    'label' => 'Keterangan',
                    'type'  => 'text',
                    ),
                )
            );

        $fields['pemohon_tanggal'] = array(
            'label' => 'Tanggal Permohonan',
            'type'  => 'datepicker',
            'validation' => 'required',
            );

        $fields['fieldset_data_pemohon'] = array(
            'label' => 'Data Pemohon',
            'type'  => 'fieldset',
            );

        $fields['pemohon_nama'] = array(
            'label' => 'Nama Lengkap',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['pemohon_jabatan'] = array(
            'label' => 'Jabatan Pemohon',
            'type'  => 'text',
            );

        $fields['pemohon_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['pemohon_telp'] = array(
            'label' => 'Nomor Telpon/HP',
            'type'  => 'text',
            'validation' => 'max_length[12]'
            );

        $fields['fieldset_data_perusahaan'] = array(
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset'
            );

        $fields['usaha_nama'] = array(
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_skala'] = array(
            'label' => 'Skala Perusahaan',
            'type'  => 'radio',
            'option'=> $this->get_field_prop('jenis_usaha'),
            'validation' => 'required',
            );

        $fields['usaha_jenis'] = array(
            'label' => 'Jenis Usaha',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_alamat'] = array(
            'label' => 'Alamat Kantor',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['usaha_tanah_milik'] = array(
            'label' => 'A.N. Kepemilikan Tanah',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_lokasi'] = array(
            'label' => 'Lokasi Perusahaan',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['usaha_luas'] = array(
            'label' => 'Luas perusahaan (M<sup>2</sup>)',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['fieldset_data_tetangga'] = array(
            'label' => 'Data Tetangga',
            'type'  => 'fieldset',
            );

        $fields['usaha_tetangga_timur'] = array(
            'label' => 'Tetangga sebelah timur',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_tetangga_utara'] = array(
            'label' => 'Tetangga sebelah utara',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_tetangga_selatan'] = array(
            'label' => 'Tetangga sebelah selatan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_tetangga_barat'] = array(
            'label' => 'Tetangga sebelah barat',
            'type'  => 'text',
            'validation' => 'required',
            );

        return $fields;
    }
}

/* End of file Izin_ho.php */
/* Location: ./application/libraries/Izin/drivers/Izin_ho.php */
