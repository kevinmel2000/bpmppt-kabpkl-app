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
				'name'	=> $this->slug.'_permohonan_jenis',
				'label'	=> 'Jenis Pengajuan',
				'type'	=> 'dropdown',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_permohonan_jenis'} : ''),
				'option'=> array(
					'br' => 'Pendaftaran Baru',
					'bn' => 'Balik Nama',
					'du' => 'Daftar Ulang' ),
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
				'type'	=> 'dropdown',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemohon_kerja'} : ''),
				'option'=> array(
					'kerja'=> 'Pekerjaan' ),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemohon_alamat'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_telp',
				'label'	=> 'No. Telp',
				'type'	=> 'tel',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemohon_telp'} : ''),
				'validation'=> 'numeric' ),
			array(
				'name'	=> $this->slug.'_fieldset_data_pemilik',
				'label'	=> 'Data Pemilik Perusahaan',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_pemilik_nama',
				'label'	=> 'Nama lengkap',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemilik_nama'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemilik_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemilik_alamat'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemilik_telp',
				'label'	=> 'No. Telp',
				'type'	=> 'tel',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemilik_telp'} : ''),
				'validation'=> 'numeric' ),
			array(
				'name'	=> $this->slug.'_fieldset_data_usaha',
				'label'	=> 'Data Perusahaan',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_usaha_nama',
				'label'	=> 'Nama Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_nama'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_skala',
				'label'	=> 'Skala',
				'type'	=> 'dropdown',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_skala'} : ''),
				'option'=> array(
					'kecil'		=> 'Perusahaan Kecil',
					'menengah'	=> 'Perusahaan Menengah',
					'besar'		=> 'Perusahaan Besar' ),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_npwp',
				'label'	=> 'No. NPWP',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_npwp'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_alamat'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_telp',
				'label'	=> 'No. Telp',
				'type'	=> 'tel',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_telp'} : ''),
				'validation'=> 'numeric' ),
			array(
				'name'	=> $this->slug.'_usaha_kawasan',
				'label'	=> 'Kawasan Industri',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_kawasan'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_pj',
				'label'	=> 'Nama Penanggungjawab',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_pj'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_npwp',
				'label'	=> 'No. NPWP',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_npwp'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_jenis',
				'label'	=> 'Jenis Perusahaan',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'kbli',
						'label'	=> 'KBLI',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_jenis_kbli'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '6',
						'name'	=> 'kki',
						'label'	=> 'KKI',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_jenis_kki'} : ''),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_usaha_akta',
				'label'	=> 'Pendirian',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'ntrs',
						'label'	=> 'Nama Notaris',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_akta_ntrs'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '6',
						'name'	=> 'nomor',
						'label'	=> 'Nomor Akta',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_akta_nomor'} : ''),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_usaha_direksi',
				'label'	=> 'Nama Direksi',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_direksi'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_lokasi',
				'label'	=> 'Lokasi Pabrik',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_lokasi'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_nama',
				'label'	=> 'Luas Tanah (M<sup>2</sup>)',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_usaha_nama'} : ''),
				'validation'=> 'required' ),
			);
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