<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usaha_perdagangan extends App_main
{
	public $kode = 'SIUP';
	public $slug = 'izin_usaha_perdagangan';
	public $nama = 'Surat Izin Usaha Perdangangan';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Usaha_perdagangan_model Class Initialized");
	}

	public function form( $data_obj = FALSE )
	{
		$fields[]	= array(
			'name'	=> $this->slug.'_pengajuan_jenis',
			'label'	=> 'Jenis Pengajuan',
			'type'	=> 'dropdown',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->pengajuan_jenis : ''),
			'option'=> array(
				'' => '---',
				'daftar baru'	=> 'Pendaftaran Baru',
				'balik nama'	=> 'Balik Nama',
				'daftar ulang'	=> 'Daftar Ulang' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pembaruan_ke',
			'label'	=> 'Daftar ulang Ke',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pembaruan_ke : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemilik',
			'label'	=> 'Data Pemilik Perusahaan',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemilik_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_ktp',
			'label'	=> 'Nomor KTP',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemilik_ktp : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->pemilik_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_lahir',
			'label'	=> 'Tempat &amp; Tgl. Lahir',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'tmpt',
					'label'	=> 'Tempat Lahir',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->pemilik_lahir_tmpt : '' ),
					'validation'=> ''
					),
				array(
					'col'	=> '6',
					'name'	=> 'tgl',
					'label'	=> 'Tanggal Lahir',
					'type'	=> 'datepicker',
					'std'	=> ( $data_obj ? $data_obj->pemilik_lahir_tgl : ''),
					'callback'=> 'string_to_date',
					'validation'=> ''
					),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_no',
			'label'	=> 'Nomor Telp/Fax',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'telp',
					'label'	=> 'Telpon',
					'type'	=> 'number',
					'std'	=> ( $data_obj ? $data_obj->pemilik_no_telp : ''),
					'validation'=> 'numeric' ),
				array(
					'col'	=> '6',
					'name'	=> 'fax',
					'label'	=> 'Faksimili',
					'type'	=> 'number',
					'std'	=> ( $data_obj ? $data_obj->pemilik_no_fax : ''),
					'validation'=> 'numeric' ),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_pemilik_usaha',
			'label'	=> 'Perusahaan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemilik_usaha : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_usaha',
			'label'	=> 'Data Perusahaan',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_skala',
			'label'	=> 'Skala Perusahaan',
			'type'	=> 'dropdown',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->usaha_skala : ''),
			'option'=> array(
				'' => '---',
				'bumn' => 'Badan Usaha Milik Negara (BUMN)',
				'kpr' => 'Koperasi',
				'po' => 'Perorangan (PO)',
				'cv' => 'Perseroan Komanditer (CV)',
				'pt' => 'Perseroan Terbatas (PT)' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_lembaga',
			'label'	=> 'Kelembagaan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_lembaga : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_kegiatan',
			'label'	=> 'Kegiatan Usaha (KBLI)',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_kegiatan : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_lembaga',
			'label'	=> 'Kelembagaan',
			'type'	=> 'multiselect',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->usaha_lembaga : ''),
			'option'=> array(
				0 => '---',
				// Kecil
				1 => 'Pengecer',
				2 => 'Penyalur',
				3 => 'Pengumpul',
				// Menengah
				4 => 'Produsen',
				5 => 'Sub Distributor',
				6 => 'Distributor',
				7 => 'Distributor',
				),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_komoditi',
			'label'	=> 'Komoditi Usaha',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_komoditi : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_no',
			'label'	=> 'Nomor Telp/Fax',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'telp',
					'label'	=> 'Telpon',
					'type'	=> 'number',
					'std'	=> ( $data_obj ? $data_obj->usaha_no_telp : ''),
					'validation'=> 'numeric' ),
				array(
					'col'	=> '6',
					'name'	=> 'fax',
					'label'	=> 'Faksimili',
					'type'	=> 'number',
					'std'	=> ( $data_obj ? $data_obj->usaha_no_fax : ''),
					'validation'=> 'numeric' ),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_pendirian_akta',
			'label'	=> 'Akta Pendirian',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'no',
					'label'	=> 'Nomor Akta',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_pendirian_akta_no : ''),
					'validation'=> '' ),
				array(
					'col'	=> '6',
					'name'	=> 'tgl',
					'label'	=> 'Tanggal Akta',
					'type'	=> 'datepicker',
					'std'	=> ( $data_obj ? $data_obj->usaha_pendirian_akta_tgl : ''),
					'validation'=> '' ),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_pendirian_pengesahan',
			'label'	=> 'Pengesahan Pendirian',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'no',
					'label'	=> 'Nomor Pengesahan',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_pendirian_pengesahan_no : ''),
					'validation'=> '' ),
				array(
					'col'	=> '6',
					'name'	=> 'tgl',
					'label'	=> 'Tanggal Pengesahan',
					'type'	=> 'datepicker',
					'std'	=> ( $data_obj ? $data_obj->usaha_pendirian_pengesahan_tgl : ''),
					'validation'=> '' ),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_perubahan_akta',
			'label'	=> 'Akta Perubahan',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'no',
					'label'	=> 'Nomor Akta',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_perubahan_akta_no : ''),
					'validation'=> '' ),
				array(
					'col'	=> '6',
					'name'	=> 'tgl',
					'label'	=> 'Tanggal Akta',
					'type'	=> 'datepicker',
					'std'	=> ( $data_obj ? $data_obj->usaha_perubahan_akta_tgl : ''),
					'validation'=> '' ),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_perubahan_pengesahan',
			'label'	=> 'Pengesahan Perubahan',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'no',
					'label'	=> 'Nomor Pengesahan',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_perubahan_pengesahan_no : ''),
					'validation'=> '' ),
				array(
					'col'	=> '6',
					'name'	=> 'tgl',
					'label'	=> 'Tanggal Pengesahan',
					'type'	=> 'datepicker',
					'std'	=> ( $data_obj ? $data_obj->usaha_perubahan_pengesahan_tgl : ''),
					'validation'=> '' ),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_siup_lama',
			'label'	=> 'Nilai Saham',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'nomor',
					'label'	=> 'Nomor Siup Lama',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_siup_lama_nomor : ''),
					'validation'=> ( !$data_obj ? 'numeric' : '' ) ),
				array(
					'col'	=> '6',
					'name'	=> 'tgl',
					'label'	=> 'Tanggal',
					'type'	=> 'datepicker',
					'std'	=> ( $data_obj ? $data_obj->usaha_siup_lama_tgl : ''),
					'validation'=> ( !$data_obj ? 'numeric' : '' ) ),
				));

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