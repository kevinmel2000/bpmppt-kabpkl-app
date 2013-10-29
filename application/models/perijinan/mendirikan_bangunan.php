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
		$fields = array(
			array(
				'name'	=> $this->slug.'_surat_no',
				'label'	=> 'Nomor Surat',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->surat_no : set_value($this->slug.'_surat_no')),
				),
			array(
				'name'	=> $this->slug.'_surat_tgl',
				'label'	=> 'Tanggal',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->surat_tgl : set_value($this->slug.'_surat_tgl')),
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_pemohon',
				'label'	=> 'Data Pemohon',
				'type'	=> 'fieldset',
				),
			array(
				'name'	=> $this->slug.'_pemohon_nama',
				'label'	=> 'Nama lengkap',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_nama : set_value($this->slug.'_pemohon_nama')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_jabatan',
				'label'	=> 'Jabatan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_jabatan : set_value($this->slug.'_pemohon_jabatan')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_usaha',
				'label'	=> 'Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_usaha : set_value($this->slug.'_pemohon_usaha')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->pemohon_alamat : set_value($this->slug.'_pemohon_alamat')),
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_lokasi',
				'label'	=> 'Data Lokasi',
				'type'	=> 'fieldset',
				),
			array(
				'name'	=> $this->slug.'_lokasi_tujuan',
				'label'	=> 'Tujuan Permohonan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_tujuan : set_value($this->slug.'_lokasi_tujuan')),
				),
			array(
				'name'	=> $this->slug.'_lokasi_alamat',
				'label'	=> 'Alamat Lokasi',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->lokasi_alamat : set_value($this->slug.'_lokasi_alamat')),
				),
			array(
				'name'	=> $this->slug.'_lokasi_nama',
				'label'	=> 'Luas Area (M<sup>2</sup>)',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $query->lokasi_nama : set_value($this->slug.'_lokasi_nama')),
				),
			array(
				'name'	=> $this->slug.'_lokasi_area_hijau',
				'label'	=> 'Area terbuka hijau',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_area_hijau : set_value($this->slug.'_lokasi_area_hijau')),
				),
			);

		return $fields;
	}

	public function data()
	{
		// surat_no:640/     /IMB/BPM PPT/X/2013
		// surat_tgl:28-10-2013
		// bangunan_maksud:
		// bangunan_penggunaan:
		// pemohon_nama:
		// pemohon_kerja:
		// pemohon_alamat:
		// pemohon_rt:
		// pemohon_rw:
		// pemohon_kota:
		// pemohon_kecamatan:
		// bangunan_alamat:
		// bangunan_rt:
		// bangunan_rw:
		// bangunan_kota:
		// bangunan_kecamatan:
		// bangunan_luas_tanah:
		// bangunan_keadaan_tanah:
		// bangunan_status_milik:
		// bangunan_status_nomor:
		// bangunan_status_an:
		// bangunan_luas_bangunan:
	}
}

/* End of file Izin_mendirikan_bangunan.php */
/* Location: ./application/models/app/Izin_mendirikan_bangunan.php */