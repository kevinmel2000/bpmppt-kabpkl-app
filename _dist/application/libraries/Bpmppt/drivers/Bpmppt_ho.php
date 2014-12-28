<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bpmppt_ho Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Gangguan
| ------------------------------------------------------------------------------
*/

class Bpmppt_ho extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'HO';
    public $alias = 'izin_gangguan';
    public $name = 'Izin Gangguan';
    public $prefield_label = 'No. &amp; Tgl. Input';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'surat_jenis_pengajuan'     => '',
        'surat_kode'                => '',
        'pembaruan_ke'              => '',
        'pemohon_nama'              => '',
        'pemohon_jabatan'           => '',
        'pemohon_alamat'            => '',
        'pemohon_telp'              => '',
        'usaha_nama'                => '',
        'usaha_jenis'               => '',
        'usaha_skala'               => '',
        'usaha_alamat'              => '',
        'usaha_tanah_milik'         => '',
        'usaha_lokasi'              => '',
        'usaha_luas'                => '',
        'usaha_pekerja'             => '',
        'usaha_tetangga_timur'      => '',
        'usaha_tetangga_utara'      => '',
        'usaha_tetangga_selatan'    => '',
        'usaha_tetangga_barat'      => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Gangguan Class Initialized");
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
            'name'  => 'surat_kode',
            'label' => 'Kode Nomor',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->surat_kode : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'surat_jenis_pengajuan',
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->surat_jenis_pengajuan : ''),
            'option'=> array(
                'Pendaftaran Baru' => 'Pendaftaran Baru',
                'Balik Nama'       => 'Balik Nama',
                'Daftar Ulang'     => 'Daftar Ulang' ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'ho_lama',
            'label' => 'HO Lama',
            'type'  => 'subfield',
            'fold'  => array(
                'key'   => $this->alias.'_surat_jenis_pengajuan',
                'value' => 'Daftar Ulang'
                ),
            'fields' => array(
                array(
                    'name'  => 'no',
                    'label' => 'No. HO Lama',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->ho_lama_no : '') ),
                array(
                    'name'  => 'tgl',
                    'label' => 'Tanggal HO Lama',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->ho_lama_tgl : '') ),
                array(
                    'name'  => 'ho',
                    'label' => 'Keterangan',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->ho_lama_ho : '') ),
                ),
            'std'   => ( $data_obj ? $data_obj->pembaruan_ke : '') );

        $fields[] = array(
            'name'  => 'pemohon_tanggal',
            'label' => 'Tanggal Permohonan',
            'type'  => 'datepicker',
            'std'   => ( $data_obj ? $data_obj->pemohon_tanggal : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama Lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_jabatan',
            'label' => 'Jabatan Pemohon',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_jabatan : '') );

        $fields[] = array(
            'name'  => 'pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_telp',
            'label' => 'Nomor Telpon/HP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_telp : ''),
            'validation'=> 'numeric|max_length[12]' );

        $fields[] = array(
            'name'  => 'fieldset_data_perusahaan',
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_nama',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_skala',
            'label' => 'Skala Perusahaan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_skala : ''),
            'option'=> $this->get_field_prop('jenis_usaha'),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_jenis',
            'label' => 'Jenis Usaha',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_alamat',
            'label' => 'Alamat Kantor',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_tanah_milik',
            'label' => 'A.N. Kepemilikan Tanah',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_tanah_milik : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_lokasi',
            'label' => 'Lokasi Perusahaan',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_luas',
            'label' => 'Luas perusahaan (M<sup>2</sup>)',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_luas : ''),
            'validation'=> ( !$data_obj ? 'required' : ''  ) );

        $fields[] = array(
            'name'  => 'fieldset_data_tetangga',
            'label' => 'Data Tetangga',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_tetangga_timur',
            'label' => 'Tetangga sebelah timur',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_tetangga_timur : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_tetangga_utara',
            'label' => 'Tetangga sebelah utara',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_tetangga_utara : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_tetangga_selatan',
            'label' => 'Tetangga sebelah selatan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_tetangga_selatan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_tetangga_barat',
            'label' => 'Tetangga sebelah barat',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_tetangga_barat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        return $fields;
    }
}

/* End of file Bpmppt_ho.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_ho.php */
