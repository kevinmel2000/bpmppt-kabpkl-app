<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Bpmppt_tdp Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Tanda Daftar Perusahaan
| ------------------------------------------------------------------------------
*/

class Bpmppt_tdp extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'TDP';
    public $alias = 'tanda_daftar_perusahaan';
    public $name = 'Tanda Daftar Perusahaan';
    public $prefield_label = 'No. &amp; Tgl. Agenda';
    public $tembusan = FALSE;

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'daftar_no'                         => '',
        'daftar_tgl'                        => '',
        'no_tdp'                            => '',
        'no_sk'                             => '',
        'tgl_berlaku'                       => '',
        'pengajuan_jenis'                   => '',
        'pembaruan_ke'                      => '',
        'pemohon_nama'                      => '',
        'pemilik_ktp'                       => '',
        'pemilik_alamat'                    => '',
        'pemilik_kwn'                       => '',
        // 'pemilik_lahir_tmpt'                => '',
        // 'pemilik_lahir_tgl'                 => '',
        'pemilik_no_telp'                   => '',
        'pemilik_no_fax'                    => '',
        'usaha_nama'                        => '',
        'usaha_jenis'                       => '',
        'usaha_skala'                       => '',
        'usaha_status'                      => '',
        'usaha_alamat'                      => '',
        'usaha_no_telp'                     => '',
        'usaha_no_fax'                      => '',
        'usaha_pokok'                       => '',
        'usaha_kbli'                        => '',
        'usaha_pendirian_akta_no'           => '',
        'usaha_pendirian_akta_tgl'          => '',
        'usaha_pendirian_pengesahan_no'     => '',
        'usaha_pendirian_pengesahan_tgl'    => '',
        'usaha_pendirian_pengesahan_uraian' => '',
        'usaha_perubahan_akta_no'           => '',
        'usaha_perubahan_akta_tgl'          => '',
        'usaha_perubahan_pengesahan_no'     => '',
        'usaha_perubahan_pengesahan_tgl'    => '',
        'usaha_perubahan_pengesahan_uraian' => '',
        'usaha_npwp'                        => '',
        'usaha_saham_status'                => '',
        'usaha_modal_awal'                  => '',
        'usaha_data_pengesahan'             => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Tanda_daftar_perusahaan Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Form fields from this driver
     *
     * @param   bool    $data_obj  Data field
     * @return  array
     */
    public function form( $data_obj = FALSE )
    {
        $fields[] = array(
            'name'  => 'no_tdp',
            'label' => 'Nomor TDP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->no_tdp : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'tgl_berlaku',
            'label' => 'Tgl. Masa Berlaku',
            'type'  => 'datepicker',
            'callback'=> 'string_to_date',
            'std'   => ( $data_obj ? format_date($data_obj->tgl_berlaku) : '') );

        $fields[] = array(
            'name'  => 'pengajuan_jenis',
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->pengajuan_jenis : ''),
            'option'=> array(
                'daftar baru'   => 'Pendaftaran Baru',
                'balik nama'    => 'Balik Nama',
                'daftar ulang'  => 'Daftar Ulang' ));

        $fields[] = array(
            'name'  => 'pembaruan_ke',
            'label' => 'Daftar ulang Ke',
            'type'  => 'number',
            'fold'  => array(
                'key'   => $this->alias.'_pengajuan_jenis',
                'value' => 'daftar ulang' ),
            'std'   => ( $data_obj ? $data_obj->pembaruan_ke : ''));

        $fields[] = array(
            'name'  => 'fieldset_data_pemilik',
            'label' => 'Data Pemilik Perusahaan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''));

        $fields[] = array(
            'name'  => 'pemilik_ktp',
            'label' => 'Nomor KTP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemilik_ktp : ''));

        $fields[] = array(
            'name'  => 'pemilik_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemilik_alamat : ''));

        $fields[] = array(
            'name'  => 'pemilik_kwn',
            'label' => 'Kewarganegaraan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->pemilik_kwn : ''),
            'option'=> array(
                'wni' => 'Warga Negara Indonesia',
                'wna' => 'Warga Negara Asing' ));

        // $fields[] = array(
        //     'name'  => 'pemilik_lahir',
        //     'label' => 'Tempat &amp; Tgl. Lahir',
        //     'type'  => 'subfield',
        //     'fields'=> array(
        //         array(
        //             'name'  => 'tmpt',
        //             'label' => 'Tempat Lahir',
        //             'type'  => 'text',
        //             'std'   => ( $data_obj ? $data_obj->pemilik_lahir_tmpt : '') ),
        //         array(
        //             'name'  => 'tgl',
        //             'label' => 'Tanggal Lahir',
        //             'type'  => 'datepicker',
        //             'std'   => ( $data_obj ? format_date($data_obj->pemilik_lahir_tgl) : '') ,
        //             'callback'=> 'string_to_date' ),
        //         ));

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
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''));

        $u_jenis = array(
            'Perseroan Terbatas (PT)',
            'Perseroan Komanditer (CV)',
            'Badan Usaha Milik Negara (BUMN)',
            'Perorangan (PO)',
            'Koperasi',
            );

        foreach ( $u_jenis as $jenis )
        {
            $jns_opt[$jenis] = $jenis;
        }

        $fields[] = array(
            'name'  => 'usaha_jenis',
            'label' => 'Jenis Perusahaan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : ''),
            'option'=> $jns_opt );

        $fields[] = array(
            'name'  => 'daftar',
            'label' => 'Nomor &amp; Tgl. Pendaftaran',
            'type'  => 'subfield',
            'fold'  => array(
                'key' => $this->alias.'_usaha_jenis',
                'value' => 'Perseroan Terbatas (PT)',
                ),
            'fields'=> array(
                array(
                    'name'  => 'no',
                    'label' => 'Nomor Pendaftaran',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->daftar_no : '') ),
                array(
                    'name'  => 'tgl',
                    'label' => 'Tanggal Pendaftaran',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? format_date($data_obj->daftar_tgl) : '') ,
                    'callback'=> 'string_to_date' ),
                ));

        $fields[] = array(
            'name'  => 'usaha_skala',
            'label' => 'Skala Perusahaan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_skala : ''),
            'option'=> array(
                'PMK' => 'Perusahaan Mikro',
                'PK' => 'Perusahaan Kecil',
                'PM' => 'Menengah',
                'PB' => 'Besar'
            ));

        $fields[] = array(
            'name'  => 'usaha_status',
            'label' => 'Status Perusahaan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_status : ''),
            'option'=> array(
                'tunggal'    => 'Kantor Tunggal',
                'pusat'      => 'Kantor Pusat',
                'cabang'     => 'Kantor Cabang',
                'pembantu'   => 'Kantor Pembantu',
                'perwakilan' => 'Kantor Perwakilan' ));

        $fields[] = array(
            'name'  => 'usaha_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''));

        $fields[] = array(
            'name'  => 'usaha_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_telp : '') ),
                array(
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_fax : '') ),
                ));

        /**
         * 0 - 50   Usaha kecil
         * 50 - 500 Menengah
         * 500 >    Besar
         */

        $fields[] = array(
            'name'  => 'fieldset_data_usaha_kegiatan',
            'label' => 'Kegiatan Usaha',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_pokok',
            'label' => 'Kegiatan Usaha Pokok',
            'type'  => 'editor',
            'std'   => ( $data_obj ? $data_obj->usaha_pokok : ''));

        $fields[] = array(
            'name'  => 'usaha_kbli',
            'label' => 'KBLI',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_kbli : ''));

        $fields[] = array(
            'name'  => 'fieldset_data_usaha_saham',
            'label' => 'Data Modal Usaha',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_npwp',
            'label' => 'NPWP Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_npwp : '') );

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
            'std'   => ( $data_obj ? $data_obj->usaha_modal_awal : '') );

        // $fields[] = array(
        //     'name'  => 'usaha_saham_nilai',
        //     'label' => 'Nilai Saham',
        //     'type'  => 'subfield',
        //     'fields'=> array(
        //         array(
        //             'col'   => '6',
        //             'name'  => 'total',
        //             'label' => 'Total Nilai Saham (Rp.)',
        //             'type'  => 'text',
        //             'std'   => ( $data_obj ? $data_obj->usaha_saham_nilai_total : ''),
        //             'validation'=> ( !$data_obj ? 'numeric' : '' ) ),
        //         array(
        //             'col'   => '3',
        //             'name'  => 'nasional',
        //             'label' => 'Nasional (%)',
        //             'type'  => 'text',
        //             'max'   => 100,
        //             'std'   => ( $data_obj ? $data_obj->usaha_saham_nilai_nasional : ''),
        //             'validation'=> ( !$data_obj ? 'numeric' : '' ) ),
        //         array(
        //             'col'   => '3',
        //             'name'  => 'tgl',
        //             'label' => 'Asing (%)',
        //             'type'  => 'text',
        //             'max'   => 100,
        //             'std'   => ( $data_obj ? $data_obj->usaha_saham_nilai_tgl : ''),
        //             'validation'=> ( !$data_obj ? 'numeric' : '' ) ),
        //         ));

        $fields[] = array(
            'name'  => 'fieldset_data_usaha_akta',
            'label' => 'Data Akta dan Pengesahan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_data_pengesahan',
            'label' => 'Data Pengesahan',
            'type'  => 'custom',
            'std' => $this->custom_field( $data_obj ),
            'validation'=> ( !$data_obj ? '' : '' ) );

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

        $data_mode = $data and !empty($data->usaha_data_pengesahan);

        // var_dump($this);
        $head[] = array(
            'data'  => 'Nomor Akta',
            'class' => 'head-id',
            'width' => '25%' );

        $head[] = array(
            'data'  => 'Tanggal Akta',
            'class' => 'head-value',
            'width' => '25%' );

        $head[] = array(
            'data'  => 'Uraian',
            'class' => 'head-value',
            'width' => '40%' );

        $head[] = array(
            'data'  => form_button( array(
                'name'  => 'usaha_data_pengesahan_add-btn',
                'type'  => 'button',
                'class' => 'btn btn-primary bs-tooltip btn-block btn-sm',
                'tabindex' => '-1',
                'title' => 'Tambahkan baris',
                'content'=> 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->_ci->table->set_heading( $head );

        if (isset($data->usaha_data_pengesahan) and !empty($data->usaha_data_pengesahan))
        {
            foreach (unserialize($data->usaha_data_pengesahan) as $row)
            {
                $this->_row_pengesahan($row);
            }
        }
        else
        {
            $this->_row_pengesahan();
        }

        return $this->_ci->table->generate();
    }

    // -------------------------------------------------------------------------

    private function _row_pengesahan( $data = FALSE )
    {
        $cols = array(
            'no'     => 'Nomor Akta',
            'tgl'    => 'Tanggal Akta',
            'uraian' => 'Uraian',
            );

        foreach ($cols as $name => $label)
        {
            $column[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_usaha_data_pengesahan_'.$name.'[]',
                    'type'  => 'text',
                    'value' => $data ? $data[$name] : '',
                    'class' => 'form-control bs-tooltip input-sm',
                    'placeholder'=> $label ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );
        }

        $column[] = array(
            'data'  => form_button( array(
                'name'  => $this->alias.'_usaha_data_pengesahan_remove-btn',
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
        $pengesahan_fn = $this->alias.'_usaha_data_pengesahan';

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

/* End of file Bpmppt_tdp.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_tdp.php */
