<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BPMPPT Driver
 *
 * @subpackage  Drivers
 * @category    Application
 */
class Bpmppt extends CI_Driver_Library
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
    private $available_drivers = array(
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
     * All modules wrapper
     *
     * @var  array
     */
    private $modules = array();

    /**
     * Form fields
     *
     * @var  array
     */
    public $fields;

    /**
     * CI Table Template Configuration
     *
     * @var  array
     */
    public $table_templ = array(
        'table_open' => '<table class="table table-exp table-striped table-hover table-condensed">'
        );

    /**
     * Default class constructor
     */
    public function __construct()
    {
        $this->_ci =& get_instance();

        $this->_ci->load->model('bpmppt_model');

        $self = get_class( $this );

        foreach ( $this->available_drivers as $module )
        {
            if ( $this->_ci->authr->is_permited( 'doc_'.$module.'_manage' ) )
            {
                $this->valid_drivers[] = $self.'_'.$module;

                $child = $this->$module;
                $code  = ( property_exists( $this->$module, 'code' ) )
                    ? $child->code
                    : FALSE;

                $this->modules[$module] = array(
                    'name'  => $child->name,
                    'alias' => $child->alias,
                    'label' => $child->name.( $code ? ' ('.$code.')' : '' ),
                    'code'  => $code,
                    );
            }
        }

        // $this->fields[] = array();

        log_message('debug', '#BPMPPT: Drivers Library initialized.');
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
    public function __call( $method, $args )
    {
        if ( !method_exists( $this->_ci->bpmppt_model, $method ) )
        {
            show_error('Undefined method BPMPPT::'.$method.'() called', 500, 'An Error Eas Encountered');
        }

        return call_user_func_array( array( $this->_ci->bpmppt_model, $method ), $args );
    }

    // -------------------------------------------------------------------------

    /**
     * Get all modules properties
     *
     * @param   bool    $obj  return option
     *                        set it TRUE if you want return it as Object
     *                        set it FALSE or leave it empty to return it as is
     *
     * @return  mixed
     */
    public function get_modules( $obj = FALSE )
    {
        if ( $obj )
        {
            return array_to_object( $this->modules );
        }

        return (array) $this->modules;
    }

    // -------------------------------------------------------------------------

    /**
     * Get all modules in associative array
     *
     * @param   string  $key  Module prop that you want to use as return key
     * @param   string  $val  Module prop that you want to use as return val
     *
     * @return  array
     */
    public function get_modules_assoc( $key = '', $val = '' )
    {
        $ret = array();
        $key || $key = 'alias';
        $val || $val = 'name';

        foreach ( $this->modules as $module )
        {
            $ret[$module[$key]] = $module[$val];
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    /**
     * Get single module name
     *
     * @param   string  $name  Module name
     *
     * @return  array
     */
    public function get_module( $name )
    {
        return $this->modules[$name];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module name
     *
     * @param   string  $name
     *
     * @return  string
     */
    public function get_name( $name )
    {
        return $this->modules[$name]['name'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module alias
     *
     * @param   string  $name
     *
     * @return  string
     */
    public function get_alias( $name )
    {
        return $this->modules[$name]['alias'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module code
     *
     * @param   string  $name
     *
     * @return  string
     */
    public function get_code( $name )
    {
        return $this->modules[$name]['code'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get Module label
     *
     * @param   string  $name
     *
     * @return  string
     */
    public function get_label( $name )
    {
        return $this->modules[$name]['label'];
    }

    // -------------------------------------------------------------------------

    /**
     * Get form properties from child driver (if available)
     *
     * @param   string  $driver  Driver name
     * @param   object  $driver  Data Object
     *
     * @return  array|false
     */
    public function get_form( $driver, $data_obj = FALSE, $data_id = FALSE )
    {
        // $data_obj   = ( $data_id ? $this->get_fulldata_by_id( $data_id ) : FALSE );
        $modul_slug = $this->get_alias($driver);

        if ($data_obj)
        {
            foreach ($this->$driver->defaults as $key => $value)
            {
                if(!isset($data_obj->$key))
                {
                    $data_obj->$key = $value;
                }
            }
        }

        if ( $driver != 'imb' )
        {
            $data_label = 'Permohonan';

            if ($driver == 'tdp')
            {
                $data_label = 'Agenda';
            }

            if ($driver == 'siup')
            {
                $data_label = 'SIUP';
            }

            $this->fields[] = array(
                'name'  => $modul_slug.'_surat',
                'label' => 'No. &amp; Tgl. '.$data_label,
                'type'  => 'subfield',
                // 'attr'  => ( $data_obj ? 'disabled' : ''),
                'fields'=> array(
                    array(
                        'name'  => 'nomor',
                        'label' => 'Nomor',
                        'type'  => 'text',
                        'std'   => ( $data_obj ? $data_obj->surat_nomor : ''),
                        'validation'=> ( !$data_obj ? 'required' : '' ) ),
                    array(
                        'name'  => 'tanggal',
                        'label' => 'Tanggal',
                        'type'  => 'datepicker',
                        'std'   => ( $data_obj ? format_date( $data_obj->surat_tanggal ) : ''),
                        'validation'=> ( !$data_obj ? 'required' : '' ),
                        'callback'=> 'string_to_date' ),
                    )
                );
        }

        if ( !method_exists( $this->$driver, 'form') )
        {
            return FALSE;
        }

        $this->_ci->load->library('former');

        foreach ($this->$driver->form( $data_obj ) as $form_field)
        {
            // if ($data_obj)
            // {
            //     if (isset($form_field['attr']))
            //     {
            //         if (is_array($form_field['attr']))
            //         {
            //             $form_field['attr']['disabled'] = '';
            //         }
            //         else
            //         {
            //             $form_field['attr'] .= ' disabled';
            //         }
            //     }
            //     else
            //     {
            //         $form_field['attr'] = 'disabled';
            //     }
            // }

            $form_field['name'] = $modul_slug.'_'.$form_field['name'];

            $this->fields[] = $form_field;
        }

        $this->fields[] = array(
            'name'  => $modul_slug.'_fieldset_tembusan',
            'label' => 'Tembusan Dokumen',
            // 'attr'  => ( $data_obj ? array('disabled'=>'') : '' ),
            'type'  => 'fieldset' );

        $this->fields[] = $this->field_tembusan($data_obj, $modul_slug);

        // $no_buttons = $data_obj ? TRUE : FALSE ;

        $form = $this->_ci->former->init( array(
            'name'       => $modul_slug,
            'action'     => current_url(),
            'fields'     => $this->fields,
            // 'no_buttons' => $no_buttons,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $driver == 'imb' )
            {
                $form_data[$modul_slug.'_surat_nomor'] = 614;
            }

            if ( $driver == 'iup' )
            {
                $i = 0;
                $koor_fn = $modul_slug.'_tambang_koor';

                foreach ($_POST[$koor_fn.'_no'] as $no)
                {
                    foreach (array('no', 'gb-1', 'gb-2', 'gb-3', 'gl-1', 'gl-2', 'gl-3', 'lsu') as $name)
                    {
                        $koor_name = $koor_fn.'_'.$name;
                        $koordinat[$i][$name] = isset($_POST[$koor_name][$i]) ? $_POST[$koor_name][$i] : 0;
                        unset($_POST[$koor_name][$i]);
                    }

                    $i++;
                }

                $form_data[$modul_slug.'_tambang_koor'] = serialize($koordinat);
            }

            unset($form_data[$modul_slug]);

            if ( $new_id = $this->simpan( $modul_slug, $form_data, $data_id ) )
            {
                $new_id = $data_id == FALSE ? '/'.$new_id : '' ;
            }

            foreach ( get_message() as $type => $item )
            {
                $this->_ci->session->set_flashdata( $type, $item );
            }

            redirect( current_url().$new_id );
        }

        return $form->generate();
    }

    // -------------------------------------------------------------------------

    /**
     * Get Print properties from child driver (if available)
     *
     * @param   string  $driver  Driver name
     *
     * @return  array|false
     */
    public function get_print( $driver, $data_id )
    {
        $data = array_merge(
                    (array) $this->skpd_properties(),
                    (array) $this->get_fulldata_by_id($data_id)
                    );

        $this->$driver->defaults['data_tembusan'] = '';

        foreach ($this->$driver->defaults as $key => $value)
        {
            if(!isset($data[$key]))
            {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    // -------------------------------------------------------------------------

    public function simpan( $driver_alias, $form_data, $data_id = FALSE )
    {
        // $driver_alias = $this->get_alias( $driver );

        $data['no_agenda']  = $form_data[$driver_alias.'_surat_nomor'];
        $data['created_on'] = string_to_datetime();
        $data['created_by'] = $this->_ci->authr->get_user_id();
        $data['type']       = $driver_alias;
        $data['label']      = '-';
        $data['petitioner'] = $form_data[$driver_alias.'_pemohon_nama'];
        $data['status']     = 'pending';

        if ( $result = $this->save_data( $driver_alias, $data, $form_data, $data_id ) )
        {
            set_message('success', array(
                'Permohonan dari saudara/i '.$data['petitioner'].' berhasil disimpan.',
                'Klik cetak jika anda ingin langsung mencetaknya.'));

            return $result;
        }
        else
        {
            set_message('error', 'Terjadi kegagalan penginputan data.');

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
    public function get_template_editor( $product_type, $data_type, $paterns )
    {
        // Get data label
        $data_label = $this->get_label( $data_type );

        // Load file helper to read the template file
        $this->_ci->load->helper('file');

        // Getting started
        $file_path    = APPPATH.'views/prints/'.$product_type.'/'.$data_type.'.php';
        $file_content = read_file($file_path);
        $new_patterns = array();

        // Setup new patterns
        foreach ( $paterns as $search => $replacement )
        {
            $new_patterns[] = array(
                'search'      => $search,
                'replacement' => $replacement,
                );
        }

        // Remove the old one
        unset( $paterns );
        // Sorting low to hight
        ksort( $new_patterns );

        // Parsing file content by new patterns #lol
        foreach ( $new_patterns as $pattern )
        {
            $file_content = str_replace( $pattern['search'], $pattern['replacement'], $file_content );
        }

        // Setup field
        $fields[] = array(
            'name'  => 'tmpl-editor',
            'type'  => 'editor',
            'height'=> 300,
            'label' => 'Template Editor',
            'std'   => $file_content,
            'left-desc'=> TRUE,
            'desc'  => 'Ubah dan sesuaikan template Print out dokumen '.$data_label.' sesuai dengan keinginan anda.<br>'
                    .  '<b>CATATAN: jangan mengubah isi dari text yang diapit oleh kurung kurawal "{...}" karna itu merupakan variabel data untuk output dokumen ini.</b><br>'
                    .  'Jika anda hendak memindahkan posisi, cut dan paste keseluruhan text termasuk kurung kurawalnya <i>misal: {text}</i> ke posisi baru yang anda inginkan.',
            );

        $this->_ci->load->library('former');

        $form = $this->_ci->former->init(array(
            'name'      => 'template-'.$this->get_alias( $data_type ),
            'action'    => current_url(),
            'fields'    => $fields,
            ));

        // on Submition
        if ( $form_data = $form->validate_submition() )
        {
            // Reverse sort order
            krsort( $new_patterns );
            // re-parsing
            foreach ( $new_patterns as $pattern )
            {
                $file_content = str_replace( $pattern['search'], $pattern['replacement'], $file_content );
            }

            // Save it to the file
            if ( write_file( $file_path.'', html_entity_decode( $form_data['tmpl-editor'] ) ) )
            {
                $this->_ci->session->set_flashdata( 'success', 'Template '.$data_label.' berhasil diperbarui' );
                redirect( current_url() );
            }

            $this->_ci->session->set_flashdata( 'error', 'Template '.$data_label.' gagal diperbarui' );
            redirect( current_url() );
        }

        return $form->generate();
    }

    // -------------------------------------------------------------------------

    public function field_tembusan( $data = FALSE, $alias = '' )
    {
        if (!$this->_ci->load->is_loaded('table'))
        {
            $this->_ci->load->library('table');
        }

        $this->_ci->table->set_template($this->table_templ);

        $data_mode = ($data != FALSE and isset($data->data_tembusan));

        $head[] = array(
            'data'  => 'Tembusan Kepada',
            'class' => 'head-kepada',
            'width' => '90%' );

        $head[] = array(
            'data'  => form_button( array(
                'name'  => $alias.'_tembusan_add-btn',
                'type'  => 'button',
                'class' => 'btn btn-primary btn-block btn-sm',
                'value' => 'add',
                'title' => 'Tambahkan baris',
                'content'=> 'Add' ) ),
            'class' => 'head-action',
            'width' => '10%' );

        $this->_ci->table->set_heading( $head );
        $tembusan = isset($data->data_tembusan) ? unserialize($data->data_tembusan) : $this->_ci->input->post( $alias.'_data_tembusan' );
        $method = $this->_ci->former->_attrs['method'];

        if ( !empty( $tembusan ) )
        {
            foreach ( $tembusan as $row )
            {
                $this->_temrow( $row, $alias );
            }
        }
        else
        {
            $this->_temrow( '', $alias );
        }

        return array(
            'name'  => $alias.'_data_tembusan',
            'label' => 'Daftar Tembusan',
            'type'  => 'custom',
            'value' => $this->_ci->table->generate(),
            'validation'=> ( !$data ? '' : '' ) );
    }

    private function _temrow( $value = '', $alias = '' )
    {
        if ( $this->_ci->load->is_loaded('table') )
        {
            $column[] = array(
                'data'  => form_input( array(
                    'name'  => $alias.'_data_tembusan[]',
                    'type'  => 'text',
                    'class' => 'form-control input-sm',
                    'placeholder'=> 'Kepada...' ), $value),
                'class' => 'data-id',
                'width' => '90%' );

            $column[] = array(
                'data'  => form_button( array(
                    'name'  => $alias.'_tembusan_remove-btn',
                    'type'  => 'button',
                    'class' => 'btn btn-danger btn-block btn-sm remove-btn',
                    'value' => 'remove',
                    'title' => 'Hapus baris ini',
                    'content'=> '&times;' ) ),
                'class' => '',
                'width' => '10%' );

            $this->_ci->table->add_row( $column );
        }
    }
}

/* End of file Bpmppt.php */
/* Location: ./application/libraries/Bpmppt/Bpmppt.php */
