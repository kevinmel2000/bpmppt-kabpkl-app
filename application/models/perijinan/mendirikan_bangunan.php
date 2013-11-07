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

	public function form( $data_obj = NULL )
	{
		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_maksud',
			'label'	=> 'Maksud Permohonan',
			'type'	=> ($data_id != '' ? 'static' : 'dropdown'),
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'option'=> array(
				'baru'	=> 'Mendirikan Bangunan Baru',
				'rehap'	=> 'Perbaikan/Rehab Bangunan Lama' ),
			'std'	=> (! is_null($data_obj) ? $data_obj->bangunan_maksud : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_guna',
			'label'	=> 'Penggunaan bangunan',
			'type'	=> ($data_id != '' ? 'static' : 'dropdown'),
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'option'=> array(
				'rumah'	=> 'Rumah',
				'kios'	=> 'Kios',
				'toko'	=> 'Toko',
				'gudang'=> 'Gudang',
				'pabrik'=> 'Pabrik',
				'kantor'=> 'Kantor' ),
			'std'	=> (! is_null($data_obj) ? $data_obj->bangunan_guna : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> ($data_id != '' ? 'static' : 'text'),
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_kerja',
			'label'	=> 'Pekerjaan',
			'type'	=> ($data_id != '' ? 'static' : 'text'),
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_kerja : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> ($data_id != '' ? 'static' : 'textarea'),
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_bangunan',
			'label'	=> 'Data Bangunan',
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_lokasi',
			'label'	=> 'Lokasi bangunan',
			'type'	=> ($data_id != '' ? 'static' : 'textarea'),
			'std'	=> (! is_null($data_obj) ? $data_obj->bangunan_lokasi : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_tanah_luas',
			'label'	=> 'Luas Tanah Bangunan (M<sup>2</sup>)',
			'type'	=> ($data_id != '' ? 'static' : 'number'),
			'std'	=> (! is_null($data_obj) ? $data_obj->bangunan_tanah_luas : ''),
			'validation'=> 'required|numeric' );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_tanah_keadaan',
			'label'	=> 'Keadaan Tanah',
			'type'	=> ($data_id != '' ? 'static' : 'dropdown'),
			'option'=> array(
				'd1'	=> 'D I',
				'd2'	=> 'D II',
				'd3'	=> 'D III' ),
			'std'	=> (! is_null($data_obj) ? $data_obj->bangunan_tanah_keadaan : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_tanah_status',
			'label'	=> 'Status Tanah',
			'type'	=> ($data_id != '' ? 'static' : 'dropdown'),
			'option'=> array(
				'hm'	=> 'Hak guna bangunan',
				'hg'	=> 'Hak milik' ),
			'std'	=> (! is_null($data_obj) ? $data_obj->bangunan_tanah_status : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_milik_no',
			'label'	=> 'Nomor kepemilikan',
			'type'	=> ($data_id != '' ? 'static' : 'text'),
			'std'	=> (! is_null($data_obj) ? $data_obj->bangunan_milik_no : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_milik_an',
			'label'	=> 'Atas Nama kepemilikan',
			'type'	=> ($data_id != '' ? 'static' : 'text'),
			'std'	=> (! is_null($data_obj) ? $data_obj->bangunan_milik_an : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_bangunan_luas',
			'label'	=> 'Luas bangunan (M<sup>2</sup>)',
			'type'	=> ($data_id != '' ? 'static' : 'number'),
			'std'	=> (! is_null($data_obj) ? $data_obj->bangunan_luas : ''),
			'validation'=> 'required|numeric' );
		
		return $fields;
	}
}

/* End of file Izin_mendirikan_bangunan.php */
/* Location: ./application/models/app/Izin_mendirikan_bangunan.php */