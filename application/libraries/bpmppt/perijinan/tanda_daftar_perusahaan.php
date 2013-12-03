<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tanda_daftar_perusahaan extends App_main
{
	public $kode = 'TDP';
	public $slug = 'izin_tanda_daftar_perusahaan';
	public $nama = 'Tanda Daftar Perusahaan';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Tanda_daftar_perusahaan_model Class Initialized");
	}

	/**
	 * Todo
	 * Tambahan nomor
	 * - Nomor agenda		posisi atas
	 * - Nomor registrasi	posisi kolom kiri
	 * - Masa berlaku
	 * - Tanggal ditetapkan
	 */
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
			'name'	=> $this->slug.'_pemilik_kwn',
			'label'	=> 'Kewarganegaraan',
			'type'	=> 'dropdown',
			'std'	=> ( $data_obj ? $data_obj->pemilik_kwn : ''),
			'option'=> array(
				'' => '---',
				'wni' => 'Warga Negara Indonesia',
				'wna' => 'Warga Negara Asing' ),
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
					'std'	=> ( $data_obj ? $data_obj->pemilik_lahir_tmpt : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				array(
					'col'	=> '6',
					'name'	=> 'tgl',
					'label'	=> 'Tanggal Lahir',
					'type'	=> 'datepicker',
					'std'	=> ( $data_obj ? $data_obj->pemilik_lahir_tgl : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ),
					'callback'=> 'string_to_date' ),
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
			'name'	=> $this->slug.'_usaha_jenis',
			'label'	=> 'Jenis Perusahaan',
			'type'	=> 'dropdown',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->usaha_jenis : ''),
			'option'=> array(
				'' => '---',
				'bumn' => 'Badan Usaha Milik Negara (BUMN)',
				'kpr' => 'Koperasi',
				'po' => 'Perorangan (PO)',
				'cv' => 'Perseroan Komanditer (CV)',
				'pt' => 'Perseroan Terbatas (PT)' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_skala',
			'label'	=> 'Skala Perusahaan',
			'type'	=> 'dropdown',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->usaha_skala : ''),
			'option'=> array(
				'' => '---',
				'kcl' => 'Perusahaan Kecil',
				'mng' => 'Menengah',
				'bsr' => 'Besar' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_status',
			'label'	=> 'Status Perusahaan',
			'type'	=> 'dropdown',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'std'	=> ( $data_obj ? $data_obj->usaha_status : ''),
			'option'=> array(
				'' => '---',
				'tunggal' => 'Kantor Tunggal',
				'pusat' => 'Kantor Pusat',
				'cabang' => 'Kantor Cabang',
				'pembantu' => 'Kantor Pembantu',
				'perwakilan' => 'Kantor Perwakilan' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		/**
		 * 0 - 50	Usaha kecil
		 * 50 - 500	Menengah
		 * 500 > 	Besar
		 */

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_kegiatan',
			'label'	=> 'Kegiatan Usaha &amp; KBLI',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '8',
					'name'	=> 'pokok',
					'label'	=> 'Kegiatan Usaha Pokok',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_pokok : ''),
					'validation'=> 'required' ),
				array(
					'col'	=> '4',
					'name'	=> 'kbli',
					'label'	=> 'KBLI',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_kbli : ''),
					'validation'=> 'required' ),
				));

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
			'name'	=> $this->slug.'_usaha_saham_status',
			'label'	=> 'Status Saham',
			'type'	=> 'dropdown',
			'std'	=> ( $data_obj ? $data_obj->usaha_saham_status : ''),
			'option'=> array(
				'' => '---',
				'pmdm' => 'Penanaman Modal Dalam Negeri',
				'pma' => 'Penanaman Modal Asing' ),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_modal_awal',
			'label'	=> 'Modal awal',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_modal_awal : ''),
			'validation'=> ( !$data_obj ? 'required|numeric' : '' ) );

		$fields[]	= array(
			'name'	=> $this->slug.'_usaha_saham_nilai',
			'label'	=> 'Nilai Saham',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'total',
					'label'	=> 'Total Nilai Saham (Rp.)',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->usaha_saham_nilai_total : ''),
					'validation'=> ( !$data_obj ? 'required|numeric' : '' ) ),
				array(
					'col'	=> '3',
					'name'	=> 'nasional',
					'label'	=> 'Nasional (%)',
					'type'	=> 'number',
					'std'	=> ( $data_obj ? $data_obj->usaha_saham_nilai_nasional : ''),
					'validation'=> ( !$data_obj ? 'required|numeric' : '' ) ),
				array(
					'col'	=> '3',
					'name'	=> 'tgl',
					'label'	=> 'Asing (%)',
					'type'	=> 'number',
					'std'	=> ( $data_obj ? $data_obj->usaha_saham_nilai_tgl : ''),
					'validation'=> ( !$data_obj ? 'required|numeric' : '' ) ),
				));

		return $fields;
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