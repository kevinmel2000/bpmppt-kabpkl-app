<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BPMPPT Izin Gangguan Driver
 *
 * @subpackage  Drivers
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

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'surat_jenis_pengajuan'     => '',
        'pembaruan_ke'              => '',
        'pemohon_nama'              => '',
        'pemohon_kerja'             => '',
        'pemohon_alamat'            => '',
        'pemohon_telp'              => '',
        'usaha_nama'                => '',
        'usaha_jenis'               => '',
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
        // $this->baka_auth->permit( 'manage_'.$this->alias );

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
            'name'  => 'surat_jenis_pengajuan',
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->surat_jenis_pengajuan : ''),
            'option'=> array(
                'Pendaftaran Baru' => 'Pendaftaran Baru',
                'Perubahan'        => 'Perubahan',
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
            // 'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama Lengkap',
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
            'label' => 'Nomor Telpon/HP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_telp : ''),
            'validation'=> 'numeric|max_length[12]' );

        $fields[] = array(
            'name'  => 'fieldset_data_perusahaan',
            'label' => 'Data Perusahaan',
            // 'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_nama',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''),
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
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->usaha_luas : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_pekerja',
            'label' => 'Jumlah pekerja',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->usaha_pekerja : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'fieldset_data_tetangga',
            'label' => 'Data Tetangga',
            // 'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
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
