<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     Bapa Pack BPMPPT
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 1.0
 * @filesource
 */

// =============================================================================

/**
 * BPMPPT Izin Usaha Pariwisata Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_wisata extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $alias
     * @var  string  $name
     */
    public $alias = 'pariwisata';
    public $name = 'Izin Usaha Pariwisata';

    /**
     * Default field
     *
     * @var  array
     */
    public $fields = array(
        'pemohon_nama'      => '',
        'pemohon_kerja'     => '',
        'pemohon_jabatan'   => '',
        'pemohon_alamat'    => '',
        'pemohon_telp'      => '',
        'usaha_nama'        => '',
        'usaha_jenis'       => '',
        'usaha_alamat'      => '',
        'usaha_luas'        => '',
        'usaha_an'          => '',
        'usaha_ket'         => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Usaha_pariwisata Class Initialized");
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
        /**
         * @todo
         *
         * Nomor Izin:
         * 557.142/19/PAR/RM/BPMPPT/XI/2013
         * + 557.142 -> Static
         * + 19 -> Nomor urut mulai per tahun
         * + PAR -> static
         * + RM -> Kode Jenis Usaha
         *
         * Bentuk cetak
         * + Surat Ijin
         * + kutipan
         */

        $fields[]   = array(
            'name'  => $this->alias.'_penetapan',
            'label' => 'No. &amp; Tgl. Ditetapkan',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'nomor',
                    'label' => 'Nomor Ditetapkan',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->penetapan_nomor : '' ),
                    'validation'=> ''
                    ),
                array(
                    'col'   => '6',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Ditetapkan',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->penetapan_tgl : ''),
                    'callback'=> 'string_to_date',
                    'validation'=> ''
                    ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_pemohon',
            'label' => 'Data Pemohon',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_kerja',
            'label' => 'Pekerjaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_kerja : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_jabatan',
            'label' => 'Jabatan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_jabatan : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_telp',
            'label' => 'Nomor Telpon/HP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_telp : ''),
            'validation'=> 'numeric|max_length[12]' );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_perusahaan',
            'label' => 'Data Perusahaan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_nama',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_jenis',
            'label' => 'Jenis Usaha',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_alamat',
            'label' => 'Alamat Kantor',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_luas',
            'label' => 'Luas perusahaan (M<sup>2</sup>)',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->usaha_luas : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_an',
            'label' => 'Atas Nama Pendirian',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_an : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_ket',
            'label' => 'Keterangan Lain',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_ket : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_tembusan',
            'label' => 'Tembusan Dokumen',
            'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
            'type'  => 'fieldset' );

        $fields[] = $this->field_tembusan($data_obj, $this->alias);

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

/* End of file Bpmppt_wisata.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_wisata.php */