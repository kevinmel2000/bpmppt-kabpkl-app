<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengobatan_tradisional extends CI_Model
{
	public $slug = 'izin_pengobatan_tradisional';
	public $nama = 'Izin Pengobatan Tradisional';

	public function __construct()
	{
		parent::__construct();

		log_message('debug', "Pengobatan_tradisional_model Class Initialized");
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
				'label'	=> 'Perusahaan',
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
				'name'	=> $this->slug.'_lokasi_tujuan',
				'label'	=> 'Tujuan Permohonan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_lokasi_tujuan'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_alamat',
				'label'	=> 'Alamat Lokasi',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_lokasi_alamat'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_nama',
				'label'	=> 'Luas Area (M<sup>2</sup>)',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_lokasi_nama'} : ''),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_area_hijau',
				'label'	=> 'Area terbuka hijau',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $data->{$this->slug.'_lokasi_area_hijau'} : ''),
				'validation'=> 'required' ),
			);
	}

	public function data()
	{
		// surat_no:
		// surat_tgl:28-10-2013
		// surat_petugas:
		// surat_jenis_pengajuan:
		// pemohon_nama:
		// pemohon_kerja:
		// pemohon_alamat:
		// pemohon_telp:
		// usaha_nama:
		// usaha_jenis:
		// usaha_alamat:
		// usaha_lokasi:
		// usaha_luas:
		// usaha_pekerja:
		// usaha_tetangga_timur:
		// usaha_tetangga_utara:
		// usaha_tetangga_selatan:
		// usaha_tetangga_barat:
		// total_syarat:13
	}
}

/* End of file Izin_obat_tradisional.php */
/* Location: ./application/models/app/Izin_obat_tradisional.php */