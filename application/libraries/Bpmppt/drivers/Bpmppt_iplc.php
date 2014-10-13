<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bpmppt_iplc Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Pembuangan Air Limbah ke Air atau Sumber Air
| ------------------------------------------------------------------------------
*/

/**
 * BPMPPT Izin Pembuangan Air Limbah ke Air atau Sumber Air Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_iplc extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'IPLC';
    public $alias = 'izin_pembuangan_air_limbah';
    public $name = 'Izin Pembuangan Air Limbah ke Air atau Sumber Air';
    public $prefield_label = 'No. &amp; Tgl. Input';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'pemohon_nama'              => '',
        'pemohon_jabatan'           => '',
        'pemohon_usaha'             => '',
        'pemohon_alamat'            => '',
        'ketentuan_teknis'          => '',
        'limbah_kapasitas_produksi' => '',
        'limbah_debit_max_proses'   => '',
        'limbah_debit_max_kond'     => '',
        'limbah_target_buang'       => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Pembuangan_limbah Class Initialized");
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
        $fields[] = array(
            'name'  => 'fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_jabatan',
            'label' => 'Jabatan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_jabatan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_usaha',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_usaha : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'data_teknis',
            'label' => 'Data Teknis',
            'type'  => 'editor',
            'std'   => ( $data_obj ? $data_obj->data_teknis : Bootigniter::get_setting('iplc_teknis') ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        return $fields;
    }
}

/* End of file Bpmppt_iplc.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_iplc.php */
