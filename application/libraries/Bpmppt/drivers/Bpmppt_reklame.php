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
 * @copyright   Copyright (c) Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kab. Pekalongan
 * @license     http://dbad-license.org
 * @since       Version 1.0
 */

// =============================================================================

/**
 * BPMPPT Izin Reklame Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_reklame extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $alias
     * @var  string  $name
     */
    public $alias = 'izin_reklame';
    public $name  = 'Izin Reklame';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'pemohon_nama'              => '',
        'pemohon_kerja'             => '',
        'pemohon_alamat'            => '',
        'pemohon_telp'              => '',
        'reklame_jenis'             => '',
        'reklame_juml'              => '',
        'reklame_lokasi'            => '',
        'reklame_ukuran_panjang'    => '',
        'reklame_ukuran_lebar'      => '',
        'reklame_range_tgl_text'    => '',
        'reklame_range_tgl_mulai'   => '',
        'reklame_range_tgl_selesai' => '',
        'reklame_tema'              => '',
        'reklame_ket'               => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Reklame Class Initialized");
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
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
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
            'name'  => 'fieldset_data_reklame',
            'label' => 'Data Reklame',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'reklame_jenis',
            'label' => 'Jenis Reklame',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->reklame_jenis : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'reklame_juml',
            'label' => 'Jumlah',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->reklame_juml : ''),
            'validation'=> 'required|numeric' );

        $fields[] = array(
            'name'  => 'reklame_lokasi',
            'label' => 'Lokasi pemasangan',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->reklame_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'reklame_ukuran',
            'label' => 'Ukuran (P x L)',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'panjang',
                    'label' => 'Panjang',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->reklame_ukuran_panjang : ''),
                    'validation'=> 'required|numerik' ),
                array(
                    'name'  => 'lebar',
                    'label' => 'Lebar',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->reklame_ukuran_lebar : ''),
                    'validation'=> 'required|numerik' ),
                )
            );

        $fields[] = array(
            'name'  => 'reklame_range',
            'label' => 'Jangka waktu',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'tgl_text',
                    'label' => 'Terbilang',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->reklame_range_tgl_text : ''),
                    'validation'=> 'required' ),
                array(
                    'name'  => 'tgl_mulai',
                    'label' => 'Mulai Tanggal',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->reklame_range_tgl_mulai : ''),
                    'validation'=> 'required|numerik' ),
                array(
                    'name'  => 'tgl_selesai',
                    'label' => 'Sampai Tanggal',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->reklame_range_tgl_selesai : ''),
                    'validation'=> 'required|numerik' ),
                )
            );

        $fields[] = array(
            'name'  => 'reklame_tema',
            'label' => 'Tema/Isi',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->reklame_tema : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'reklame_ket',
            'label' => 'Keterangan',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->reklame_ket : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        return $fields;
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

/* End of file Bpmppt_reklame.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_reklame.php */