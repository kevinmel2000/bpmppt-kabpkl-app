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
 * BPMPPT Surat Izin Usaha Perdangangan Driver
 *
 * @subpackage  Drivers
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

    /**
     * Default field
     *
     * @var  array
     */
    public $fields = array(
        'pengajuan_jenis'                   => '',
        'pembaruan_ke'                      => '',
        'pemohon_nama'                      => '',
        'pemilik_ktp'                       => '',
        'pemilik_alamat'                    => '',
        'pemilik_lahir_tmpt'                => '',
        'pemilik_lahir_tgl'                 => '',
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
        'usaha_saham_nilai_total'           => '',
        'usaha_saham_nilai_nasional'        => '',
        'usaha_saham_nilai_tgl'             => '',
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
        $fields[]   = array(
            'name'  => $this->alias.'_pengajuan_jenis',
            'label' => 'Jenis Pengajuan',
            'type'  => 'dropdown',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->pengajuan_jenis : ''),
            'option'=> array(
                '' => '---',
                'Pendaftaran Baru' => 'Pendaftaran Baru',
                'Perubahan'        => 'Perubahan',
                'Daftar Ulang'     => 'Daftar Ulang' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pembaruan_ke',
            'label' => 'Daftar ulang Ke',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pembaruan_ke : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_pemilik',
            'label' => 'Data Pemilik Perusahaan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_ktp',
            'label' => 'Nomor KTP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemilik_ktp : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemilik_alamat : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_lahir',
            'label' => 'Tempat &amp; Tgl. Lahir',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'tmpt',
                    'label' => 'Tempat Lahir',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->pemilik_lahir_tmpt : '' ),
                    'validation'=> ''
                    ),
                array(
                    'col'   => '6',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Lahir',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->pemilik_lahir_tgl : ''),
                    'callback'=> 'string_to_date',
                    'validation'=> ''
                    ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->pemilik_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
                    'col'   => '6',
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->pemilik_no_fax : ''),
                    'validation'=> 'numeric' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_usaha',
            'label' => 'Data Perusahaan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : '') );

        $u_jenis = array(
            'Perseroan Terbatas (PT)',
            'Perseroan Komanditer (CV)',
            'Badan Usaha Milik Negara (BUMN)',
            'Perorangan (PO)',
            'Koperasi',
            );

        foreach ( $u_jenis as $jenis )
            $jns_opt[$jenis] = $jenis;

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_jenis',
            'label' => 'Jenis Perusahaan',
            'type'  => 'dropdown',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : ''),
            'option'=> add_placeholder( $jns_opt ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_skala',
            'label' => 'Skala Perusahaan',
            'type'  => 'dropdown',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_skala : ''),
            'option'=> array(
                '' => '---',
                'MK' => 'Mikro',
                'PK' => 'Perusahaan Kecil',
                'PM' => 'Menengah',
                'PB' => 'Besar' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_kegiatan',
            'label' => 'Kegiatan Usaha (KBLI)',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_kegiatan : '') );

        $lembs = array( 'Pengecer', 'Penyalur', 'Pengumpul', 'Produsen', 'Sub Distributor', 'Distributor', 'Distributor' );

        foreach ( $lembs as $lemb )
            $lemb_opt[$lemb] = $lemb;

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_lembaga',
            'label' => 'Kelembagaan',
            'type'  => 'multiselect',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? unserialize($data_obj->usaha_lembaga) : ''),
            'option'=> $lemb_opt );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_komoditi',
            'label' => 'Komoditi Usaha',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_komoditi : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
                    'col'   => '6',
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_fax : ''),
                    'validation'=> 'numeric' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_saham_status',
            'label' => 'Status Saham',
            'type'  => 'dropdown',
            'std'   => ( $data_obj ? $data_obj->usaha_saham_status : ''),
            'option'=> array(
                '' => '---',
                'pmdm' => 'Penanaman Modal Dalam Negeri',
                'pma' => 'Penanaman Modal Asing' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_modal_awal',
            'label' => 'Modal awal',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_modal_awal : ''),
            'validation'=> ( !$data_obj ? 'required|numeric' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_saham_nilai',
            'label' => 'Nilai Saham',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'total',
                    'label' => 'Total Nilai Saham (Rp.)',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_saham_nilai_total : ''),
                    'validation'=> ( !$data_obj ? 'required|numeric' : '' ) ),
                array(
                    'col'   => '3',
                    'name'  => 'nasional',
                    'label' => 'Nasional (%)',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->usaha_saham_nilai_nasional : ''),
                    'validation'=> ( !$data_obj ? 'required|numeric' : '' ) ),
                array(
                    'col'   => '3',
                    'name'  => 'tgl',
                    'label' => 'Asing (%)',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->usaha_saham_nilai_tgl : ''),
                    'validation'=> ( !$data_obj ? 'required|numeric' : '' ) ),
                ));

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

/* End of file Bpmppt_siup.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_siup.php */