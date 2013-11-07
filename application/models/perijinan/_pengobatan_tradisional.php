<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengobatan_tradisional extends App_main
{
	public $slug = 'izin_pengobatan_tradisional';
	public $nama = 'Izin Pengobatan Tradisional';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Pengobatan_tradisional_model Class Initialized");
	}

	public function form( $data_obj = NULL )
	{
		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_jabatan',
			'label'	=> 'Jabatan',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_jabatan : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_usaha',
			'label'	=> 'Perusahaan',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_usaha : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_lokasi',
			'label'	=> 'Data Lokasi',
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_lokasi_tujuan',
			'label'	=> 'Tujuan Permohonan',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->lokasi_tujuan : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_lokasi_alamat',
			'label'	=> 'Alamat Lokasi',
			'type'	=> 'textarea',
			'std'	=> (! is_null($data_obj) ? $data_obj->lokasi_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_lokasi_nama',
			'label'	=> 'Luas Area (M<sup>2</sup>)',
			'type'	=> 'number',
			'std'	=> (! is_null($data_obj) ? $data_obj->lokasi_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_lokasi_area_hijau',
			'label'	=> 'Area terbuka hijau',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->lokasi_area_hijau : ''),
			'validation'=> 'required' );

		return $fields;
	}
}

/* End of file Izin_obat_tradisional.php */
/* Location: ./application/models/app/Izin_obat_tradisional.php */