<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     Bapa Pack BPMPPT
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
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

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_tembusan',
            'label' => 'Tembusan Dokumen',
            'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
            'type'  => 'fieldset' );

        $fields[] = $this->field_tembusan($data_obj, $this->alias);

        return $fields;
    }

    // -------------------------------------------------------------------------

    private function custom_field( $data = FALSE, $field_name )
    {
        // if ( ! $this->load->is_loaded('table'))
        if (!$this->_ci->load->is_loaded('table'))
        {
            $this->_ci->load->library('table');
        }

        $this->_ci->table->set_template( $this->table_templ );

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

        $this->_ci->table->set_heading( $head );

        if ( $data_mode )
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

                $this->_ci->table->add_row( $cols[$i] );
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

            $this->_ci->table->add_row( $cols );
        }

        return $this->_ci->table->generate();
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