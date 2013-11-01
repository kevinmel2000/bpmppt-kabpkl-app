<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengelolaan_b3 extends CI_Model
{
	public $kode = 'B3';
	public $slug = 'izin_pengelolaan_b3';
	public $nama = 'Izin Penyimpanan Sementara dan Pengumpulan Limbah Bahan Berbahaya dan Beracun';

	public function __construct()
	{
		log_message('debug', "Pengelolaan_b3_model Class Initialized");
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
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->pemohon_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_jabatan',
			'label'	=> 'Jabatan',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->pemohon_jabatan : ''),
			'validation'=> 'required' );

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
			'name'	=> $this->slug.'_usaha_bidang',
			'label'	=> 'Bidang usaha',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->usaha_bidang : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_alamat',
			'label'	=> 'Alamat Kantor',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->usaha_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_lokasi',
			'label'	=> 'Lokasi Usaha',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->usaha_lokasi : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_kontak',
			'label'	=> 'Nomor Telp. &amp; Fax.',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'telp',
					'label'	=> 'No. Telpon',
					'type'	=> 'tel',
					'std'	=> ($data_id != '' ? $data->usaha_kontak_telp : '') ),
				array(
					'col'	=> '6',
					'name'	=> 'fax',
					'label'	=> 'No. Fax',
					'type'	=> 'tel',
					'std'	=> ($data_id != '' ? $data->usaha_kontak_fax : '') ),
				)
			);

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_tps',
			'label'	=> 'Tempat Pembuangan Sementara',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '3',
					'name'	=> 'fungsi',
					'label'	=> 'Keterangan fungsi',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->usaha_tps_fungsi : ''),
					'validation'=> 'required'),
				array(
					'col'	=> '3',
					'name'	=> 'ukuran',
					'label'	=> 'Ukuran',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->usaha_tps_ukuran : ''),
					'validation'=> 'required'),
				array(
					'col'	=> '3',
					'name'	=> 'koor_s',
					'label'	=> 'Koor. S',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->usaha_tps_koor_s : ''),
					'validation'=> 'required'),
				array(
					'col'	=> '3',
					'name'	=> 'koor_e',
					'label'	=> 'Koor. E',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->usaha_tps_koor_e : ''),
					'validation'=> 'required'),
				)
			);

		return $fields;
	}
}

/* End of file Izin_kelola_b3.php */
/* Location: ./application/models/app/Izin_kelola_b3.php */