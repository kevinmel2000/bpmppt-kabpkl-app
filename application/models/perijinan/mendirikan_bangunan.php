<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mendirikan_bangunan extends App_main
{
	public $kode = 'IMB';
	public $slug = 'izin_mendirikan_bangunan';
	public $nama = 'Izin Mendirikan Bangunan';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Mendirikan_bangunan_model Class Initialized");
	}

	public function form( $data_obj = FALSE )
	{
		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_maksud',
			'label'	=> 'Maksud Permohonan',
			'type'	=> 'dropdown',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'option'=> array(
				'baru'	=> 'Mendirikan Bangunan Baru',
				'rehap'	=> 'Perbaikan/Rehab Bangunan Lama' ),
			'std'	=> ( $data_obj ? $data_obj->bangunan_maksud : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_guna',
			'label'	=> 'Penggunaan bangunan',
			'type'	=> 'dropdown',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'option'=> array(
				'rumah'	=> 'Rumah Tinggal',
				'kios'	=> 'Kios',
				'toko'	=> 'Toko',
				'gudang'=> 'Gudang',
				'pabrik'=> 'Pabrik',
				'kantor'=> 'Kantor' ),
			'std'	=> ( $data_obj ? $data_obj->bangunan_guna : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_kerja',
			'label'	=> 'Pekerjaan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_kerja : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->pemohon_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_bangunan',
			'label'	=> 'Data Bangunan',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_lokasi',
			'label'	=> 'Lokasi bangunan',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->bangunan_lokasi : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_tanah_luas',
			'label'	=> 'Luas Tanah Bangunan (M<sup>2</sup>)',
			'type'	=> 'number',
			'std'	=> ( $data_obj ? $data_obj->bangunan_tanah_luas : ''),
			'validation'=> ( !$data_obj ? 'required|numeric' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_tanah_keadaan',
			'label'	=> 'Keadaan Tanah',
			'type'	=> 'dropdown',
			'option'=> array(
				'd1'	=> 'D I',
				'd2'	=> 'D II',
				'd3'	=> 'D III' ),
			'std'	=> ( $data_obj ? $data_obj->bangunan_tanah_keadaan : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_tanah_status',
			'label'	=> 'Status Tanah',
			'type'	=> 'dropdown',
			'option'=> array(
				'hm'	=> 'Hak guna bangunan',
				'hg'	=> 'Hak milik' ),
			'std'	=> ( $data_obj ? $data_obj->bangunan_tanah_status : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_milik_no',
			'label'	=> 'Nomor kepemilikan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->bangunan_milik_no : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_milik_an',
			'label'	=> 'Atas Nama kepemilikan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->bangunan_milik_an : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_luas',
			'label'	=> 'Luas bangunan (M<sup>2</sup>)',
			'type'	=> 'number',
			'std'	=> ( $data_obj ? $data_obj->bangunan_luas : ''),
			'validation'=> 'required|numeric' );
		
		return $fields;
	}
}

/* End of file Izin_mendirikan_bangunan.php */
/* Location: ./application/models/app/Izin_mendirikan_bangunan.php */