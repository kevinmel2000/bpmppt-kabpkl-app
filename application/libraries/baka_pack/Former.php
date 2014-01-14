<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter core library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Form Generator Library Class
 *
 * @subpackage  Libraries
 * @category    Forms
 */
class Former
{
    /**
     * Codeigniter superobject
     *
     * @var  mixed
     */
    protected $_ci;

    /**
     * Main form attributes
     *
     * @var  array
     */
    protected $_attrs = array(
        'action'    => '',
        'name'      => '',
        'class'     => '',
        'method'    => 'post',
        );

    /**
     * Field types which need Form Multipart handler
     *
     * @var  array
     */
    protected $_file_fields = array( 'file', 'upload' );

    /**
     * Is it a Horizontal Form?
     *
     * @var  bool
     */
    protected $is_hform = FALSE;

    /**
     * Is it a Multipart Form?
     *
     * @var  bool
     */
    protected $is_multipart = FALSE;

    /**
     * Is it doesn't need any buttons?
     *
     * @var  bool
     */
    protected $no_buttons = FALSE;

    /**
     * Is it has any fieldsets?
     *
     * @var  bool
     */
    private $has_fieldset = FALSE;

    /**
     * Form fields placeholder
     *
     * @var  array
     */
    protected $_fields = array();

    /**
     * Form buttons placeholder
     *
     * @var  array
     */
    protected $_buttons = array();

    /**
     * Defualt field attributes,
     * in case you forget to give it an value, you'll get an empty string from
     * this
     *
     * @var  array
     */
    protected $_default_attr = array(
        'value'      => '',
        'std'        => '',
        'desc'       => '',
        'attr'       => '',
        'validation' => ''
        );

    /**
     * Form errors placeholder
     *
     * @var  array
     */
    protected $_errors = array();

    /**
     * Field templates
     *
     * @var  array
     */
    protected $_template = array(
        'group_open'    => "<div class='%s' %s>",
        'group_close'   => "</div>",
        'group_class'   => "form-group",
        'label_open'    => "<label class='%s' %s>",
        'label_close'   => "</label>",
        'label_class'   => "control-label",
        'field_open'    => "<div class='%s' %s>",
        'field_close'   => "</div>",
        'field_class'   => "form-control input-sm",
        'buttons_class' => "btn btn-sm",
        'required_attr' => " <abbr title='Field ini harus diisi'>*</abbr>",
        'desc_open'     => "<span class='help-block'>",
        'desc_close'    => "</span>",
        );

    /**
     * Default class constructor
     */
    public function __construct( array $attrs = array() )
    {
        // Load CI super object
        $this->_ci =& get_instance();

        // Load dependencies
        $this->_ci->load->library('form_validation');

        // Give some default values
        $this->_attrs['action'] = current_url(); 
        $this->_attrs['name']   = str_replace('/', '-', uri_string());

        if ( !empty( $attrs ) )
            $this->init( $attrs );

        log_message('debug', "#Baka_pack: Former Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Initializing new form
     *
     * @since   version 0.1.3
     * @param   array   $attrs  Form Attributes config
     *
     * @return  mixed
     */
    public function init( array $attrs = array() )
    {
        // Applying default form attributes
        foreach ( array('action', 'name', 'id', 'class', 'method', 'extras') as $attr_key )
        {
            if ( isset( $attrs[$attr_key] ) )
                $this->_attrs[$attr_key] = $attrs[$attr_key];
        }

        if ( !isset( $attrs['id'] ) )
            $this->_attrs['id'] = 'form-'.$this->_attrs['name'];

        // Is 'is_hform' already declarated? if not make it true
        $this->is_hform = isset( $attrs['is_hform'] ) ? $attrs['is_hform'] : TRUE;

        // make it horizontal form by default
        if ( $this->is_hform == TRUE )
            $this->_attrs['class'] .= ' form-horizontal';

        // set-up HTML5 role attribute
        $this->_attrs['role'] = 'form';

        // if fields is already declarated in the config, just make it happen ;)
        if ( isset( $attrs['fields'] ) and is_array( $attrs['fields'] ) and !empty( $attrs['fields'] ) )
            $this->set_fields( $attrs['fields'] );

        // if buttons is already declarated in the config, just make it happen ;)
        if ( isset( $attrs['buttons'] ) and is_array( $attrs['buttons'] ) and !empty( $attrs['buttons'] ) )
            $this->set_buttons( $attrs['buttons'] );

        // set this up and you'll lose your buttons :P
        if ( isset( $attrs['no_buttons'] ) )
            $this->no_buttons = $attrs['no_buttons'];

        // set this up and you'll lose your buttons :P
        if ( isset( $attrs['template'] ) )
            $this->set_template( $attrs['template'] );

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup default field template
     * If you want to replace the default value, just pass these key(s) with
     * your value, and you'll see your own field template
     *
     * @since   version 0.1.3
     * @param   array  $template  Template replacements
     *
     * @return  obj
     */
    public function set_template( array $template )
    {
        $valid_tmpl = array(
            'group_open',
            'group_close',
            'group_class',
            'label_open',
            'label_close',
            'label_class',
            'field_open',
            'field_close',
            'field_class',
            'buttons_class',
            'required_attr',
            'desc_open',
            'desc_close',
            );

        foreach ( $valid_tmpl as $option )
        {
            if ( isset( $template[$option] ) )
                $this->_template[$option] = $template[$option];
        }

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup form fields
     *
     * @since   version 0.1.3
     * @param   array  $fields  Form fields
     */
    public function set_fields( array $fields )
    {
        if ( empty( $fields ) )
        {
            $this->_errors[] = 'You can\'t give me an empty field.';
            return FALSE;
        }

        foreach ( $fields as $id => $field )
        {
            $this->set_field( $field );
        }

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup form field one by one.
     * Use it if you like one by one declarations
     *
     * @since   version 0.1.3
     * @param   array  $field  Field attributes
     */
    public function set_field( array $field )
    {
        if ( isset( $field['type'] ) and in_array( $field['type'], $this->_file_fields ) )
        {
            $this->is_multipart = TRUE;
        }

        $this->_fields[] = $field;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup form buttons
     *
     * @since   version 0.1.3
     * @param   array  $buttons  Form buttons
     */
    public function set_buttons( array $buttons )
    {
        if ( count( $buttons ) === 0 )
        {
            $this->_errors[] = 'You can\'t give me an empty button.';
            return FALSE;
        }

        foreach ( $buttons as $button )
        {
            $this->set_button( $button );
        }

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup form button one by one.
     * Use it if you like one by one declarations
     *
     * @since   version 0.1.3
     * @param   array  $button  Button attributes
     */
    public function set_button( array $button )
    {
        $this->_buttons[] = $button;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Generate everything that we've set above
     * Let's see what we'll get
     *
     * @since   version 0.1.3
     * 
     * @return  string
     */
    public function generate()
    {
        // push Form action out from Attributes
        $_action = $this->_attrs['action'];
        unset( $this->_attrs['action'] );

        // is it an upload form?
        if ( $this->is_multipart == TRUE )
            $this->_attrs['enctype'] = 'multipart/form-data';

        if ( isset( $this->_attrs['extras'] ) )
        {
            $_extras = $this->_attrs['extras'];
            unset( $this->_attrs['extras'] );

            $this->_attrs = array_merge( $this->_attrs, $_extras );
        }

        // getting started
        $html = form_open( $_action, $this->_attrs );

        // var_dump( $this->_fields );

        // Loop the fields if not empty
        if ( count( $this->_fields ) > 0 )
        {
            foreach( $this->_fields as $field_attrs )
            {
                $html .= $this->_compile( $field_attrs );
            }
        }

        if( $this->has_fieldset === TRUE )
            $html .= form_fieldset_close();

        if ( $this->no_buttons === FALSE )
            $html .= $this->_form_actions();
    
        $html .= form_close();

        return $html;
    }

    // -------------------------------------------------------------------------

    /**
     * Compile all Fields that you've setup
     *
     * @since   version 0.1.3
     * @param   array   $field_attrs  Field Attributes
     * @param   bool    $is_sub       Is it an sub-fields?
     *
     * @return  string
     */
    protected function _compile( array $field_attrs, $is_sub = FALSE )
    {
        $html        = '';
        $counter     = 0;
        $input_class = $this->_template['field_class'];

        $field_attrs['id'] = 'field-'.str_replace( '_', '-', isset( $field_attrs['id'] )
            ? $field_attrs['id']
            : $field_attrs['name'] );

        if ( $is_sub and isset( $field_attrs['label'] ) )
            $field_attrs['attr'] = 'placeholder="'.$field_attrs['label'].'"';

        $attributes  = $this->_set_defaults( $field_attrs );
        extract( $attributes );

        if ( $type == 'hidden' )
        {
            // Form hidden
            // CI form_hidden() function
            $html .= form_hidden( $name, $value );
        }
        else if ( $type == 'fieldset' )
        {
            // Fieldset counter. If you have more that one fieldset in
            // you form, be sure to close it befor call the new one.
            $counter++;
            if ( $counter >= 2 )
                $html .= form_fieldset_close();

            // If your attributes is string, turn it into an array
            // @TODO: Please make a better attribute parser than this one
            if ( is_string( $attr ) )
                $attr = array( $attr => '' );

            // Call the fieldset and give it an ID with 'fieldset-' prefix
            $html .= form_fieldset( $label,
                array_merge( $attr, array( 'id'=>'fieldset-'.$id ) )
                );

            // indicate you have an opened fieldset 
            $this->has_fieldset = TRUE;
        }
        else if ( $type == 'subfield' )
        {
            $id = 'sub'.$id;
            $errors = array();
            $input = '<div id="'.$id.'" class="row">';
            
            if ( isset( $fields ) and !empty( $fields ) )
            {
                foreach ( $fields as $field )
                {
                    $input .= '<div class="col-md-'.$field['col'].'">';
                    $validation = '';

                    if ( isset( $field['validation'] ) AND $field['validation'] != '' )
                    {
                        if ( strpos( 'required', $field['validation'] ) !== FALSE )
                            $field['label'] .= ' *';

                        $validation = $field['validation'];
                    }

                    $field['name']  = $name.'_'.$field['name'];
                    $field['id']    = 'sub'.str_replace( '_', '-', 'input-'.$field['name'] );
                    $field['attr']  = isset( $field['attr'] ) ? $field['attr'] : $attr;
                    $field['std']   = isset( $field['std'] ) ? $field['std'] : '';

                    $input .= $this->_compile( $field, TRUE );
                    $input .= '</div>';

                    if ( $is_error = form_error( $field['name'], $this->_template['desc_open'], $this->_template['desc_close'] ) )
                    {
                        $errors[] = $is_error;
                    }
                }
            }

            $input .= '</div>';

            if ( count( $errors ) > 0 )
                $field_attrs['desc']['err'] = $errors;

            $html .= $this->_form_common( $field_attrs, $input );
        }
        else
        {
            switch( $type )
            {
                // Text Input fields
                // date, number, email, url, search, tel, password, text
                case 'date':
                case 'number':
                case 'email':
                case 'url':
                case 'search':
                case 'tel':
                case 'password':
                case 'text':
                    $input = form_input( array(
                            'name'  => $name,
                            'type'  => $type,
                            'id'    => $id,
                            'class' => $input_class ), set_value( $name, $std ), $attr);
                    break;

                // Date picker field
                case 'datepicker':
                    $path = 'asset/vendor/bootstrap-datepicker/';
                    add_script( 'bt-datepicker', $path.'js/bootstrap-datepicker.js', 'bootstrap', '1.1.1' );
                    add_script( 'bt-datepicker-id', $path.'js/locales/bootstrap-datepicker.id.js', 'bt-datepicker', '1.1.1' );
                    add_style( 'bt-datepicker', $path.'css/datepicker.css', 'bootstrap', '1.1.1' );
                    
                    $script = "$('.bs-datepicker').datepicker({\n"
                            . "format: 'dd-mm-yyyy',\n"
                            . "language: 'id',\n"
                            . "autoclose: true,\n"
                            . "todayBtn: true\n"
                            . "});\n";

                    add_script( 'dp-trigger', $script, 'bt-datepicker' );

                    $input = form_input( array(
                        'name'  => $name,
                        'type'  => 'text',
                        'id'    => $id,
                        'class' => $input_class.' bs-datepicker' ), set_value( $name, $std ), $attr );
                    break;

                // Textarea field
                // Using CI form_textarea() function.
                // adding jquery-autosize.js to make it more useful
                case 'textarea':
                    $path = 'asset/vendor/jquery-autosize/';
                    add_script( 'jquery-autosize', $path.'jquery.autosize.js', 'jquery', '1.18.0' );
                    add_script( 'autosize-trigger', "$('textarea').autosize();\n", 'jquery-autosize' );

                    $input = form_textarea( array(
                            'name'  => $name,
                            'rows'  => 3,
                            'cols'  => '',
                            'id'    => $id,
                            'class' => $input_class ), set_value( $name, $std ), $attr);
                    break;

                // Upload field
                // Using CI form_upload() function
                case 'file':
                case 'upload':
                    $input = form_upload( array(
                            'name'  => $name,
                            'id'    => $id,
                            'class' => $input_class ) );
                    break;

                // Ajax Upload using FineUploader.JS
                // @TODO: done it! :v
                case 'fineupload':
                    $input = form_button( array(
                                // 'name'  => 'reset',
                                'type'  => 'button',
                                'class' => 'btn btn-primary btn-sm',
                                'content'=> 'Pilih berkas' ))
                           . '<div id="'.$id.'" class="upload-placeholder">'
                           . '</div>';
                    break;

                // Selectbox field
                case 'multiselect':
                case 'dropdown':
                    $attr = 'class="'.$input_class.'" id="'.$id.'" '.$attr;

                    $form_func = 'form_'.$type;
                    $input = $form_func( $name, $option, set_value( $name, $std), $attr );
                    // $input = $form_func( $name, $option, set_select( $name, 'one', TRUE, $std), $attr );
                    break;

                // Selectbox field
                case 'select2':
                    $path = 'asset/vendor/select2/';
                    add_script( 'select2', $path.'select2.min.js', 'jquery', '3.4.5' );
                    add_script( 'select2-trigger', "$('.form-control-select2').select2();\n", 'select2' );
                    add_style( 'select2', $path.'select2.css', 'bootstrap', '3.4.5' );
                    $attr = 'class="form-control-select2 '.$input_class.'" id="'.$id.'" '.$attr;

                    $input = form_dropdown( $name, $option, $std, $attr );
                    break;

                // Radiocheckbox field
                case 'radio':
                case 'checkbox':
                    $count  = 1;
                    $input  = '';
                    $field  = ( $type == 'checkbox' ? $name.'[]' : $name );
                    $devide = ( count( $option ) > 8 ? TRUE : FALSE );

                    if ( !empty( $option ) )
                    {
                        $rc         = '';
                        $actived    = FALSE;

                        $set_func   = 'set_'.$type;
                        $form_func  = 'form_'.$type;

                        foreach( $option as $value => $opt )
                        {
                            if ( is_array( $std ) )
                            {
                                if ( ($_key = array_keys($std)) !== range(0, count($std) - 1) )
                                    $std = $_key;

                                $actived = ( in_array( $value, $std ) ? TRUE : FALSE );
                            }
                            else if ( is_string($std) )
                            {
                                $actived = ( $std == $value ? TRUE : FALSE );
                            }

                            $_id = str_replace('-', '-', $name.'-'.$value);

                            $check  = '<div class="'.$type.'">'
                                    . $form_func( $field, $value, $set_func( $name, $value, $actived ), 'id="'.$_id.'"' )
                                    . '<label for="'.$_id.'"> '.$opt.'</label>'
                                    . '</div>';

                            $rc .= ( $devide ? '<div class="col-md-6">'.$check.'</div>' : $check );

                            if ( $devide AND $count % 2 == 0)
                                $rc .= '</div><div class="row">';

                            $count++;
                        }

                        $input = $devide ? '<div class="row">'.$rc.'</div>' : $rc;
                    }
                    break;

                // Recaptcha field
                case 'recaptcha':
                    $this->_ci->load->helper('recaptcha');
                    $input = recaptcha_get_html( Setting::get('auth_recaptcha_public_key') );
                    break;

                // Captcha field
                case 'captcha':
                    $captcha_url = base_url( get_conf('cool_captcha_folder').'captcha'.EXT );
                    $image_id = 'captcha-'.$id.'-img';
                    $input_id = 'captcha-'.$id.'-input';

                    $input = img( array(
                        'src'   => $captcha_url,
                        'alt'   => 'Cool captcha image',
                        'id'    => $image_id,
                        'class' => 'img',
                        'width' => '200',
                        'height'=> '70',
                        'rel'   => 'cool-captcha' ));

                    $input .= anchor( current_url().'#', 'Ganti teks', array(
                        'class'   => 'small change-image',
                        'onclick' => '$(function() {'
                                    .'$(\'#'.$image_id.'\').attr(\'src\', \''.$captcha_url.'?\'+Math.random());'
                                    .'$(\'#'.$input_id.'\').focus();'
                                .'return false; });' ) );

                    $input .= form_input( array(
                        'name'  => $name,
                        'type'  => 'text',
                        'id'    => $input_id,
                        'class' => $input_class ), set_value( $name, '' ), $attr );
                    break;

                // Static field
                case 'static':
                    $input = '<p id="'.$id.'" class="'.str_replace('form-control', 'form-control-static', $input_class).'">'.$std.'</p>';
                    break;

                default:
                    log_message('error', '#Baka_form: '.$type.' Field type are not supported currently');
                    break;
            }

            if ( isset( $input ) )
            {
                $html .= $is_sub == FALSE ? $this->_form_common( $field_attrs, $input ) : $input;
            }
        }

        return $html;
    }

    // -------------------------------------------------------------------------

    /**
     * Form field which commonly used by all field types
     *
     * @since   version 0.1.3
     * @param   array   $attrs  Field Attributes
     * @param   string  $input  Field input html
     *
     * @return  string
     */
    protected function _form_common( $attrs, $input )
    {
        extract( $this->_template );

        $attrs = $this->_set_defaults( $attrs );
        $is_error = '';

        if ( !is_array( $attrs['desc'] ) )
        {
            $is_error = form_error( $attrs['name'], $desc_open, $desc_close );
        }
        else if ( is_array( $attrs['desc'] ) and isset( $attrs['desc']['err'] ) )
        {
            $is_error = $this->_form_desc( $attrs['desc'] );
        }
        
        if ( $attrs['validation'] != '' )
        {
            if ( FALSE !== strpos( $attrs['validation'], 'required' ) )
            {
                $attrs['label'] .= $required_attr;
                $group_class .= ' form-required';
            }

            if ( $is_error != '' )
                $group_class .= ' has-error';

            // var_dump( $is_error );
        }

        $label_col = $this->is_hform ? ' col-lg-3 col-md-3 ' : '';
        $input_col = $this->is_hform ? ' col-lg-9 col-md-9 ' : '';

        $group_attr = 'id="group-'.str_replace('_', '-', $attrs['name']).'"';
        $html = sprintf( $group_open, $group_class, $group_attr );

        if ( $attrs['label'] != '' OR $this->is_hform )
        {
            $label_class .= $label_col;
            $html .= form_label( $attrs['label'], $attrs['id'], array('class'=> $label_class) );
        }
    
        $html .= sprintf( $field_open, $input_col, '' )
              . $input
              . $is_error
              . $field_close.$group_close;

        return $html;
    }

    // -------------------------------------------------------------------------

    /**
     * Form action buttons
     *
     * @since   version 0.1.3
     * 
     * @return  string
     */
    protected function _form_actions()
    {
        // If you have no buttons i'll give you two as default ;)
        // 1. Submit button as Bootstrap btn-primary on the left side
        // 2. Reset button as Bootstrap btn-default on the right side
        if ( count( $this->_buttons ) == 0 )
        {
            $this->_buttons = array(
                array(
                    'name'  => 'submit',
                    'type'  => 'submit',
                    'label' => 'lang:submit_btn',
                    'class' => 'pull-left btn-primary' ),
                array(
                    'name'  => 'reset',
                    'type'  => 'reset',
                    'label' => 'lang:reset_btn',
                    'class' => 'pull-right btn-default' )
                );
        }

        // If you were use Bootstrap form-horizontal class in your form,
        // You'll need to specify Bootstrap grids class.
        $group_col = $this->is_hform ? 'col-lg-12 col-md-12 ' : '';
        $output = '<div class="form-group form-action"><div class="'.$group_col.'clearfix">';

        // Let's reset your button attributes.
        $button_attr = array();

        foreach ( $this->_buttons as $attr )
        {
            // Button name is inheritance with form ID.
            $button_attr['name']    = $this->_attrs['name'].'-'.$attr['name'];
            // If you not specify your Button ID, you'll get it from Button name with '-btn' as surfix.
            $button_attr['id']      = ( isset( $attr['id'] ) ? $attr['id'] : $button_attr['name'] ).'-btn';
            // I prefer to use Bootstrap btn-sm as default.
            $button_attr['class']   = $this->_template['buttons_class'].( isset( $attr['class'] ) ? ' '.$attr['class'] : '' );

            if ( substr( $attr['label'], 0, 5 ) == 'lang:' )
                $attr['label'] = _x( str_replace( 'lang:', '', $attr['label'] ) );

            switch ( $attr['type'] ) {
                case 'submit':
                case 'reset':
                    $func = 'form_'.$attr['type'];
                    $button_attr['value'] = $attr['label'];

                    $button_attr['data-loading-text'] = 'Loading...';
                    $button_attr['data-complete-text'] = 'Finished!';

                    $output .= $func( $button_attr );
                    break;

                case 'button':
                    $button_attr['content'] = $attr['label'];

                    $output .= form_button( $button_attr );
                    break;

                case 'anchor':
                    $attr['url'] = ( isset( $attr['url'] ) AND $attr['url'] != '' ) ? $attr['url'] : current_url();
                    $output .= anchor( $attr['url'], $attr['label'], $button_attr );
                    break;
            }
        }

        $output .= '</div></div>';

        return $output;
    }

    // -------------------------------------------------------------------------

    /**
     * Validate submission, it will setup validation rules of each field
     * using default CI Form Validation
     *
     * @since   version 0.1.3
     * 
     * @return  bool
     */
    public function validate_submition()
    {
        foreach ($this->_fields as $field)
        {
            if ( $field['type'] == 'subfield' )
            {
                foreach ( $field['fields'] as $sub )
                {
                    $this->set_field_rules(
                        $field['name'].'_'.$sub['name'],                            // Subfield Name
                        $sub['label'],                                              // Subfield Label
                        $sub['type'],
                        (isset($sub['validation'])  ? $sub['validation']: ''),      // Subfield Validation  (jika ada)
                        (isset($sub['callback'])    ? $sub['callback']  : '') );    // Subfield Callback    (jika ada)
                }
            }
            else if ( $field['type'] != 'static' AND $field['type'] != 'fieldset' )
            {
                $this->set_field_rules(
                    $field['name'],                                                 // Field Name
                    $field['label'],                                                // Field Label
                    $field['type'],
                    (isset($field['validation'])? $field['validation']  : ''),      // Field Validation (jika ada)
                    (isset($field['callback'])  ? $field['callback']    : '') );    // Field Callback   (jika ada)
            }
        }

        return $this->_ci->form_validation->run();
    }

    // -------------------------------------------------------------------------

    /**
     * Get errors output from validation
     * I don't thing it's nessesary, but I need it for some reason :P
     *
     * @since   version 0.1.3
     * 
     * @return  mixed
     */
    public function validation_errors()
    {
        return validation_errors();
    }

    // -------------------------------------------------------------------------

    /**
     * Setup field validation rules
     *
     * @since   0.1.0
     * 
     * @return  void
     */
    protected function set_field_rules( $name, $label, $type, $validation = '', $callback = '' )
    {
        $field_arr  = ( $type == 'checkbox' OR $type == 'multiselect' ? TRUE : FALSE );
        $rules      = ( $field_arr ? 'xss_clean' : 'trim|xss_clean' );

        if ( strlen( $validation ) > 0 )
            $rules .= '|'.$validation;

        $this->_ci->form_validation->set_rules( $name, $label, $rules);

        // log_message( 'error', '#Form set field "'.$name.'" rules "'.$rules.'"' );

        $method = $this->_attrs['method'];

        if ( strlen( $callback ) > 0 and is_callable( $callback ) )
            $this->form_data[$name] = call_user_func( $callback, $this->_ci->input->$method( $name ) );
        else
            $this->form_data[$name] = $this->_ci->input->$method( $name );
    }

    // -------------------------------------------------------------------------

    /**
     * Return the submited data
     *
     * @since   0.1.1
     * @return  object
     */
    public function submited_data()
    {
        $data = $this->form_data;

        $this->clear();

        return $data;
    }

    // -------------------------------------------------------------------------

    /**
     * Clean up form properties
     * It's useful if you have multiple form declarations.
     *
     * @since   0.1.3
     * @return  void
     */
    public function clear()
    {
        $this->_attrs = array(
            'action'  => '',
            'name'    => '',
            'class'   => '',
            'method'  => 'post' );

        $this->is_hform     = FALSE;
        $this->is_multipart = FALSE;
        $this->no_buttons   = FALSE;
        $this->has_fieldset = FALSE;
        $this->_fields      = array();
        $this->_buttons     = array();
        $this->_errors      = array();
    }

    // -------------------------------------------------------------------------

    /**
     * Field description
     *
     * @param   mixed  $desc  Description about what this field is
     *
     * @return  string
     */
    protected function _form_desc( $desc = NULL )
    {
        $ret = '';

        if ( is_null( $desc ) )
        {
            $ret = '';
        }
        else if ( is_string( $desc ) and strlen( $desc ) > 0 )
        {
            $ret = $this->_template['desc_open'].$desc.$this->_template['desc_close'];
        }
        else if ( is_array( $desc ) and !empty( $desc ) )
        {
            $descs = isset( $desc['err'] ) ? $desc['err'] : $desc;

            foreach ( $descs as $ket )
                $ret .= $ket;
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    /**
     * Set default keys in an array, it's useful to prevent un setup array keys
     * but you'd use that in next code.
     *
     * @param   array  $field       An array that will recieve default key
     * @param   array  $array_keys  Array of keys which be default key of $field
     *                              Array must be associative array, which have
     *                              key and value. Key used as default key and
     *                              Value used as default value for $field param
     *
     * @return  array
     */
    private function _set_defaults( array $field, $array_keys = array() )
    {
        if ( empty( $array_keys ) )
        {
            $array_keys = $this->_default_attr;
        }

        foreach ( $array_keys as $key => $val )
        {
            if ( !array_key_exists($key, $field) AND !isset( $field[$key] ) )
                $field[$key] = $val;
        }

        return $field;
    }
}

/* End of file Form.php */
/* Location: ./application/libraries/baka/Form.php */