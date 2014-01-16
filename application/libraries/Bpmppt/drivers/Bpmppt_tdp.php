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
 * BPMPPT Tanda Daftar Perusahaan Driver
 *
 * @subpackage  Drivers
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
     * @todo
      Tambahan nomor
      - Nomor agenda        posisi atas
      - Nomor registrasi    posisi kolom kiri
      - Masa berlaku
      - Tanggal ditetapkan
     * 
     * @param   bool    $data_obj  Data field
     *
     * @return  array
     */
    public function form( $data_obj = FALSE )
    {
        $fields[]   = array(
            'name'  => $this->alias.'_no_daftar',
            'label' => 'Nomor Registrasi',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->no_daftar : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_no_sk',
            'label' => 'Nomor Ditetapkan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->no_sk : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_tgl_berlaku',
            'label' => 'Tgl. Masa Berlaku',
            'type'  => 'datepicker',
            'std'   => ( $data_obj ? $data_obj->tgl_berlaku : ''),
            'validation'=> ( !$data_obj ? '' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pengajuan_jenis',
            'label' => 'Jenis Pengajuan',
            'type'  => 'dropdown',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->pengajuan_jenis : ''),
            'option'=> array(
                '' => '---',
                'daftar baru'   => 'Pendaftaran Baru',
                'balik nama'    => 'Balik Nama',
                'daftar ulang'  => 'Daftar Ulang' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pembaruan_ke',
            'label' => 'Daftar ulang Ke',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pembaruan_ke : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_pemilik',
            'label' => 'Data Pemilik Perusahaan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_ktp',
            'label' => 'Nomor KTP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemilik_ktp : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemilik_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_kwn',
            'label' => 'Kewarganegaraan',
            'type'  => 'dropdown',
            'std'   => ( $data_obj ? $data_obj->pemilik_kwn : ''),
            'option'=> array(
                '' => '---',
                'wni' => 'Warga Negara Indonesia',
                'wna' => 'Warga Negara Asing' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

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
                    'std'   => ( $data_obj ? $data_obj->pemilik_lahir_tmpt : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'col'   => '6',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Lahir',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->pemilik_lahir_tgl : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ),
                    'callback'=> 'string_to_date' ),
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
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->pemilik_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
                    'col'   => '6',
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'tel',
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
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

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
            'option'=> add_placeholder( $jns_opt ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_skala',
            'label' => 'Skala Perusahaan',
            'type'  => 'dropdown',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_skala : ''),
            'option'=> array(
                '' => '---',
                'PK' => 'Perusahaan Kecil',
                'PM' => 'Menengah',
                'PB' => 'Besar' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_status',
            'label' => 'Status Perusahaan',
            'type'  => 'dropdown',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_status : ''),
            'option'=> array(
                '' => '---',
                'tunggal' => 'Kantor Tunggal',
                'pusat' => 'Kantor Pusat',
                'cabang' => 'Kantor Cabang',
                'pembantu' => 'Kantor Pembantu',
                'perwakilan' => 'Kantor Perwakilan' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
                    'col'   => '6',
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_fax : ''),
                    'validation'=> 'numeric' ),
                ));

        /**
         * 0 - 50   Usaha kecil
         * 50 - 500 Menengah
         * 500 >    Besar
         */

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_pokok',
            'label' => 'Kegiatan Usaha Pokok',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_pokok : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_kbli',
            'label' => 'KBLI',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_kbli : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_pendirian_akta',
            'label' => 'Akta Pendirian',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'no',
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_akta_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Akta',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_akta_tgl : ''),
                    'validation'=> '' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_pendirian_pengesahan',
            'label' => 'Pengesahan Pendirian',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'no',
                    'label' => 'Nomor Pengesahan',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_pengesahan_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Pengesahan',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_pengesahan_tgl : ''),
                    'validation'=> '' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_perubahan_akta',
            'label' => 'Akta Perubahan',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'no',
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_perubahan_akta_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Akta',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_perubahan_akta_tgl : ''),
                    'validation'=> '' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_perubahan_pengesahan',
            'label' => 'Pengesahan Perubahan',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'no',
                    'label' => 'Nomor Pengesahan',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_perubahan_pengesahan_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Pengesahan',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_perubahan_pengesahan_tgl : ''),
                    'validation'=> '' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_npwp',
            'label' => 'NPWP Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_npwp : ''),
            'validation'=> ( !$data_obj ? 'required|numeric' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_saham_status',
            'label' => 'Status Saham',
            'type'  => 'dropdown',
            'std'   => ( $data_obj ? $data_obj->usaha_saham_status : ''),
            'option'=> array(
                '' => '---',
                'pmdm' => 'Penanaman Modal Dalam Negeri',
                'pma' => 'Penanaman Modal Asing' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

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

/* End of file Bpmppt_tdp.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_tdp.php */