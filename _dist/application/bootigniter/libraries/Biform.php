<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Biform
 * @category    Libraries
 */

// -----------------------------------------------------------------------------

class Biform
{
    /**
     * Codeigniter superobject
     * @var  mixed
     */
    protected $_ci;

    /**
     * Main Form Field Attributes
     * @var  array
     */
    public $_attrs = array(
        'action' => '',
        'name'   => '',
        'class'  => '',
        'method' => 'post',
        );

    /**
     * Is it a Horizontal Form?
     * @var  bool
     */
    protected $is_hform = TRUE;

    /**
     * Is it a Multipart Form?
     * @var  bool
     */
    protected $is_multipart = FALSE;

    /**
     * Is it doesn't need any buttons?
     * @var  bool
     */
    protected $no_buttons = FALSE;

    /**
     * Is it has any fieldsets?
     * @var  bool
     */
    private $has_fieldset = FALSE;

    /**
     * Is it has any s?
     * @var  bool
     */
    private $has_jqueryui = FALSE;

    /**
     * Form fields placeholder
     * @var  array
     */
    protected $_fields = array();

    /**
     * Form buttons placeholder
     * @var  array
     */
    protected $_buttons = array();

    /**
     * Form Fields counters
     * @var  array
     */
    protected $_counts = array();

    /**
     * Defualt field attributes,
     * in case you forget to give it an value, you'll get an empty string from
     * this
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
     * @var  array
     */
    protected $_errors = array();

    /**
     * Field templates
     * @var  array
     */
    protected $_template = array(
        'group_open'    => "<div class='%s' %s>",
        'group_close'   => "</div>",
        'group_class'   => "form-group",
        'label_open'    => "<label class='%s' %s>",
        'label_close'   => "</label>",
        'label_class'   => "control-label",
        'label_col_lg'  => 3,
        'label_col_md'  => 3,
        'label_col_sm'  => 4,
        'label_col_xs'  => 12,
        'field_open'    => "<div class='%s' %s>",
        'field_close'   => "</div>",
        'field_class'   => "form-control input ",
        'field_col_lg'  => 9,
        'field_col_md'  => 9,
        'field_col_sm'  => 8,
        'field_col_xs'  => 12,
        'buttons_class' => "btn",
        'required_attr' => " <abbr title='Field ini harus diisi'>*</abbr>",
        'desc_open'     => "<span class='help-block'>",
        'desc_close'    => "</span>",
        );

    /**
     * Default class constructor
     */
    public function __construct(array $attrs = array())
    {
        // Load CI super object
        $this->_ci =& get_instance();

        // Load dependencies
        $this->_ci->config->load('biform');
        $this->_ci->lang->load('biform');
        $this->_ci->load->helper('biform');
        $this->_ci->load->library('form_validation');

        if ($template = config_item('biform_template'))
        {
            $this->_template = array_merge($this->_template, $template);
        }

        // Give some default values
        $this->_attrs['action'] = current_url();
        $this->_attrs['name']   = str_replace('/', '-', uri_string());

        if (!empty($attrs))
        {
            $this->initialize($attrs);
        }

        log_message('debug', "#BootIgniter: Biform Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Initializing new form
     *
     * @param   array   $attrs  Form Attributes config
     * @return  mixed
     */
    public function initialize(array $attrs = array())
    {
        // Applying default form attributes
        foreach (array('action', 'name', 'id', 'class', 'method', 'extras', 'hiddens') as $attr_key)
        {
            if (isset($attrs[$attr_key]))
            {
                $this->_attrs[$attr_key] = $attrs[$attr_key];
            }
        }

        if (!isset($attrs['id']))
        {
            $this->_attrs['id'] = 'form-'.$this->_attrs['name'];
        }

        // Is 'is_hform' already declarated? if not make it true
        if (isset($attrs['is_hform']) )
        {
            $this->is_hform = $attrs['is_hform'];
        }

        // set-up HTML5 role attribute
        $this->_attrs['role'] = 'form';

        // if fields is already declarated in the config, just make it happen ;)
        if (isset($attrs['fields']) and is_array($attrs['fields']) and !empty($attrs['fields']))
        {
            $this->set_fields($attrs['fields']);
            load_script('biform-script', $this->_scripts($attrs['fields']), Bootigniter::app('version'));
        }

        // if buttons is already declarated in the config, just make it happen ;)
        if (isset($attrs['buttons']) and is_array($attrs['buttons']) and !empty($attrs['buttons']))
        {
            $this->set_buttons($attrs['buttons']);
        }

        // set this up and you'll lose your buttons :P
        if (isset($attrs['no_buttons']))
        {
            $this->no_buttons = $attrs['no_buttons'];
        }

        // set this up and you'll lose your buttons :P
        if (isset($attrs['template']))
        {
            $this->set_template($attrs['template']);
        }

        return $this;
    }

    // -------------------------------------------------------------------------

    protected function _scripts($fields = '')
    {
        $script = "function showHide(el, state) {\n"
                . "    if (state) {\n"
                . "        el.removeClass('hide')\n"
                . "    } else {\n"
                . "        el.addClass('hide')\n"
                . "    }\n"
                . "}\n"
                . "$('.form-group').each(function () {\n"
                . "    if ($(this).data('fold') == 1) {\n"
                . "        var el  = $(this),\n"
                . "            key = el.data('fold-key'),\n"
                . "            val = el.data('fold-value'),\n"
                . "            tgt = '[name=\"'+key+'\"]';\n"

                . "        if ($(tgt).is(':radio')) {\n"
                . "            showHide(el, ($(tgt).filter(':checked').val() == val))\n"
                . "        }\n"
                . "        else if ($(tgt).is(':checkbox')) {\n"
                . "            showHide(el, ($(tgt).is(':checked') == val))\n"
                . "        }\n"
                . "        else {\n"
                . "            showHide(el, ($(tgt).val() == val))\n"
                . "        }\n"

                . "        if ($(tgt).hasClass('bs-switch')) {\n"
                . "            $(tgt).on('switchChange.bootstrapSwitch', function(event, state) {\n"
                . "                showHide(el, (val == state))\n"
                . "            });\n"
                . "        }\n"
                . "        else {\n"
                . "            $(tgt).change(function (e) {\n"
                . "                showHide(el, ($(this).val() == val))\n"
                . "            })\n"
                . "        }\n"
                . "    }\n"
                . "})\n";

        if ($fields[0]['type'] == 'subfield')
        {
            $first_field = 'sub'.str_replace('_', '-', 'input-'.$fields[0]['name'].'-'.$fields[0]['fields'][0]['name']);
        }
        else
        {
            $first_field = $fields[0]['name'];
        }

        $first_field = 'field-'.str_replace('_', '-', $first_field);
        $script .= "$('#".$first_field."').focus();\n";

        return $script;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup default field template
     * If you want to replace the default value, just pass these key(s) with
     * your value, and you'll see your own field template
     *
     * @param   array  $template  Template replacements
     * @return  mixed
     */
    public function set_template(array $template)
    {
        $valid_tmpl = array_keys($this->_template);

        foreach ($valid_tmpl as $option)
        {
            if (isset($template[$option]))
            {
                $this->_template[$option] = $template[$option];
            }
        }

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup multiple form fields at once.
     *
     * @param   array  $fields  Fields declaration
     * @return  mixed
     */
    public function set_fields(array $fields)
    {
        if (!empty($fields))
        {
            foreach ($fields as $field_id => $attributes)
            {
                $this->set_field($field_id, $attributes);
            }
        }

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup single form field.
     *
     * @param   string  $field_id    Field identifier
     * @param   array   $attributes  Field attributes
     * @return  mixed
     */
    public function set_field($field_id, array $attributes)
    {
        if (in_array($attributes['type'], array( 'file', 'upload' )))
        {
            $this->is_multipart = TRUE;
        }

        // Make sure that you have no duplicated field name
        if (is_numeric($field_id) and isset($attributes['name']))
        {
            $field_id = $attributes['name'];
        }
        elseif (is_string($field_id) and strlen($field_id) > 0 and !isset($attributes['name']))
        {
            $attributes['name'] = $field_id;
        }

        $this->_fields[$field_id] = $attributes;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup form multiple form buttons at once
     *
     * @param   array  $buttons  Form buttons
     * @return  mixed
     */
    public function set_buttons(array $buttons)
    {
        if (!empty($buttons))
        {
            foreach ($buttons as $button_id => $attributes)
            {
                $this->set_button($button_id, $attributes);
            }
        }

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup single form buttons
     *
     * @param   string  $button  Button identifier
     * @param   array   $button  Button attributes
     * @return  mixed
     */
    public function set_button($button_id, array $attributes)
    {
        // Make sure that you have no duplicated field name
        if (is_numeric($button_id) and isset($attributes['name']))
        {
            $button_id = $attributes['name'];
        }
        elseif (is_string($button_id) and strlen($button_id) > 0 and !isset($attributes['name']))
        {
            $attributes['name'] = $button_id;
        }

        $this->_buttons[$button_id] = $attributes;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Generate everything that we've set above
     *
     * @return  string
     */
    public function generate()
    {
        $html = '';

        // remove Form action out from Attributes
        $_action = $this->_attrs['action'];
        unset($this->_attrs['action']);

        // is it an upload form?
        if ($this->is_multipart === TRUE)
        {
            $this->_attrs['enctype'] = 'multipart/form-data';
            $this->_ci->load->library('biupload');
            $html .= $this->_ci->biupload->template();
        }

        // If you have additional form attributes, merge it.
        if (isset($this->_attrs['extras']))
        {
            $this->_attrs = array_merge($this->_attrs, $this->_attrs['extras']);
            unset($this->_attrs['extras']);
        }

        // If you have form hidden, put them to new variable
        $_hiddens = array();
        if (isset($this->_attrs['hiddens']))
        {
            $_hiddens = $this->_attrs['hiddens'];
            unset($this->_attrs['hiddens']);
        }

        // make it horizontal form by default
        if ($this->is_hform == TRUE)
        {
            $this->_attrs['class'] .= ' form-horizontal';
        }

        $this->_attrs['class'] = trim($this->_attrs['class']);

        // Open up new form
        $html .= form_open($_action, $this->_attrs, $_hiddens);

        // Loop the fields if not empty
        if (count($this->_fields) > 0)
        {
            $this->_counts['feildsets'] = 0;

            foreach($this->_fields as $field_attrs)
            {
                $html .= $this->_compile($field_attrs);
            }
        }

        // Close the fieldset before you close your form
        if($this->has_fieldset)
        {
            $html .= form_fieldset_close();
        }

        // Let them see your form has an action button(s)
        if ($this->no_buttons === FALSE)
        {
            $html .= $this->_form_actions();
        }

        // Now you can close your form
        $html .= form_close();

        return $html;
    }

    // -------------------------------------------------------------------------

    /**
     * Compile all Fields that you've setup
     *
     * @param   array   $field_attrs  Field Attributes
     * @param   bool    $is_sub       Is it an sub-fields?
     * @return  string
     */
    protected function _compile(array $field_attrs, $is_sub = FALSE)
    {
        $html              = '';
        $field_id          = isset($field_attrs['id']) ? $field_attrs['id'] : $field_attrs['name'];
        $field_attrs['id'] = 'field-'.str_replace('_', '-', $field_id);

        if (!isset($field_attrs['attr']))
        {
            $field_attrs['attr'] = '';
        }

        if ($is_sub and isset($field_attrs['label']))
        {
            $field_attrs['attr'] .= ' placeholder="'.$field_attrs['label'].'"';
        }

        $field_attrs  = array_set_defaults($field_attrs, $this->_default_attr);

        if ($field_attrs['type'] == 'hidden')
        {
            // Form hidden
            // CI form_hidden() function
            $html .= form_hidden($field_attrs['name'], $field_attrs['std']);
        }
        else if ($field_attrs['type'] == 'fieldset')
        {
            // Fieldset counter. If you have more that one fieldset in
            // you form, be sure to close it befor call the new one.
            if ($this->_counts['feildsets'] >= 1)
            {
                $html .= form_fieldset_close()."\n";
            }

            $field_attrs['id'] = 'fieldset-'.$field_attrs['id'];

            // If your attributes is string, turn it into an array
            if (isset($field_attrs['attr']) and is_array($field_attrs['attr']))
            {
                $field_attrs = array_merge($field_attrs, $field_attrs['attr']);
            }

            // Call the fieldset and give it an ID with 'fieldset-' prefix
            $html .= form_fieldset($field_attrs['label'], $field_attrs)."\n";

            // indicate you have an opened fieldset
            $this->has_fieldset = TRUE;
            $this->_counts['feildsets']++;
        }
        else if ($field_attrs['type'] == 'subfield')
        {
            $errors            = array();
            $field_attrs['id'] = 'sub'.$field_attrs['id'];
            $input             = '<div id="'.$field_attrs['id'].'" class="row">'."\n";

            if (isset($field_attrs['fields']) and !empty($field_attrs['fields']))
            {
                $field_attrs['for'] = 'field-sub'.str_replace('_', '-', 'input-'.$field_attrs['name'].'-'.$field_attrs['fields'][0]['name']);
                $c_fields           = count($field_attrs['fields']);

                foreach ( $field_attrs['fields'] as $field )
                {
                    $field = array_set_defaults( $field, array(
                        'name'       => '',
                        'std'        => '',
                        'col'        => '',
                        'validation' => '',
                        'attr'       => '',
                        ));

                    if ( empty( $field['col'] ) )
                    {
                        $field['col'] = floor( 12/$c_fields );
                    }

                    $input .= '<div class="'.twbs_set_columns($field['col'], $field['col'], $field['col'], 12).'">'."\n";
                    $field_attrs['validation'] = '';

                    if ( !empty( $field['validation'] ) )
                    {
                        if ( strpos( 'required', $field['validation'] ) !== FALSE)
                        {
                            $field['label'] .= ' &#42;';
                        }

                        $field_attrs['validation'] = $field['validation'];
                    }

                    $field['name'] = $field_attrs['name'].'_'.$field['name'];
                    $field['id']   = 'sub'.str_replace('_', '-', 'input-'.$field['name']);
                    $field['attr'] = !empty($field['attr']) ? $field['attr'] : $field_attrs['attr'];

                    $input .= $this->_compile( $field, TRUE ).'</div>'."\n";

                    if ( $is_error = form_error( $field['name'], $this->_template['desc_open'], $this->_template['desc_close'] ) )
                    {
                        $errors[] = $is_error;
                    }
                }
            }

            $input .= '</div>'."\n";

            if (count($errors) > 0)
            {
                $field_attrs['desc']['err'] = $errors;
            }

            $html .= $this->_form_common($field_attrs, $input);
        }
        else if ($field_attrs['type'] == 'info')
        {
            if (!isset($field_attrs['class']))
            {
                $field_attrs['class'] = 'default';
            }

            if (in_array($field_attrs['class'], array('default', 'danger', 'warning', 'success')))
            {
                $field_attrs['class'] = 'info-'.$field_attrs['class'];
            }

            $html .= '<div class="form-info '.$field_attrs['class'].'" id="'.$field_attrs['id'].'">'
                  .  '<h3 class="info-heading">'.$label.'</h3>'
                  .  '<div class="info-content"><p>'
                  .  (is_array($field_attrs['std']) ? implode('</p><p>', $field_attrs['std']) : $field_attrs['std'])
                  .  '</p></div></div>'."\n";
        }
        else
        {
            switch($field_attrs['type'])
            {
                // Text Input fields
                // date, email, url, search, tel, password, text
                case 'email':
                case 'url':
                case 'search':
                case 'tel':
                case 'password':
                case 'number':
                case 'date':
                case 'text':
                    $input = $this->_set_input_text($field_attrs)."\n";
                    break;

                // Radiocheckbox field
                case 'radio':
                case 'checkbox':
                    $input = $this->_set_input_radiocheck($field_attrs)."\n";
                    break;

                // Textarea field
                // Using CI form_textarea() function.
                // adding jquery-autosize.js to make it more useful
                case 'textarea':
                    $input = $this->_set_input_textarea($field_attrs)."\n";
                    break;

                // Captcha field
                case 'captcha':
                    $input = $this->_set_input_captcha($field_attrs)."\n";
                    break;

                // Selectbox field
                case 'multiselect':
                case 'dropdown':
                    $input = $this->_set_input_selectbox($field_attrs)."\n";
                    break;

                // Bootstrap Switch field
                case 'switch':
                    $input = $this->_set_input_switch($field_attrs)."\n";
                    break;

                // Date picker field
                case 'datepicker':
                    $input = $this->_set_input_datepicker($field_attrs)."\n";
                    break;

                // Jquery-ui Slider
                case 'slider':
                case 'rangeslider':
                    $input = $this->_set_input_slider($field_attrs)."\n";
                    break;

                // Jquery-UI Spinner
                case 'spinner':
                    $input = $this->_set_input_spinner($field_attrs)."\n";
                    break;

                // Upload field
                // Using CI form_upload() function
                // Ajax Upload using FineUploader.JS
                case 'file':
                case 'upload':
                    $input = $this->_set_input_upload($field_attrs)."\n";
                    break;

                // Summernote editor
                case 'editor':
                    $input = $this->_set_input_textrich($field_attrs)."\n";
                    break;

                // Static field
                case 'static':
                    $input = $this->_set_input_static($field_attrs)."\n";
                    break;

                // Custom field
                case 'custom':
                    $input = $field_attrs['std'];
                    break;

                default:
                    log_message('error', '#BootIgniter: Biform->Compile ERROR '.$field_attrs['type'].' Field type are not supported currently');
                    break;
            }

            // if ($this->has_jqueryui)
            // {
            //     load_script('jquery-mousewheel', 'js/lib/jquery.mousewheel.min.js', 'jquery', '3.1.12');
            //     load_script('jqui-core',         'js/lib/jquery-ui/core.min.js', 'jquery', '1.11.0');
            //     load_script('jqui-widget',       'js/lib/jquery-ui/widget.min.js', 'jqui-core', '1.11.0');
            //     load_script('jqui-button',       'js/lib/jquery-ui/button.min.js', 'jqui-widget', '1.11.0');
            //     load_script('jqui-mouse',        'js/lib/jquery-ui/mouse.min.js', 'jqui-widget', '1.11.0');
            //     load_script('jqui-position',     'js/lib/jquery-ui/position.min.js', 'jqui-widget', '1.11.0');
            //     load_script('jqui-touch',        'js/lib/jquery.ui.touch-punch.min.js', 'jqui-mouse', '0.2.3');
            //     load_style('jqui-theme',         'bower/jqueryui/themes/smoothness/jquery-ui.min.css', 'jquery', '1.11.0');
            // }

            if (isset($input))
            {
                $html .= $is_sub == FALSE ? $this->_form_common($field_attrs, $input) : $input;
            }
        }

        return $html;
    }

    // -------------------------------------------------------------------------

    /**
     * Form field which commonly used by all field types
     *
     * @param   array    $attrs  Field Attributes
     * @param   string   $input  Field input html
     * @return  string
     */
    protected function _form_common($attrs, $input)
    {
        extract($this->_template);

        $attrs    = array_set_defaults($attrs, $this->_default_attr);
        $is_error = FALSE;

        if (!is_array($attrs['desc']))
        {
            $is_error = form_error($attrs['name'], $desc_open, $desc_close);
        }
        else if (is_array($attrs['desc']) and isset($attrs['desc']['err']))
        {
            $is_error = $attrs['desc'];
        }

        if (strlen(trim($attrs['validation'])) != 0)
        {
            if (FALSE !== strpos($attrs['validation'], 'required'))
            {
                $attrs['label'] .= $required_attr;
                $group_class    .= ' form-required';
            }

            if ($is_error)
            {
                $group_class .= ' has-error';
            }
        }

        if (isset($attrs['class']))
        {
            $group_class .= ' '.$attrs['class'];
        }


        $group_attr = 'id="group-'.str_replace('_', '-', $attrs['name']).'"';

        if (isset($attrs['fold']) and !empty($attrs['fold']))
        {
            $group_attr .= ' data-fold="1" data-fold-key="'.$attrs['fold']['key'].'" data-fold-value="'.$attrs['fold']['value'].'"';
        }

        $html      = sprintf($group_open, trim($group_class), $group_attr);
        $left_desc = (isset($attrs['left-desc']) and $attrs['left-desc'] == TRUE);
        $errors    = ($is_error and !is_array($attrs['desc'])) ? $is_error : $attrs['desc'];

        if ($attrs['label'] != '')
        {
            // $label_class .= $label_col;
            $label_target = (isset($attrs['for']) ? $attrs['for'] : $attrs['id']);
            $label_col    = $this->is_hform ? twbs_set_columns($label_col_lg, $label_col_md, $label_col_sm, $label_col_xs) : '';

            $html .= '<div class="form-label '.$label_col.'">';
            $html .= form_label($attrs['label'], $label_target, array('class'=> $label_class));

            if ($left_desc)
            {
                $html .= $this->_form_desc($errors);
            }

            $html .= '</div>';
        }

        $input_col = $this->is_hform ? twbs_set_columns($field_col_lg, $field_col_md, $field_col_sm, $field_col_xs) : '';
        $html .= sprintf($field_open, 'form-input '.$input_col, '').$input;

        if (!$left_desc)
        {
            $html .= $this->_form_desc($errors);
        }

        $html .= $field_close.$group_close;

        return $html;
    }

    // -------------------------------------------------------------------------

    /**
     * Form action buttons
     *
     * @return  string
     */
    protected function _form_actions()
    {
        // If you have no buttons i'll give you two as default ;)
        // 1. Submit button as Bootstrap btn-primary on the left side
        // 2. Reset button as Bootstrap btn-default on the right side
        if (count($this->_buttons) == 0)
        {
            $this->_buttons[] = array(
                'name'  => 'submit',
                'type'  => 'submit',
                'label' => 'lang:biform_submit_btn',
                'class' => 'pull-left btn-primary'
               );
            $this->_buttons[] = array(
                'name'  => 'reset',
                'type'  => 'reset',
                'label' => 'lang:biform_reset_btn',
                'class' => 'pull-right btn-default'
               );
        }

        // If you were use Bootstrap form-horizontal class in your form,
        // You'll need to specify Bootstrap grids class.
        $group_col  = $this->is_hform ? twbs_set_columns(12, 12, 12, 12) : '';
        $html       = '<div class="form-group form-action"><div class="clearfix '.$group_col.'">';

        // Let's reset your button attributes.
        $button_attr = array();

        foreach ($this->_buttons as $attr)
        {
            // Button name is inheritance with form ID.
            $button_attr['name']  = $this->_attrs['name'].'-'.$attr['name'];
            // If you not specify your Button ID, you'll get it from Button name with '-btn' as surfix.
            $button_attr['id']    = (isset($attr['id']) ? $attr['id'] : $button_attr['name']).'-btn';
            // I prefer to use Bootstrap btn-sm as default.
            $button_attr['class'] = $this->_template['buttons_class'].(isset($attr['class']) ? ' '.$attr['class'] : '');

            if (substr($attr['label'], 0, 5) == 'lang:')
            {
                $attr['label'] = _x(str_replace('lang:', '', $attr['label']));
            }

            // $button_attr['data-loading-text']  = 'Loading...';
            // $button_attr['data-complete-text'] = 'Finished!';

            switch ($attr['type'])
            {
                // For submit and reset type input
                // <input type="[submit|reset]" ...>
                case 'submit':
                case 'reset':
                    $func = 'form_'.$attr['type'];
                    $button_attr['value'] = $attr['label'];
                    $html .= $func($button_attr);
                    break;

                // For button type button
                // <button type="button" ...></button>
                case 'button':
                    $button_attr['content'] = $attr['label'];
                    $html .= form_button($button_attr);
                    break;

                // For anchor type button
                // <a href="url" class="btn ..." ...></a>
                case 'anchor':
                    $attr['url'] = (isset($attr['url']) AND strlen($attr['url']) > 0) ? $attr['url'] : '#';
                    $html .= anchor(($attr['url'] != '#' ? $attr['url'] : current_url().'#'), $attr['label'], $button_attr);
                    break;
            }
        }

        $html .= '</div></div>';

        return $html;
    }

    // -------------------------------------------------------------------------

    /**
     * Default CI Text Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_text(array $field_attrs)
    {
        $field_attrs = array_set_defaults($field_attrs, array(
            'type'  => 'text',
            'std'   => '',
            'class' => '',
            'attr'  => '',
            ));

        $field_attrs['class'] = $this->_template['field_class'].' '.$field_attrs['class'];

        return form_input(array(
            'name'  => $field_attrs['name'],
            'type'  => $field_attrs['type'],
            'id'    => $field_attrs['id'],
            'class' => $field_attrs['class'],
           ), set_value($field_attrs['name'], $field_attrs['std']), $field_attrs['attr']);
    }

    // -------------------------------------------------------------------------

    /**
     * Default CI Textarea Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_textarea(array $field_attrs)
    {
        // load_script('jquery-autosize', 'js/lib/jquery.autosize.min.js', 'jquery', '1.18.0');
        load_script('autosize-trigger', "$('textarea').autosize();", Bootigniter::app('version'), 'jq-autosize');

        $field_attrs = array_set_defaults($field_attrs, array(
            'std'   => '',
            'rows'  => 3,
            'cols'  => '',
            'class' => '',
            'attr'  => '',
            ));

        $field_attrs['class'] = $this->_template['field_class'].' '.$field_attrs['class'];

        return form_textarea(array(
            'name'  => $field_attrs['name'],
            'rows'  => $field_attrs['rows'],
            'cols'  => $field_attrs['cols'],
            'id'    => $field_attrs['id'],
            'class' => $field_attrs['class']
            ), set_value($field_attrs['name'], $field_attrs['std']), $field_attrs['attr']);
    }

    // -------------------------------------------------------------------------

    /**
     * Radio and Checkbox Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_radiocheck(array $field_attrs)
    {
        $count  = 1;
        $input  = '';
        $field  = ($field_attrs['type'] == 'checkbox' ? $field_attrs['name'].'[]' : $field_attrs['name']);
        $devide = (count($field_attrs['option']) >= 6 ? TRUE : FALSE);

        if (!empty($field_attrs['option']))
        {
            $output    = '';
            $actived   = FALSE;
            $set_func  = 'set_'.$field_attrs['type'];
            $form_func = 'form_'.$field_attrs['type'];

            foreach ($field_attrs['option'] as $value => $option)
            {
                if (is_array($field_attrs['std']))
                {
                    if (($_key = array_keys($field_attrs['std'])) !== range(0, count($field_attrs['std']) - 1))
                    {
                        $field_attrs['std'] = $_key;
                    }

                    $actived = (in_array($value, $field_attrs['std']) ? TRUE : FALSE);
                }
                else if (is_string($field_attrs['std']))
                {
                    $actived = ($field_attrs['std'] == $value ? TRUE : FALSE);
                }

                $_id    = str_replace('-', '-', $field_attrs['name'].'-'.$value);
                $check  = '<div class="'.$field_attrs['type'].'" '.$field_attrs['attr'].'>'
                        . $form_func($field, $value, $set_func($field_attrs['name'], $value, $actived), 'id="'.$_id.'" '.$field_attrs['attr'])
                        . '<label for="'.$_id.'"> '.$option.'</label>'
                        . '</div>';

                $output .= ($devide ? '<div class="'.twbs_set_columns(6, 6, 6).'">'.$check.'</div>' : $check);

                if ($devide AND $count % 2 == 0)
                {
                    $output .= '</div><div class="row">';
                }

                $count++;
            }

            return ($devide ? '<div class="row">'.$output.'</div>' : $output);
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Default CI Text Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_spinner(array $field_attrs)
    {
        if (!isset($field_attrs['min'])) $field_attrs['min'] = 0;
        if (!isset($field_attrs['max'])) $field_attrs['max'] = 100;

        $script = "$('.jqui-spinner').each(function () {\n"
                . "    if ($(this).attr('disabled') != undefined || $(this).attr('readonly') != undefined) {\n"
                // . "        $(this).spinner('disable', true)\n"
                . "        console.log($(this).attr('disabled') != undefined)\n"
                . "    }\n"
                . "    else {\n"
                . "        $(this).spinner({\n"
                . "            spin: function(event, ui) {\n"
                . "                var val = ui.value,\n"
                . "                    max = $(this).data('spinner-max'),\n"
                . "                    min = $(this).data('spinner-min');\n"
                . "                if (val > max) {\n"
                . "                    val = min;\n"
                . "                } else if (val < min) {\n"
                . "                    val = max;\n"
                . "                }\n"
                . "                $(this).spinner('value', val);\n"
                . "                event.preventDefault();\n"
                . "            }\n"
                . "        });\n"
                . "    }\n"
                . "});";

        // load_script('jqui-spinner', 'js/lib/jquery-ui/spinner.min.js', 'jqui-core', '1.11.0');
        load_script('jqui-spinner-trigger', $script, Bootigniter::app('version'), 'jqueryui-spinner');

        return form_input(array(
            'name'              => $field_attrs['name'],
            'id'                => $field_attrs['id'],
            'data-spinner-min'  => $field_attrs['min'],
            'data-spinner-max'  => $field_attrs['max'],
            'class'             => $this->_template['field_class'].' jqui-spinner'
            ), set_value($field_attrs['name'], $field_attrs['std']), $field_attrs['attr']);
    }

    // -------------------------------------------------------------------------

    /**
     * Default CI Text Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_slider(array $field_attrs)
    {
        // $this->has_jqueryui = TRUE;

        $field_attrs = array_set_defaults( $field_attrs, array(
            'min' => 0,
            'max' => 100,
            'step' => 1,
            ));

        $script = "$('.jqui-".$field_attrs['type']."').each(function () {\n"
                . "    var el = $(this)\n"
                . "    var elmin = el.data('slider-min')\n"
                . "    var elmax = el.data('slider-max')\n";

        if ($field_attrs['type'] == 'rangeslider')
        {
            $script .= "    var inputMin = $(el.data('slider-target-min'))\n"
                    .  "    var inputMax = $(el.data('slider-target-max'))\n\n";
        }
        else
        {
            $script .= "    var input = $(el.data('slider-target'))\n\n";
        }

        $script .= "    $(this).slider({\n"
                .  "        max: elmax,\n"
                .  "        min: elmin,\n"
                .  "        step: el.data('slider-step'),\n";

        if ($field_attrs['type'] == 'rangeslider')
        {
            $script .= "        range: true,\n"
                    .  "        values: [inputMin.val(), inputMax.val()],\n"
                    .  "        slide: function(event, ui) {\n"
                    .  "            inputMin.val(ui.values[0]);\n"
                    .  "            inputMax.val(ui.values[1]);\n"
                    .  "        }\n"
                    .  "    });\n\n"
                    .  "    inputMin.on('change', function() {\n"
                    .  "        var val = +$(this).val();\n"
                    .  "        if (val <= elmin) {\n"
                    .  "            val = elmin;\n"
                    .  "        }\n"
                    .  "        else if (val > inputMax.val()) {\n"
                    .  "            val = inputMax.val();\n"
                    .  "        }\n"
                    .  "        inputMin.val(val)\n"
                    .  "        el.slider('values', 0, val)\n"
                    .  "    });\n\n"
                    .  "    inputMax.on('change', function() {\n"
                    .  "        var val = +$(this).val();\n"
                    .  "        if (val >= elmax) {\n"
                    .  "            val = elmax\n"
                    .  "        }\n"
                    .  "        else if (val < inputMin.val()) {\n"
                    .  "            val = inputMin.val()\n"
                    .  "        }\n"
                    .  "        inputMax.val(val)\n"
                    .  "        el.slider('values', 1, val)\n"
                    .  "    });\n";
        }
        else
        {
            $script .= "        range: 'min',\n"
                    .  "        value: input.val(),\n"
                    .  "        slide: function(event, ui) {\n"
                    .  "            input.val(ui.value);\n"
                    .  "        }\n"
                    .  "    });\n"
                    .  "    input.on('change', function() {\n"
                    .  "        var val = +$(this).val();\n"
                    .  "        if (val > elmax) {\n"
                    .  "            val = elmax\n"
                    .  "        }\n"
                    .  "        else if (val < elmin) {\n"
                    .  "            val = elmin\n"
                    .  "        }\n"
                    .  "        $(this).val(val)\n"
                    .  "        el.slider('value', val)\n"
                    .  "    });\n";
        }

        $script .= "});";

        // load_script('jqui-slider', 'js/lib/jquery-ui/slider.min.js', 'jqui-core', '1.11.0');
        load_script('jqui-'.$field_attrs['type'].'-trigger', $script, Bootigniter::app('version'), 'jqueryui-slider');

        $slider_attrs = array(
            'class'            => 'jqui-'.$field_attrs['type'],
            'data-slider-step' => $field_attrs['step'],
            'data-slider-min'  => $field_attrs['min'],
            'data-slider-max'  => $field_attrs['max'],
           );

        if ($field_attrs['type'] == 'rangeslider')
        {
            if (!isset($std['min'])) $std['min'] = $field_attrs['min'];
            if (!isset($std['max'])) $std['max'] = $field_attrs['max'];

            $slider_attrs['data-slider-target-min'] = '#'.$field_attrs['id'].'-min';
            $slider_attrs['data-slider-target-max'] = '#'.$field_attrs['id'].'-max';

            $form_input = '<div class="input-group">'
                        . form_input(array(
                            'name'  => $field_attrs['name'].'_min',
                            'id'    => $field_attrs['id'].'-min',
                            'type'  => 'number',
                            'style' => 'width: 50%;',
                            'class' => $this->_template['field_class']
                            ), set_value($field_attrs['name'].'_min', $field_attrs['std']['min']), $field_attrs['attr'])
                        . form_input(array(
                            'name'  => $field_attrs['name'].'_max',
                            'id'    => $field_attrs['id'].'-max',
                            'type'  => 'number',
                            'style' => 'width: 50%;',
                            'class' => $this->_template['field_class']
                            ), set_value($field_attrs['name'].'_max', $field_attrs['std']['max']), $field_attrs['attr'])
                        . '</div>';
        }
        else
        {
            $slider_attrs['data-slider-target'] = '#'.$field_attrs['id'];

            $form_input = form_input(array(
                'name'  => $field_attrs['name'],
                'id'    => $field_attrs['id'],
                'type'  => 'number',
                'class' => $this->_template['field_class']
               ), set_value($field_attrs['name'], $field_attrs['std']), $field_attrs['attr']);
        }

        $input  = '<div class="row"><div class="'.twbs_set_columns(3, 3, 3, 3).'">'.$form_input.'</div>'
                . '<div class="'.twbs_set_columns(9, 9, 9, 9).'">'
                . '<div '.parse_attrs($slider_attrs).'></div>'
                . '</div></div>';

        return $input;
    }

    // -------------------------------------------------------------------------

    /**
     * Default CI Text Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_textrich(array $field_attrs)
    {
        // load_script('summernote',     'js/lib/summernote.min.js', 'bootstrap', '0.5.2');
        // load_script('codemirror',     'js/lib/codemirror.js', 'jquery', '4.1');
        // load_script('codemirror.xml', 'js/lib/codemirror.mode.xml.js', 'codemirror', '4.1');
        // load_script('jquery-mousewheel', 'js/lib/jquery.mousewheel.min.js', 'jquery', '3.1.0');
        // load_script('perfectscrollbar', 'js/lib/perfect-scrollbar.js', 'jquery', '0.4.10');

        if (!isset($field_attrs['height'])) $field_attrs['height'] = 200;

        $script = "$('.summernote').each(function (e){\n"
                . "    var snel = $(this),\n"
                . "        Hsnel = snel.data('edtr-height'),\n"
                . "        Vsnel = snel.code();\n"
                . "    snel.summernote({\n";

        if ( $locale = (($lang = get_lang_code()) != 'en' ? $lang.'-'.strtoupper($lang) : '') )
        {
            // load_script('summernote-id',  'js/lib/summernote.'.$locale.'.js', 'summernote', '0.5.2');
            $script .="        lang: '".$locale."',\n";
        }

        $script .="        height: Hsnel,\n"
                . "        fontSizes: ['5', '6', '7', '8', '9', '10', '11', '12', '14', '18', '24', '36'],\n"
                . "        toolbar: [\n"
                . "            ['fontname', ['fontname']],\n"
                . "            ['fontsize', ['fontsize']],\n"
                . "            ['color', ['color']],\n"
                . "            ['font', ['bold', 'italic', 'underline', 'clear']],\n"
                . "            ['para', ['ul', 'ol', 'paragraph']],\n"
                . "            ['table', ['table']],\n"
                . "            ['view', ['fullscreen', 'codeview', 'help']]\n"
                . "        ],\n"
                . "        defaultFontName: 'Arial',\n"
                . "        fontNames: [\n"
                . "            'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',\n"
                . "            'Tahoma', 'Times New Roman', 'Verdana'\n"
                . "        ]\n"
                . "    });\n"
                . "});\n"
                . "$('.summernote').parents('form').on('submit', function (e) {\n"
                . "    $('.summernote').val($('.summernote').code());\n"
                . "});";

        load_script('summernote-trigger', $script, Bootigniter::app('version'), 'summernote-'.get_lang_code());

        return form_textarea(array(
                'name'  => $field_attrs['name'],
                'rows'  => '',
                'cols'  => '',
                'id'    => $field_attrs['id'],
                'class' => $this->_template['field_class'].' summernote',
                'data-edtr-height' => $field_attrs['height']), set_value($field_attrs['name'], $field_attrs['std']), $field_attrs['attr']);
    }

    // -------------------------------------------------------------------------

    /**
     * Captcha Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_captcha(array $field_attrs)
    {
        if (isset($field_attrs['mode']) and $field_attrs['mode'] == 'recaptcha')
        {
            $this->_ci->load->helper('recaptcha');
            $output = recaptcha_get_html(Bootigniter::get_setting('auth_recaptcha_public_key'));
        }
        else
        {
            $captcha     = str_replace(FCPATH, '', config_item('bi_base_path'));
            $captcha_url = base_url($captcha.'libraries/vendor/captcha/captcha'.EXT);
            $image_id    = 'captcha-'.$field_attrs['id'].'-img';
            $input_id    = 'captcha-'.$field_attrs['id'].'-input';

            $output = img(array(
                'src'    => $captcha_url,
                'alt'    => 'Cool captcha image',
                'id'     => $image_id,
                'class'  => 'img',
                'width'  => '200',
                'height' => '70',
                'rel'    => 'cool-captcha'
               ));

            $output .= anchor(current_url().'#', 'Ganti teks', array(
                'class' => 'small change-image btn btn-default',
               ));

            $output .= $this->_set_input_text(array(
                'name'  => $field_attrs['name'],
                'type'  => 'text',
                'id'    => $input_id,
                'std'   => '',
                'attr'  => $field_attrs['attr'],
               ));

            $script = "$('.change-image').on('click', function (e){\n"
                    . "    $('#".$image_id."').attr('src', '".$captcha_url."?'+Math.random());\n"
                    . "    $('#".$input_id."').focus();\n"
                    . "    e.preventDefault();\n"
                    . "});";

            load_script('collcaptha-trigger', $script, Bootigniter::app('version'));

            if (!extension_loaded('gd'))
            {
                $field_attrs['class'] = ' has-error';
                $output = '<p class="form-control form-control-static">'._x('biform_gdext_notfound').'</p>';
            }
        }

        return $output;
    }

    // -------------------------------------------------------------------------

    /**
     * Bootstrap Switch
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_switch(array $field_attrs)
    {
        // load_script('bs-switch', 'js/lib/bootstrap.switch.min.js', 'bootstrap', '3.0.2');
        // load_style('bs-switch', 'bower/bootstrap.switch/dist/css/bootstrap3/bootstrap-switch.min.css', 'bootstrap', '3.0.2');
        load_script('bs-switch-trigger', "$('.bs-switch').bootstrapSwitch();", Bootigniter::app('version'), 'bs-switch');

        if (!isset($field_attrs['option']))
        {
            $field_attrs['option'] = array(
                0 => 'Off',
                1 => 'On',
               );
        }

        if (count($field_attrs['option']) > 2)
        {
            return '<span class="form-control form-control-static">Pilihan tidak boleh lebih dari 2 (dua)!!</span>';
        }

        $_id = str_replace('-', '-', $field_attrs['name']);
        $field_attrs['std'] = (int) $field_attrs['std'];
        $checked = ($field_attrs['std'] == 1 ? TRUE : FALSE);

        return form_checkbox(array(
            'name'          => $field_attrs['name'],
            'id'            => $_id,
            'class'         => 'bs-switch',
            'value'         => 1,
            'checked'       => set_checkbox($field_attrs['name'], 1, $checked),
            'data-off-text' => $field_attrs['option'][0],
            'data-on-text'  => $field_attrs['option'][1],
           ));
    }

    // -------------------------------------------------------------------------

    /**
     * Dropdown and Multiselect Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_selectbox(array $field_attrs)
    {
        $native = (isset($field_attrs['native']) ? $field_attrs['native'] : FALSE);
        $control_class = '';

        if ($field_attrs['type'] == 'multiselect') $field_attrs['name'] = $field_attrs['name'].'[]';
        if ($field_attrs['type'] == 'select2')
        {
            $field_attrs['type'] = 'dropdown';
            $native = FALSE;
        }

        if ($native == FALSE)
        {
            // load_script('select2',         'js/lib/select2.min.js', 'jquery', '3.4.5');
            // load_script('select2-locale',  'js/lib/select2.'.(($code = get_lang_code()) != 'en' ? $code : '').'.js', 'jquery', '3.4.5');
            load_script('select2-trigger', "$('.form-control-select2').select2();\n", Bootigniter::app('version'), 'select2-'.get_lang_code());
            // load_style('select2');

            $control_class = 'form-control-select2 ';
        }

        $field_attrs['attr'] = 'class="'.$control_class.$this->_template['field_class'].'" id="'.$field_attrs['id'].'" '.$field_attrs['attr'];
        $form_func = 'form_'.$field_attrs['type'];

        return call_user_func_array($form_func, array(
            $field_attrs['name'],
            $field_attrs['option'],
            set_value($field_attrs['name'], $field_attrs['std']),
            $field_attrs['attr']
           ));
    }

    // -------------------------------------------------------------------------

    /**
     * FineUploader Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_upload(array $field_attrs)
    {
        $field_attrs = array_set_defaults( $field_attrs, array(
            'allowed_types' => '',
            'file_limit'    => 5,
            ));

        if ( is_array($field_attrs['allowed_types']) )
        {
            $field_attrs['allowed_types'] = implode('|', $field_attrs['allowed_types']);
        }

        $uploader = $this->_ci->biupload->initialize(array(
            'allowed_types' => $field_attrs['allowed_types'],
            'file_limit'    => $field_attrs['file_limit'],
           ));

        $desc = $uploader->upload_policy();

        if (isset($field_attrs['desc']))
        {
            $field_attrs['desc'] .= '. '.$desc;
        }
        else
        {
            $field_attrs['desc'] = $desc;
        }

        return $uploader->get_html($field_attrs['name']);
    }

    // -------------------------------------------------------------------------

    /**
     * Default CI Text Form
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_datepicker(array $field_attrs)
    {
        if (!isset($field_attrs['mode']))
        {
            $field_attrs['mode'] = 'bootstrap';
        }

        if ($field_attrs['mode'] == 'jqueryui')
        {
            // load_script('jqui-datepicker', 'js/lib/jquery-ui/datepicker.min.js', 'jqui-core', '1.11.0');

            // if ($locale = (($code = get_lang_code()) != 'en' ? $code : ''))
            // {
            //     load_script('jqui-datepicker-'.$code, 'js/lib/jquery-ui/i18n/datepicker-'.$locale.'.min.js', 'jqui-datepicker', '1.11.0');
            // }

            $script = "$('.jqui-datepicker').datepicker({\n"
                    . "    dateFormat: 'dd-mm-yyyy'\n"
                    . "});";

            load_script('jqui-datepicker-trigger', $script, Bootigniter::app('version'), 'jqueryui-datepicker-'.get_lang_code());

            // $this->has_jqueryui = TRUE;
            $field_attrs['class'] = 'jqui-datepicker';
        }
        elseif ($field_attrs['mode'] == 'bootstrap')
        {
            // load_script('bs-datepicker', 'js/lib/bootstrap.datepicker.js', 'bootstrap', '1.3.0');
            // load_style('bs-datepicker', 'bower/bootstrap-datepicker/css/datepicker3.css', 'bootstrap', '1.3.0');

            // if ($locale = (($code = get_lang_code()) != 'en' ? '.'.$code : ''))
            // {
            //     load_script('bs-datepicker-'.$code, 'js/lib/bootstrap.datepicker'.$locale.'.js', 'bs-datepicker', '1.3.0');
            // }

            $code = get_lang_code();
            $script = " // $.fn.bsDatepicker = $.fn.datepicker.noConflict();\n"
                    . "$('.bs-datepicker').datepicker({\n"
                    . "    format: 'dd-mm-yyyy',\n"
                    . "    language: '{$code}',\n"
                    . "    autoclose: true,\n"
                    . "    todayBtn: true\n"
                    . "});\n";

            load_script('bs-datepicker-trigger', $script, Bootigniter::app('version'), 'bs-datepicker-'.$code);

            $field_attrs['class'] = 'bs-datepicker';
        }

        $field_attrs['type'] = 'text';
        $output = '<div class="has-feedback">'
                    . $this->_set_input_text($field_attrs)
                . '<span class="fa fa-calendar form-control-feedback"></span></div>';

        return $output;
    }

    // -------------------------------------------------------------------------

    /**
     * Static Form
     * @link    http://getbootstrap.com/css/#forms-controls-static
     *
     * @param   array  $field_attrs  Field Attributes
     * @return  string
     */
    protected function _set_input_static(array $field_attrs)
    {
        $attributes = _parse_attributes(array(
            'id'    => $field_attrs['id'],
            'class' => str_replace('form-control', 'form-control-static', $this->_template['field_class']),
           ));

        return '<p '.$attributes.'>'.$field_attrs['std'].'</p>';
    }

    // -------------------------------------------------------------------------

    /**
     * Validate submission, it will setup validation rules of each field
     * using default CI Form Validation
     *
     * @return  bool
     */
    public function validate_submition()
    {
        foreach ($this->_fields as $field)
        {
            if ($field['type'] == 'subfield')
            {
                foreach ($field['fields'] as $sub)
                {
                    $sub_validation = (isset($sub['validation']) ? $sub['validation'] : '');
                    $sub_callback   = (isset($sub['callback'])   ? $sub['callback']   : '');

                    $this->set_field_rules($field['name'].'_'.$sub['name'], $sub['label'], $sub['type'], $sub_validation, $sub_callback);
                }
            }
            else if ($field['type'] == 'rangeslider')
            {
                $validation = (isset($field['validation']) ? $field['validation'] : '');
                $callback   = (isset($field['callback'])   ? $field['callback']   : '');

                $this->set_field_rules($field['name'].'_min', $field['label'], $field['type'], $validation, $callback);
                $this->set_field_rules($field['name'].'_max', $field['label'], $field['type'], $validation, $callback);
            }
            else if ($field['type'] != 'static' AND $field['type'] != 'fieldset')
            {
                $validation = (isset($field['validation']) ? $field['validation'] : '');
                $callback   = (isset($field['callback'])   ? $field['callback']   : '');

                $this->set_field_rules($field['name'], $field['label'], $field['type'], $validation, $callback);
            }
        }

        // if is valid submissions
        if ($this->_ci->form_validation->run())
        {
            return $this->submited_data();
        }

        // otherwise
        return false;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup field validation rules
     *
     * @return  void
     */
    protected function set_field_rules($name, $label, $type, $validation = '', $callback = '')
    {
        $field_arr = (strpos($name, '[]') === FALSE OR $type == 'checkbox' OR $type == 'multiselect' OR $type == 'upload' ? TRUE : FALSE);
        $rules     = ($field_arr ? 'xss_clean' : 'trim|xss_clean');

        if (strlen($validation) > 0)
        {
            $rules .= '|'.$validation;
        }

        $this->_ci->form_validation->set_rules($name, $label, $rules);

        $method = $this->_attrs['method'];

        if (strlen($callback) > 0 and function_exists($callback) and is_callable($callback))
        {
            $this->form_data[$name] = call_user_func($callback, $this->_ci->input->$method($name));
        }
        else
        {
            $this->form_data[$name] = $this->_ci->input->$method($name);
        }

        if (isset($this->_attrs['hiddens']))
        {
            foreach ($this->_attrs['hiddens'] as $h_name => $h_value)
            {
                $this->form_data[$h_name] = $this->_ci->input->$method($h_name);
            }
        }

        if ($type == 'upload')
        {
            $files = $this->form_data[$name];

            if (count($files) == 1)
            {
                $this->form_data[$name] = $files[0];
            }
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Field description
     *
     * @param   string|array  $desc  Description about what this field is
     * @return  string
     */
    protected function _form_desc($desc = NULL)
    {
        $ret = '';

        if (is_null($desc))
        {
            $ret = '';
        }
        else if (is_string($desc) and strlen($desc) > 0)
        {
            $ret = $this->_template['desc_open'].$desc.$this->_template['desc_close'];
        }
        else if (is_array($desc) and !empty($desc))
        {
            $descs = isset($desc['err']) ? $desc['err'] : $desc;

            foreach ($descs as $ket)
            {
                $ret .= $ket;
            }
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    /**
     * Return the submited data
     *
     * @return  array
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
     * @return  void
     */
    public function clear()
    {
        $this->_attrs = array(
            'action' => '',
            'name'   => '',
            'class'  => '',
            'method' => 'post'
           );

        $this->is_hform     = FALSE;
        $this->is_multipart = FALSE;
        $this->no_buttons   = FALSE;
        $this->has_fieldset = FALSE;
        // $this->has_jqueryui = FALSE;
        $this->_fields      = array();
        $this->_buttons     = array();
        $this->_errors      = array();
    }
}

/* End of file Former.php */
/* Location: ./bootigniter/libraries/Former.php */
