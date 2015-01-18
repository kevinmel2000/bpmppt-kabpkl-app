<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Izin_tdp Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Tanda Daftar Perusahaan
| ------------------------------------------------------------------------------
*/

class Izin_tdp extends CI_Driver
{
    public
        $code = 'TDP',
        $alias = 'tanda_daftar_perusahaan',
        $name = 'Tanda Daftar Perusahaan',
        $_prefield_label = 'No. &amp; Tgl. Agenda',
        $_tembusan = FALSE;

    public function _form()
    {
        $fields['no_tdp'] = array(
            'label' => 'Nomor TDP',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['tgl_berlaku'] = array(
            'label' => 'Tgl. Masa Berlaku',
            'type'  => 'datepicker',
            );

        $fields['pengajuan_jenis'] = array(
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'option'=> $this->get_field_prop('pendaftaran'),
            );

        $fields['pembaruan_ke'] = array(
            'label' => 'Daftar ulang Ke',
            'type'  => 'number',
            'fold'  => array(
                'key'   => 'pengajuan_jenis',
                'value' => 'ulang',
                ),
            );

        $fields['fieldset_data_pemilik'] = array(
            'label' => 'Data Pemilik Perusahaan',
            'type'  => 'fieldset',
            );

        $fields['pemohon_nama'] = array(
            'label' => 'Nama lengkap',
            'type'  => 'text',
            );

        $fields['pemilik_ktp'] = array(
            'label' => 'Nomor KTP',
            'type'  => 'text',
            );

        $fields['pemilik_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            );

        $fields['pemilik_kwn'] = array(
            'label' => 'Kewarganegaraan',
            'type'  => 'radio',
            'option'=> array(
                'wni' => 'Warga Negara Indonesia',
                'wna' => 'Warga Negara Asing',
                ),
            );

        $fields['pemilik_no'] = array(
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                'telp' => array(
                    'label' => 'Telpon',
                    'type'  => 'text',
                    ),
                'fax' => array(
                    'label' => 'Faksimili',
                    'type'  => 'text',
                    ),
                ),
            );

        $fields['fieldset_data_usaha'] = array(
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset',
            );

        $fields['usaha_nama'] = array(
            'label' => 'Nama lengkap',
            'type'  => 'text',
            );

        $fields['usaha_jenis'] = array(
            'label' => 'Jenis Perusahaan',
            'type'  => 'radio',
            'option'=> $this->get_field_prop('jenis_usaha')
            );

        $fields['daftar'] = array(
            'label' => 'Nomor &amp; Tgl. Pendaftaran',
            'type'  => 'subfield',
            'fold'  => array(
                'key' => 'usaha_jenis',
                'value' => array( 'Perseroan Terbatas (PT)', 'Koperasi' ),
                ),
            'fields'=> array(
                'no' => array(
                    'label' => 'Nomor Pendaftaran',
                    'type'  => 'text',
                    ),
                'tgl' => array(
                    'label' => 'Tanggal Pendaftaran',
                    'type'  => 'datepicker',
                    ),
                ),
            );

        $fields['usaha_skala'] = array(
            'label' => 'Skala Perusahaan',
            'type'  => 'radio',
            'option'=> $this->get_field_prop('skala_usaha'),
            );

        $fields['usaha_status'] = array(
            'label' => 'Status Perusahaan',
            'type'  => 'radio',
            'option'=> array(
                'tunggal'    => 'Kantor Tunggal',
                'pusat'      => 'Kantor Pusat',
                'cabang'     => 'Kantor Cabang',
                'pembantu'   => 'Kantor Pembantu',
                'perwakilan' => 'Kantor Perwakilan',
                ),
            );

        $fields['usaha_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            );

        $fields['usaha_no'] = array(
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                'telp' => array(
                    'label' => 'Telpon',
                    'type'  => 'text',
                    ),
                'fax' => array(
                    'label' => 'Faksimili',
                    'type'  => 'text',
                    ),
                )
            );

        $fields['fieldset_data_usaha_kegiatan'] = array(
            'label' => 'Kegiatan Usaha',
            'type'  => 'fieldset',
            );

        $fields['usaha_pokok'] = array(
            'label' => 'Kegiatan Usaha Pokok',
            'type'  => 'editor',
            );

        $fields['usaha_kbli'] = array(
            'label' => 'KBLI',
            'type'  => 'text',
            );

        $fields['fieldset_data_usaha_saham'] = array(
            'label' => 'Data Modal Usaha',
            'type'  => 'fieldset',
            );

        $fields['usaha_npwp'] = array(
            'label' => 'NPWP Perusahaan',
            'type'  => 'text',
            );

        $fields['usaha_saham_status'] = array(
            'label' => 'Status Saham',
            'type'  => 'radio',
            'option'=> array(
                'pmdm' => 'Penanaman Modal Dalam Negeri',
                'pma'  => 'Penanaman Modal Asing',
                )
            );

        $fields['usaha_modal_awal'] = array(
            'label' => 'Modal awal',
            'type'  => 'text',
            );

        $fields['fieldset_data_usaha_akta'] = array(
            'label' => 'Data Akta dan Pengesahan',
            'type'  => 'fieldset',
            );

        $fields['usaha_data_pengesahan'] = array(
            'label' => 'Data Pengesahan',
            'type'  => 'custom',
            'std' => $this->_custom_exp_field('usaha_data_pengesahan', array(
                'no'     => array( 'width' => 25, 'data' => 'Nomor Akta' ),
                'tgl'    => array( 'width' => 25, 'data' => 'Tanggal Akta', 'type' => 'date' ),
                'uraian' => array( 'width' => 40, 'data' => 'Uraian' ),
                )),
            );

        return $fields;
    }

    // -------------------------------------------------------------------------

    /**
     * Prepost form data hooks
     *
     * @return  mixed
     */
    public function _pre_post( $form_data )
    {
        $pengesahan_fn = 'usaha_data_pengesahan';
        if (isset($_POST[$pengesahan_fn.'_no']))
        {
            $i = 0;
            foreach ($_POST[$pengesahan_fn.'_no'] as $no)
            {
                foreach (array('no', 'tgl', 'uraian') as $name)
                {
                    $pengesahan_name = $pengesahan_fn.'_'.$name;
                    $pengesahan[$i][$name] = isset($_POST[$pengesahan_name][$i]) ? $_POST[$pengesahan_name][$i] : 0;
                    unset($_POST[$pengesahan_name][$i]);
                }

                $i++;
            }

            $form_data[$pengesahan_fn] = $pengesahan;
        }

        return $form_data;
    }
}

/* End of file Izin_tdp.php */
/* Location: ./application/libraries/Izin/drivers/Izin_tdp.php */
