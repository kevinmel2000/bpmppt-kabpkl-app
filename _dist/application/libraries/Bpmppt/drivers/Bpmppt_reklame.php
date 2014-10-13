<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bpmppt_reklame Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Reklame
| ------------------------------------------------------------------------------
*/

class Bpmppt_reklame extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $alias
     * @var  string  $name
     */
    public $alias = 'izin_reklame';
    public $name  = 'Izin Reklame';

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'pemohon_nama'              => '',
        'pemohon_kerja'             => '',
        'pemohon_alamat'            => '',
        'pemohon_telp'              => '',
        'pengajuan_jenis'           => '',
        'reklame_jenis'             => '',
        'reklame_juml'              => '',
        'reklame_range_tgl_text'    => '',
        'reklame_range_tgl_mulai'   => '',
        'reklame_range_tgl_selesai' => '',
        'reklame_tema'              => '',
        'reklame_ket'               => '',
        'lampirans'                 => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Reklame Class Initialized");
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
            'name'  => 'pengajuan_jenis',
            'label' => 'Jenis Pengajuan',
            'type'  => 'radio',
            'std'   => ( $data_obj ? $data_obj->pengajuan_jenis : ''),
            'option'=> array(
                'Pendaftaran Baru' => 'Pendaftaran Baru',
                'Perpanjangan'     => 'Perpanjangan'
                ),
            'validation'=> ( !$data_obj ? 'required' : '' ));

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

        // $fields[] = array(
        //     'name'  => 'pemohon_kerja',
        //     'label' => 'Pekerjaan',
        //     'type'  => 'text',
        //     'std'   => ( $data_obj ? $data_obj->pemohon_kerja : ''),
        //     'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_telp',
            'label' => 'No. Telp',
            'type'  => 'tel',
            'std'   => ( $data_obj ? $data_obj->pemohon_telp : ''),
            'validation'=> 'numeric' );

        $fields[] = array(
            'name'  => 'fieldset_data_reklame',
            'label' => 'Data Reklame',
            // 'attr'  => ( $data_obj ? 'disabled' : '' ),
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'reklame_jenis',
            'label' => 'Jenis Reklame',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->reklame_jenis : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'reklame_juml',
            'label' => 'Jumlah',
            'type'  => 'number',
            'std'   => ( $data_obj ? $data_obj->reklame_juml : ''),
            'validation'=> 'required|numeric' );

        $fields[] = array(
            'name'  => 'reklame_range',
            'label' => 'Jangka waktu',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'tgl_text',
                    'label' => 'Terbilang',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->reklame_range_tgl_text : ''),
                    'validation'=> 'required' ),
                array(
                    'name'  => 'tgl_mulai',
                    'label' => 'Mulai Tanggal',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->reklame_range_tgl_mulai : ''),
                    'validation'=> 'required|numerik' ),
                array(
                    'name'  => 'tgl_selesai',
                    'label' => 'Sampai Tanggal',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->reklame_range_tgl_selesai : ''),
                    'validation'=> 'required|numerik' ),
                )
            );

        $fields[] = array(
            'name'  => 'reklame_tema',
            'label' => 'Tema/Isi',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->reklame_tema : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'reklame_ket',
            'label' => 'Keterangan',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->reklame_ket : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'lampirans',
            'label' => 'Data Lampiran',
            'type'  => 'custom',
            'std' => $this->custom_field( $data_obj ),
            // 'fold'  => array(
            //     'key'   => 'reklame_lampiran',
            //     'value' => 1
            //     ),
            );

        return $fields;
    }

    // -------------------------------------------------------------------------

    private function custom_field( $data = FALSE )
    {
        if (!$this->_ci->load->is_loaded('table'))
        {
            $this->_ci->load->library('table');
        }

        $this->_ci->table->set_template($this->table_templ);

        $data_mode = $data and !empty($data->lampirans);

        // var_dump($this);
        $head[] = array(
            'data'  => 'Lokasi Pemasangan',
            'class' => 'head-id',
            'width' => '60%' );

        $head[] = array(
            'data'  => 'Panjang',
            'class' => 'head-value',
            'width' => '15%' );

        $head[] = array(
            'data'  => 'Lebar',
            'class' => 'head-value',
            'width' => '15%' );

        $head[] = array(
            'data'  => form_button( array(
                'name'  => 'lampirans_add-btn',
                'type'  => 'button',
                'class' => 'btn btn-primary bs-tooltip btn-block btn-sm',
                'tabindex' => '-1',
                'title' => 'Tambahkan baris',
                'content'=> 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->_ci->table->set_heading( $head );

        if (isset($data->lampirans) and !empty($data->lampirans))
        {
            foreach (unserialize($data->lampirans) as $row)
            {
                $this->_row_pengesahan($row);
            }
        }
        else
        {
            $this->_row_pengesahan();
        }

        return $this->_ci->table->generate();
    }

    // -------------------------------------------------------------------------

    private function _row_pengesahan( $data = FALSE )
    {
        $cols = array(
            'tempat'  => 'Lokasi',
            'panjang' => 'Panjang (M)',
            'lebar'   => 'Lebar (M)',
            );

        foreach ($cols as $name => $label)
        {
            $column[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_lampirans_'.$name.'[]',
                    'type'  => 'text',
                    'value' => $data ? $data[$name] : '',
                    'class' => 'form-control bs-tooltip input-sm',
                    'placeholder'=> $label ), '', ''),
                'class' => 'data-id',
                'width' => '10%' );
        }

        $column[] = array(
            'data'  => form_button( array(
                'name'  => $this->alias.'_lampirans_remove-btn',
                'type'  => 'button',
                'class' => 'btn btn-danger bs-tooltip btn-block btn-sm remove-btn',
                'tabindex' => '-1',
                'content'=> '&times;' ) ),
            'class' => '',
            'width' => '10%' );

        $this->_ci->table->add_row( $column );
    }

    // -------------------------------------------------------------------------

    /**
     * Prepost form data hooks
     *
     * @return  mixed
     */
    public function _pre_post( $form_data )
    {
        $pengesahan_fn = $this->alias.'_lampirans';

        if (isset($_POST[$pengesahan_fn.'_tempat']))
        {
            $i = 0;

            foreach ($_POST[$pengesahan_fn.'_tempat'] as $no)
            {
                foreach (array('tempat', 'panjang', 'lebar') as $name)
                {
                    $pengesahan_name = $pengesahan_fn.'_'.$name;
                    $pengesahan[$i][$name] = isset($_POST[$pengesahan_name][$i]) ? $_POST[$pengesahan_name][$i] : 0;
                    unset($_POST[$pengesahan_name][$i]);
                }

                $i++;
            }

            $form_data[$pengesahan_fn] = $pengesahan;
        }

        return $form_data;
    }
}

/* End of file Bpmppt_reklame.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_reklame.php */
