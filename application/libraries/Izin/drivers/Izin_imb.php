<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
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
        $luas = $koef = 0;
        foreach ($this->_custom as $custom => $subs)
        {
            $slug = $this->alias.'_'.$custom;
            foreach ($subs as $field => $label)
            {
                if (isset($form_data[$slug][$field]))
                {
                    foreach ($form_data[$slug][$field] as $i => $val)
                    {
                        $form_data[$slug][$i][$field] = $val ?: '';
                        unset($form_data[$slug][$field]);
                    }
                }
            }

            foreach ($form_data[$slug] as $e => $yield)
            {
                if ($custom == 'bangunan_area')
                {
                    $luas = (int) $yield['panjang'] * (int) $yield['lebar'];
                    $form_data[$slug][$e]['luas'] = $luas;
                }

                if ($custom == 'bangunan_koefisien')
                {
                    $koef = (int) $yield['bwk'] * (int) $yield['luas'] * (int) $yield['tinggi'] * (int) $yield['guna'] * (int) $yield['letak'] * (int) $yield['kons'];
                    $form_data[$slug][$e]['koef'] = $koef;
                }
            }
        }

        if ($luas > 0 && $koef > 0)
        {
            foreach ($form_data[$slug] as $a => $su)
            {
                $form_data[$this->alias.'_form'][$a]['sempendan']  = (.25/100) * 1000000 * $luas * $koef;
                $form_data[$this->alias.'_form'][$a]['pengawasan'] = (.02/100) * 1000000 * $luas * $koef;
                $form_data[$this->alias.'_form'][$a]['koreksi']    = (.01/100) * 1000000 * $luas * $koef;
            }
        }

        return $form_data;
    }
}

/* End of file Izin_imb.php */
/* Location: ./application/libraries/Izin/drivers/Izin_imb.php */
