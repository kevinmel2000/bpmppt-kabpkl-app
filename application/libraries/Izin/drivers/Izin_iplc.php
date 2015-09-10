<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Izin_iplc Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Pembuangan Air Limbah ke Air atau Sumber Air
| ------------------------------------------------------------------------------
*/

class Izin_iplc extends CI_Driver
{
    public
        $code = 'IPLC',
        $alias = 'izin_pembuangan_air_limbah',
        $name = 'Izin Pembuangan Air Limbah ke Air atau Sumber Air',
        $_prefield_label = 'No. &amp; Tgl. Input',
        $_defaults = array();

    public function __construct()
    {
        $this->_defaults['data_teknis'] = Bootigniter::get_setting('iplc_teknis');
    }

    public function _form()
    {
        $fields['masa_berlaku'] = array(
            'label' => 'Masa Berlaku',
            'type'  => 'subfield',
            'validation' => 'required',
            'fields' => array(
                'text' => array(
                    'label' => 'Terbilang',
                    'type'  => 'text',
                    ),
                'mulai' => array(
                    'label' => 'Mulai',
                    'type'  => 'datepicker',
                    ),
                'selesai' => array(
                    'label' => 'Selesai',
                    'type'  => 'datepicker',
                    ),
                ));

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
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['pemohon_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['pemohon_lokasi'] = array(
            'label' => 'Lokasi',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['data_teknis'] = array(
            'label' => 'Data Teknis',
            'type'  => 'editor',
            'validation' => 'required',
            );

        $fields['debits'] = array(
            'label' => 'Data Debit Limbah',
            'type'  => 'custom',
            'std'   => $this->_custom_exp_field('debits', array(
                'param'        => 'Parameter',
                'proses_kadar' => 'Kadar max proses (Mg/l)',
                'proses_beban' => 'Beban pencemaran proses (Mg/l)',
                'kond_kadar'   => 'Kadar max kondensor (Mg/l)',
                'kond_beban'   => 'Beban pencemaran kondensor (Mg/l)',
                ))
            );

        return $fields;
    }

    // -------------------------------------------------------------------------

    public function _pre_post($form_data)
    {
        $custom_fields = array('param', 'proses_kadar', 'proses_beban', 'kond_kadar', 'kond_beban');

        foreach ($custom_fields as $field)
        {
            $slug = $this->alias.'_debits';
            if (isset($form_data[$slug][$field]))
            {
                foreach ($form_data[$slug][$field] as $i => $val)
                {
                    $form_data[$slug]['body'][$i][$field] = $val ?: '';
                    unset($form_data[$slug][$field]);
                }
            }
            elseif ($form_data[$slug][$field.'_head'])
            {
                $form_data[$slug]['head'][$field] = $form_data[$slug][$field.'_head'];
                unset($form_data[$slug][$field.'_head']);
            }
        }

        return $form_data;
    }
}

/* End of file Izin_iplc.php */
/* Location: ./application/libraries/Izin/drivers/Izin_iplc.php */
