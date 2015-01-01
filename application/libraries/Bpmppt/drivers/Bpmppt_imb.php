<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Bpmppt_imb Driver
 * @category    Drivers
 */

/*
| ------------------------------------------------------------------------------
| Izin Mendirikan Bangunan
| ------------------------------------------------------------------------------
*/

/**
 * BPMPPT Izin Mendirikan Bangunan Driver
 *
 * @subpackage  Drivers
 */
class Bpmppt_imb extends CI_Driver
{
    /**
     * Document property
     *
     * @var  string  $code
     * @var  string  $alias
     * @var  string  $name
     */
    public $code = 'IMB';
    public $alias = 'izin_mendirikan_bangunan';
    public $name = 'Izin Mendirikan Bangunan';
    public $tembusan = FALSE;
    public $_custom = array(
        'bangunan_area' => array(
            'guna' => 'Guna Bangunan',
            'panjang' => 'Panjang (M)',
            'lebar' => 'Lebar (M)',
            ),
        'bangunan_koefisien' => array(
            'bwk' => 'BWK',
            'luas' => 'Luas',
            'tinggi' => 'Tinggi',
            'guna' => 'Guna',
            'letak' => 'Letak',
            'kons' => 'Konstruksi',
            ),
        );

    /**
     * Default field
     *
     * @var  array
     */
    public $defaults = array(
        'bangunan_maksud'           => '',
        'pemohon_nama'              => '',
        'pemohon_kerja'             => '',
        'pemohon_alamat'            => '',
        'bangunan_lokasi'           => '',
        'bangunan_area'             => '',
        'bangunan_koefisien'        => '',
        'bangunan_tanah_luas'       => '',
        'bangunan_tanah_keadaan'    => '',
        'bangunan_tanah_status'     => '',
        'bangunan_milik_no'         => '',
        'bangunan_milik_an'         => '',
        );

    // -------------------------------------------------------------------------

    /**
     * Default class constructor,
     * Just simply log this class when it loaded
     */
    public function __construct()
    {
        log_message('debug', "#BPMPPT_driver: Mendirikan_bangunan Class Initialized");
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
            'name'  => 'bangunan_maksud',
            'label' => 'Maksud Permohonan',
            'type'  => 'radio',
            'option'=> array(
                'baru'  => 'Mendirikan Bangunan Baru',
                'rehap' => 'Perbaikan/Rehab Bangunan Lama' ),
            'std'   => ( $data_obj ? $data_obj->bangunan_maksud : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

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
            'name'  => 'pemohon_kerja',
            'label' => 'Pekerjaan',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->pemohon_kerja : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'pemohon_alamat',
            'label' => 'Alamat',
            'type'  => 'textarea',
            'std'   => ( $data_obj ? $data_obj->pemohon_alamat : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'fieldset_data_bangunan',
            'label' => 'Data Bangunan',
            'type'  => 'fieldset' );

        $fields[] = array(
            'name'  => 'bangunan_tanah_keadaan',
            'label' => 'Keadaan Tanah',
            'type'  => 'radio',
            'option'=> array(
                'd1'    => 'D I',
                'd2'    => 'D II',
                'd3'    => 'D III' ),
            'std'   => ( $data_obj ? $data_obj->bangunan_tanah_keadaan : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'bangunan_tanah_status',
            'label' => 'Status Tanah',
            'type'  => 'radio',
            'option'=> array(
                'hm'    => 'Hak milik',
                'hg'    => 'Hak guna bangunan' ),
            'std'   => ( $data_obj ? $data_obj->bangunan_tanah_status : ''),
            'validation'=> ( !$data_obj ? 'required' : '' ) );

        $fields[] = array(
            'name'  => 'bangunan_milik',
            'label' => 'Kepemilikan',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name'  => 'no',
                    'label' => 'Nomor',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->bangunan_milik_no : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'name'  => 'an',
                    'label' => 'Nomor',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->bangunan_milik_an : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                ));

        $fields[] = array(
            'name'  => 'bangunan_lokasi',
            'label' => 'Lokasi Bangunan',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'col'  => 6,
                    'name'  => 'no',
                    'label' => 'Alamat',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->bangunan_lokasi_no : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'col'  => 3,
                    'name'  => 'an',
                    'label' => 'Desa/Kel.',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->bangunan_lokasi_an : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                array(
                    'col'  => 3,
                    'name'  => 'an',
                    'label' => 'Kec.',
                    'type'  => 'text',
                    'std'   => ( $data_obj ? $data_obj->bangunan_lokasi_an : ''),
                    'validation'=> ( !$data_obj ? 'required' : '' ) ),
                ));

        $fields[] = array(
            'name'  => 'bangunan_tanah_luas',
            'label' => 'Luas Tanah (M<sup>2</sup>)',
            'type'  => 'text',
            'std'   => ( $data_obj ? $data_obj->bangunan_tanah_luas : ''),
            'validation'=> ( !$data_obj ? 'required|numeric' : '' ) );

        if (!$this->_ci->load->is_loaded('table'))
        {
            $this->_ci->load->library('table');
        }

        $this->_ci->table->set_template( $this->table_templ );

        $fields[] = array(
            'name'  => 'bangunan_area',
            'label' => 'Data Bangunan',
            'type'  => 'custom',
            'std'   => $this->custom_field('bangunan_area', $data_obj) );

        $fields[] = array(
            'name'  => 'bangunan_koefisien',
            'label' => 'Data Koefisien',
            'type'  => 'custom',
            'std'   => $this->custom_field('bangunan_koefisien', $data_obj) );

        return $fields;
    }

    // -------------------------------------------------------------------------

    private function custom_field($alokasi, $data = FALSE)
    {
        $width = ceil(90 / count($this->_custom[$alokasi]));

        foreach ($this->_custom[$alokasi] as $name => $label)
        {
            $head[] = array(
                'data'  => $label,
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
                'content'=> 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->_ci->table->set_heading( $head );

        if (isset($data->$alokasi) && !empty($data->$alokasi))
        {
            foreach (unserialize($data->$alokasi) as $row)
            {
                $this->_custom_row($alokasi, $row);
            }
        }
        else
        {
            $this->_custom_row($alokasi);
        }

        return $this->_ci->table->generate();
    }

    // -------------------------------------------------------------------------

    private function _custom_row($alokasi, $data = FALSE)
    {
        foreach ( $this->_custom[$alokasi] as $name => $label )
        {
            $column[] = array(
                'data'  => form_input( array(
                    'name'  => $this->alias.'_'.$alokasi.'['.$name.'][]',
                    'type'  => 'text',
                    'value' => $data && isset($data[$name]) ? $data[$name] : '',
                    'class' => 'form-control bs-tooltip input-sm',
                    'placeholder'=> $label ) ),
                'class' => 'data-id',
                );
        }

        $column[] = array(
            'data'  => form_button( array(
                'name'  => $this->alias.'_'.$alokasi.'_remove-btn',
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

    public function _pre_post($form_data)
    {
        $luas = $koef = 0;
        foreach ($this->_custom as $custom => $subs)
        {
            $slug = $this->alias.'_'.$custom;
            foreach ($subs as $field => $label)
            {
                if (isset($form_data[$slug][$field]))
                {
                    foreach ($form_data[$slug][$field] as $i => $val)
                    {
                        $form_data[$slug][$i][$field] = $val ?: '';
                        unset($form_data[$slug][$field]);
                    }
                }
            }

            foreach ($form_data[$slug] as $e => $yield)
            {
                if ($custom == 'bangunan_area')
                {
                    $luas = (int) $yield['panjang'] * (int) $yield['lebar'];
                    $form_data[$slug][$e]['luas'] = $luas;
                }

                if ($custom == 'bangunan_koefisien')
                {
                    $koef = (int) $yield['bwk'] * (int) $yield['luas'] * (int) $yield['tinggi'] * (int) $yield['guna'] * (int) $yield['letak'] * (int) $yield['kons'];
                    $form_data[$slug][$e]['koef'] = $koef;
                }
            }
        }

        if ($luas > 0 && $koef > 0)
        {
            foreach ($form_data[$slug] as $a => $su)
            {
                $form_data[$this->alias.'_form'][$a]['sempendan']  = (.25/100) * 1000000 * $luas * $koef;
                $form_data[$this->alias.'_form'][$a]['pengawasan'] = (.02/100) * 1000000 * $luas * $koef;
                $form_data[$this->alias.'_form'][$a]['koreksi']    = (.01/100) * 1000000 * $luas * $koef;
            }
        }

        return $form_data;
    }
}

/* End of file Bpmppt_imb.php */
/* Location: ./application/libraries/Bpmppt/drivers/Bpmppt_imb.php */
