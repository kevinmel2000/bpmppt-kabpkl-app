<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembuangan_limbah extends App_main
{
	public $kode = 'IPLC';
	public $slug = 'izin_pembuangan_air_limbah';
	public $nama = 'Izin Pembuangan Air Limbah ke Air atau Sumber Air';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Pembuangan_limbah_model Class Initialized");
	}

	public function form( $data_obj = NULL )
	{
		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_jabatan',
			'label'	=> 'Jabatan',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_jabatan : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_usaha',
			'label'	=> 'Nama Perusahaan',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_usaha : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_lokasi',
			'label'	=> 'Data Lokasi',
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_limbah_kapasitas_produksi',
			'label'	=> 'Kapasitas Produksi',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->limbah_kapasitas_produksi : ''),
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
					'std'	=> (! is_null($data_obj) ? $data_obj->limbah_debit_max_proses : ''),
					'validation'=> 'required' ),
				array(
					'col'	=> '6',
					'name'	=> 'kond',
					'label'	=> 'kondensor',
					'type'	=> 'text',
					'std'	=> (! is_null($data_obj) ? $data_obj->limbah_debit_max_kond : ''),
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
			'std'	=> (! is_null($data_obj) ? $data_obj->target_buang : ''),
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
			'std'	=> (! is_null($data_obj) ? $data_obj->{$parent.'kond'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'cod',
			'label'	=> 'COD',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->{$parent.'cod'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'tts',
			'label'	=> 'TTS',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->{$parent.'tts'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'minyak',
			'label'	=> 'Minyak',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->{$parent.'minyak'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'sulfida',
			'label'	=> 'Silfida',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->{$parent.'sulfida'} : ''),
			'validation'=> 'required' );
		
		$fields[]	= array(
			'col'	=> '2',
			'name'	=> 'ph',
			'label'	=> 'pH',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->{$parent.'ph'} : ''),
			'validation'=> 'required' );

		return $fields;
	}
}

/* End of file Izin_pembuangan_air_limbah.php */
/* Location: ./application/models/app/Izin_pembuangan_air_limbah.php */