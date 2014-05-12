<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BPMPPT driver
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     BPMPPT
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 1.0
 * @filesource
 */

// =============================================================================

/**
 * BPMPPT Izin Usaha Pertambangan Driver
 *
 * @subpackage  Drivers
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
    public $fields = array(
        'rekomendasi_nomor'     => '',
        'rekomendasi_tanggal'   => '',
        'pemohon_nama'          => '',
        'pemohon_alamat'        => '',
        'tambang_waktu_mulai'   => '',
        'tambang_waktu_selesai' => '',
        'tambang_jns_galian'    => '',
        'tambang_luas'          => '',
        'tambang_alamat'        => '',
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
        $fields[]   = array(
            'name'  => $this->alias.'_rekomendasi',
            'label' => 'Surat Rekomendasi',
            'type'  => 'subfield',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'nomor',
                    'label' => 'Nomor',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->rekomendasi_nomor : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'col'   => '6',
                    'name'  => 'tanggal',
                    'label' => 'Tanggal',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->rekomendasi_tanggal : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ),
                    'callback'=> 'string_to_date' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            'attr'  => ( $data_obj ? array( 'disabled' => TRUE ) : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_perijinan',
            'label' => 'Ketentuan Perijinan',
            'attr'  => ( $data_obj ? array( 'disabled' => TRUE ) : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_tambang_waktu',
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

        $fields[]   = array(
            'name'  => $this->alias.'_tambang_jns_galian',
            'label' => 'Jenis Galian',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->tambang_jns_galian : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_tambang_luas',
            'label' => 'Luas Area (M<sup>2</sup>)',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->tambang_luas : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_tambang_alamat',
            'label' => 'Alamat Lokasi',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->tambang_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_tambang',
            'label' => 'Data Pertambangan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_tambang_koor',
            'label' => 'Kode Koordinat',
            'type'  => 'custom',
            'value' => $this->custom_field($data_obj, 'tambang_koor'),
            'validation'=> ( !$data_obj ? '' : '' ) );

        return $fields;
    }

    // -------------------------------------------------------------------------

    private function custom_field( $data = FALSE, $field_name )
    {
        // if ( ! $this->load->is_loaded('table'))
        $ci =& get_instance();
        $ci->load->library('table');
        $ci->table->set_template( array('table_open' => '<table id="table-koordinat" class="table table-exp table-striped table-hover table-condensed">' ) );

        $data_mode = $data and !empty($data->$field_name);

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
        
        if (!$data_mode)
        {
            $head[] = array(
                'data'  => form_button( array(
                    'name'  => $this->alias.'_'.$field_name.'_add-btn',
                    'type'  => 'button',
                    'class' => 'btn btn-primary bs-tooltip btn-block btn-sm',
                    'value' => 'add',
                    'title' => 'Tambahkan baris',
                    'content'=> 'Add' ) ),
                'class' => 'head-action',
                'width' => '10%' );
        }

        $ci->table->set_heading( $head );

        if ( $data and !empty($data->$field_name) )
        {
            $i = 0;
            foreach ( unserialize($data->$field_name) as $row )
            {
                $cols[$i][] = array(
                    'data'  => $row['no'],
                    'class' => 'data-id',
                    'width' => '10%' );

                $cols[$i][] = array(
                    'data'  => $row['gb-1'],
                    'class' => 'data-id',
                    'width' => '10%' );

                $cols[$i][] = array(
                    'data'  => $row['gb-2'],
                    'class' => 'data-id',
                    'width' => '10%' );

                $cols[$i][] = array(
                    'data'  => $row['gb-3'],
                    'class' => 'data-id',
                    'width' => '10%' );

                $cols[$i][] = array(
                    'data'  => $row['gl-1'],
                    'class' => 'data-id',
                    'width' => '10%' );

                $cols[$i][] = array(
                    'data'  => $row['gl-2'],
                    'class' => 'data-id',
                    'width' => '10%' );

                $cols[$i][] = array(
                    'data'  => $row['gl-3'],
                    'class' => 'data-id',
                    'width' => '10%' );

                $cols[$i][] = array(
                    'data'  => $row['lsu'],
                    'class' => 'data-id',
                    'width' => '10%' );

                $ci->table->add_row( $cols[$i] );
                $i++;
            }
        }
        else
        {
            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_'.$field_name.'_no[]',
                    'type'  => 'text',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nomor titik',
                    'placeholder'=> 'No' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_'.$field_name.'_gb-1[]',
                    'type'  => 'text',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &deg; Garis Bujur',
                    'placeholder'=> '&deg;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_'.$field_name.'_gb-2[]',
                    'type'  => 'text',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &apos; Garis Bujur',
                    'placeholder'=> '&apos;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_'.$field_name.'_gb-3[]',
                    'type'  => 'text',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &quot; Garis Bujur',
                    'placeholder'=> '&quot;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_'.$field_name.'_gl-1[]',
                    'type'  => 'text',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &deg; Garis Lintang',
                    'placeholder'=> '&deg;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_'.$field_name.'_gl-2[]',
                    'type'  => 'text',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &apos; Garis Lintang',
                    'placeholder'=> '&apos;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_'.$field_name.'_gl-3[]',
                    'type'  => 'text',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &quot; Garis Lintang',
                    'placeholder'=> '&quot;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_'.$field_name.'_lsu[]',
                    'type'  => 'text',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'ini tooltip',
                    'placeholder'=> 'LS/U' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            if (!$data_mode)
            {
                $cols[] = array(
                    'data'  => form_button( array(
                        'name'  => $this->alias.'_'.$field_name.'_remove-btn',
                        'type'  => 'button',
                        'class' => 'btn btn-danger bs-tooltip btn-block btn-sm remove-btn',
                        'value' => 'remove',
                        'title' => 'Hapus baris ini',
                        'content'=> '&times;' ) ),
                    'class' => '',
                    'width' => '10%' );
            }

            $ci->table->add_row( $cols );
        }

        return $ci->table->generate();
    }

    // -------------------------------------------------------------------------

    /**
     * Format cetak produk perijinan
     *
     * @return  mixed
     */
    public function produk()
    {
        return false;
    }

    // -------------------------------------------------------------------------

    /**
     * Format output laporan
     *
     * @return  mixed
     */
    public function laporan()
    {
        return false;
    }
}

/* End of file Bpmppt_iup.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_iup.php */