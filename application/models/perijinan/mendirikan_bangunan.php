<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mendirikan_bangunan extends CI_Model
{
	public $kode = 'IMB';
	public $slug = 'izin_mendirikan_bangunan';
	public $nama = 'Izin Mendirikan Bangunan';

	public function __construct()
	{
		parent::__construct();

		log_message('debug', "Mendirikan_bangunan_model Class Initialized");
	}

	public function form( $data_id = '' )
	{
		$data = ( $data_id != '' ? $this->app_data->get_fulldata_by_id( $data_id ) : '' );

		return array(
			array(
				'name'	=> $this->slug.'_surat',
				'label'	=> 'Nomor &amp; Tanggal Surat',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'nomor',
						'label'	=> 'Nomor',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_surat_nomor'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '6',
						'name'	=> 'tanggal',
						'label'	=> 'Tanggal',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_surat_tanggal'} : ''),
						'validation'=> 'required',
						'callback'=> 'string_to_date' ),
					)
				),
			array(
				'name'	=> $this->slug.'_bangunan_maksud',
				'label'	=> 'Maksud Permohonan',
				'type'	=> 'dropdown',
				'option'=> array(
					'baru'	=> 'Mendirikan Bangunan Baru',
					'rehap'	=> 'Perbaikan/Rehab Bangunan Lama' ),
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_bangunan_maksud'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_bangunan_guna',
				'label'	=> 'Penggunaan bangunan',
				'type'	=> 'dropdown',
				'option'=> array(
					'rumah'	=> 'Rumah',
					'kios'	=> 'Kios',
					'toko'	=> 'Toko',
					'gudang'=> 'Gudang',
					'pabrik'=> 'Pabrik',
					'kantor'=> 'Kantor' ),
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_bangunan_guna'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_fieldset_data_pemohon',
				'label'	=> 'Data Pemohon',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_pemohon_nama',
				'label'	=> 'Nama lengkap',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemohon_nama'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_kerja',
				'label'	=> 'Pekerjaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemohon_kerja'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemohon_alamat'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_fieldset_data_bangunan',
				'label'	=> 'Data Bangunan',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_bangunan_lokasi',
				'label'	=> 'Lokasi bangunan',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_bangunan_lokasi'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_bangunan_tanah_luas',
				'label'	=> 'Luas Tanah Bangunan (M<sup>2</sup>)',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_bangunan_tanah_luas'} : ''),
				'validation'=> 'required|numeric' ),
			array(
				'name'	=> $this->slug.'_bangunan_tanah_keadaan',
				'label'	=> 'Keadaan Tanah',
				'type'	=> 'dropdown',
				'option'=> array(
					'd1'	=> 'D I',
					'd2'	=> 'D II',
					'd3'	=> 'D III' ),
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_bangunan_tanah_keadaan'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_bangunan_tanah_status',
				'label'	=> 'Status Tanah',
				'type'	=> 'dropdown',
				'option'=> array(
					'hm'	=> 'Hak guna bangunan',
					'hg'	=> 'Hak milik' ),
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_bangunan_tanah_status'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_bangunan_milik_no',
				'label'	=> 'Nomor kepemilikan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_bangunan_milik_no'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_bangunan_milik_an',
				'label'	=> 'Atas Nama kepemilikan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_bangunan_milik_an'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_bangunan_luas',
				'label'	=> 'Luas bangunan (M<sup>2</sup>)',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_bangunan_luas'} : ''),
				'validation'=> 'required|numeric' ),
			);
	}

	public function data()
	{
		return;
	}
}

/* End of file Izin_mendirikan_bangunan.php */
/* Location: ./application/models/app/Izin_mendirikan_bangunan.php */