<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usaha_industri extends CI_Model
{
	public $kode = 'IUI';
	public $slug = 'izin_usaha_industri';
	public $nama = 'Izin Usaha Industri';

	public function __construct()
	{
		log_message('debug', "Usaha_industri_model Class Initialized");
	}

	public function form( $data_id = '' )
	{
		$data = ( $data_id != '' ? $this->app_data->get_fulldata_by_id( $data_id ) : '' );

		$fields[]	= array(
			'name'	=> $this->slug.'_surat',
			'label'	=> 'Nomor &amp; Tanggal Surat',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'nomor',
					'label'	=> 'Nomor',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->surat_nomor : ''),
					'validation'=> 'required' ),
				array(
					'col'	=> '6',
					'name'	=> 'tanggal',
					'label'	=> 'Tanggal',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->surat_tanggal : ''),
					'validation'=> 'required',
					'callback'=> 'string_to_date' ),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_permohonan_jenis',
			'label'	=> 'Jenis Pengajuan',
			'type'	=> 'dropdown',
			'std'	=> ($data_id != '' ? $data->permohonan_jenis : ''),
			'option'=> array(
				'br' => 'Pendaftaran Baru',
				'bn' => 'Balik Nama',
				'du' => 'Daftar Ulang' ),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->pemohon_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_kerja',
			'label'	=> 'Pekerjaan',
			'type'	=> 'dropdown',
			'std'	=> ($data_id != '' ? $data->pemohon_kerja : ''),
			'option'=> array(
				'kerja'=> 'Pekerjaan' ),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->pemohon_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_telp',
			'label'	=> 'No. Telp',
			'type'	=> 'tel',
			'std'	=> ($data_id != '' ? $data->pemohon_telp : ''),
			'validation'=> 'numeric' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemilik',
			'label'	=> 'Data Pemilik Perusahaan',
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->pemilik_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->pemilik_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_telp',
			'label'	=> 'No. Telp',
			'type'	=> 'tel',
			'std'	=> ($data_id != '' ? $data->pemilik_telp : ''),
			'validation'=> 'numeric' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_usaha',
			'label'	=> 'Data Perusahaan',
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_nama',
			'label'	=> 'Nama Perusahaan',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_skala',
			'label'	=> 'Skala',
			'type'	=> 'dropdown',
			'std'	=> ($data_id != '' ? $data->usaha_skala : ''),
			'option'=> array(
				'kecil'		=> 'Perusahaan Kecil',
				'menengah'	=> 'Perusahaan Menengah',
				'besar'		=> 'Perusahaan Besar' ),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_npwp',
			'label'	=> 'No. NPWP',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_npwp : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->usaha_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_telp',
			'label'	=> 'No. Telp',
			'type'	=> 'tel',
			'std'	=> ($data_id != '' ? $data->usaha_telp : ''),
			'validation'=> 'numeric' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_kawasan',
			'label'	=> 'Kawasan Industri',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_kawasan : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_pj',
			'label'	=> 'Nama Penanggungjawab',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_pj : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_npwp',
			'label'	=> 'No. NPWP',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_npwp : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_jenis',
			'label'	=> 'Jenis Perusahaan',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'kbli',
					'label'	=> 'KBLI',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->usaha_jenis_kbli : ''),
					'validation'=> 'required' ),
				array(
					'col'	=> '6',
					'name'	=> 'kki',
					'label'	=> 'KKI',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->usaha_jenis_kki : ''),
					'validation'=> 'required' ),
				)
			);

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_akta',
			'label'	=> 'Pendirian',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'ntrs',
					'label'	=> 'Nama Notaris',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->usaha_akta_ntrs : ''),
					'validation'=> 'required' ),
				array(
					'col'	=> '6',
					'name'	=> 'nomor',
					'label'	=> 'Nomor Akta',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->usaha_akta_nomor : ''),
					'validation'=> 'required' ),
				)
			);

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_direksi',
			'label'	=> 'Nama Direksi',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_direksi : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_lokasi',
			'label'	=> 'Lokasi Pabrik',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->usaha_lokasi : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_nama',
			'label'	=> 'Luas Tanah (M<sup>2</sup>)',
			'type'	=> 'number',
			'std'	=> ($data_id != '' ? $data->usaha_nama : ''),
			'validation'=> 'required' );
		
		return $fields;
	}
}

/* End of file Izin_usaha_industri.php */
/* Location: ./application/models/app/Izin_usaha_industri.php */