<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Bpmppt_iui Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Usaha Industri
| ------------------------------------------------------------------------------
*/

class Bpmppt_iui extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'IUI';
    public $alias = 'izin_usaha_industri';
    public $name = 'Izin Usaha Industri';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'permohonan_jenis'    => '',
        'pemohon_nama'        => '',
        'pemohon_kerja'       => '',
        'pemohon_alamat'      => '',
        'pemohon_telp'        => '',
        'pemilik_nama'        => '',
        'pemilik_alamat'      => '',
        'pemilik_telp'        => '',
        'usaha_nama'          => '',
        'usaha_skala'         => '',
        'usaha_npwp'          => '',
        'usaha_alamat'        => '',
        'usaha_telp'          => '',
        'usaha_kawasan'       => '',
        'usaha_pj'            => '',
        'usaha_npwp'          => '',
        'usaha_komoditi_kbli' => '',
        'usaha_komoditi_kki'  => '',
        'usaha_komoditi_prod' => '',
        'usaha_komoditi_sat'  => '',
        'usaha_pekerja_wni'   => '',
        'usaha_pekerja_wna'   => '',
        'usaha_akta_ntrs'     => '',
        'usaha_akta_nomor'    => '',
        'usaha_direksi'       => '',
        'usaha_lokasi'        => '',
        'usaha_investasi'     => '',
        'luas_tanah'          => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Usaha_industri Class Initialized");
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
            'name'  => 'fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_kerja',
            'label' => 'Pekerjaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_kerja : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_telp',
            'label' => 'No. Telp',
            'type'  => 'tel',
            'std'   => ( $data_obj ? $data_obj->pemohon_telp : ''),
            'validation'=> 'numeric' );

        $fields[] = array(
            'name'  => 'fieldset_data_pemilik',
            'label' => 'Data Pemilik Perusahaan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemilik_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemilik_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemilik_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemilik_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemilik_telp',
            'label' => 'No. Telp',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemilik_telp : ''),
            'validation'=> 'numeric' );

        $fields[] = array(
            'name'  => 'fieldset_data_usaha',
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_nama',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_npwp',
            'label' => 'No. NPWP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_npwp : '') );

        $fields[] = array(
            'name'  => 'usaha_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_telp',
            'label' => 'No. Telp',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_telp : ''),
            'validation'=> 'numeric' );

        $fields[] = array(
            'name'  => 'usaha_jenis',
            'label' => 'Jenis Industri',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_pj',
            'label' => 'Nama Penanggungjawab',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_pj : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_komoditi',
            'label' => 'Komoditi Industri',
            'type'  => 'custom',
            'std'   => $this->custom_field( $data_obj ) );

        $fields[] = array(
            'name'  => 'usaha_direksi',
            'label' => 'Nama Direksi',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_direksi : '') );

        $fields[] = array(
            'name'  => 'usaha_lokasi',
            'label' => 'Lokasi Pabrik',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'luas_tanah',
            'label' => 'Luas Tanah (M<sup>2</sup>)',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->luas_tanah : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_investasi',
            'label' => 'Total Investasi',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_investasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_akta',
            'label' => 'Pendirian',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'ntrs',
                    'label' => 'Nama Notaris',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_ntrs : '') ),
                array(
                    'name'  => 'nomor',
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_nomor : '') ),
                )
            );

        $fields[] = array(
            'name'  => 'usaha_pekerja',
            'label' => 'Jumlah Pekerja',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'wni',
                    'label' => 'Indonesia',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->usaha_pekerja_wni : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'wna',
                    'label' => 'Asing',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->usaha_pekerja_wna : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                )
            );

        return $fields;
    }

    // -------------------------------------------------------------------------

    private function custom_field( $data = FALSE )
    {
        if (!$this->_ci->load->is_loaded('table'))
        {
            $this->_ci->load->library('table');
        }

        $this->_ci->table->set_template( $this->table_templ );

        $data_mode = $data and !empty($data->komoditi);

        $head[] = array(
            'data'  => 'Komoditi',
            'class' => 'head-id',
            'width' => '30%' );

        $head[] = array(
            'data'  => 'KBLI',
            'class' => 'head-value',
            'width' => '20%' );

        $head[] = array(
            'data'  => 'Prod. /Tahun',
            'class' => 'head-value',
            'width' => '20%');

        $head[] = array(
            'data'  => 'Satuan',
            'class' => 'head-value',
            'width' => '20%');

        $head[] = array(
            'data'  => form_button( array(
                'name'  => 'komoditi_add-btn',
                'type'  => 'button',
                'class' => 'btn btn-primary bs-tooltip btn-block btn-sm',
                'tabindex' => '-1',
                'title' => 'Tambahkan baris',
                'content'=> 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->_ci->table->set_heading( $head );

        if ( isset( $data->komoditi ) and !empty( $data->komoditi ) )
        {
            foreach ( unserialize( $data->komoditi ) as $row )
            {
                $this->_custom_row( $row );
            }
        }
        else
        {
            $this->_custom_row();
        }

        return $this->_ci->table->generate();
    }

    // -------------------------------------------------------------------------

    private function _custom_row( $data = FALSE )
    {
        $cols = array(
            'kki'  => 'KKI',
            'kbli' => 'KBLI',
            'prod' => 'Produksi pertahun',
            'sat'  => 'Satuan',
            );

        foreach ( $cols as $name => $label )
        {
            $column[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_komoditi_'.$name.'[]',
                    'type'  => 'text',
                    'value' => $data ? $data[$name] : '',
                    'class' => 'form-control bs-tooltip input-sm',
                    'placeholder'=> $label ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );
        }

        $column[] = array(
            'data'  => form_button( array(
                'name'  => $this->alias.'_komoditi_remove-btn',
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

/* End of file Bpmppt_iui.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_iui.php */
