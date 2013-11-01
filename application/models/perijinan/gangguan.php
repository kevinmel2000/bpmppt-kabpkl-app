<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gangguan extends CI_Model
{
	public $kode = 'HO';
	public $slug = 'izin_gangguan';
	public $nama = 'Izin Gangguan';

	public function __construct()
	{
		log_message('debug', "Gangguan_model Class Initialized");
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
			'name'	=> $this->slug.'_surat_jenis_pengajuan',
			'label'	=> 'Jenis Pengajuan',
			'type'	=> 'dropdown',
			'std'	=> ($data_id != '' ? $data->surat_jenis_pengajuan : ''),
			'option'=> array(
				'br' => 'Pendaftaran baru',
				'bn' => 'Balik nama',
				'du' => 'Daftar ulang' ),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama Lengkap',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->pemohon_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_kerja',
			'label'	=> 'Pekerjaan',
			'type'	=> 'dropdown',
			'std'	=> ($data_id != '' ? $data->pemohon_nama : ''),
			'option'=> array(
				'p' => 'Pekerjaan' ),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->pemohon_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_telp',
			'label'	=> 'Nomor Telpon/HP',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->pemohon_telp : ''),
			'validation'=> 'numeric|max_length[12]' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_perusahaan',
			'label'	=> 'Data Perusahaan',
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_nama',
			'label'	=> 'Nama Perusahaan',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_jenis',
			'label'	=> 'Jenis Usaha',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_jenis : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_alamat',
			'label'	=> 'Alamat Kantor',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->usaha_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_lokasi',
			'label'	=> 'Lokasi Perusahaan',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->usaha_lokasi : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_luas',
			'label'	=> 'Luas perusahaan (M<sup>2</sup>)',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_luas : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_pekerja',
			'label'	=> 'Jumlah pekerja',
			'type'	=> 'number',
			'std'	=> ($data_id != '' ? $data->usaha_pekerja : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_tetangga',
			'label'	=> 'Data Tetangga',
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_tetangga_timur',
			'label'	=> 'Tetangga sebelah timur',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_tetangga_timur : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_tetangga_utara',
			'label'	=> 'Tetangga sebelah utara',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_tetangga_utara : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_tetangga_selatan',
			'label'	=> 'Tetangga sebelah selatan',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_tetangga_selatan : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_tetangga_barat',
			'label'	=> 'Tetangga sebelah barat',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_tetangga_barat : ''),
			'validation'=> 'required' );
		
		return $fields;
	}
}

/* End of file ho_model.php */
/* Location: ./application/models/layanan/ho_model.php */