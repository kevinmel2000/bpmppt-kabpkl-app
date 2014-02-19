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
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
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
            'name'  => $this->alias.'_fieldset_tambang',
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
                    'name'  => 'nomor',
                    'label' => 'Mulai',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->tambang_waktu_mulai : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'col'   => '6',
                    'name'  => 'tanggal',
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
            'label' => 'Ketentuan Perijinan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_tambang_koor',
            'label' => 'Kode Koordinat',
            'type'  => 'custom',
            'value' => $this->custom_field(),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        return $fields;
    }

    // -------------------------------------------------------------------------

    private function custom_field( $data = NULL)
    {
        // if ( ! $this->load->is_loaded('table'))
        $this->load->library('table');

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
                'name'  => 'no',
                'type'  => 'button',
                'id'    => 'no',
                'class' => 'btn btn-primary bs-tooltip btn-block btn-sm',
                'value' => 'add',
                'title' => 'Tambahkan baris',
                'content'=> 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->table->set_heading( $head );

        if ( ! is_null( $data ) )
        {
            foreach ( $query->result() as $row )
            {
                $cols[] = array(
                    'data'  => anchor($form_link.'/'.$row->id, '#'.$row->id),
                    'class' => 'data-id',
                    'width' => '10%' );

                $cols[] = array(
                    'data'  => '<strong>'.anchor($form_link.'/'.$row->id, 'No. '.$row->no_agenda).'</strong><br><small class="text-muted">'.format_datetime($row->created_on).'</small>',
                    'class' => 'data-value',
                    'width' => '30%' );

                $cols[] = array(
                    'data'  => '<strong>'.$row->petitioner.'</strong><br><small class="text-muted">'.format_datetime($row->adopted_on).'</small>',
                    'class' => 'data-value',
                    'width' => '30%' );

                $cols[] = array(
                    'data'  => $row->status,
                    'class' => '',
                    'width' => '10%' );
            }
        }
        else
        {
            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => 'no',
                    'type'  => 'text',
                    'id'    => 'no',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nomor titik',
                    'placeholder'=> 'No' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => 'no',
                    'type'  => 'text',
                    'id'    => 'no',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &deg; Garis Bujur',
                    'placeholder'=> '&deg;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => 'no',
                    'type'  => 'text',
                    'id'    => 'no',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &apos; Garis Bujur',
                    'placeholder'=> '&apos;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => 'no',
                    'type'  => 'text',
                    'id'    => 'no',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &quot; Garis Bujur',
                    'placeholder'=> '&quot;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => 'no',
                    'type'  => 'text',
                    'id'    => 'no',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &deg; Garis Lintang',
                    'placeholder'=> '&deg;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => 'no',
                    'type'  => 'text',
                    'id'    => 'no',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &apos; Garis Lintang',
                    'placeholder'=> '&apos;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => 'no',
                    'type'  => 'text',
                    'id'    => 'no',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'Masukan nilai &quot; Garis Lintang',
                    'placeholder'=> '&quot;' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_input( array(
                    'name'  => 'no',
                    'type'  => 'text',
                    'id'    => 'no',
                    'class' => 'form-control bs-tooltip input-sm',
                    'title' => 'ini tooltip',
                    'placeholder'=> 'LS/U' ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );

            $cols[] = array(
                'data'  => form_button( array(
                    'name'  => 'no',
                    'type'  => 'button',
                    'id'    => 'no',
                    'class' => 'btn btn-danger bs-tooltip btn-block btn-sm',
                    'value' => 'remove',
                    'title' => 'Hapus baris ini',
                    'content'=> '&times;' ) ),
                'class' => '',
                'width' => '10%' );
        }

        $this->table->add_row( $cols );

        $this->table->set_template( array('table_open' => '<table id="table-koordinat" class="table table-striped table-hover table-condensed">' ) );

        return $this->table->generate();
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