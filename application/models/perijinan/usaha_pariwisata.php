<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usaha_pariwisata extends App_main
{
	public $slug = 'Usaha_pariwisata';
	public $nama = 'Izin Usaha Pariwisata';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Usaha_pariwisata_model Class Initialized");
	}

	public function form( $data_obj = FALSE )
	{
		/**
		 * TODO:
		 *
		 * Nomor Izin:
		 * 557.142/19/PAR/RM/BPMPPT/XI/2013
		 * + 557.142 -> Static
		 * + 19 -> Nomor urut mulai per tahun
		 * + PAR -> static
		 * + RM -> Kode Jenis Usaha
		 *
		 * Bentuk cetak
		 * + Surat Ijin
		 * + kutipan
		 */
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
			'name'	=> $this->slug.'_pemohon_kerja',
			'label'	=> 'Pekerjaan',
			'type'	=> 'dropdown',
			'std'	=> ( $data_obj ? $data_obj->pemohon_nama : ''),
			'option'=> array(
				'p' => 'Pekerjaan' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_jabatan',
			'label'	=> 'Jabatan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_jabatan : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->pemohon_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_telp',
			'label'	=> 'Nomor Telpon/HP',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_telp : ''),
			'validation'=> 'numeric|max_length[12]' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_perusahaan',
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
			'name'	=> $this->slug.'_usaha_jenis',
			'label'	=> 'Jenis Usaha',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_jenis : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_alamat',
			'label'	=> 'Alamat Kantor',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_luas',
			'label'	=> 'Luas perusahaan (M<sup>2</sup>)',
			'type'	=> 'number',
			'std'	=> ( $data_obj ? $data_obj->usaha_luas : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_an',
			'label'	=> 'Atas Nama Pendirian',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_an : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_ket',
			'label'	=> 'Keterangan Lain',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_ket : '') );

		return $fields;
	}
}

/* End of file Izin_usaha_pariwisata.php */
/* Location: ./application/models/app/Izin_usaha_pariwisata.php */