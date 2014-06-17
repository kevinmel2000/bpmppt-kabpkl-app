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
 * BPMPPT Izin Usaha Industri Driver
 *
 * @subpackage  Drivers
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
        'permohonan_jenis'  => '',
        'pemohon_nama'      => '',
        'pemohon_kerja'     => '',
        'pemohon_alamat'    => '',
        'pemohon_telp'      => '',
        'pemilik_nama'      => '',
        'pemilik_alamat'    => '',
        'pemilik_telp'      => '',
        'usaha_nama'        => '',
        'usaha_skala'       => '',
        'usaha_npwp'        => '',
        'usaha_alamat'      => '',
        'usaha_telp'        => '',
        'usaha_kawasan'     => '',
        'usaha_pj'          => '',
        'usaha_npwp'        => '',
        'usaha_jenis_kbli'  => '',
        'usaha_jenis_kki'   => '',
        'usaha_akta_ntrs'   => '',
        'usaha_akta_nomor'  => '',
        'usaha_direksi'     => '',
        'usaha_lokasi'      => '',
        'usaha_nama'        => '',
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
            'name'  => 'permohonan_jenis',
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->permohonan_jenis : ''),
            'option'=> array(
                'Pendaftaran Baru' => 'Pendaftaran Baru',
                'Balik Nama'       => 'Balik Nama',
                'Daftar Ulang'     => 'Daftar Ulang' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pembaruan_ke',
            'label' => 'Daftar ulang Ke',
            'type'  => 'text',
            'fold'  => array(
                'key'   => $this->alias.'_surat_jenis_pengajuan',
                'value' => 'Daftar Ulang'
                ),
            'std'   => ( $data_obj ? $data_obj->pembaruan_ke : '') );

        $fields[] = array(
            'name'  => 'fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            'type'  => 'fieldset',
            'attr'  => ( $data_obj ? 'disabled' : '' ));

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
            'type'  => 'fieldset',
            'attr'  => ( $data_obj ? 'disabled' : '' ));

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
            'type'  => 'tel',
            'std'   => ( $data_obj ? $data_obj->pemilik_telp : ''),
            'validation'=> 'numeric' );

        $fields[] = array(
            'name'  => 'fieldset_data_usaha',
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset',
            'attr'  => ( $data_obj ? 'disabled' : '' ));

        $fields[] = array(
            'name'  => 'usaha_nama',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_skala',
            'label' => 'Skala',
            'type'  => 'dropdown',
            'std'   => ( $data_obj ? $data_obj->usaha_skala : ''),
            'option'=> add_placeholder(array(
                'kecil'     => 'Perusahaan Kecil',
                'menengah'  => 'Perusahaan Menengah',
                'besar'     => 'Perusahaan Besar' )) ,
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_npwp',
            'label' => 'No. NPWP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_npwp : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_telp',
            'label' => 'No. Telp',
            'type'  => 'tel',
            'std'   => ( $data_obj ? $data_obj->usaha_telp : ''),
            'validation'=> 'numeric' );

        $fields[] = array(
            'name'  => 'usaha_kawasan',
            'label' => 'Kawasan Industri',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_kawasan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_pj',
            'label' => 'Nama Penanggungjawab',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_pj : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_npwp',
            'label' => 'No. NPWP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_npwp : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_jenis',
            'label' => 'Jenis Perusahaan',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'kbli',
                    'label' => 'KBLI',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_jenis_kbli : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'kki',
                    'label' => 'KKI',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_jenis_kki : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                )
            );

        $fields[] = array(
            'name'  => 'usaha_akta',
            'label' => 'Pendirian',
            'type'  => 'subfield',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'fields'=> array(
                array(
                    'name'  => 'ntrs',
                    'label' => 'Nama Notaris',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_ntrs : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'nomor',
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_nomor : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                )
            );

        $fields[] = array(
            'name'  => 'usaha_direksi',
            'label' => 'Nama Direksi',
            'type'  => 'text',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_direksi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_lokasi',
            'label' => 'Lokasi Pabrik',
            'type'  => 'textarea',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_nama',
            'label' => 'Luas Tanah (M<sup>2</sup>)',
            'type'  => 'number',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
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

/* End of file Bpmppt_iui.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_iui.php */