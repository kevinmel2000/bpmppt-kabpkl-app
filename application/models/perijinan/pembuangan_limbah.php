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
				'name'	=> $this->slug.'_pemohon_jabatan',
				'label'	=> 'Jabatan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemohon_jabatan'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_usaha',
				'label'	=> 'Nama Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemohon_usaha'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_pemohon_alamat'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_fieldset_data_lokasi',
				'label'	=> 'Data Lokasi',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_limbah_kapasitas_produksi',
				'label'	=> 'Kapasitas Produksi',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kapasitas_produksi'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_limbah_debit_max',
				'label'	=> 'Debit max limbah',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'proses',
						'label'	=> 'proses',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_debit_max_proses'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '6',
						'name'	=> 'kond',
						'label'	=> 'kondensor',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_debit_max_kond'} : ''),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_limbah_kadar_max_proses',
				'label'	=> 'Kadar max proses',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '2',
						'name'	=> 'bod',
						'label'	=> 'BOD',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_proses_kond'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'cod',
						'label'	=> 'COD',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_proses_cod'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'tts',
						'label'	=> 'TTS',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_proses_tts'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'minyak',
						'label'	=> 'Minyak',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_proses_minyak'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'sulfida',
						'label'	=> 'Silfida',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_proses_sulfida'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'ph',
						'label'	=> 'pH',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_proses_ph'} : ''),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_limbah_beban_max_proses',
				'label'	=> 'Beban pencemaran proses',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '2',
						'name'	=> 'bod',
						'label'	=> 'BOD',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_proses_kond'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'cod',
						'label'	=> 'COD',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_proses_cod'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'tts',
						'label'	=> 'TTS',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_proses_tts'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'minyak',
						'label'	=> 'Minyak',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_proses_minyak'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'sulfida',
						'label'	=> 'Silfida',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_proses_sulfida'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'ph',
						'label'	=> 'pH',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_proses_ph'} : ''),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_limbah_kadar_max_kond',
				'label'	=> 'Kadar max kondensor',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '2',
						'name'	=> 'bod',
						'label'	=> 'BOD',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_kond_kond'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'cod',
						'label'	=> 'COD',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_kond_cod'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'tts',
						'label'	=> 'TTS',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_kond_tts'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'minyak',
						'label'	=> 'Minyak',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_kond_minyak'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'sulfida',
						'label'	=> 'Silfida',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_kond_sulfida'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'ph',
						'label'	=> 'pH',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_kadar_max_kond_ph'} : ''),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_limbah_beban_max_kond',
				'label'	=> 'Beban pencemaran kondensor',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '2',
						'name'	=> 'bod',
						'label'	=> 'BOD',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_kond_kond'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'cod',
						'label'	=> 'COD',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_kond_cod'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'tts',
						'label'	=> 'TTS',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_kond_tts'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'minyak',
						'label'	=> 'Minyak',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_kond_minyak'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'sulfida',
						'label'	=> 'Silfida',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_kond_sulfida'} : ''),
						'validation'=> 'required' ),
					array(
						'col'	=> '2',
						'name'	=> 'ph',
						'label'	=> 'pH',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $data->{$this->slug.'_limbah_beban_max_kond_ph'} : ''),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_limbah_target_buang',
				'label'	=> 'Target pembuangan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_target_buang'} : ''),
				'validation'=> 'required' ),
			);
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