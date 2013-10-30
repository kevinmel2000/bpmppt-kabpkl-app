<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tanda_daftar_perusahaan extends CI_Model
{
	public $kode = 'TDP';
	public $slug = 'izin_tanda_daftar_perusahaan';
	public $nama = 'Tanda Daftar Perusahaan';

	public function __construct()
	{
		parent::__construct();

		log_message('debug', "Tanda_daftar_perusahaan_model Class Initialized");
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
		// surat_tgl:28/10/2013
		// surat_petugas:
		// surat_jenis_pengajuan:
		// pemilik_nama:
		// pemilik_identitas_jenis:
		// pemilik_identitas_nomor:
		// pemilik_telp:
		// pemilik_alamat:
		// pemilik_rt:
		// pemilik_rw:
		// pemilik_propinsi:
		// pemilik_kota:
		// pemilik_kecamatan:
		// pemilik_kelurahan:
		// pemilik_lahir_tempat:
		// pemilik_lahir_tanggal:
		// pemilik_telpon:
		// pemilik_kwn:
		// usaha_nama:
		// usaha_bentuk:
		// usaha_status:
		// usaha_induk_nama:
		// usaha_induk_tdp:
		// usaha_induk_alamat:
		// usaha_induk_rt:
		// usaha_induk_rw:
		// usaha_induk_propinsi:
		// usaha_induk_kota:
		// usaha_induk_kecamatan:
		// usaha_induk_kelurahan:
		// usaha_lembaga:
		// usaha_kbli:
		// usaha_kki:
		// usaha_alamat:
		// usaha_rt:
		// usaha_rw:
		// usaha_propinsi:
		// usaha_kota:
		// usaha_kecamatan:
		// usaha_kelurahan:
		// usaha_pos:
		// usaha_telpon:
		// usaha_fax:
		// usaha_pendirian_akta_nomor:
		// usaha_pendirian_akta_tanggal:
		// usaha_pendirian_sah_nomor:
		// usaha_pendirian_sah_tanggal:
		// usaha_perubahan_akta_nomor:
		// usaha_perubahan_akta_tanggal:
		// usaha_perubahan_sah_nomor:
		// usaha_perubahan_sah_tanggal:
		// usaha_saham_status:
		// usaha_modal:
		// usaha_saham_nilai:
		// usaha_saham_nasional:
		// usaha_saham_asing:
		// total_syarat:7
	}
}

/* End of file Izin_tdp.php */
/* Location: ./application/models/app/Izin_tdp.php */