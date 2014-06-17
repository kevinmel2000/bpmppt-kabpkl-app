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
 * BPMPPT Izin Penyimpanan Sementara dan Pengumpulan Limbah Bahan Berbahaya dan 
 * Beracun Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_b3 extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'B3';
    public $alias = 'izin_pengelolaan_b3';
    public $name = 'Izin Penyimpanan Sementara dan Pengumpulan Limbah Bahan Berbahaya dan Beracun';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'pemohon_nama'      => '',
        'pemohon_alamat'    => '',
        'pemohon_jabatan'   => '',
        'daftar_nomor'      => '',
        'daftar_tanggal'    => '',
        'usaha_nama'        => '',
        'usaha_bidang'      => '',
        'usaha_alamat'      => '',
        'usaha_lokasi'      => '',
        'usaha_kontak_telp' => '',
        'usaha_kontak_fax'  => '',
        'usaha_tps_fungsi'  => '',
        'usaha_tps_ukuran'  => '',
        'usaha_tps_koor_s'  => '',
        'usaha_tps_koor_e'  => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Pengelolaan_b3 Class Initialized");
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
            'attr'  => ( $data_obj ? 'disabled' : '' ),
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
            'name'  => 'pemohon_jabatan',
            'label' => 'Jabatan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_jabatan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'fieldset_data_daftar',
            'label' => 'Data Pendaftaran',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'daftar_nomor',
            'label' => 'Nomor Daftar Permohonan.',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->daftar_nomor : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'daftar_tanggal',
            'label' => 'Tanggal Daftar Permohonan.',
            'type'  => 'datepicker',
            'std'   => ( $data_obj ? $data_obj->daftar_tanggal : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'fieldset_data_usaha',
            'label' => 'Data Perusahaan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_nama',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_bidang',
            'label' => 'Bidang usaha',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_bidang : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_alamat',
            'label' => 'Alamat Kantor',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_lokasi',
            'label' => 'Lokasi Usaha',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_kontak',
            'label' => 'Nomor Telp. &amp; Fax.',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'telp',
                    'label' => 'No. Telpon',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->usaha_kontak_telp : '') ),
                array(
                    'name'  => 'fax',
                    'label' => 'No. Fax',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->usaha_kontak_fax : '') ),
                )
            );

        $fields[] = array(
            'name'  => 'usaha_tps',
            'label' => 'Tempat Pembuangan Sementara',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'fungsi',
                    'label' => 'Keterangan fungsi',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_tps_fungsi : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'ukuran',
                    'label' => 'Ukuran',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_tps_ukuran : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'koor_s',
                    'label' => 'Koor. S',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_tps_koor_s : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'koor_e',
                    'label' => 'Koor. E',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_tps_koor_e : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                )
            );

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

/* End of file Bpmppt_b3.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_b3.php */