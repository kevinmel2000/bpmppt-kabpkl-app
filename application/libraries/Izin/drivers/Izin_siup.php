<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Izin_siup Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Surat Izin Usaha Perdangangan
| ------------------------------------------------------------------------------
*/

class Izin_siup extends CI_Driver
{
    public
        $code = 'SIUP',
        $alias = 'surat_izin_usaha_perdagangan',
        $name = 'Surat Izin Usaha Perdangangan',
        $_prefield_label = 'No. &amp; Tgl. SIUP',
        $_tembusan = FALSE;

    public function _form()
    {
        $fields['pengajuan_jenis'] = array(
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'option'=> $this->get_field_prop('pendaftaran'),
            );

        $fields['pembaruan_ke'] = array(
            'label' => 'Daftar ulang Ke',
            'type'  => 'text',
            'fold'  => array(
                'key' => 'pengajuan_jenis',
                'value' => 'ulang'
                ),
            );

        $fields['siup_lama'] = array(
            'label' => 'Data SIUP Lama',
            'type'  => 'custom',
            'std'   => $this->_custom_exp_field('siup_lama', array(
                'no'  => 'Nomor',
                'tgl' => array('data' => 'Tanggal', 'type' => 'date'),
                )),
            'fold'  => array(
                'key' => 'pengajuan_jenis',
                'value' => array('ulang', 'ubah')
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
                )
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
            'option'=> $this->get_field_prop('jenis_usaha'),
            );

        $fields['usaha_skala'] = array(
            'label' => 'Skala Perusahaan',
            'type'  => 'radio',
            'option'=> $this->get_field_prop('skala_usaha'),
            );

        $fields['usaha_kegiatan'] = array(
            'label' => 'Kegiatan Usaha (KBLI)',
            'type'  => 'text',
            );

        $fields['usaha_lembaga'] = array(
            'label' => 'Kelembagaan',
            'type'  => 'checkbox',
            'option'=> $this->get_field_prop('kelembagaan'),
            );

        $fields['usaha_lembaga_lain'] = array(
            'label' => 'Kelembagaan Lain',
            'type'  => 'text',
            'fold'  => array(
                'key' => 'usaha_lembaga[]',
                'value' => 'Lainnya',
                ),
            );

        $fields['usaha_komoditi'] = array(
            'label' => 'Komoditi Usaha',
            'type'  => 'textarea',
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
            'type'  => 'number',
            'validation' => 'numeric'
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
        $pengesahan_fn = $this->alias.'_siup_lama';
        if (isset($_POST[$pengesahan_fn.'_no']))
        {
            $i = 0;
            foreach ($_POST[$pengesahan_fn.'_no'] as $no)
            {
                foreach (array('no', 'tgl') as $name)
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

/* End of file Izin_siup.php */
/* Location: ./application/libraries/Izin/drivers/Izin_siup.php */
