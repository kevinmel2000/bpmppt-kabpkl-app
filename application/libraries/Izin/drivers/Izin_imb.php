<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Izin_imb Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Mendirikan Bangunan
| ------------------------------------------------------------------------------
*/

class Izin_imb extends CI_Driver
{
    public
        $code = 'IMB',
        $alias = 'izin_mendirikan_bangunan',
        $name = 'Izin Mendirikan Bangunan',
        $_tembusan = FALSE;

    public function _form()
    {
        $fields['bangunan_maksud'] = array(
            'label' => 'Maksud Permohonan',
            'type'  => 'radio',
            'option'=> array(
                'baru'  => 'Mendirikan Bangunan Baru',
                'rehap' => 'Perbaikan/Rehab Bangunan Lama'
                ),
            'validation' => 'required',
            );

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

        $fields['fieldset_data_tanah'] = array(
            'label' => 'Data Tanah',
            'type'  => 'fieldset'
            );

        $fields['bangunan_tanah_keadaan'] = array(
            'label' => 'Keadaan Tanah',
            'type'  => 'radio',
            'option'=> array( 'Pertanian', 'Non-Pertanian' ),
            'validation' => 'required',
            );

        $fields['bangunan_tanah_status'] = array(
            'label' => 'Status Tanah',
            'type'  => 'radio',
            'option'=> array(
                'hm' => 'Hak milik',
                'hg' => 'Hak guna bangunan'
                ),
            'validation' => 'required',
            );

        $fields['bangunan_tanah'] = array(
            'label' => 'Kepemilikan Tanah',
            'type'  => 'custom',
            'std'   => $this->_custom_exp_field('bangunan_tanah', array(
                'no'   => 'Nomor Kepemilikan',
                'an'   => 'Atas Nama Pemilik',
                'luas' => 'Luas Tanah (M)',
                ))
            );

        $fields['fieldset_data_bangunan'] = array(
            'label' => 'Data Bangunan',
            'type'  => 'fieldset'
            );

        $fields['bangunan_lokasi'] = array(
            'label' => 'Lokasi Bangunan',
            'type'  => 'subfield',
            'validation' => 'required',
            'fields'=> array(
                'kel' => array(
                    'label' => 'Desa/Kel.',
                    'type'  => 'text',
                    ),
                'kec' => array(
                    'label' => 'Kec.',
                    'type'  => 'text',
                    ),
                )
            );

        $fields['bangunan_area'] = array(
            'label' => 'Data Bangunan',
            'type'  => 'custom',
            'std'   => $this->_custom_exp_field('bangunan_area', array(
                'guna'    => 'Guna Bangunan',
                'panjang' => 'Panjang (M)',
                'lebar'   => 'Lebar (M)',
                ))
            );

        $fields['bangunan_koefisien'] = array(
            'label' => 'Data Koefisien',
            'type'  => 'custom',
            'std'   => $this->_custom_exp_field('bangunan_koefisien', array(
                'bwk'    => 'BWK',
                'luas'   => 'Luas',
                'tinggi' => 'Tinggi',
                'guna'   => 'Guna',
                'letak'  => 'Letak',
                'kons'   => 'Konstruksi',
                ))
            );

        return $fields;
    }

    // -------------------------------------------------------------------------

    public function _pre_post($form_data)
    {
        $luas = $koef = array();
        $custom_fields = array(
            'bangunan_area' => array(
                'guna'    => 'Guna Bangunan',
                'panjang' => 'Panjang (M)',
                'lebar'   => 'Lebar (M)',
                ),
            'bangunan_koefisien' => array(
                'bwk'    => 'BWK',
                'luas'   => 'Luas',
                'tinggi' => 'Tinggi',
                'guna'   => 'Guna',
                'letak'  => 'Letak',
                'kons'   => 'Konstruksi',
                ),
            );

        $_form_data = array();

        foreach ($custom_fields as $slug => $subs)
        {
            foreach ($subs as $sub => $label)
            {
                foreach ($form_data[$slug][$sub] as $i => $value)
                {
                    $_form_data[$slug][$i][$sub] = $value;
                }

            }

            foreach ($_form_data[$slug] as $i => $subs)
            {
                if ($slug == 'bangunan_area')
                {
                    $luas[$i] = $subs['panjang'] * $subs['lebar'];
                    $form_data[$slug]['luas'][$i] = $luas[$i];
                }

                if ($slug == 'bangunan_koefisien')
                {
                    $koef[$i] = $subs['bwk'] * $subs['luas'] * $subs['tinggi'] * $subs['guna'] * $subs['letak'] * $subs['kons'];
                    $form_data[$slug]['koef'][$i] = $koef[$i];
                }
            }
        }

        foreach ($_form_data[$slug] as $a => $su)
        {
            $form_data['bangunan_hasil'][$a]['sempendan']  = ((.25/100) * 1000000 * $luas[$a] * $koef[$a]);
            $form_data['bangunan_hasil'][$a]['pengawasan'] = ((.02/100) * 1000000 * $luas[$a] * $koef[$a]);
            $form_data['bangunan_hasil'][$a]['koreksi']    = ((.01/100) * 1000000 * $luas[$a] * $koef[$a]);
        }

        return $form_data;
    }
}

/* End of file Izin_imb.php */
/* Location: ./application/libraries/Izin/drivers/Izin_imb.php */
