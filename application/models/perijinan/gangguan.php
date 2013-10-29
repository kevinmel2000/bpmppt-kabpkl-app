<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gangguan extends CI_Model
{
	public $kode = 'HO';
	public $slug = 'izin_gangguan';
	public $nama = 'Izin Gangguan';

	public function __construct()
	{
		parent::__construct();

		log_message('debug', "Gangguan_model Class Initialized");
	}

	public function form( $data_id = '' )
	{
		$fields = array(
			array(
				'name'	=> $this->slug.'_surat_no',
				'label'	=> 'Nomor &amp; Tanggal Surat',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'nomor',
						'label'	=> 'Nomor',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_nomor : set_value($this->slug.'_surat_nomor')),
						'validation'=> 'required' ),
					array(
						'col'	=> '6',
						'name'	=> 'tanggal',
						'label'	=> 'Tanggal',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_tanggal : set_value($this->slug.'_surat_tanggal')),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_surat_jenis_pengajuan',
				'label'	=> 'Jenis Pengajuan',
				'type'	=> 'dropdown',
				'std'	=> ($data_id !== '' ? $data->surat_jenis_pengajuan : set_value($this->slug.'_surat_jenis_pengajuan')),
				'option'=> array(),
				),
			// array(
			// 	'name'	=> $this->slug.'_surat_petugas',
			// 	'label'	=> 'Petugas',
			// 	'type'	=> 'text',
			// 	'std'	=> ($data_id !== '' ? $data->surat_petugas : set_value($this->slug.'_surat_petugas'))
			// 	'desc'	=> 'Just another Text field description',
			// 	),
			array(
				'name'	=> $this->slug.'_fieldset_data_pemohon',
				'label'	=> 'Data Pemohon',
				'type'	=> 'fieldset',
				),
			array(
				'name'	=> $this->slug.'_pemohon_nama',
				'label'	=> 'Nama Lengkap',
				'type'	=> 'text',
				'std'	=> ($data_id !== '' ? $data->pemohon_nama : set_value($this->slug.'_pemohon_nama')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_kerja',
				'label'	=> 'Pekerjaan',
				'type'	=> 'dropdown',
				'std'	=> ($data_id !== '' ? $data->pemohon_nama : set_value($this->slug.'_pemohon_nama')),
				'option'=> array(),
				),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id !== '' ? $data->pemohon_alamat : set_value($this->slug.'_pemohon_alamat')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_telp',
				'label'	=> 'Nomor Telpon/HP',
				'type'	=> 'text',
				'std'	=> ($data_id !== '' ? $data->pemohon_telp : set_value($this->slug.'_pemohon_telp')),
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_perusahaan',
				'label'	=> 'Data Perusahaan',
				'type'	=> 'fieldset',
				),
			array(
				'name'	=> $this->slug.'_usaha_nama',
				'label'	=> 'Nama Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id !== '' ? $data->usaha_nama : set_value($this->slug.'_usaha_nama')),
				),
			array(
				'name'	=> $this->slug.'_usaha_jenis',
				'label'	=> 'Jenis Usaha',
				'type'	=> 'text',
				'std'	=> ($data_id !== '' ? $data->usaha_jenis : set_value($this->slug.'_usaha_jenis')),
				),
			array(
				'name'	=> $this->slug.'_usaha_alamat',
				'label'	=> 'Alamat Kantor',
				'type'	=> 'textarea',
				'std'	=> ($data_id !== '' ? $data->usaha_alamat : set_value($this->slug.'_usaha_alamat')),
				),
			array(
				'name'	=> $this->slug.'_usaha_lokasi',
				'label'	=> 'Lokasi Perusahaan',
				'type'	=> 'textarea',
				'std'	=> ($data_id !== '' ? $data->usaha_lokasi : set_value($this->slug.'_usaha_lokasi')),
				),
			array(
				'name'	=> $this->slug.'_usaha_luas',
				'label'	=> 'Luas perusahaan (M<sup>2</sup>)',
				'type'	=> 'text',
				'std'	=> ($data_id !== '' ? $data->usaha_luas : set_value($this->slug.'_usaha_luas')),
				),
			array(
				'name'	=> $this->slug.'_usaha_pekerja',
				'label'	=> 'Jumlah pekerja',
				'type'	=> 'number',
				'std'	=> ($data_id !== '' ? $data->usaha_pekerja : set_value($this->slug.'_usaha_pekerja')),
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_tetangga',
				'label'	=> 'Data Tetangga',
				'type'	=> 'fieldset',
				),
			array(
				'name'	=> $this->slug.'_usaha_tetangga_timur',
				'label'	=> 'Tetangga sebelah timur',
				'type'	=> 'text',
				'std'	=> ($data_id !== '' ? $data->usaha_tetangga_timur : set_value($this->slug.'_usaha_tetangga_timur')),
				),
			array(
				'name'	=> $this->slug.'_usaha_tetangga_utara',
				'label'	=> 'Tetangga sebelah utara',
				'type'	=> 'text',
				'std'	=> ($data_id !== '' ? $data->usaha_tetangga_utara : set_value($this->slug.'_usaha_tetangga_utara')),
				),
			array(
				'name'	=> $this->slug.'_usaha_tetangga_selatan',
				'label'	=> 'Tetangga sebelah selatan',
				'type'	=> 'text',
				'std'	=> ($data_id !== '' ? $data->usaha_tetangga_selatan : set_value($this->slug.'_usaha_tetangga_selatan')),
				),
			array(
				'name'	=> $this->slug.'_usaha_tetangga_barat',
				'label'	=> 'Tetangga sebelah barat',
				'type'	=> 'text',
				'std'	=> ($data_id !== '' ? $data->usaha_tetangga_barat : set_value($this->slug.'_usaha_tetangga_barat')),
				),
			);

		return $fields;
	}

	public function data()
	{
		// surat_no:
		// surat_tgl:28-10-2013
		// surat_jenis_pengajuan:
		// pemohon_nama:
		// pemohon_kerja:
		// pemohon_alamat:
		// pemohon_telp:
		// usaha_nama:
		// usaha_jenis:
		// usaha_alamat:
		// usaha_lokasi:
		// usaha_luas:
		// usaha_pekerja:
		// usaha_tetangga_timur:
		// usaha_tetangga_utara:
		// usaha_tetangga_selatan:
		// usaha_tetangga_barat:
		// total_syarat:10
	}
}

/* End of file ho_model.php */
/* Location: ./application/models/layanan/ho_model.php */