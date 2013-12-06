<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bpmppt_b3 extends CI_Driver
{
	public $code = 'B3';
	public $alias = 'izin_pengelolaan_b3';
	public $name = 'Izin Penyimpanan Sementara dan Pengumpulan Limbah Bahan Berbahaya dan Beracun';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Pengelolaan_b3_model Class Initialized");
	}

	public function form( $data_obj = FALSE )
	{
		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->pemohon_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_jabatan',
			'label'	=> 'Jabatan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_jabatan : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_usaha',
			'label'	=> 'Data Perusahaan',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_nama',
			'label'	=> 'Nama Perusahaan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_bidang',
			'label'	=> 'Bidang usaha',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_bidang : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_alamat',
			'label'	=> 'Alamat Kantor',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_lokasi',
			'label'	=> 'Lokasi Usaha',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_lokasi : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

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
					'std'	=> ( $data_obj ? $data_obj->usaha_kontak_telp : '') ),
				array(
					'col'	=> '6',
					'name'	=> 'fax',
					'label'	=> 'No. Fax',
					'type'	=> 'tel',
					'std'	=> ( $data_obj ? $data_obj->usaha_kontak_fax : '') ),
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
					'std'	=> ( $data_obj ? $data_obj->usaha_tps_fungsi : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				array(
					'col'	=> '3',
					'name'	=> 'ukuran',
					'label'	=> 'Ukuran',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_tps_ukuran : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				array(
					'col'	=> '3',
					'name'	=> 'koor_s',
					'label'	=> 'Koor. S',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_tps_koor_s : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				array(
					'col'	=> '3',
					'name'	=> 'koor_e',
					'label'	=> 'Koor. E',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_tps_koor_e : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				)
			);

		return $fields;
	}
}

/* End of file Izin_kelola_b3.php */
/* Location: ./application/models/app/Izin_kelola_b3.php */