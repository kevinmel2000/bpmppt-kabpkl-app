<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usaha_industri extends App_main
{
	public $kode = 'IUI';
	public $slug = 'izin_usaha_industri';
	public $nama = 'Izin Usaha Industri';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Usaha_industri_model Class Initialized");
	}

	public function form( $data_obj = FALSE )
	{
		$fields[]	= array(
			'name'	=> $this->slug.'_permohonan_jenis',
			'label'	=> 'Jenis Pengajuan',
			'type'	=> 'dropdown',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->permohonan_jenis : ''),
			'option'=> array(
				'br' => 'Pendaftaran Baru',
				'bn' => 'Balik Nama',
				'du' => 'Daftar Ulang' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'type'	=> 'fieldset',
			'attr'	=> ( $data_obj ? 'disabled' : '' ));

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_kerja',
			'label'	=> 'Pekerjaan',
			'type'	=> 'dropdown',
			'std'	=> ( $data_obj ? $data_obj->pemohon_kerja : ''),
			'option'=> array(
				'kerja'=> 'Pekerjaan' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->pemohon_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_telp',
			'label'	=> 'No. Telp',
			'type'	=> 'tel',
			'std'	=> ( $data_obj ? $data_obj->pemohon_telp : ''),
			'validation'=> 'numeric' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemilik',
			'label'	=> 'Data Pemilik Perusahaan',
			'type'	=> 'fieldset',
			'attr'	=> ( $data_obj ? 'disabled' : '' ));

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemilik_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->pemilik_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_telp',
			'label'	=> 'No. Telp',
			'type'	=> 'tel',
			'std'	=> ( $data_obj ? $data_obj->pemilik_telp : ''),
			'validation'=> 'numeric' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_usaha',
			'label'	=> 'Data Perusahaan',
			'type'	=> 'fieldset',
			'attr'	=> ( $data_obj ? 'disabled' : '' ));

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_nama',
			'label'	=> 'Nama Perusahaan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_skala',
			'label'	=> 'Skala',
			'type'	=> 'dropdown',
			'std'	=> ( $data_obj ? $data_obj->usaha_skala : ''),
			'option'=> array(
				'kecil'		=> 'Perusahaan Kecil',
				'menengah'	=> 'Perusahaan Menengah',
				'besar'		=> 'Perusahaan Besar' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_npwp',
			'label'	=> 'No. NPWP',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_npwp : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_telp',
			'label'	=> 'No. Telp',
			'type'	=> 'tel',
			'std'	=> ( $data_obj ? $data_obj->usaha_telp : ''),
			'validation'=> 'numeric' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_kawasan',
			'label'	=> 'Kawasan Industri',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_kawasan : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_pj',
			'label'	=> 'Nama Penanggungjawab',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_pj : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_npwp',
			'label'	=> 'No. NPWP',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_npwp : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

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
					'std'	=> ( $data_obj ? $data_obj->usaha_jenis_kbli : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				array(
					'col'	=> '6',
					'name'	=> 'kki',
					'label'	=> 'KKI',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_jenis_kki : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				)
			);

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_akta',
			'label'	=> 'Pendirian',
			'type'	=> 'subfield',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'ntrs',
					'label'	=> 'Nama Notaris',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_akta_ntrs : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				array(
					'col'	=> '6',
					'name'	=> 'nomor',
					'label'	=> 'Nomor Akta',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_akta_nomor : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				)
			);

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_direksi',
			'label'	=> 'Nama Direksi',
			'type'	=> 'text',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->usaha_direksi : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_lokasi',
			'label'	=> 'Lokasi Pabrik',
			'type'	=> 'textarea',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->usaha_lokasi : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_nama',
			'label'	=> 'Luas Tanah (M<sup>2</sup>)',
			'type'	=> 'number',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->usaha_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );
		
		return $fields;
	}
}

/* End of file Izin_usaha_industri.php */
/* Location: ./application/models/app/Izin_usaha_industri.php */