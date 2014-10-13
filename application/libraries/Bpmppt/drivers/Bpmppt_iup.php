<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bpmppt_iup Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Usaha Pertambangan
| ------------------------------------------------------------------------------
*/

class Bpmppt_iup extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'IUP';
    public $alias = 'izin_usaha_pertambangan';
    public $name = 'Izin Usaha Pertambangan';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'rekomendasi_nomor'     => '',
        'rekomendasi_tanggal'   => '',
        'pemohon_nama'          => '',
        'pemohon_alamat'        => '',
        'tambang_waktu_mulai'   => '',
        'tambang_waktu_selesai' => '',
        'tambang_jns_galian'    => '',
        'tambang_luas'          => '',
        'tambang_alamat'        => '',
        'tambang_koor'          => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Usaha_pertambangan Class Initialized");
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
            'name'  => 'rekomendasi',
            'label' => 'Surat Rekomendasi',
            'type'  => 'subfield',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'fields'=> array(
                array(
                    'name'  => 'nomor',
                    'label' => 'Nomor',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->rekomendasi_nomor : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'tanggal',
                    'label' => 'Tanggal',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? format_date($data_obj->rekomendasi_tanggal) : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ),
                    'callback'=> 'string_to_date' ),
                ));

        $fields[] = array(
            'name'  => 'fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            // 'attr'  => ( $data_obj ? array( 'disabled' => TRUE ) : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'fieldset_perijinan',
            'label' => 'Ketentuan Perijinan',
            // 'attr'  => ( $data_obj ? array( 'disabled' => TRUE ) : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'tambang_waktu',
            'label' => 'Jangka waktu',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'mulai',
                    'label' => 'Mulai',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->tambang_waktu_mulai : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'col'   => '6',
                    'name'  => 'selesai',
                    'label' => 'Selesai',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->tambang_waktu_selesai : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ),
                    'callback'=> 'string_to_date' ),
                ));

        $fields[] = array(
            'name'  => 'tambang_jns_galian',
            'label' => 'Jenis Galian',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->tambang_jns_galian : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'tambang_luas',
            'label' => 'Luas Area (M<sup>2</sup>)',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->tambang_luas : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'tambang_alamat',
            'label' => 'Alamat Lokasi',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->tambang_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'fieldset_tambang',
            'label' => 'Data Pertambangan',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'tambang_koor',
            'label' => 'Kode Koordinat',
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

        $this->_ci->table->set_template( $this->table_templ );

        $data_mode = $data and !empty($data->tambang_koor);

        // var_dump($this);
        $head[] = array(
            'data'  => 'No. Titik',
            'class' => 'head-id',
            'width' => '10%' );

        $head[] = array(
            'data'  => 'Garis Bujur',
            'class' => 'head-value',
            'width' => '30%',
            'colspan'=> 3 );

        $head[] = array(
            'data'  => 'Garis Lintang',
            'class' => 'head-value',
            'width' => '30%',
            'colspan'=> 4 );

        $head[] = array(
            'data'  => form_button( array(
                'name'  => 'tambang_koor_add-btn',
                'type'  => 'button',
                'class' => 'btn btn-primary bs-tooltip btn-block btn-sm',
                'tabindex' => '-1',
                'title' => 'Tambahkan baris',
                'content'=> 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->_ci->table->set_heading( $head );

        if ( isset( $data->tambang_koor ) and !empty( $data->tambang_koor ) )
        {
            foreach ( unserialize( $data->tambang_koor ) as $row )
            {
                $this->_row_koordinat( $row );
            }
        }
        else
        {
            $this->_row_koordinat();
        }

        return $this->_ci->table->generate();
    }

    // -------------------------------------------------------------------------

    private function _row_koordinat( $data = FALSE )
    {
        $cols = array(
            'no'   => 'No',
            'gb-1' => '&deg;',
            'gb-2' => '&apos;',
            'gb-3' => '&quot;',
            'gl-1' => '&deg;',
            'gl-2' => '&apos;',
            'gl-3' => '&quot;',
            'lsu'  => 'LS/U',
            );

        foreach ( $cols as $name => $label )
        {
            $column[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_tambang_koor_'.$name.'[]',
                    'type'  => 'text',
                    'value' => $data ? $data[$name] : '',
                    'class' => 'form-control bs-tooltip input-sm',
                    'placeholder'=> $label ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );
        }

        $column[] = array(
            'data'  => form_button( array(
                'name'  => $this->alias.'_tambang_koor_remove-btn',
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

/* End of file Bpmppt_iup.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_iup.php */
