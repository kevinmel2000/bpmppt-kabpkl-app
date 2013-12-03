<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reklame extends App_main
{
	public $slug = 'izin_reklame';
	public $nama = 'Izin Reklame';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Reklame_model Class Initialized");
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
			'name'	=> $this->slug.'_fieldset_data_reklame',
			'label'	=> 'Data Reklame',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_lokasi_jenis',
			'label'	=> 'Jenis Reklame',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->reklame_jenis : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_juml',
			'label'	=> 'Jumlah',
			'type'	=> 'number',
			'std'	=> ( $data_obj ? $data_obj->reklame_juml : ''),
			'validation'=> 'required|numeric' );

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_lokasi',
			'label'	=> 'Lokasi pemasangan',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->reklame_lokasi : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_ukuran',
			'label'	=> 'Ukuran (P x L)',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'panjang',
					'label'	=> 'Panjang',
					'type'	=> 'number',
					'std'	=> ( $data_obj ? $data_obj->reklame_ukuran_panjang : ''),
					'validation'=> 'required|numerik' ),
				array(
					'col'	=> '6',
					'name'	=> 'lebar',
					'label'	=> 'Lebar',
					'type'	=> 'number',
					'std'	=> ( $data_obj ? $data_obj->reklame_ukuran_lebar : ''),
					'validation'=> 'required|numerik' ),
				)
			);

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_range',
			'label'	=> 'Jangka waktu',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'tgl_mulai',
					'label'	=> 'Mulai Tanggal',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->reklame_range_tgl_mulai : ''),
					'validation'=> 'required|numerik' ),
				array(
					'col'	=> '6',
					'name'	=> 'tgl_selesai',
					'label'	=> 'Sampai Tanggal',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->reklame_range_tgl_selesai : ''),
					'validation'=> 'required|numerik' ),
				)
			);

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_tema',
			'label'	=> 'Tema/Isi',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->reklame_tema : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_ket',
			'label'	=> 'Keterangan',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->reklame_ket : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );
		
		return $fields;
	}
}

/* End of file Izin_reklame.php */
/* Location: ./application/models/app/Izin_reklame.php */