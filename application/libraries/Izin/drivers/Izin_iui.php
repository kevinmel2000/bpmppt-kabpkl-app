<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Izin_iui Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Usaha Industri
| ------------------------------------------------------------------------------
*/

class Izin_iui extends CI_Driver
{
    public
        $code = 'IUI',
        $alias = 'izin_usaha_industri',
        $name = 'Izin Usaha Industri';

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

        $fields['pemohon_kerja'] = array(
            'label' => 'Pekerjaan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['pemohon_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['pemohon_telp'] = array(
            'label' => 'No. Telp',
            'type'  => 'text',
            'validation' => 'numeric',
            );

        $fields['fieldset_data_pemilik'] = array(
            'label' => 'Data Pemilik Perusahaan',
            'type'  => 'fieldset',
            );

        $fields['pemilik_nama'] = array(
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['pemilik_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['pemilik_telp'] = array(
            'label' => 'No. Telp',
            'type'  => 'text',
            'validation' => 'numeric',
            );

        $fields['fieldset_data_usaha'] = array(
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset',
            );

        $fields['usaha_nama'] = array(
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_npwp'] = array(
            'label' => 'No. NPWP',
            'type'  => 'text',
            );

        $fields['usaha_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['usaha_telp'] = array(
            'label' => 'No. Telp',
            'type'  => 'text',
            'validation' => 'numeric',
            );

        $fields['usaha_jenis'] = array(
            'label' => 'Jenis Industri',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_pj'] = array(
            'label' => 'Nama Penanggungjawab',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_komoditi'] = array(
            'label' => 'Komoditi Industri',
            'type'  => 'custom',
            'std'   => $this->_custom_exp_field('usaha_komoditi', array(
                'kki'  => 'KKI',
                'kbli' => 'KBLI',
                'prod' => 'Produksi pertahun',
                'sat'  => 'Satuan',
                )),
            );

        $fields['usaha_direksi'] = array(
            'label' => 'Nama Direksi',
            'type'  => 'text',
            );

        $fields['usaha_lokasi'] = array(
            'label' => 'Lokasi Pabrik',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['luas_tanah'] = array(
            'label' => 'Luas Tanah (M<sup>2</sup>)',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_investasi'] = array(
            'label' => 'Total Investasi',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['usaha_akta'] = array(
            'label' => 'Pendirian',
            'type'  => 'subfield',
            'fields'=> array(
                'ntrs' => array(
                    'label' => 'Nama Notaris',
                    'type'  => 'text',
                    ),
                'nomor' => array(
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    ),
                )
            );

        $fields['usaha_pekerja'] = array(
            'label' => 'Jumlah Pekerja',
            'type'  => 'subfield',
            'validation' => 'required',
            'fields'=> array(
                'wni' => array(
                    'label' => 'Indonesia',
                    'type'  => 'number',
                    ),
                'wna' => array(
                    'label' => 'Asing',
                    'type'  => 'number',
                    ),
                )
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
        $koor_fn = $this->alias.'_komoditi';
        if ( isset( $_POST[$koor_fn.'_kki'] ) )
        {
            $i = 0;
            // $koor_fn = $this->alias.'_komoditi';
            foreach ($_POST[$koor_fn.'_kki'] as $no)
            {
                foreach (array('kki', 'kbli', 'prod', 'sat') as $name)
                {
                    $koor_name = $koor_fn.'_'.$name;
                    $koordinat[$i][$name] = isset($_POST[$koor_name][$i]) ? $_POST[$koor_name][$i] : 0;
                    unset($_POST[$koor_name][$i]);
                }

                $i++;
            }

            $form_data[$koor_fn] = $koordinat;
        }

        return $form_data;
    }
}

/* End of file Izin_iui.php */
/* Location: ./application/libraries/Izin/drivers/Izin_iui.php */
