<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usaha_pariwisata extends CI_Model
{
	public $slug = 'Usaha_pariwisata';
	public $nama = 'Izin Usaha Pariwisata';

	public function __construct()
	{
		log_message('debug', "Usaha_pariwisata_model Class Initialized");
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
				));

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
			'label'	=> 'Perusahaan',
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
			'name'	=> $this->slug.'_lokasi_tujuan',
			'label'	=> 'Tujuan Permohonan',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->lokasi_tujuan : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_lokasi_alamat',
			'label'	=> 'Alamat Lokasi',
			'type'	=> 'textarea',
			'std'	=> ($data_id != '' ? $data->lokasi_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_lokasi_nama',
			'label'	=> 'Luas Area (M<sup>2</sup>)',
			'type'	=> 'number',
			'std'	=> ($data_id != '' ? $data->lokasi_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_lokasi_area_hijau',
			'label'	=> 'Area terbuka hijau',
			'type'	=> 'text',
			'std'	=> ($data_id != '' ? $data->lokasi_area_hijau : ''),
			'validation'=> 'required' );

		return $fields;
	}

	public function data()
	{
		$post_data['pemohon_nama'] = $this->input->post('pemohon_nama');
		$post_data['pemohon_kerja'] = $this->input->post('pemohon_kerja');
		$post_data['pemohon_jabatan'] = $this->input->post('pemohon_jabatan');
		$post_data['pemohon_alamat'] = $this->input->post('pemohon_alamat');
		$post_data['pemohon_rt'] = $this->input->post('pemohon_rt');
		$post_data['pemohon_rw'] = $this->input->post('pemohon_rw');
		$post_data['pemohon_propinsi'] = $this->input->post('pemohon_propinsi');
		$post_data['pemohon_kota'] = $this->input->post('pemohon_kota');
		$post_data['pemohon_kecamatan'] = $this->input->post('pemohon_kecamatan');
		$post_data['pemohon_kelurahan'] = $this->input->post('pemohon_kelurahan');
		$post_data['pemohon_telp'] = $this->input->post('pemohon_telp');
		$post_data['usaha_nama'] = $this->input->post('usaha_nama');
		$post_data['usaha_jenis'] = $this->input->post('usaha_jenis');
		$post_data['usaha_alamat'] = $this->input->post('usaha_alamat');
		$post_data['usaha_rt'] = $this->input->post('usaha_rt');
		$post_data['usaha_rw'] = $this->input->post('usaha_rw');
		$post_data['usaha_propinsi'] = $this->input->post('usaha_propinsi');
		$post_data['usaha_kota'] = $this->input->post('usaha_kota');
		$post_data['usaha_kecamatan'] = $this->input->post('usaha_kecamatan');
		$post_data['usaha_kelurahan'] = $this->input->post('usaha_kelurahan');
		$post_data['usaha_luas'] = $this->input->post('usaha_luas');
		$post_data['usaha_tanah'] = $this->input->post('usaha_tanah');
		$post_data['usaha_pendirian_an'] = $this->input->post('usaha_pendirian_an');
		$post_data['usaha_keterangan'] = $this->input->post('usaha_keterangan');
	}
}

/* End of file Izin_usaha_pariwisata.php */
/* Location: ./application/models/app/Izin_usaha_pariwisata.php */