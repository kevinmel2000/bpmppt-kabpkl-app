<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BPMPPT driver
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     BPMPPT
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 1.0
 * @filesource
 */

// =============================================================================

/**
 * BPMPPT Surat Izin Usaha Perdangangan Driver
 *
 * @subpackage	Drivers
 */
class Bpmppt_siup extends CI_Driver
{
	/**
	 * Document property
	 *
	 * @var  string  $code
	 * @var  string  $alias
	 * @var  string  $name
	 */
	public $code = 'SIUP';
	public $alias = 'surat_izin_usaha_perdagangan';
	public $name = 'Surat Izin Usaha Perdangangan';

	// -------------------------------------------------------------------------

	/**
	 * Default class constructor,
	 * Just simply log this class when it loaded
	 */
	public function __construct()
	{
		log_message('debug', "#BPMPPT_driver: Usaha_perdagangan Class Initialized");
	}

	// -------------------------------------------------------------------------

	/**
	 * Form fields from this driver
	 *
	 * @param   bool    $data_obj  Data field
	 *
	 * @return  array
	 */
	public function form( $data_obj = FALSE )
	{
		$fields[]	= array(
			'name'	=> $this->alias.'_pengajuan_jenis',
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
			'name'	=> $this->alias.'_pembaruan_ke',
			'label'	=> 'Daftar ulang Ke',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pembaruan_ke : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_fieldset_data_pemilik',
			'label'	=> 'Data Pemilik Perusahaan',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->alias.'_pemilik_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemilik_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_pemilik_ktp',
			'label'	=> 'Nomor KTP',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemilik_ktp : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_pemilik_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->pemilik_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_pemilik_lahir',
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
			'name'	=> $this->alias.'_pemilik_no',
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
			'name'	=> $this->alias.'_pemilik_usaha',
			'label'	=> 'Perusahaan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemilik_usaha : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_fieldset_data_usaha',
			'label'	=> 'Data Perusahaan',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->alias.'_usaha_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_usaha_skala',
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
			'name'	=> $this->alias.'_usaha_lembaga',
			'label'	=> 'Kelembagaan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_lembaga : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_usaha_kegiatan',
			'label'	=> 'Kegiatan Usaha (KBLI)',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->usaha_kegiatan : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_usaha_lembaga',
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
			'name'	=> $this->alias.'_usaha_komoditi',
			'label'	=> 'Komoditi Usaha',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_komoditi : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_usaha_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->usaha_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_usaha_no',
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
			'name'	=> $this->alias.'_usaha_pendirian_akta',
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
			'name'	=> $this->alias.'_usaha_pendirian_pengesahan',
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
			'name'	=> $this->alias.'_usaha_perubahan_akta',
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
			'name'	=> $this->alias.'_usaha_perubahan_pengesahan',
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
			'name'	=> $this->alias.'_usaha_siup_lama',
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

	// -------------------------------------------------------------------------

	/**
	 * Format cetak produk perijinan
	 *
	 * @return  mixed
	 */
	public function produk()
	{
		return false;
	}

	// -------------------------------------------------------------------------

	/**
	 * Format output laporan
	 *
	 * @return  mixed
	 */
	public function laporan()
	{
		return false;
	}
}

/* End of file Bpmppt_siup.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_siup.php */