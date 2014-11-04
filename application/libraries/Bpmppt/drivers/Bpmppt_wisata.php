<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bpmppt_wisata Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Usaha Pariwisata
| ------------------------------------------------------------------------------
*/

class Bpmppt_wisata extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $alias
     * @var  string  $name
     */
    public $alias = 'pariwisata';
    public $name = 'Izin Usaha Pariwisata';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'pemohon_nama'      => '',
        'pemohon_kerja'     => '',
        'pemohon_jabatan'   => '',
        'pemohon_alamat'    => '',
        'pemohon_telp'      => '',
        'usaha_nama'        => '',
        'usaha_jenis'       => '',
        'usaha_alamat'      => '',
        'usaha_luas'        => '',
        'usaha_an'          => '',
        'usaha_ket'         => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Usaha_pariwisata Class Initialized");
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
        /**
         * @todo
         *
         * Nomor Izin:
         * 557.142/19/PAR/RM/BPMPPT/XI/2013
         * + 557.142 -> Static
         * + 19 -> Nomor urut mulai per tahun
         * + PAR -> static
         * + RM -> Kode Jenis Usaha
         *
         * Bentuk cetak
         * + Surat Ijin
         * + kutipan
         */

        $fields[] = array(
            'name'  => 'penetapan',
            'label' => 'No. &amp; Tgl. Ditetapkan',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'nomor',
                    'label' => 'Nomor Ditetapkan',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->penetapan_nomor : '' ),
                    'validation'=> ''
                    ),
                array(
                    'name'  => 'tgl',
                    'label' => 'Tanggal Ditetapkan',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? format_date($data_obj->penetapan_tgl) : ''),
                    'callback'=> 'string_to_date',
                    'validation'=> ''
                    ),
                ));

        $fields[] = array(
            'name'  => 'fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : '') );

        $fields[] = array(
            'name'  => 'pemohon_kerja',
            'label' => 'Pekerjaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_kerja : '') );

        $fields[] = array(
            'name'  => 'pemohon_jabatan',
            'label' => 'Jabatan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_jabatan : '') );

        $fields[] = array(
            'name'  => 'pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : '') );

        $fields[] = array(
            'name'  => 'pemohon_telp',
            'label' => 'Nomor Telpon/HP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_telp : ''),
            'validation'=> 'numeric|max_length[12]' );

        $fields[] = array(
            'name'  => 'fieldset_data_perusahaan',
            'label' => 'Data Perusahaan',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_nama',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : '') );

        $fields[] = array(
            'name'  => 'usaha_jenis',
            'label' => 'Jenis Usaha',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : '') );

        $fields[] = array(
            'name'  => 'usaha_alamat',
            'label' => 'Alamat Kantor',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : '') );

        $fields[] = array(
            'name'  => 'usaha_luas',
            'label' => 'Luas perusahaan (M<sup>2</sup>)',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_luas : '') );

        $fields[] = array(
            'name'  => 'usaha_an',
            'label' => 'Atas Nama Pendirian',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_an : '') );

        $fields[] = array(
            'name'  => 'usaha_ket',
            'label' => 'Keterangan Lain',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_ket : '') );

        return $fields;
    }
}

/* End of file Bpmppt_wisata.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_wisata.php */
