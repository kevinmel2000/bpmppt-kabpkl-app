<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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