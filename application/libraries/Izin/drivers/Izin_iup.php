<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Izin_iup Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Usaha Pertambangan
| ------------------------------------------------------------------------------
*/

class Izin_iup extends CI_Driver
{
    public
        $code = 'IUP',
        $alias = 'izin_usaha_pertambangan',
        $name = 'Izin Usaha Pertambangan',
        $_defaults = array();

    public function __construct()
    {
        $this->_defaults['data_teknis'] = Bootigniter::get_setting('iup_teknis');
        log_message('debug', '#Izin_driver: '.$this->name.' Class Initialized');
    }

    public function _form()
    {
        $fields['rekomendasi'] = array(
            'label' => 'Surat Rekomendasi',
            'type'  => 'subfield',
            'validation' => 'required',
            'fields'=> array(
                'nomor' => array(
                    'label' => 'Nomor',
                    'type'  => 'text',
                    ),
                'tanggal' => array(
                    'label' => 'Tanggal',
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
            'validation' => 'required',
            );

        $fields['pemohon_an'] = array(
            'label' => 'Atas Nama',
            'type'  => 'text',
            );

        $fields['pemohon_alamat'] = array(
            'label' => 'Alamat',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['fieldset_perijinan'] = array(
            'label' => 'Ketentuan Perijinan',
            'type'  => 'fieldset',
            );

        $fields['tambang_waktu'] = array(
            'label' => 'Jangka waktu',
            'type'  => 'subfield',
            'validation' => 'required',
            'fields'=> array(
                'mulai' => array(
                    'label' => 'Mulai',
                    'type'  => 'datepicker',
                    ),
                'selesai' => array(
                    'label' => 'Selesai',
                    'type'  => 'datepicker',
                    ),
                )
            );

        $fields['tambang_jns_galian'] = array(
            'label' => 'Jenis Galian',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['tambang_luas'] = array(
            'label' => 'Luas Area (M<sup>2</sup>)',
            'type'  => 'text',
            'validation' => 'required',
            );

        $fields['tambang_alamat'] = array(
            'label' => 'Alamat Lokasi',
            'type'  => 'textarea',
            'validation' => 'required',
            );

        $fields['fieldset_tambang'] = array(
            'label' => 'Data Pertambangan',
            'type'  => 'fieldset',
            );

        $fields['data_teknis'] = array(
            'label' => 'Ketentuan Teknis',
            'type'  => 'editor',
            'validation' => 'required',
            );

        $fields['tambang_koor'] = array(
            'label' => 'Kode Koordinat',
            'type'  => 'custom',
            'std'   => $this->_custom_exp_field('tambang_koor', array(
                'no'   => 'No',
                'gb-1' => '&deg;',
                'gb-2' => '&apos;',
                'gb-3' => '&quot;',
                'gl-1' => '&deg;',
                'gl-2' => '&apos;',
                'gl-3' => '&quot;',
                'lsu'  => 'LS/U',
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
        $koor_fn = $this->alias.'_tambang_koor';
        if ( isset( $_POST[$koor_fn.'_no'] ) )
        {
            $i = 0;
            // $koor_fn = $this->alias.'_tambang_koor';
            foreach ($_POST[$koor_fn.'_no'] as $no)
            {
                foreach (array('no', 'gb-1', 'gb-2', 'gb-3', 'gl-1', 'gl-2', 'gl-3', 'lsu') as $name)
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

/* End of file Izin_iup.php */
/* Location: ./application/libraries/Izin/drivers/Izin_iup.php */
