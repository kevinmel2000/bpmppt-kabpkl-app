<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usaha_industri extends CI_Model
{
	public $kode = 'IUI';
	public $slug = 'izin_usaha_industri';
	public $nama = 'Izin Usaha Industri';

	public function __construct()
	{
		parent::__construct();

		log_message('debug', "Usaha_industri_model Class Initialized");
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
						'name'	=> 'proses',
						'label'	=> 'Nomor',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_no : set_value($this->slug.'_surat_no')),
						'validation'=> 'required' ),
					array(
						'col'	=> '6',
						'name'	=> 'kond',
						'label'	=> 'Tanggal',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_tgl : set_value($this->slug.'_surat_tgl')),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_pemohon',
				'label'	=> 'Data Pemohon',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_pemohon_nama',
				'label'	=> 'Nama lengkap',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_nama : set_value($this->slug.'_pemohon_nama')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_jabatan',
				'label'	=> 'Jabatan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_jabatan : set_value($this->slug.'_pemohon_jabatan')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_usaha',
				'label'	=> 'Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_usaha : set_value($this->slug.'_pemohon_usaha')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->pemohon_alamat : set_value($this->slug.'_pemohon_alamat')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_fieldset_data_lokasi',
				'label'	=> 'Data Lokasi',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_lokasi_tujuan',
				'label'	=> 'Tujuan Permohonan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_tujuan : set_value($this->slug.'_lokasi_tujuan')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_alamat',
				'label'	=> 'Alamat Lokasi',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->lokasi_alamat : set_value($this->slug.'_lokasi_alamat')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_nama',
				'label'	=> 'Luas Area (M<sup>2</sup>)',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $query->lokasi_nama : set_value($this->slug.'_lokasi_nama')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_area_hijau',
				'label'	=> 'Area terbuka hijau',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_area_hijau : set_value($this->slug.'_lokasi_area_hijau')),
				'validation'=> 'required' ),
			);

		return $fields;
	}

	public function fields()
	{
		$post_data['surat_no']					= $this->input->post('surat_no');
		$post_data['surat_catatan']				= $this->input->post('surat_catatan');
		$post_data['pemilik_alamat']			= $this->input->post('pemilik_alamat');
		$post_data['pemilik_nama']				= $this->input->post('pemilik_nama');
		$post_data['pemilik_telp']				= $this->input->post('pemilik_telp');
		$post_data['pemohon_alamat']			= $this->input->post('pemohon_alamat');
		$post_data['pemohon_kerja']				= $this->input->post('pemohon_kerja');
		$post_data['pemohon_nama']				= $this->input->post('pemohon_nama');
		$post_data['pemohon_telp']				= $this->input->post('pemohon_telp');
		$post_data['usaha_alamat']				= $this->input->post('usaha_alamat');
		$post_data['usaha_kawasan']				= $this->input->post('usaha_kawasan');
		$post_data['usaha_kbli']				= $this->input->post('usaha_kbli');
		$post_data['usaha_kki']					= $this->input->post('usaha_kki');
		$post_data['usaha_luas_tanah']			= $this->input->post('usaha_luas_tanah');
		$post_data['usaha_nama']				= $this->input->post('usaha_nama');
		$post_data['usaha_nama_direksi']		= $this->input->post('usaha_nama_direksi');
		$post_data['usaha_nama_pj']				= $this->input->post('usaha_nama_pj');
		$post_data['usaha_no_akta_pendirian']	= $this->input->post('usaha_no_akta_pendirian');
		$post_data['usaha_notaris']				= $this->input->post('usaha_notaris');
		$post_data['usaha_npwp']				= $this->input->post('usaha_npwp');
		$post_data['usaha_pabrik_alamat']		= $this->input->post('usaha_pabrik_alamat');
		$post_data['usaha_pabrik_kecamatan']	= $this->input->post('usaha_pabrik_kecamatan');
		$post_data['usaha_pabrik_kelurahan']	= $this->input->post('usaha_pabrik_kelurahan');
		$post_data['usaha_pabrik_kota']			= $this->input->post('usaha_pabrik_kota');
		$post_data['usaha_pabrik_propinsi']		= $this->input->post('usaha_pabrik_propinsi');
		$post_data['usaha_pabrik_rt']			= $this->input->post('usaha_pabrik_rt');
		$post_data['usaha_pabrik_rw']			= $this->input->post('usaha_pabrik_rw');
		$post_data['usaha_skala']				= $this->input->post('usaha_skala');
		$post_data['usaha_telpon']				= $this->input->post('usaha_telpon');

		// surat_no:
		// surat_tgl:28-10-2013
		// surat_petugas:
		// surat_jenis_pengajuan:
		// pemohon_nama:
		// pemohon_kerja:
		// pemohon_alamat:
		// pemohon_telp:
		// pemilik_nama:
		// pemilik_alamat:
		// pemilik_telp:
		// usaha_skala:
		// usaha_nama:
		// usaha_npwp:
		// usaha_alamat:
		// usaha_telpon:
		// usaha_kawasan:
		// usaha_nama_pj:
		// usaha_kbli:
		// usaha_kki:
		// usaha_notaris:
		// usaha_no_akta_pendirian:
		// usaha_nama_direksi:
		// usaha_pabrik_alamat:
		// usaha_pabrik_rt:
		// usaha_pabrik_rw:
		// usaha_pabrik_propinsi:
		// usaha_pabrik_kota:
		// usaha_pabrik_kecamatan:
		// usaha_pabrik_kelurahan:
		// usaha_luas_tanah:
		// total_syarat:18
	}

	public function data()
	{
		return 'test';
	}
}

/* End of file Izin_usaha_industri.php */
/* Location: ./application/models/app/Izin_usaha_industri.php */