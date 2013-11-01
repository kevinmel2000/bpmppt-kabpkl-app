<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usaha_perdagangan extends CI_Model
{
	public $kode = 'SIUP';
	public $slug = 'izin_usaha_perdagangan';
	public $nama = 'Surat Izin Usaha Perdangangan';

	public function __construct()
	{
		log_message('debug', "Usaha_perdagangan_model Class Initialized");
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
		$post_data['surat_no']						= $this->input->post('surat_no');
		$post_data['pemilik_nama']					= $this->input->post('pemilik_nama');
		$post_data['pemilik_identitas_jenis']		= $this->input->post('pemilik_identitas_jenis');
		$post_data['pemilik_identitas_nomor']		= $this->input->post('pemilik_identitas_nomor');
		$post_data['pemilik_lahir_tanggal']			= string_to_date( $this->input->post('pemilik_lahir_tanggal') );
		$post_data['pemilik_lahir_tempat']			= $this->input->post('pemilik_lahir_tempat');

		$post_data['pemilik_alamat']				= array(
			'alamat'	=> $this->input->post('pemilik_alamat'),
			'propinsi'	=> $this->input->post('pemilik_propinsi'),
			'kota'		=> $this->input->post('pemilik_kota'),
			'kecamatan'	=> $this->input->post('pemilik_kecamatan'),
			'kelurahan'	=> $this->input->post('pemilik_kelurahan'),
			'desa'		=> $this->input->post('pemilik_desa'),
			'rt'		=> $this->input->post('pemilik_rt'),
			'rw'		=> $this->input->post('pemilik_rw'),
			);

		$post_data['pemilik_kwn']					= $this->input->post('pemilik_kwn');
		$post_data['pemilik_telpon']				= $this->input->post('pemilik_telpon');
		$post_data['usaha_nama']					= $this->input->post('usaha_nama');
		$post_data['usaha_bentuk']					= $this->input->post('usaha_bentuk');

		$post_data['usaha_alamat']					= array(
			'alamat'	=> $this->input->post('usaha_alamat'),
			'propinsi'	=> $this->input->post('usaha_propinsi'),
			'kota'		=> $this->input->post('usaha_kota'),
			'kecamatan'	=> $this->input->post('usaha_kecamatan'),
			'kelurahan'	=> $this->input->post('usaha_kelurahan'),
			'desa'		=> $this->input->post('usaha_desa'),
			'rt'		=> $this->input->post('usaha_rt'),
			'rw'		=> $this->input->post('usaha_rw'),
			);

		$post_data['usaha_pos']						= $this->input->post('usaha_pos');
		$post_data['usaha_telpon']					= $this->input->post('usaha_telpon');
		$post_data['usaha_fax']						= $this->input->post('usaha_fax');
		$post_data['usaha_kbli']					= $this->input->post('usaha_kbli');
		$post_data['usaha_kki']						= $this->input->post('usaha_kki');
		$post_data['usaha_lembaga']					= $this->input->post('usaha_lembaga');
		$post_data['usaha_modal']					= $this->input->post('usaha_modal');
		$post_data['usaha_saham_asing']				= $this->input->post('usaha_saham_asing');
		$post_data['usaha_saham_nasional']			= $this->input->post('usaha_saham_nasional');
		$post_data['usaha_saham_nilai']				= $this->input->post('usaha_saham_nilai');
		$post_data['usaha_saham_status']			= $this->input->post('usaha_saham_status');
		$post_data['usaha_pendirian_akta_nomor']	= $this->input->post('usaha_pendirian_akta_nomor');
		$post_data['usaha_pendirian_akta_tanggal']	= string_to_date( $this->input->post('usaha_pendirian_akta_tanggal') );
		$post_data['usaha_pendirian_sah_nomor']		= $this->input->post('usaha_pendirian_sah_nomor');
		$post_data['usaha_pendirian_sah_tanggal']	= string_to_date( $this->input->post('usaha_pendirian_sah_tanggal') );
		$post_data['usaha_perubahan_akta_nomor']	= $this->input->post('usaha_perubahan_akta_nomor');
		$post_data['usaha_perubahan_akta_tanggal']	= string_to_date( $this->input->post('usaha_perubahan_akta_tanggal') );
		$post_data['usaha_perubahan_sah_nomor']		= $this->input->post('usaha_perubahan_sah_nomor');
		$post_data['usaha_perubahan_sah_tanggal']	= string_to_date( $this->input->post('usaha_perubahan_sah_tanggal') );

		// usaha_bentuk:
		// surat_jenis_pengajuan:
		// surat_no:
		// surat_tgl:28-10-2013
		// pemilik_nama:
		// pemilik_identitas_jenis:
		// pemilik_identitas_nomor:
		// pemilik_alamat:
		// pemilik_lahir_tempat:
		// pemilik_lahir_tanggal:28-10-2013
		// pemilik_telpon:
		// pemilik_fax:
		// pemilik_kwn:
		// usaha_nama:
		// usaha_lembaga:
		// usaha_kbli:
		// usaha_kki:
		// usaha_alamat:
		// usaha_telpon:
		// usaha_fax:
		// usaha_pendirian_akta_nomor:
		// usaha_pendirian_akta_tanggal:28-10-2013
		// usaha_pendirian_sah_nomor:
		// usaha_pendirian_sah_tanggal:28-10-2013
		// usaha_perubahan_akta_nomor:
		// usaha_perubahan_akta_tanggal:28-10-2013
		// usaha_perubahan_sah_nomor:
		// usaha_perubahan_sah_tanggal:28-10-2013
		// usaha_saham_status:
		// usaha_modal:
		// usaha_saham_nilai:
		// usaha_saham_nasional:
		// usaha_saham_asing:
		// total_syarat:13
	}
}

/* End of file Izin_usaha_perdagangan.php */
/* Location: ./application/models/app/Izin_usaha_perdagangan.php */