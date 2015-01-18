<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Izin_reklame Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Reklame
| ------------------------------------------------------------------------------
*/

class Izin_reklame extends CI_Driver
{
    public
        $alias = 'izin_reklame',
        $name  = 'Izin Reklame',
        $_tembusan = array(
            'Inspektur Kabupaten Pekalongan',
            'Ka. DPU Kabupaten Pekalongan',
            'Ka. DPPKD Kabupaten Pekalongan',
            'Ka. Dinhub Kominfo Kabupaten Pekalongan',
            'Ka. Satpol PP Kabupaten Pekalongan',
            'Ka. Bag. Hukum Setda Kabupaten Pekalongan',
            );

    public function __construct()
    {
        log_message('debug', '#Izin_driver: '.$this->name.' Class Initialized');
    }

    public function _form()
    {
        $fields['pengajuan_jenis'] = array(
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'option'=> array( 'Pendaftaran Baru', 'Perpanjangan' ),
            'validation' => 'required',
            );

        $fields['fieldset_data_pemohon'] = array(
            'label' => 'Data Pemohon',
            'type'  => 'fieldset',
            );

        $fields['pemohon_nama'] = array(
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['pemohon_usaha'] = array(
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
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

        $fields['fieldset_data_reklame'] = array(
            'label' => 'Data Reklame',
            'type'  => 'fieldset',
            );

        $fields['reklame_juml'] = array(
            'label' => 'Jumlah',
            'type'  => 'subfield',
            'validation' => 'required',
            'fields' => array(
                'val' => array(
                    'label' => 'Jumlah',
                    'type'  => 'text',
                    ),
                'unit' => array(
                    'label' => 'Unit',
                    'type'  => 'dropdown',
                    'option'=> array( 'Unit', 'Buah' ),
                    ),
                )
            );

        $fields['reklame_range'] = array(
            'label' => 'Jangka waktu',
            'type'  => 'subfield',
            'validation' => 'required',
            'fields'=> array(
                'tgl_text' => array(
                    'label' => 'Terbilang',
                    'type'  => 'text',
                    ),
                'tgl_mulai' => array(
                    'label' => 'Mulai Tanggal',
                    'type'  => 'datepicker',
                    ),
                'tgl_selesai' => array(
                    'label' => 'Sampai Tanggal',
                    'type'  => 'datepicker',
                    ),
                )
            );

        $fields['reklame_data'] = array(
            'label' => 'Data Reklame',
            'type'  => 'custom',
            'std'   => $this->_custom_exp_field('reklame_data', array(
                'jenis'   => array('width' => 15, 'data' => 'Jenis' ),
                'tema'    => array('width' => 20, 'data' => 'Tema' ),
                'tempat'  => array('width' => 20, 'data' => 'Lokasi' ),
                'panjang' => array('width' => 7,  'data' => 'Panjang (M)' ),
                'lebar'   => array('width' => 7,  'data' => 'Lebar (M)' ),
                '2x'      => array('width' => 6,  'data' => '2&times;', 'type' => 'checkbox' ),
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
        $slug = $this->alias.'_reklame_data';
        if (isset($_POST[$slug.'_tempat']))
        {
            $i = 0;
            foreach ($_POST[$slug.'_tempat'] as $no)
            {
                foreach (array('jenis', 'tema', 'tempat', 'panjang', 'lebar', '2x') as $name)
                {
                    $slug_name = $slug.'_'.$name;
                    $data[$i][$name] = isset($_POST[$slug_name][$i]) ? $_POST[$slug_name][$i] : 0;
                    unset($_POST[$slug_name][$i]);
                }

                $i++;
            }

            $form_data[$slug] = $data;
        }

        return $form_data;
    }
}

/* End of file Izin_reklame.php */
/* Location: ./application/libraries/Izin/drivers/Izin_reklame.php */
