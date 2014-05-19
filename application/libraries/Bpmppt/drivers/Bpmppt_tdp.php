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
 * BPMPPT Tanda Daftar Perusahaan Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_tdp extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'TDP';
    public $alias = 'tanda_daftar_perusahaan';
    public $name = 'Tanda Daftar Perusahaan';

    /**
     * Default field
     *
     * @var  array
     */
    public $fields = array(
        'no_daftar'                         => '',
        'no_sk'                             => '',
        'tgl_berlaku'                       => '',
        'pengajuan_jenis'                   => '',
        'pembaruan_ke'                      => '',
        'pemohon_nama'                      => '',
        'pemilik_ktp'                       => '',
        'pemilik_alamat'                    => '',
        'pemilik_kwn'                       => '',
        'pemilik_lahir_tmpt'                => '',
        'pemilik_lahir_tgl'                 => '',
        'pemilik_no_telp'                   => '',
        'pemilik_no_fax'                    => '',
        'usaha_nama'                        => '',
        'usaha_jenis'                       => '',
        'usaha_skala'                       => '',
        'usaha_status'                      => '',
        'usaha_alamat'                      => '',
        'usaha_no_telp'                     => '',
        'usaha_no_fax'                      => '',
        'usaha_pokok'                       => '',
        'usaha_kbli'                        => '',
        'usaha_pendirian_akta_no'           => '',
        'usaha_pendirian_akta_tgl'          => '',
        'usaha_pendirian_pengesahan_no'     => '',
        'usaha_pendirian_pengesahan_tgl'    => '',
        'usaha_perubahan_akta_no'           => '',
        'usaha_perubahan_akta_tgl'          => '',
        'usaha_perubahan_pengesahan_no'     => '',
        'usaha_perubahan_pengesahan_tgl'    => '',
        'usaha_npwp'                        => '',
        'usaha_saham_status'                => '',
        'usaha_modal_awal'                  => '',
        'usaha_saham_nilai_total'           => '',
        'usaha_saham_nilai_nasional'        => '',
        'usaha_saham_nilai_tgl'             => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Tanda_daftar_perusahaan Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Form fields from this driver
     *
     * @todo
      Tambahan nomor
      - Nomor agenda        posisi atas
      - Nomor registrasi    posisi kolom kiri
      - Masa berlaku
      - Tanggal ditetapkan
     * 
     * @param   bool    $data_obj  Data field
     *
     * @return  array
     */
    public function form( $data_obj = FALSE )
    {
        $fields[]   = array(
            'name'  => $this->alias.'_no_tdp',
            'label' => 'Nomor TDP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->no_daftar : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_no_agenda',
            'label' => 'Nomor Agenda PT',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->no_sk : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_tgl_berlaku',
            'label' => 'Tgl. Masa Berlaku',
            'type'  => 'datepicker',
            'std'   => ( $data_obj ? $data_obj->tgl_berlaku : '') );

        $fields[]   = array(
            'name'  => $this->alias.'_pengajuan_jenis',
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->pengajuan_jenis : ''),
            'option'=> array(
                'daftar baru'   => 'Pendaftaran Baru',
                'balik nama'    => 'Balik Nama',
                'daftar ulang'  => 'Daftar Ulang' ));

        $fields[]   = array(
            'name'  => $this->alias.'_pembaruan_ke',
            'label' => 'Daftar ulang Ke',
            'type'  => 'text',
            'fold'  => array(
                'key'   => $this->alias.'_pengajuan_jenis',
                'value' => 'daftar ulang' ),
            'std'   => ( $data_obj ? $data_obj->pembaruan_ke : ''));

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_pemilik',
            'label' => 'Data Pemilik Perusahaan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''));

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_ktp',
            'label' => 'Nomor KTP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemilik_ktp : ''));

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemilik_alamat : ''));

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_kwn',
            'label' => 'Kewarganegaraan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->pemilik_kwn : ''),
            'option'=> array(
                'wni' => 'Warga Negara Indonesia',
                'wna' => 'Warga Negara Asing' ));

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_lahir',
            'label' => 'Tempat &amp; Tgl. Lahir',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'tmpt',
                    'label' => 'Tempat Lahir',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->pemilik_lahir_tmpt : '') ),
                array(
                    'col'   => '6',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Lahir',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->pemilik_lahir_tgl : '') ,
                    'callback'=> 'string_to_date' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_pemilik_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->pemilik_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
                    'col'   => '6',
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->pemilik_no_fax : ''),
                    'validation'=> 'numeric' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_usaha',
            'label' => 'Data Perusahaan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_nama : ''));

        $u_jenis = array(
            'Perseroan Terbatas (PT)',
            'Perseroan Komanditer (CV)',
            'Badan Usaha Milik Negara (BUMN)',
            'Perorangan (PO)',
            'Koperasi',
            );

        foreach ( $u_jenis as $jenis )
        {
            $jns_opt[$jenis] = $jenis;
        }

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_jenis',
            'label' => 'Jenis Perusahaan',
            'type'  => 'radio',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : ''),
            'option'=> $jns_opt );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_skala',
            'label' => 'Skala Perusahaan',
            'type'  => 'radio',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_skala : ''),
            'option'=> array(
                'PK' => 'Perusahaan Kecil',
                'PM' => 'Menengah',
                'PB' => 'Besar' ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_status',
            'label' => 'Status Perusahaan',
            'type'  => 'radio',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'std'   => ( $data_obj ? $data_obj->usaha_status : ''),
            'option'=> array(
                'tunggal' => 'Kantor Tunggal',
                'pusat' => 'Kantor Pusat',
                'cabang' => 'Kantor Cabang',
                'pembantu' => 'Kantor Pembantu',
                'perwakilan' => 'Kantor Perwakilan' ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
                    'col'   => '6',
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_fax : ''),
                    'validation'=> 'numeric' ),
                ));

        /**
         * 0 - 50   Usaha kecil
         * 50 - 500 Menengah
         * 500 >    Besar
         */

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_usaha_kegiatan',
            'label' => 'Kegiatan Usaha',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_pokok',
            'label' => 'Kegiatan Usaha Pokok',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_pokok : ''));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_kbli',
            'label' => 'KBLI',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_kbli : ''));

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_usaha_akta',
            'label' => 'Data Akta dan Pengesahan',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_akta_pengesahan',
            'label' => 'Akta Pengesahan Pendirian B.H.',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '3',
                    'name'  => 'no',
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_akta_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '3',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Akta',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_akta_tgl : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'uraian',
                    'label' => 'Uraian',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_pengesahan_uraian : ''),
                    'validation'=> '' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_akta_perubahan',
            'label' => 'Akta Perubahan A.D.B.H.',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '3',
                    'name'  => 'no',
                    'label' => 'Nomor Pengesahan',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_pengesahan_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '3',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Pengesahan',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_pengesahan_tgl : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'uraian',
                    'label' => 'Uraian',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_pengesahan_uraian : ''),
                    'validation'=> '' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_perubahan_ad',
            'label' => 'Penerimaan Perubahan A.D.',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '3',
                    'name'  => 'no',
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_perubahan_akta_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '3',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Akta',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_perubahan_akta_tgl : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'uraian',
                    'label' => 'Uraian',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_pendirian_pengesahan_uraian : ''),
                    'validation'=> '' ),
                ));

        $fields[]   = array(
            'name'  => $this->alias.'_fieldset_data_usaha_saham',
            'label' => 'Data Modal Usaha',
            'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_npwp',
            'label' => 'NPWP Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_npwp : ''),
            'validation'=> ( !$data_obj ? 'numeric' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_saham_status',
            'label' => 'Status Saham',
            'type'  => 'dropdown',
            'std'   => ( $data_obj ? $data_obj->usaha_saham_status : ''),
            'option'=> array(
                '' => '---',
                'pmdm' => 'Penanaman Modal Dalam Negeri',
                'pma' => 'Penanaman Modal Asing' ));

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_modal_awal',
            'label' => 'Modal awal',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_modal_awal : ''),
            'validation'=> ( !$data_obj ? 'numeric' : '' ) );

        $fields[]   = array(
            'name'  => $this->alias.'_usaha_saham_nilai',
            'label' => 'Nilai Saham',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '6',
                    'name'  => 'total',
                    'label' => 'Total Nilai Saham (Rp.)',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_saham_nilai_total : ''),
                    'validation'=> ( !$data_obj ? 'numeric' : '' ) ),
                array(
                    'col'   => '3',
                    'name'  => 'nasional',
                    'label' => 'Nasional (%)',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->usaha_saham_nilai_nasional : ''),
                    'validation'=> ( !$data_obj ? 'numeric' : '' ) ),
                array(
                    'col'   => '3',
                    'name'  => 'tgl',
                    'label' => 'Asing (%)',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->usaha_saham_nilai_tgl : ''),
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

/* End of file Bpmppt_tdp.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_tdp.php */