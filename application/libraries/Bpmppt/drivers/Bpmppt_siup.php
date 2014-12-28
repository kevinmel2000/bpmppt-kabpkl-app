<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bpmppt_siup Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Surat Izin Usaha Perdangangan
| ------------------------------------------------------------------------------
*/

class Bpmppt_siup extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'SIUP';
    public $alias = 'surat_izin_usaha_perdagangan';
    public $name = 'Surat Izin Usaha Perdangangan';
    public $prefield_label = 'No. &amp; Tgl. SIUP';
    public $tembusan = FALSE;

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'pengajuan_jenis'                   => '',
        'pembaruan_ke'                      => '',
        'siup_lama'                         => '',
        'pemohon_nama'                      => '',
        'pemilik_ktp'                       => '',
        'pemilik_alamat'                    => '',
        'pemilik_no_telp'                   => '',
        'pemilik_no_fax'                    => '',
        'pemilik_usaha'                     => '',
        'usaha_nama'                        => '',
        'usaha_jenis'                       => '',
        'usaha_skala'                       => '',
        'usaha_kegiatan'                    => '',
        'usaha_lembaga'                     => '',
        'usaha_komoditi'                    => '',
        'usaha_alamat'                      => '',
        'usaha_no_telp'                     => '',
        'usaha_no_fax'                      => '',
        'usaha_pendirian_akta_no'           => '',
        'usaha_pendirian_akta_tgl'          => '',
        'usaha_pendirian_pengesahan_no'     => '',
        'usaha_pendirian_pengesahan_tgl'    => '',
        'usaha_perubahan_akta_no'           => '',
        'usaha_perubahan_akta_tgl'          => '',
        'usaha_perubahan_pengesahan_no'     => '',
        'usaha_perubahan_pengesahan_tgl'    => '',
        'usaha_siup_lama_nomor'             => '',
        'usaha_siup_lama_tgl'               => '',
        'usaha_saham_status'                => '',
        'usaha_modal_awal'                  => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Usaha_perdagangan Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Form fields from this driver
     *
     * @param   bool    $data_obj  Data field
     *
     * @return  array
     */
    public function form( $data_obj = FALSE )
    {
        $fields[] = array(
            'name'  => 'pengajuan_jenis',
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->pengajuan_jenis : ''),
            'option'=> $this->get_field_prop('pendaftaran') );

        $fields[] = array(
            'name'  => 'pembaruan_ke',
            'label' => 'Daftar ulang Ke',
            'type'  => 'text',
            'fold'  => array(
                'key' => $this->alias.'_pengajuan_jenis',
                'value' => 'ulang'
                ),
            'std'   => ( $data_obj ? $data_obj->pembaruan_ke : '') );

        $fields[] = array(
            'name'  => 'siup_lama',
            'label' => 'Data SIUP Lama',
            'type'  => 'custom',
            'std' => $this->custom_field($data_obj),
            'fold'  => array(
                'key' => $this->alias.'_pengajuan_jenis',
                'value' => array('ulang', 'ubah')
                ),
            'validation'=> ( !$data_obj ? '' : '' ) );

        $fields[] = array(
            'name'  => 'fieldset_data_pemilik',
            'label' => 'Data Pemilik Perusahaan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : '') );

        $fields[] = array(
            'name'  => 'pemilik_ktp',
            'label' => 'Nomor KTP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemilik_ktp : '') );

        $fields[] = array(
            'name'  => 'pemilik_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemilik_alamat : '') );

        $fields[] = array(
            'name'  => 'pemilik_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->pemilik_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->pemilik_no_fax : ''),
                    'validation'=> 'numeric' ),
                ));

        $fields[] = array(
            'name'  => 'fieldset_data_usaha',
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : '') );

        $fields[] = array(
            'name'  => 'usaha_jenis',
            'label' => 'Jenis Perusahaan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : ''),
            'option'=> $this->get_field_prop('jenis_usaha') );

        $fields[] = array(
            'name'  => 'usaha_skala',
            'label' => 'Skala Perusahaan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_skala : ''),
            'option'=> $this->get_field_prop('skala_usaha') );

        $fields[] = array(
            'name'  => 'usaha_kegiatan',
            'label' => 'Kegiatan Usaha (KBLI)',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_kegiatan : '') );

        $fields[] = array(
            'name'  => 'usaha_lembaga',
            'label' => 'Kelembagaan',
            'type'  => 'checkbox',
            'std'   => ( $data_obj ? unserialize($data_obj->usaha_lembaga) : ''),
            'option'=> $this->get_field_prop('kelembagaan') );

        $fields[] = array(
            'name'  => 'usaha_komoditi',
            'label' => 'Komoditi Usaha',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_komoditi : '') );

        $fields[] = array(
            'name'  => 'usaha_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : '') );

        $fields[] = array(
            'name'  => 'usaha_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_fax : ''),
                    'validation'=> 'numeric' ),
                ));

        $fields[] = array(
            'name'  => 'usaha_saham_status',
            'label' => 'Status Saham',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_saham_status : ''),
            'option'=> array(
                'pmdm' => 'Penanaman Modal Dalam Negeri',
                'pma'  => 'Penanaman Modal Asing' ));

        $fields[] = array(
            'name'  => 'usaha_modal_awal',
            'label' => 'Modal awal',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_modal_awal : ''),
            'validation'=> ( !$data_obj ? 'required|numeric' : '' ) );

        return $fields;
    }

    // -------------------------------------------------------------------------

    private function custom_field( $data = FALSE )
    {
        if (!$this->_ci->load->is_loaded('table'))
        {
            $this->_ci->load->library('table');
        }

        $this->_ci->table->set_template($this->table_templ);

        $data_mode = $data and !empty($data->siup_lama);

        // var_dump($this);
        $head[] = array(
            'data'  => 'Nomor SIUP',
            'class' => 'head-id',
            'width' => '45%' );

        $head[] = array(
            'data'  => 'Tanggal SIUP',
            'class' => 'head-value',
            'width' => '45%' );

        $head[] = array(
            'data'  => form_button( array(
                'name'  => 'siup_lama_add-btn',
                'type'  => 'button',
                'class' => 'btn btn-primary bs-tooltip btn-block btn-sm',
                'tabindex' => '-1',
                'title' => 'Tambahkan baris',
                'content'=> 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->_ci->table->set_heading( $head );

        if (isset($data->siup_lama) and !empty($data->siup_lama))
        {
            foreach (unserialize($data->siup_lama) as $row)
            {
                $this->_row_siup_lama($row);
            }
        }
        else
        {
            $this->_row_siup_lama();
        }

        return $this->_ci->table->generate();
    }

    // -------------------------------------------------------------------------

    private function _row_siup_lama($data = FALSE)
    {
        $cols = array(
            'no'  => 'Nomor',
            'tgl' => 'Tanggal',
            );

        foreach ($cols as $name => $label)
        {
            $column[] = array(
                'data'  => form_input(array(
                    'name'  => $this->alias.'_siup_lama_'.$name.'[]',
                    'type'  => 'text',
                    'value' => $data ? $data[$name] : '',
                    'class' => 'form-control bs-tooltip input-sm',
                    'placeholder'=> $label ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );
        }

        $column[] = array(
            'data'  => form_button( array(
                'name'  => $this->alias.'_siup_lama_remove-btn',
                'type'  => 'button',
                'class' => 'btn btn-danger bs-tooltip btn-block btn-sm remove-btn',
                'tabindex' => '-1',
                'content'=> '&times;' ) ),
            'class' => '',
            'width' => '10%' );

        $this->_ci->table->add_row( $column );
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

/* End of file Bpmppt_siup.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_siup.php */
