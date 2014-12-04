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
        'pemohon_usaha'             => '',
        'pemohon_alamat'            => '',
        'pemohon_telp'              => '',
        'pengajuan_jenis'           => '',
        'reklame_juml_val'          => '',
        'reklame_juml_unit'         => '',
        'reklame_range_tgl_text'    => '',
        'reklame_range_tgl_mulai'   => '',
        'reklame_range_tgl_selesai' => '',
        'reklame_data'              => '',
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

        $fields[] = array(
            'name'  => 'pemohon_usaha',
            'label' => 'Nama Perusahaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_usaha : '') );

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
            'name'  => 'reklame_juml',
            'label' => 'Jumlah',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'val',
                    'label' => 'Jumlah',
                    'type'  => 'number',
                    'std'   => ( $data_obj ? $data_obj->reklame_juml_val : ''),
                    'validation'=> 'required|numerik' ),
                array(
                    'name'  => 'unit',
                    'label' => 'Unit',
                    'type'  => 'dropdown',
                    'option'=> array('Unit', 'Buah'),
                    'std'   => ( $data_obj ? $data_obj->reklame_juml_unit : ''),
                    'validation'=> 'required|numerik' ),
            )
        );

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
            'name'  => 'reklame_data',
            'label' => 'Data Reklame',
            'type'  => 'custom',
            'std'   => $this->custom_field( $data_obj ),
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
        $data_mode = $data and !empty($data->reklame_data);

        $head[] = array(
            'data'  => 'Jenis',
            'width' => '15%' );

        $head[] = array(
            'data'  => 'Tema',
            'width' => '20%' );

        $head[] = array(
            'data'  => 'Lokasi',
            'width' => '20%' );

        $head[] = array(
            'data'  => 'Panjang',
            'width' => '7%' );

        $head[] = array(
            'data'  => 'Lebar',
            'width' => '7%' );

        $head[] = array(
            'data'  => '2x',
            'width' => '6%' );



        $head[] = array(
            'data'  => form_button( array(
                'name'     => 'reklame_data_add-btn',
                'type'     => 'button',
                'class'    => 'btn btn-primary bs-tooltip btn-block btn-sm',
                'tabindex' => '-1',
                'title'    => 'Tambahkan baris',
                'content'  => 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->_ci->table->set_heading( $head );

        if (isset($data->reklame_data) and !empty($data->reklame_data))
        {
            foreach (unserialize($data->reklame_data) as $row)
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
            'jenis'   => 'Jenis',
            'tema'    => 'Tema',
            'tempat'  => 'Lokasi',
            'panjang' => 'Panjang (M)',
            'lebar'   => 'Lebar (M)',
        );

        $column = array();

        foreach ($cols as $name => $label)
        {
            $column[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_reklame_data_'.$name.'[]',
                    'value' => $data ? $data[$name] : '',
                    'class' => 'form-control bs-tooltip input-sm',
                    'placeholder'=> $label ), '', ''),
                'class' => 'data-id'
            );
        }

        $column[] = array(
            'data'  => form_checkbox( array(
                'name'  => $this->alias.'_reklame_data_2x[]',
                'checked' => (isset($data['2x']) && $data['2x'] == 1),
                'value' => 1,
                'class' => 'form-control bs-tooltip input-sm',
                'placeholder'=> $label ), '', ''),
            'class' => 'data-id'
        );

        $column[] = array(
            'data'  => form_button( array(
                'name'  => $this->alias.'_reklame_data_remove-btn',
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
        $pengesahan_fn = $this->alias.'_reklame_data';

        if (isset($_POST[$pengesahan_fn.'_tempat']))
        {
            $i = 0;

            foreach ($_POST[$pengesahan_fn.'_tempat'] as $no)
            {
                foreach (array('jenis', 'tema', 'tempat', 'panjang', 'lebar') as $name)
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
