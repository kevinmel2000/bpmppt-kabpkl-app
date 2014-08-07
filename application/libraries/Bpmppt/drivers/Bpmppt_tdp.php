<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
    public $prefield_label = 'No. &amp; Tgl. Agenda';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
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
        'usaha_pendirian_pengesahan_uraian' => '',
        'usaha_perubahan_akta_no'           => '',
        'usaha_perubahan_akta_tgl'          => '',
        'usaha_perubahan_pengesahan_no'     => '',
        'usaha_perubahan_pengesahan_tgl'    => '',
        'usaha_perubahan_pengesahan_uraian' => '',
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
        $fields[] = array(
            'name'  => 'no_tdp',
            'label' => 'Nomor TDP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->no_tdp : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'no_agenda',
            'label' => 'Nomor Agenda PT',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->no_agenda : '') );

        $fields[] = array(
            'name'  => 'tgl_berlaku',
            'label' => 'Tgl. Masa Berlaku',
            'type'  => 'datepicker',
            'std'   => ( $data_obj ? $data_obj->tgl_berlaku : '') );

        $fields[] = array(
            'name'  => 'pengajuan_jenis',
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->pengajuan_jenis : ''),
            'option'=> array(
                'daftar baru'   => 'Pendaftaran Baru',
                'balik nama'    => 'Balik Nama',
                'daftar ulang'  => 'Daftar Ulang' ));

        $fields[] = array(
            'name'  => 'pembaruan_ke',
            'label' => 'Daftar ulang Ke',
            'type'  => 'text',
            'fold'  => array(
                'key'   => $this->alias.'_pengajuan_jenis',
                'value' => 'daftar ulang' ),
            'std'   => ( $data_obj ? $data_obj->pembaruan_ke : ''));

        $fields[] = array(
            'name'  => 'fieldset_data_pemilik',
            'label' => 'Data Pemilik Perusahaan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'pemohon_nama',
            'label' => 'Nama lengkap',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_nama : ''));

        $fields[] = array(
            'name'  => 'pemilik_ktp',
            'label' => 'Nomor KTP',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemilik_ktp : ''));

        $fields[] = array(
            'name'  => 'pemilik_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemilik_alamat : ''));

        $fields[] = array(
            'name'  => 'pemilik_kwn',
            'label' => 'Kewarganegaraan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->pemilik_kwn : ''),
            'option'=> array(
                'wni' => 'Warga Negara Indonesia',
                'wna' => 'Warga Negara Asing' ));

        $fields[] = array(
            'name'  => 'pemilik_lahir',
            'label' => 'Tempat &amp; Tgl. Lahir',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'tmpt',
                    'label' => 'Tempat Lahir',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->pemilik_lahir_tmpt : '') ),
                array(
                    'name'  => 'tgl',
                    'label' => 'Tanggal Lahir',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->pemilik_lahir_tgl : '') ,
                    'callback'=> 'string_to_date' ),
                ));

        $fields[] = array(
            'name'  => 'pemilik_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->pemilik_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
                    'name'  => 'fax',
                    'label' => 'Faksimili',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->pemilik_no_fax : ''),
                    'validation'=> 'numeric' ),
                ));

        $fields[] = array(
            'name'  => 'fieldset_data_usaha',
            'label' => 'Data Perusahaan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_nama',
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

        $fields[] = array(
            'name'  => 'usaha_jenis',
            'label' => 'Jenis Perusahaan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_jenis : ''),
            'option'=> $jns_opt );

        $fields[] = array(
            'name'  => 'usaha_skala',
            'label' => 'Skala Perusahaan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_skala : ''),
            'option'=> array(
                'PK' => 'Perusahaan Kecil',
                'PM' => 'Menengah',
                'PB' => 'Besar' ));

        $fields[] = array(
            'name'  => 'usaha_status',
            'label' => 'Status Perusahaan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_status : ''),
            'option'=> array(
                'tunggal'    => 'Kantor Tunggal',
                'pusat'      => 'Kantor Pusat',
                'cabang'     => 'Kantor Cabang',
                'pembantu'   => 'Kantor Pembantu',
                'perwakilan' => 'Kantor Perwakilan' ));

        $fields[] = array(
            'name'  => 'usaha_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_alamat : ''));

        $fields[] = array(
            'name'  => 'usaha_no',
            'label' => 'Nomor Telp/Fax',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'telp',
                    'label' => 'Telpon',
                    'type'  => 'tel',
                    'std'   => ( $data_obj ? $data_obj->usaha_no_telp : ''),
                    'validation'=> 'numeric' ),
                array(
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

        $fields[] = array(
            'name'  => 'fieldset_data_usaha_kegiatan',
            'label' => 'Kegiatan Usaha',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_pokok',
            'label' => 'Kegiatan Usaha Pokok',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->usaha_pokok : ''));

        $fields[] = array(
            'name'  => 'usaha_kbli',
            'label' => 'KBLI',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_kbli : ''));

        $fields[] = array(
            'name'  => 'fieldset_data_usaha_akta',
            'label' => 'Data Akta dan Pengesahan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_akta_pengesahan',
            'label' => 'Akta Pengesahan Pendirian B.H.',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '3',
                    'name'  => 'no',
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_pengesahan_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '3',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Akta',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_pengesahan_tgl : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'uraian',
                    'label' => 'Uraian',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_pengesahan_uraian : ''),
                    'validation'=> '' ),
                ));

        $fields[] = array(
            'name'  => 'usaha_akta_perubahan',
            'label' => 'Akta Perubahan A.D.B.H.',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '3',
                    'name'  => 'no',
                    'label' => 'Nomor Pengesahan',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_perubahan_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '3',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Pengesahan',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_perubahan_tgl : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'uraian',
                    'label' => 'Uraian',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_akta_perubahan_uraian : ''),
                    'validation'=> '' ),
                ));

        $fields[] = array(
            'name'  => 'usaha_perubahan_ad',
            'label' => 'Penerimaan Perubahan A.D.',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'   => '3',
                    'name'  => 'no',
                    'label' => 'Nomor Akta',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_perubahan_ad_no : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '3',
                    'name'  => 'tgl',
                    'label' => 'Tanggal Akta',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->usaha_perubahan_ad_tgl : ''),
                    'validation'=> '' ),
                array(
                    'col'   => '6',
                    'name'  => 'uraian',
                    'label' => 'Uraian',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->usaha_perubahan_ad_uraian : ''),
                    'validation'=> '' ),
                ));

        $fields[] = array(
            'name'  => 'fieldset_data_usaha_saham',
            'label' => 'Data Modal Usaha',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'usaha_npwp',
            'label' => 'NPWP Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_npwp : ''),
            'validation'=> ( !$data_obj ? 'numeric' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_saham_status',
            'label' => 'Status Saham',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->usaha_saham_status : ''),
            'option'=> array(
                'pmdm' => 'Penanaman Modal Dalam Negeri',
                'pma'  => 'Penanaman Modal Asing' ));

        $fields[] = array(
            'name'  => 'usaha_modal_awal',
            'label' => 'Modal awal',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->usaha_modal_awal : ''),
            'validation'=> ( !$data_obj ? 'numeric' : '' ) );

        $fields[] = array(
            'name'  => 'usaha_saham_nilai',
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
