<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembuangan_limbah extends CI_Model
{
	public $kode = 'IPLC';
	public $slug = 'izin_pembuangan_air_limbah';
	public $nama = 'Izin Pembuangan Air Limbah ke Air atau Sumber Air';

	public function __construct()
	{
		parent::__construct();

		log_message('debug', "Pembuangan_limbah_model Class Initialized");
	}

	public function form( $data_id = '' )
	{
		$fields = array(
			array(
				'name'	=> $this->slug.'_surat_no',
				'label'	=> 'Nomor Surat',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->surat_no : set_value($this->slug.'_surat_no')),
				),
			array(
				'name'	=> $this->slug.'_surat_tgl',
				'label'	=> 'Tanggal',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->surat_tgl : set_value($this->slug.'_surat_tgl')),
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_pemohon',
				'label'	=> 'Data Pemohon',
				'type'	=> 'fieldset',
				),
			array(
				'name'	=> $this->slug.'_pemohon_nama',
				'label'	=> 'Nama lengkap',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_nama : set_value($this->slug.'_pemohon_nama')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_jabatan',
				'label'	=> 'Jabatan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_jabatan : set_value($this->slug.'_pemohon_jabatan')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_usaha',
				'label'	=> 'Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_usaha : set_value($this->slug.'_pemohon_usaha')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->pemohon_alamat : set_value($this->slug.'_pemohon_alamat')),
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_lokasi',
				'label'	=> 'Data Lokasi',
				'type'	=> 'fieldset',
				),
			array(
				'name'	=> $this->slug.'_lokasi_tujuan',
				'label'	=> 'Tujuan Permohonan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_tujuan : set_value($this->slug.'_lokasi_tujuan')),
				),
			array(
				'name'	=> $this->slug.'_lokasi_alamat',
				'label'	=> 'Alamat Lokasi',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->lokasi_alamat : set_value($this->slug.'_lokasi_alamat')),
				),
			array(
				'name'	=> $this->slug.'_lokasi_nama',
				'label'	=> 'Luas Area (M<sup>2</sup>)',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $query->lokasi_nama : set_value($this->slug.'_lokasi_nama')),
				),
			array(
				'name'	=> $this->slug.'_lokasi_area_hijau',
				'label'	=> 'Area terbuka hijau',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_area_hijau : set_value($this->slug.'_lokasi_area_hijau')),
				),
			);

		return $fields;
	}

	public function data()
	{
		$post_data['pemohon_nama']						= $this->input->post('pemohon_nama');
		$post_data['pemohon_posisi']					= $this->input->post('pemohon_posisi');
		$post_data['pemohon_perusahaan']				= $this->input->post('pemohon_perusahaan');
		$post_data['pemohon_alamat']					= $this->input->post('pemohon_alamat');
		$post_data['pemohon_propinsi']					= $this->input->post('pemohon_propinsi');
		$post_data['pemohon_kota']						= $this->input->post('pemohon_kota');
		$post_data['pemohon_kecamatan']					= $this->input->post('pemohon_kecamatan');
		$post_data['pemohon_kelurahan']					= $this->input->post('pemohon_kelurahan');
		$post_data['pemohon_rt']						= $this->input->post('pemohon_rt');
		$post_data['pemohon_rw']						= $this->input->post('pemohon_rw');
		$post_data['pemohon_pj_nama']					= $this->input->post('pemohon_pj_nama');
		$post_data['pemohon_pj_jabatan']				= $this->input->post('pemohon_pj_jabatan');
		$post_data['limbah_target']						= $this->input->post('limbah_target');
		$post_data['limbah_produksi']					= $this->input->post('limbah_produksi');
		$post_data['limbah_debit_proses']				= $this->input->post('limbah_debit_proses');
		$post_data['limbah_debit_kondensor']			= $this->input->post('limbah_debit_kondensor');
		$post_data['limbah_proses_max_bod']				= $this->input->post('limbah_proses_max_bod');
		$post_data['limbah_proses_max_cod']				= $this->input->post('limbah_proses_max_cod');
		$post_data['limbah_proses_max_tts']				= $this->input->post('limbah_proses_max_tts');
		$post_data['limbah_proses_max_minyak']			= $this->input->post('limbah_proses_max_minyak');
		$post_data['limbah_proses_max_sulfida']			= $this->input->post('limbah_proses_max_sulfida');
		$post_data['limbah_proses_max_ph']				= $this->input->post('limbah_proses_max_ph');
		$post_data['limbah_proses_beban_bod']			= $this->input->post('limbah_proses_beban_bod');
		$post_data['limbah_proses_beban_cod']			= $this->input->post('limbah_proses_beban_cod');
		$post_data['limbah_proses_beban_tts']			= $this->input->post('limbah_proses_beban_tts');
		$post_data['limbah_proses_beban_minyak']		= $this->input->post('limbah_proses_beban_minyak');
		$post_data['limbah_proses_beban_sulfida']		= $this->input->post('limbah_proses_beban_sulfida');
		$post_data['limbah_proses_beban_ph']			= $this->input->post('limbah_proses_beban_ph');
		$post_data['limbah_kondensor_max_bod']			= $this->input->post('limbah_kondensor_max_bod');
		$post_data['limbah_kondensor_max_cod']			= $this->input->post('limbah_kondensor_max_cod');
		$post_data['limbah_kondensor_max_tts']			= $this->input->post('limbah_kondensor_max_tts');
		$post_data['limbah_kondensor_max_minyak']		= $this->input->post('limbah_kondensor_max_minyak');
		$post_data['limbah_kondensor_max_sulfida']		= $this->input->post('limbah_kondensor_max_sulfida');
		$post_data['limbah_kondensor_max_ph']			= $this->input->post('limbah_kondensor_max_ph');
		$post_data['limbah_kondensor_beban_bod']		= $this->input->post('limbah_kondensor_beban_bod');
		$post_data['limbah_kondensor_beban_cod']		= $this->input->post('limbah_kondensor_beban_cod');
		$post_data['limbah_kondensor_beban_tts']		= $this->input->post('limbah_kondensor_beban_tts');
		$post_data['limbah_kondensor_beban_minyak']		= $this->input->post('limbah_kondensor_beban_minyak');
		$post_data['limbah_kondensor_beban_sulfida']	= $this->input->post('limbah_kondensor_beban_sulfida');
		$post_data['limbah_kondensor_beban_ph']			= $this->input->post('limbah_kondensor_beban_ph');
		
		// surat_no:
		// surat_tgl:28-10-2013
		// pemohon_nama:
		// pemohon_posisi:
		// pemohon_perusahaan:
		// pemohon_alamat:
		// pemohon_pj_nama:
		// pemohon_pj_jabatan:
		// limbah_produksi:
		// limbah_debit_proses:
		// limbah_debit_kondensor:
		// limbah_proses_max_bod:
		// limbah_proses_max_cod:
		// limbah_proses_max_tts:
		// limbah_proses_max_minyak:
		// limbah_proses_max_sulfida:
		// limbah_proses_max_ph:
		// limbah_proses_beban_bod:
		// limbah_proses_beban_cod:
		// limbah_proses_beban_tts:
		// limbah_proses_beban_minyak:
		// limbah_proses_beban_sulfida:
		// limbah_proses_beban_ph:
		// limbah_kondensor_max_bod:
		// limbah_kondensor_max_cod:
		// limbah_kondensor_max_tts:
		// limbah_kondensor_max_minyak:
		// limbah_kondensor_max_sulfida:
		// limbah_kondensor_max_ph:
		// limbah_kondensor_beban_bod:
		// limbah_kondensor_beban_cod:
		// limbah_kondensor_beban_tts:
		// limbah_kondensor_beban_minyak:
		// limbah_kondensor_beban_sulfida:
		// limbah_kondensor_beban_ph:
		// limbah_target:
	}
}

/* End of file Izin_pembuangan_air_limbah.php */
/* Location: ./application/models/app/Izin_pembuangan_air_limbah.php */