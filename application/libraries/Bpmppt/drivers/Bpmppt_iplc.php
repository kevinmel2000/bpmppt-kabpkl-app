<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://feryardiant.github.com/bpmppt)
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
    public $_custom_fields = array(
        'param'        => 'Parameter',
        'proses_kadar' => 'Kadar max proses (Mg/l)',
        'proses_beban' => 'Beban pencemaran proses (Mg/l)',
        'kond_kadar'   => 'Kadar max kondensor (Mg/l)',
        'kond_beban'   => 'Beban pencemaran kondensor (Mg/l)',
        );

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'masa_berlaku_text'      => '',
        'masa_berlaku_mulai'     => '',
        'masa_berlaku_selesai'   => '',
        'pemohon_nama'           => '',
        'pemohon_jabatan'        => '',
        'pemohon_usaha'          => '',
        'pemohon_alamat'         => '',
        'pemohon_lokasi'         => '',
        'data_teknis'            => '',
        'limbah_target_buang'    => '',
        'debits'                 => array(),
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
            'name'  => 'masa_berlaku',
            'label' => 'Masa Berlaku',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'text',
                    'label' => 'Terbilang',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->masa_berlaku_text : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'mulai',
                    'label' => 'Mulai',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->masa_berlaku_mulai : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'selesai',
                    'label' => 'Selesai',
                    'type'  => 'datepicker',
                    'std'   => ( $data_obj ? $data_obj->masa_berlaku_selesai : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ),
                    'callback'=> 'string_to_date' ),
                ));

        $fields[] = array(
            'name'  => 'fieldset_data_pemohon',
            'label' => 'Data Pemohon',
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
            'name'  => 'pemohon_lokasi',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_lokasi : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'data_teknis',
            'label' => 'Data Teknis',
            'type'  => 'editor',
            'std'   => ( $data_obj ? $data_obj->data_teknis : Bootigniter::get_setting('iplc_teknis') ),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'debits',
            'label' => 'Data Debit Limbah',
            'type'  => 'custom',
            'std'   => $this->custom_field($data_obj)
            );

        return $fields;
    }

    // -------------------------------------------------------------------------

    private function custom_field($data = FALSE)
    {
        if (!$this->_ci->load->is_loaded('table'))
        {
            $this->_ci->load->library('table');
        }

        $this->_ci->table->set_template( $this->table_templ );
        $width = ceil(90 / count($this->_custom_fields));
        $debits = isset($data->debits) ? unserialize( $data->debits ) : array();

        foreach ($this->_custom_fields as $name => $label)
        {
            $head[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_debits['.$name.'_head]',
                    'type'  => 'text',
                    'value' => $data && !empty($debits) ? $debits[$name.'_head'] : '',
                    'class' => 'form-control bs-tooltip input-sm',
                    'placeholder'=> $label ) ),
                'class' => 'head-'.$name,
                'width' => $width.'%'
                );
        }

        $head[] = array(
            'data'  => form_button( array(
                'name'  => 'debits_add-btn',
                'type'  => 'button',
                'class' => 'btn btn-primary bs-tooltip btn-block btn-sm',
                'tabindex' => '-1',
                'title' => 'Tambahkan baris',
                'content'=> 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->_ci->table->set_heading( $head );

        if ( isset( $debits['body'] ) and !empty( $debits['body'] ) )
        {
            foreach ( $debits['body'] as $row )
            {
                $this->_custom_row($row);
            }
        }
        else
        {
            $this->_custom_row();
        }

        return $this->_ci->table->generate();
    }

    // -------------------------------------------------------------------------

    private function _custom_row($data = FALSE)
    {
        foreach ( $this->_custom_fields as $name => $label )
        {
            $column[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_debits['.$name.'][]',
                    'type'  => 'text',
                    'value' => $data && isset($data[$name]) ? $data[$name] : '',
                    'class' => 'form-control bs-tooltip input-sm',
                    'placeholder'=> $label ) ),
                'class' => 'data-id',
                );
        }

        $column[] = array(
            'data'  => form_button( array(
                'name'  => $this->alias.'_debits'.'_remove-btn',
                'type'  => 'button',
                'class' => 'btn btn-danger bs-tooltip btn-block btn-sm remove-btn',
                'tabindex' => '-1',
                'content'=> '&times;' ) ),
            'class' => '',
            'width' => '10%'
            );

        $this->_ci->table->add_row( $column );
    }

    // -------------------------------------------------------------------------

    /**
     * Prepost form data hooks
     *
     * @return  mixed
     */
    public function _pre_post($form_data)
    {
        foreach (array_keys($this->_custom_fields) as $field)
        {
            $slug = $this->alias.'_debits';

            if (isset($form_data[$slug][$field]))
            {
                foreach ($form_data[$slug][$field] as $i => $val)
                {
                    $form_data[$slug]['body'][$i][$field] = $val ?: '';
                    unset($form_data[$slug][$field]);
                }
            }
            elseif ($form_data[$slug][$field.'_head'])
            {
                $form_data[$slug]['head'][$field] = $form_data[$slug][$field.'_head'];
                unset($form_data[$slug][$field.'_head']);
            }
        }

        return $form_data;
    }
}

/* End of file Bpmppt_iplc.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_iplc.php */
