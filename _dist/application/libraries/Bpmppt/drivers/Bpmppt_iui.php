<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
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
        // $fields[] = array(
        //     'name'  => 'pembaruan_ke',
        //     'label' => 'Daftar ulang Ke',
        //     'type'  => 'text',
        //     'fold'  => array(
        //         'key'   => $this->alias.'_surat_jenis_pengajuan',
        //         'value' => 'Daftar Ulang' ),
        //     'std'   => ( $data_obj ? $data_obj->pembaruan_ke : '') );

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
            'type'  => 'text',
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
            'name'  => 'usaha_komoditi',
            'label' => 'Komoditi Industri',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'kki',
                    'label' => 'KKI',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_komoditi_kki : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'kbli',
                    'label' => 'KBLI',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_komoditi_kbli : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'prod',
                    'label' => 'Produksi per Tahun',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_komoditi_prod : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'sat',
                    'label' => 'Satuan',
                    'type'  => 'dropdown',
                    'std'   => ( $data_obj ? $data_obj->usaha_komoditi_sat : ''),
                    'option'=> array('Lusin', 'Kodi', 'Unit'),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                )
            );

        $fields[] = array(
            'name'  => 'usaha_direksi',
            'label' => 'Nama Direksi',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_direksi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

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
}

/* End of file Bpmppt_iui.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_iui.php */
