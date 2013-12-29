<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gangguan extends App_main
{
	public $kode = 'HO';
	public $slug = 'izin_gangguan';
	public $nama = 'Izin Gangguan';

	public function __construct()
	{
		// $this->authen->permit( 'manage_'.$this->slug );

		log_message('debug', "#BAKA_modul: Gangguan_model Class Initialized");
	}

	public function form( $data_obj = FALSE )
	{
		$fields[]	= array(
			'name'	=> $this->slug.'_surat_jenis_pengajuan',
			'label'	=> 'Jenis Pengajuan',
			'type'	=> 'dropdown',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->surat_jenis_pengajuan : ''),
			'option'=> array(
				'br' => 'Pendaftaran baru',
				'bn' => 'Balik nama',
				'du' => 'Daftar ulang' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'attr'	=> ( $data_obj ? array('disabled'=>'') : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama Lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_kerja',
			'label'	=> 'Pekerjaan',
			'type'	=> 'dropdown',
			'std'	=> ( $data_obj ? $data_obj->pemohon_nama : ''),
			'option'=> array(
				'p' => 'Pekerjaan' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->pemohon_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_telp',
			'label'	=> 'Nomor Telpon/HP',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_telp : ''),
			'validation'=> 'numeric|max_length[12]' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_perusahaan',
			'label'	=> 'Data Perusahaan',
			'attr'	=> ( $data_obj ? array('disabled'=>'') : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_nama',
			'label'	=> 'Nama Perusahaan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_jenis',
			'label'	=> 'Jenis Usaha',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_jenis : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_alamat',
			'label'	=> 'Alamat Kantor',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_lokasi',
			'label'	=> 'Lokasi Perusahaan',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_lokasi : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_luas',
			'label'	=> 'Luas perusahaan (M<sup>2</sup>)',
			'type'	=> 'number',
			'std'	=> ( $data_obj ? $data_obj->usaha_luas : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_pekerja',
			'label'	=> 'Jumlah pekerja',
			'type'	=> 'number',
			'std'	=> ( $data_obj ? $data_obj->usaha_pekerja : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_tetangga',
			'label'	=> 'Data Tetangga',
			'attr'	=> ( $data_obj ? array('disabled'=>'') : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_tetangga_timur',
			'label'	=> 'Tetangga sebelah timur',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_tetangga_timur : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_tetangga_utara',
			'label'	=> 'Tetangga sebelah utara',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_tetangga_utara : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_tetangga_selatan',
			'label'	=> 'Tetangga sebelah selatan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_tetangga_selatan : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_tetangga_barat',
			'label'	=> 'Tetangga sebelah barat',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_tetangga_barat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );
		
		return $fields;
	}
}

/* End of file ho_model.php */
/* Location: ./application/models/layanan/ho_model.php */