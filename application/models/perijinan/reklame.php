<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reklame extends CI_Model
{
	public $slug = 'izin_reklame';
	public $nama = 'Izin Reklame';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Reklame_model Class Initialized");
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
				)
			);

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
			'name'	=> $this->slug.'_fieldset_data_reklame',
			'label'	=> 'Data Reklame',
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_lokasi_jenis',
			'label'	=> 'Jenis Reklame',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->reklame_jenis : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_juml',
			'label'	=> 'Jumlah',
			'type'	=> 'number',
			'std'	=> ($data_id != '' ? $data->reklame_juml : ''),
			'validation'=> 'required|numeric' );

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_lokasi',
			'label'	=> 'Lokasi pemasangan',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->reklame_lokasi : ''),
			'validation'=> 'required' );

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
					'std'	=> ($data_id != '' ? $data->reklame_ukuran_panjang : ''),
					'validation'=> 'required|numerik' ),
				array(
					'col'	=> '6',
					'name'	=> 'lebar',
					'label'	=> 'Lebar',
					'type'	=> 'number',
					'std'	=> ($data_id != '' ? $data->reklame_ukuran_lebar : ''),
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
					'std'	=> ($data_id != '' ? $data->reklame_range_tgl_mulai : ''),
					'validation'=> 'required|numerik' ),
				array(
					'col'	=> '6',
					'name'	=> 'tgl_selesai',
					'label'	=> 'Sampai Tanggal',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->reklame_range_tgl_selesai : ''),
					'validation'=> 'required|numerik' ),
				)
			);

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_tema',
			'label'	=> 'Tema/Isi',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->reklame_tema : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_reklame_ket',
			'label'	=> 'Keterangan',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->reklame_ket : ''),
			'validation'=> 'required' );
		
		return $fields;
	}
}

/* End of file Izin_reklame.php */
/* Location: ./application/models/app/Izin_reklame.php */