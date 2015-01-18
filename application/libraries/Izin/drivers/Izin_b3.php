<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Izin_b3 Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Penyimpanan Sementara dan Pengumpulan Limbah Bahan Berbahaya dan Beracun
| ------------------------------------------------------------------------------
*/

class Izin_b3 extends CI_Driver
{
    public
        $code = 'LB3',
        $alias = 'izin_pengelolaan_b3',
        $name = 'Izin Penyimpanan Sementara dan Pengumpulan Limbah Bahan Berbahaya dan Beracun',
        $_prefield_label = 'No. &amp; Tgl. Input',
        $_defaults = array();

    public function __construct()
    {
        $this->_defaults['ketentuan_teknis'] = Bootigniter::get_setting('b3_teknis');

        log_message('debug', '#Izin_driver: '.$this->name.' Class Initialized');
    }

    public function _form()
    {
        $fields['fieldset_data_pemohon'] = array(
            'label' => 'Data Pemohon',
            'type'  => 'fieldset'
            );

        $fields['pemohon_nama'] = array(
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['pemohon_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['pemohon_jabatan'] = array(
            'label' => 'Jabatan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['fieldset_data_daftar'] = array(
            'label' => 'Data Pendaftaran',
            'type'  => 'fieldset'
            );

        $fields['daftar_nomor'] = array(
            'label' => 'Nomor Surat Permohonan.',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['daftar_tanggal'] = array(
            'label' => 'Tanggal Surat Permohonan.',
            'type'  => 'datepicker',
            'validation' => 'required',
            );

        $fields['fieldset_data_usaha'] = array(
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset'
            );

        $fields['usaha_nama'] = array(
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_bidang'] = array(
            'label' => 'Bidang usaha',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_alamat'] = array(
            'label' => 'Alamat Kantor',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['usaha_lokasi'] = array(
            'label' => 'Lokasi Usaha',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['usaha_kontak'] = array(
            'label' => 'Nomor Telp. &amp; Fax.',
            'type'  => 'subfield',
            'fields'=> array(
                'telp' => array(
                    'label' => 'No. Telpon',
                    'type'  => 'text',
                    ),
                'fax' => array(
                    'label' => 'No. Fax',
                    'type'  => 'text',
                    ),
                )
            );

        $fields['fieldset_ketentuan'] = array(
            'label' => 'Ketentuan',
            'type'  => 'fieldset',
            );

        $fields['ketentuan_teknis'] = array(
            'label' => 'Ketentuan Teknis',
            'type'  => 'editor',
            'validation' => 'required',
            );

        return $fields;
    }
}

/* End of file Izin_b3.php */
/* Location: ./application/libraries/Izin/drivers/Izin_b3.php */
