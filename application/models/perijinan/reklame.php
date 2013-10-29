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
		$fields = array(
			array(
				'name'	=> $this->slug.'_surat_no',
				'label'	=> 'Nomor &amp; Tanggal Surat',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'proses',
						'label'	=> 'Nomor',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_no : set_value($this->slug.'_surat_no')),
						'validation'=> 'required' ),
					array(
						'col'	=> '6',
						'name'	=> 'kond',
						'label'	=> 'Tanggal',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_tgl : set_value($this->slug.'_surat_tgl')),
						'validation'=> 'required' ),
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
				'std'	=> ($data_id != '' ? $query->pemohon_nama : set_value($this->slug.'_pemohon_nama')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_jabatan',
				'label'	=> 'Jabatan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_jabatan : set_value($this->slug.'_pemohon_jabatan')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_usaha',
				'label'	=> 'Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_usaha : set_value($this->slug.'_pemohon_usaha')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->pemohon_alamat : set_value($this->slug.'_pemohon_alamat')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_fieldset_data_lokasi',
				'label'	=> 'Data Lokasi',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_lokasi_tujuan',
				'label'	=> 'Tujuan Permohonan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_tujuan : set_value($this->slug.'_lokasi_tujuan')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_alamat',
				'label'	=> 'Alamat Lokasi',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->lokasi_alamat : set_value($this->slug.'_lokasi_alamat')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_nama',
				'label'	=> 'Luas Area (M<sup>2</sup>)',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $query->lokasi_nama : set_value($this->slug.'_lokasi_nama')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_area_hijau',
				'label'	=> 'Area terbuka hijau',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_area_hijau : set_value($this->slug.'_lokasi_area_hijau')),
				'validation'=> 'required' ),
			);

		return $fields;
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