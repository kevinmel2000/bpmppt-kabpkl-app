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
 * BPMPPT Izin Pengobatan Tradisional Driver
 *
 * @subpackage	Drivers
 */
class Bpmppt_obat extends CI_Driver
{
	/**
	 * Document property
	 *
	 * @var  string  $alias
	 * @var  string  $name
	 */
	public $alias = 'izin_obat_tradisional';
	public $name = 'Izin Pengobatan Tradisional';

	// -------------------------------------------------------------------------

	/**
	 * Default class constructor,
	 * Just simply log this class when it loaded
	 */
	public function __construct()
	{
		log_message('debug', "#BPMPPT_driver: Pengobatan_tradisional Class Initialized");
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
			'name'	=> $this->alias.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->alias.'_pemohon_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_pemohon_jabatan',
			'label'	=> 'Jabatan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_jabatan : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_pemohon_usaha',
			'label'	=> 'Perusahaan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->pemohon_usaha : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->pemohon_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_fieldset_data_lokasi',
			'label'	=> 'Data Lokasi',
			'attr'	=> ( $data_obj ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->alias.'_lokasi_tujuan',
			'label'	=> 'Tujuan Permohonan',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->lokasi_tujuan : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_lokasi_alamat',
			'label'	=> 'Alamat Lokasi',
			'type'	=> 'textarea',
			'std'	=> ( $data_obj ? $data_obj->lokasi_alamat : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_lokasi_nama',
			'label'	=> 'Luas Area (M<sup>2</sup>)',
			'type'	=> 'number',
			'std'	=> ( $data_obj ? $data_obj->lokasi_nama : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

		$fields[]	= array(
			'name'	=> $this->alias.'_lokasi_area_hijau',
			'label'	=> 'Area terbuka hijau',
			'type'	=> 'text',
			'std'	=> ( $data_obj ? $data_obj->lokasi_area_hijau : ''),
			'validation'=> ( !$data_obj ? 'required' : '' ) );

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

/* End of file Bpmppt_obat.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_obat.php */