<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reklame extends CI_Model
{
	public $slug = 'izin_reklame';
	public $nama = 'Izin Reklame';

	public function __construct()
	{
		parent::__construct();

		log_message('debug', "Reklame_model Class Initialized");
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
				'name'	=> $this->slug.'_fieldset_data_reklame',
				'label'	=> 'Data Reklame',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_lokasi_jenis',
				'label'	=> 'Jenis Reklame',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_reklame_jenis'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_reklame_juml',
				'label'	=> 'Jumlah',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_reklame_juml'} : ''),
				'validation'=> 'required|numeric' ),
			array(
				'name'	=> $this->slug.'_reklame_lokasi',
				'label'	=> 'Lokasi pemasangan',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_reklame_lokasi'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_reklame_ukuran',
				'label'	=> 'Ukuran (P x L)',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'panjang',
						'label'	=> 'Panjang',
						'type'	=> 'number',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_reklame_ukuran_panjang'} : ''),
						'validation'=> 'required|numerik' ),
					array(
						'col'	=> '6',
						'name'	=> 'lebar',
						'label'	=> 'Lebar',
						'type'	=> 'number',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_reklame_ukuran_lebar'} : ''),
						'validation'=> 'required|numerik' ),
					)
				),
			array(
				'name'	=> $this->slug.'_reklame_range',
				'label'	=> 'Jangka waktu',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'tgl_mulai',
						'label'	=> 'Mulai Tanggal',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_reklame_range_tgl_mulai'} : ''),
						'validation'=> 'required|numerik' ),
					array(
						'col'	=> '6',
						'name'	=> 'tgl_selesai',
						'label'	=> 'Sampai Tanggal',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_reklame_range_tgl_selesai'} : ''),
						'validation'=> 'required|numerik' ),
					)
				),
			array(
				'name'	=> $this->slug.'_reklame_tema',
				'label'	=> 'Tema/Isi',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_reklame_tema'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_reklame_ket',
				'label'	=> 'Keterangan',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_reklame_ket'} : ''),
				'validation'=> 'required' ),
			);
	}

	public function data()
	{
		$post_data['pemohon_nama']			= $this->input->post('pemohon_nama');
		$post_data['pemohon_kerja']			= $this->input->post('pemohon_kerja');
		$post_data['pemohon_alamat']		= $this->input->post('pemohon_alamat');
		$post_data['pemohon_telp']			= $this->input->post('pemohon_telp');
		$post_data['reklame_jenis']			= $this->input->post('reklame_jenis');
		$post_data['reklame_jumlah']		= $this->input->post('reklame_jumlah');
		$post_data['reklame_lokasi']		= $this->input->post('reklame_lokasi');
		$post_data['reklame_ukuran_p']		= $this->input->post('reklame_ukuran_p');
		$post_data['reklame_ukuran_l']		= $this->input->post('reklame_ukuran_l');
		$post_data['reklame_waktu_mulai']	= string_to_date( $this->input->post('reklame_waktu_mulai') );
		$post_data['reklame_waktu_selesai']	= string_to_date( $this->input->post('reklame_waktu_selesai') );
		$post_data['reklame_reklame_tema']	= $this->input->post('reklame_reklame_tema');
		$post_data['reklame_reklame_ket']	= $this->input->post('reklame_reklame_ket');

		// surat_no:
		// surat_tgl:28-10-2013
		// pemohon_nama:
		// pemohon_kerja:
		// pemohon_alamat:
		// pemohon_telp:
		// reklame_jenis:
		// reklame_jumlah:
		// reklame_lokasi:
		// reklame_ukuran_p:
		// reklame_ukuran_l:
		// reklame_waktu_mulai:28-10-2013
		// reklame_waktu_selesai:28-10-2013
		// reklame_reklame_tema:
		// reklame_reklame_ket:
		// total_syarat:5
	}
}

/* End of file Izin_reklame.php */
/* Location: ./application/models/app/Izin_reklame.php */