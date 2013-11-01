<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembuangan_limbah extends CI_Model
{
	public $kode = 'IPLC';
	public $slug = 'izin_pembuangan_air_limbah';
	public $nama = 'Izin Pembuangan Air Limbah ke Air atau Sumber Air';

	public function __construct()
	{
		log_message('debug', "Pembuangan_limbah_model Class Initialized");
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
					) );

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
			'name'	=> $this->slug.'_pemohon_jabatan',
			'label'	=> 'Jabatan',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->pemohon_jabatan : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_usaha',
			'label'	=> 'Nama Perusahaan',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->pemohon_usaha : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->pemohon_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_lokasi',
			'label'	=> 'Data Lokasi',
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_limbah_kapasitas_produksi',
			'label'	=> 'Kapasitas Produksi',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->limbah_kapasitas_produksi : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_limbah_debit_max',
			'label'	=> 'Debit max limbah',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'proses',
					'label'	=> 'proses',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->limbah_debit_max_proses : ''),
					'validation'=> 'required' ),
				array(
					'col'	=> '6',
					'name'	=> 'kond',
					'label'	=> 'kondensor',
					'type'	=> 'text',
					'std'	=> ($data_id != '' ? $data->limbah_debit_max_kond : ''),
					'validation'=> 'required' ),
				)
			);

		$fields[]	= array(
			'name'	=> $this->slug.'_limbah_kadar_max_proses',
			'label'	=> 'Kadar max proses',
			'type'	=> 'subfield',
			'fields'=> $this->subfield_limbah( 'limbah_kadar_max_proses_', $data_id, $data ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_limbah_beban_max_proses',
			'label'	=> 'Beban pencemaran proses',
			'type'	=> 'subfield',
			'fields'=> $this->subfield_limbah( 'limbah_beban_max_proses_', $data_id, $data ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_limbah_kadar_max_kond',
			'label'	=> 'Kadar max kondensor',
			'type'	=> 'subfield',
			'fields'=> $this->subfield_limbah( 'limbah_kadar_max_kond_', $data_id, $data ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_limbah_beban_max_kond',
			'label'	=> 'Beban pencemaran kondensor',
			'type'	=> 'subfield',
			'fields'=> $this->subfield_limbah( 'limbah_beban_max_kond_', $data_id, $data ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_limbah_target_buang',
			'label'	=> 'Target pembuangan',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->target_buang : ''),
			'validation'=> 'required' );

		return $fields;
	}

	protected function subfield_limbah( $parent, $data_id = '', $data = NULL )
	{
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'bod',
			'label'	=> 'BOD',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->{$parent.'kond'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'cod',
			'label'	=> 'COD',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->{$parent.'cod'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'tts',
			'label'	=> 'TTS',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->{$parent.'tts'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'minyak',
			'label'	=> 'Minyak',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->{$parent.'minyak'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'sulfida',
			'label'	=> 'Silfida',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->{$parent.'sulfida'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'ph',
			'label'	=> 'pH',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->{$parent.'ph'} : ''),
			'validation'=> 'required' );

		return $fields;
	}
}

/* End of file Izin_pembuangan_air_limbah.php */
/* Location: ./application/models/app/Izin_pembuangan_air_limbah.php */