<?php defined('BASEPATH') or ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Izin Driver
 * @category    Drivers
 */

// -----------------------------------------------------------------------------

class Izin extends CI_Driver_Library
{
    /**
     * Base CI instance wrapper
     *
     * @var  string
     */
    public $_ci = '';

    /**
     * Valid drivers that will be loaded
     *
     * @var  array
     */
    public $valid_drivers = array();

    /**
     * All drivers that available to be load
     *
     * @var  array
     */
    protected $available_drivers = array(
        'b3',
        'ho',
        'imb',
        'iplc',
        'iui',
        'iup',
        'lokasi',
        // 'obat',
        // 'prinsip',
        'reklame',
        'siup',
        'tdp',
        'wisata',
        );

    /**
     * All drivers wrapper
     *
     * @var  array
     */
    protected
        $_data,
        $_table_templ = array( 'table_open' => '<table class="table table-exp table-striped table-hover table-condensed">' ),
        $_current = '',
        $drivers = array(),
        $_fields = array(),
        $_properties = array(
            'jenis_usaha' => array(
                'Perseroan Terbatas (PT)', 'Perseroan Komanditer (CV)', 'Badan Usaha Milik Negara (BUMN)', 'Perorangan (PO)', 'Koperasi'
                ),
            'skala_usaha' => array(
                'PMK' => 'Mikro',
                'PK'  => 'Kecil',
                'PM'  => 'Menengah',
                'PB'  => 'Besar',
                ),
            'kelembagaan' => array(
                'Pengecer', 'Penyalur', 'Pengumpul', 'Produsen', 'Sub Distributor', 'Distributor', 'Lainnya'
                ),
            'pendaftaran' => array(
                'baru'  => 'Pendaftaran Baru',
                'ubah'  => 'Balik Nama/Perubahan',
                'ulang' => 'Daftar Ulang/Perpanjangan'
                ),
            'guna_bangunan' => array(
                'Rumah Tinggal', 'Kios', 'Toko', 'Gudang', 'Pabrik', 'Kantor', 'Lainnya'
                ),
            );

    private $custom_field_ids = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        $this->_ci =& get_instance();

        $this->_ci->load->model('bpmppt_model');
        $this->_ci->load->helpers(array('bpmppt', 'text'));
        $this->_ci->lang->load('bpmppt');

        $self = get_class($this);
        foreach ($this->available_drivers as $driver)
        {
            if (is_user_can('manage_data_'.$driver))
            {
                $this->valid_drivers[] = $self.'_'.$driver;
                $code = (property_exists($this->$driver, 'code')) ? $this->$driver->code : FALSE;
                $this->drivers[$driver] = array(
                    'name'  => $this->$driver->name,
                    'alias' => $this->$driver->alias,
                    'label' => $this->$driver->name.($code ? ' ('.$code.')' : ''),
                    'code'  => $code,
                    );
            }
        }
        $drivers = implode(', ', $this->valid_drivers);
        $drivers = rtrim($drivers, ', ');

        log_message('debug', '#Izin: Drivers Library initialized with '.count($this->valid_drivers).' available drivers, including: '.$drivers.'.');
    }

    // -------------------------------------------------------------------------

    /**
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * @param   string  $method  Method name
     * @param   mixed   $args    Method Arguments
     *
     * @return  mixed
     */
    public function __call($method, $args)
    {
        if (!method_exists($this->_ci->bpmppt_model, $method))
        {
            show_error('Undefined method Izin::'.$method.'() called', 500, 'An Error Eas Encountered');
        }

        return call_user_func_array(array($this->_ci->bpmppt_model, $method), $args);
    }

    // -------------------------------------------------------------------------

    /**
     * Get all modules properties
     *
     * @param   bool    $obj  return option
     *                        set it TRUE if you want return it as Object
     *                        set it FALSE or leave it empty to return it as is
     * @return  mixed
     */
    public function get_drivers($obj = FALSE)
    {
        if ($obj)
        {
            return array_to_object($this->drivers);
        }

        return (array) $this->drivers;
    }

    // -------------------------------------------------------------------------

    /**
     * Get all modules in associative array
     *
     * @param   string  $key  Module prop that you want to use as return key
     * @param   string  $val  Module prop that you want to use as return val
     * @return  array
     */
    public function get_drivers_assoc($key = '', $val = '')
    {
        $ret = array();
        $key or $key = 'alias';
        $val or $val = 'name';

        foreach ($this->drivers as $driver)
        {
            $ret[$driver[$key]] = $driver[$val];
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    /**
     * Get single module name
     *
     * @param   string  $name  Module name
     * @return  array
     */
    public function get_driver($name)
    {
        return $this->drivers[$name];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module name
     *
     * @param   string  $name
     * @return  string
     */
    public function get_name($name)
    {
        return $this->drivers[$name]['name'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module alias
     *
     * @param   string  $name
     * @return  string
     */
    public function get_alias($name)
    {
        return $this->drivers[$name]['alias'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module code
     *
     * @param   string  $name
     * @return  string
     */
    public function get_code($name)
    {
        return $this->drivers[$name]['code'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module label
     *
     * @param   string  $name
     * @return  string
     */
    public function get_label($name)
    {
        return $this->drivers[$name]['label'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Field Properties
     *
     * @param   string  $name
     * @return  string
     */
    public function get_field_prop($name)
    {
        if (isset($this->_properties[$name]))
        {
            return $this->_properties[$name];
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Get form fields
     *
     * @param   string  $driver  Driver name
     * @param   object  $driver  Data Object
     * @return  array|false
     */
    public function get_form_fields($driver, $data_obj = FALSE, $data_id = FALSE)
    {
        $this->_current = $driver;
        $this->_data =& $data_obj;
        $_fields['surat'] = array(
            'label'      => isset($this->$driver->_prefield_label) ? $this->$driver->_prefield_label : 'No. &amp; Tgl. Permohonan',
            'type'       => 'subfield',
            'validation' => 'required',
            'fields'     => array(
                'nomor' => array(
                    'label' => 'Nomor',
                    'type'  => 'text',
                    ),
                'tanggal' => array(
                    'label' => 'Tanggal',
                    'type'  => 'datepicker',
                    ),
                )
            );

        $_defaults = isset($this->$driver->_defaults) ? $this->$driver->_defaults : array();
        $_fields = array_merge($_fields, $this->$driver->_form());

        foreach ($_fields as $name => $field)
        {
            if (!in_array($field['type'], array('custom', 'subfield')))
            {
                $default = isset($_defaults[$name]) ? $_defaults[$name] : '';
                $field['std'] = $this->_data && isset($this->_data->$name) ? $this->_data->$name : $default;

                if ($field['type'] == 'checkbox')
                {
                    $field['std'] = unserialize($field['std']);
                }
            }

            if ($field['type'] == 'subfield')
            {
                foreach ($field['fields'] as $sub_name => $sub_field)
                {
                    $sub_std = $name.'_'.$sub_name;
                    $default = isset($_defaults[$sub_std]) ? $_defaults[$sub_std] : '';
                    $sub_field['std'] = $this->_data && isset($this->_data->$sub_std) ? $this->_data->$sub_std : $default;

                    $field['fields'][$sub_name] = $sub_field;
                }
            }

            $_fields[$name] = $field;
        }

        if (
            !isset($this->$driver->_tembusan) or
            (isset($this->$driver->_tembusan) and $this->$driver->_tembusan !== FALSE)
        ) {
            $_fields['fieldset_tembusan'] = array(
                'label' => 'Tembusan Dokumen',
                'type'  => 'fieldset'
                );

            $_tembusan = $this->$driver->_tembusan;
            $this->$driver->_tembusan = array( 'kepada' => $_tembusan );

            $_fields['data_tembusan'] = array(
                'label' => 'Daftar Tembusan',
                'type'  => 'custom',
                'std'   => $this->_custom_exp_field(
                    'data_tembusan',
                    array('kepada' => 'Tembusan Kepada'),
                    $this->$driver->_tembusan
                    ),
                );
        }

        return $_fields;
    }

    // -------------------------------------------------------------------------

    public function get_form($driver, $data_obj = FALSE, $data_id = FALSE)
    {
        $this->_ci->load->library('biform');

        $data_obj = $data_id ? $this->get_fulldata_by_id($data_id) : FALSE;
        $form = $this->_ci->biform->initialize(array(
            'name'   => $this->get_alias($driver),
            'action' => current_url(),
            'fields' => $this->get_form_fields($driver, $data_obj, $data_id),
            ));

        if ($form_data = $form->validate_submition())
        {
            if ($new_id = $this->simpan($form_data, $data_id))
            {
                $new_id = $data_id == FALSE ? '/'.$new_id : '' ;
            }

            foreach (get_message() as $type => $item)
            {
                $this->_ci->session->set_flashdata($type, $item);
            }

            redirect(current_url().$new_id);
        }

        return $form->generate();
    }

    // -------------------------------------------------------------------------

    public function do_report($driver, $form_data)
    {
        $data = $this->skpd_properties();

        $wheres['type'] = $this->get_alias($driver);

        if ($form_data['data_date_month'])
        {
            $wheres['month'] = $form_data['data_date_month'];
        }

        if ($form_data['data_date_year'])
        {
            $wheres['year'] = $form_data['data_date_year'];
        }

        if ($form_data['data_status'] != 'all')
        {
            $wheres['status'] = $form_data['data_status'];
        }

        $data['type'] = $driver;
        $data['date'] = '25-'.$form_data['data_date_month'].'-'.$form_data['data_date_year'];
        $data['submited'] = $form_data;
        $data['layanan'] = $this->get_label($driver);
        $data['results'] = $this->get_report($wheres);

        return $data;
    }

    // -------------------------------------------------------------------------

    /**
     * Get Print properties from child driver (if available)
     *
     * @param   string  $driver  Driver name
     * @return  array|false
     */
    public function get_print($driver, $data_id)
    {
        $data = array_merge(
            (array) $this->skpd_properties(),
            (array) $this->get_fulldata_by_id($data_id)
            );

        if (isset($this->$driver->_defaults))
        {
            foreach ($this->$driver->_defaults as $key => $value)
            {
                if(!isset($data[$key]))
                {
                    $data[$key] = $value;
                }

                foreach ($this->custom_field_ids as $custom_field)
                {
                    if (isset($data[$custom_field]))
                    {
                        $data[$custom_field] = unserialize($data[$custom_field]);
                    }
                }

                if ($driver == 'iplc' and $key == 'debits')
                {
                    $_data = unserialize($data[$key]);
                    unset($data[$key]);

                    foreach ($this->$driver->_custom_fields as $name => $label) {
                        if (isset($_data[$name.'_head'])) {
                            $data[$key]['head'][$name] = $_data[$name.'_head'];
                        }
                    }

                    $data[$key]['body'] = $_data['body'];
                }

                if ($driver == 'reklame' and $key == 'reklame_data') {
                    $data[$key] = unserialize($data[$key]);
                }
            }
        }

        return $data;
    }

    // -------------------------------------------------------------------------

    public function simpan($form_data, $data_id = FALSE)
    {
        $driver = $this->_current;
        $driver_alias = $this->$driver->alias;
        unset($form_data[$driver_alias]);

        $data['no_agenda']  = $form_data['surat_nomor'];
        $data['created_on'] = string_to_datetime();
        $data['created_by'] = $this->_ci->biauth->get_user_id();
        $data['type']       = $driver_alias;
        $data['label']      = '-';
        $data['petitioner'] = $form_data['pemohon_nama'];
        $data['status']     = 'pending';

        if (method_exists($this->$driver, '_pre_post'))
        {
            $form_data = $this->$driver->_pre_post($form_data);
        }

        if ($result = $this->save_data($driver_alias, $data, $form_data, $data_id))
        {
            $this->_ci->session->set_flashdata('success', array(
                'Permohonan dari saudara/i '.$data['petitioner'].' berhasil disimpan.',
                'Klik cetak jika anda ingin langsung mencetaknya.'
                ));

            return $result;
        }
        else
        {
            $this->_ci->session->set_flashdata('error', 'Terjadi kegagalan penginputan data.');

            return FALSE;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Get template editor
     *
     * @param   string  $product_type  (products|reports)
     * @param   string  $data_type     Data type
     * @param   array   $paterns       Search & Replacement patterns
     * @return  mixed                  Return string by default or bool on form submit
     */
    public function get_template_editor($product_type, $data_type, $paterns)
    {
        // Get data label
        $data_label = $this->get_label($data_type);

        // Getting started
        $file_path    = APPPATH.'views/prints/'.$product_type.'/'.$data_type.'.php';
        $file_content = read_file($file_path);

        // Setup field
        $fields[] = array(
            'name'  => 'tmpl-editor',
            'type'  => 'editor',
            'height'=> 300,
            'label' => 'Template Editor',
            'std'   => $file_content,
            'filters' => $paterns,
            'desc'  => 'Ubah dan sesuaikan template Print out dokumen '.$data_label.' sesuai dengan keinginan anda.<br>'
                    .  '<b>CATATAN: jangan mengubah isi dari text yang diapit oleh kurung kurawal "{...}" karna itu merupakan variabel data untuk output dokumen ini.</b><br>'
                    .  'Jika anda hendak memindahkan posisi, cut dan paste keseluruhan text termasuk kurung kurawalnya <i>misal: {text}</i> ke posisi baru yang anda inginkan.',
            );

        $this->_ci->load->library('biform');

        $form = $this->_ci->biform->initialize(array(
            'name'   => 'template-'.$this->get_alias($data_type),
            'action' => current_url(),
            'fields' => $fields,
            ));

        // on Submition
        if ($form_data = $form->validate_submition())
        {
            // Save it to the file
            if (write_file($file_path.'', html_entity_decode($form_data['tmpl-editor'])))
            {
                $this->_ci->session->set_flashdata('success', 'Template '.$data_label.' berhasil diperbarui');
            }
            else
            {
                $this->_ci->session->set_flashdata('error', 'Template '.$data_label.' gagal diperbarui');
            }

            redirect(current_url());
        }

        return $form->generate();
    }

    // -------------------------------------------------------------------------

    public function _custom_exp_field($field_id, array $columns, $defaults = '')
    {
        if (!$this->_ci->load->is_loaded('table'))
        {
            $this->_ci->load->library('table');
        }

        $this->custom_field_ids[] = $field_id;
        $width = ceil(90 / count($columns));
        $head = array();

        foreach ($columns as $name => $column)
        {
            if (!is_array($column))
            {
                $column = array(
                    'data' => $column,
                    'width' => $width,
                    );
            }

            $column = array_set_defaults($column, array(
                'data' => '',
                'width' => null,
                ));

            $head[] = array(
                'data'  => $column['data'],
                'class' => 'head-'.$name,
                'width' => $column['width'].'%'
                );
        }

        $head[] = array(
            'data' => form_button(array(
                'name' => $field_id.'_add-btn',
                'class' => 'btn btn-primary btn-block btn-sm',
                'tabindex' => -1,
                'content' => 'Add',
                )
            ),
            'class' => 'head-action',
            'width' => '10%',
            );

        $values = isset($this->_data->$field_id) ? unserialize($this->_data->$field_id) : $defaults;
        if (empty($values) and ($post_values = $this->_ci->input->post($field_id)))
        {
            $value = $post_values;
        }

        $this->_ci->table->set_template($this->_table_templ);
        $this->_ci->table->set_heading($head);

        if (!empty($values))
        {
            $_val = $values;
            $_val = array_shift($_val);

            for ($u = 0; $u < count($_val); $u++)
            {
                $this->_custom_exp_row($field_id, $columns, $u, $values);
            }
        }
        else
        {
            $this->_custom_exp_row($field_id, $columns);
        }

        return $this->_ci->table->generate();
    }

    // -------------------------------------------------------------------------

    protected function _custom_exp_row($field_id, array $columns, $i = null, $values = '')
    {
        $rows = array();

        foreach ($columns as $name => $column)
        {
            if (!is_array($column))
            {
                $column = array(
                    'data' => $column
                    );
            }

            $extras = '';
            $column = array_set_defaults($column, array(
                'data' => '',
                'type' => 'text',
                'class' => '',
                ));

            if ($column['type'] == 'date')
            {
                $column['type'] = 'text';
                $column['class'] = ' form-datepicker';
                $extras = 'data-lang="id" data-mode="bootstrap" data-format="dd-mm-yyyy"';
            }

            $input_cell = array(
                'name'  => $field_id.'['.$name.'][]',
                'type'  => $column['type'],
                'class' => 'form-control input-sm'.($column['class'] ? ' '.$column['class'] : ''),
                );

            $value = isset($values[$name]) && isset($values[$name][$i]) ? $values[$name][$i] : null;

            if ($column['type'] == 'text')
            {
                $input_cell['value'] = $value ?: '';
                $input_cell['placeholder'] = $column['data'];
            }
            elseif ($column['type'] == 'checkbox')
            {
                $input_cell['value'] = 1;
                if ($value === 1)
                {
                    $input_cell['checked'] = 'checked';
                }
            }

            $rows[] = array(
                'data' => form_input($input_cell, '', $extras),
                );
        }

        $rows[] = array(
            'data'  => form_button(array(
                'name'     => $field_id.'_remove-btn',
                'class'    => 'btn btn-danger btn-block btn-sm remove-btn',
                'tabindex' => -1,
                'content'  => '&times;',
                )),
            );

        $this->_ci->table->add_row($rows);
    }
}

/* End of file Izin.php */
/* Location: ./application/libraries/Izin/Izin.php */
