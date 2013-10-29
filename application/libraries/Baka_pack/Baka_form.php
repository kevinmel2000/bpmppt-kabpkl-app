<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Baka_form Extends Baka_lib
{
	private $form_action;

	private $form_attrs = array();

	private $form_data = array();

	private $fields	= array();

	private $buttons = array();

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('baka_pack/baka_form');

		log_message('debug', "Baka_form Class Initialized");
	}

	public function add_form( $action, $name, $id = '', $class = '', $method = 'post', $extra = array() )
	{
		$this->form_action			= $action;
		$this->form_attrs['name']	= $name;
		$this->form_attrs['id']		= 'form-'.($id != '' ? $id : $name);
		$this->form_attrs['class']	= ($class != '' ? ' '.$class : 'form-horizontal');
		$this->form_attrs['method']	= strtoupper($method);
		$this->form_attrs['role']	= 'form';

		if (count($extra) > 0)
		{
			foreach ($extra as $key => $value)
			{
				$this->form_attrs[$key] = $value;
			}
		}

		return $this;
	}

	public function add_fields( $fields = array() )
	{
		$this->fields = $fields;

		return $this;
	}

	public function add_buttons( $buttons = array() )
	{
		$this->buttons = $buttons;

		return $this;
	}

	public function render()
	{
		$counter	= 0;
		$fieldset	= FALSE;

		$output	= form_open( $this->form_action, $this->form_attrs );
		
		$input_classes = 'form-control input-sm';

		// $output .= $this->show_alerts();

		foreach( $this->fields as $field )
		{
			if (!array_key_exists('value', $field) AND !isset( $field['value'] ))
				$field['value'] = '';

			if (!array_key_exists('std', $field) AND !isset( $field['std'] ))
				$field['std'] = '';

			if (!array_key_exists('desc', $field) AND !isset( $field['desc'] ))
				$field['desc'] = '';

			if (!array_key_exists('attr', $field) AND !isset( $field['attr'] ))
				$field['attr'] = '';

			if (!array_key_exists('validation', $field) AND !isset( $field['validation'] ))
				$field['validation'] = '';
	
			switch( $field['type'] )
			{
				case 'hidden':
					$output .= form_hidden($field['name'], $field['value']);
					break;

				case 'fieldset':
					$counter++;
					if ( $counter >= 2 )
						$output .= form_fieldset_close();

					$fieldset = TRUE;

					$output .= form_fieldset( $field['label'], array( 'id'=>'fieldset-'.$field['name'] ) );
					break;

				case 'number':
				case 'email':
				case 'url':
				case 'search':
				case 'tel':
				case 'password':
				case 'text':
					$output .= $this->_form_common(	$field['name'], $field['label'],
						form_input( array('name' => $field['name'],'type' => $field['type'],'value' => set_value($field['name'], $field['std']),'id' => $field['name'],'class' => $input_classes) ),
						$field['desc'], $field['validation'] );
					break;

				case 'textarea':
					$output .= $this->_form_common(	$field['name'], $field['label'],
						form_textarea( array('name' => $field['name'],'rows' => 3,'cols' => '','value' => set_value($field['name'], $field['std']),'id' => $field['name'],'class' => $input_classes) ),
						$field['desc'], $field['validation'] );
					break;

				case 'upload':
					$output .= $this->_form_common(	$field['name'], $field['label'],
						form_upload( array('name' => $field['name'], 'id' => $field['name'],'class' => $input_classes) ),
						$field['desc'], $field['validation'] );
					break;

				case 'multiselect':
				case 'dropdown':
					$output .= $this->_form_selectbox($field['name'], $field['label'], $field['std'], $field['option'], $field['type'], $field['attr'], $field['desc'], $field['validation']);
					break;

				case 'radiobox':
				case 'checkbox':
					$output .= $this->_form_radiocheckbox($field['name'], $field['label'], $field['std'], $field['option'], $field['type'], $field['desc'], $field['validation']);
					break;
			}
		}

		if( $fieldset === TRUE )
			$output .= form_fieldset_close();

		$output .= $this->_form_actions();
		$output .= form_close();

		return $output;
	}

	private function _form_radiocheckbox($name, $label, $std, $options, $type = '', $desc = '', $validation = '')
	{
		$type	= ($type == 'checkbox' ? $type : 'radio');
		$input	= '';

		foreach( $options as $value => $option )
		{
			$actived = $std == $value ? TRUE : FALSE;
			$input .= '<div class="'.$type.'"><label>';
			$input .= call_user_func_array('form_'.$type, array($name, $value, $actived)).' '.$option;
			$input .= '</label></div>';
		}

		return $this->_form_common(	$name, $label, $input, $desc, $validation );
	}


	private function _form_selectbox($name, $label, $std, $option, $type = '', $attr = '', $desc = '', $validation = '')
	{
		$type	= ($type == 'dropdown' ? $type : 'multiselect');
		$attr	= 'class="form-control input-sm" id="input_'.$name.'" '.$attr;

		return $this->_form_common(	$name, $label, call_user_func_array('form_'.$type, array($name, $option, set_select($name, $std), $attr)), $desc, $validation );
	}

	private function _form_common( $name, $label, $input, $desc = '', $validation = '' )
	{
		$group = 'form-group';
		
		if ($validation != '')
		{
			if (strpos('required', $validation) !== false)
			{
				$label .= ' <abbr title="Field ini arus diisi">*</abbr>';
				$group .= ' form-required';
			}

			if (validation_errors())
				$group .= ' has-error';
		}

		$label_col = (strpos('form-horizontal', $this->form_attrs['class']) !== FALSE ? 'col-lg-3 col-md-3 ' : '' );
		$input_col = (strpos('form-horizontal', $this->form_attrs['class']) !== FALSE ? 'col-lg-9 col-md-9 ' : '' );

		$output  = '<div id="group-'.$name.'" class="'.$group.'">';

		if ($label != '' OR strpos('form-horizontal', $this->form_attrs['class']) !== FALSE )
			$output .= '	'.form_label( $label, $name, array('class'=> $label_col.'control-label') );
	
		$output .= '	<div class="'.$input_col.'">'.$input;
		
		if ($desc != '')
		{
			$output .= '<span class="help-block">';
			$output .= (validation_errors() ? form_error($name, '', '') : $desc) ;
			$output .= '</span>';
		}

		$output .= '</div></div>';

		log_message('debug', 'Field '.$label.' loaded');

		return $output;
	}

	private function _form_actions()
	{
		if (count($this->buttons) == 0 )
		{
			$this->buttons = array(
				array(
					'name'	=> 'submit',
					'type'	=> 'submit',
					'value'	=> 'submit_btn',
					'class'	=> 'pull-left btn-primary'
					),
				array(
					'name'	=> 'reset',
					'type'	=> 'reset',
					'value'	=> 'reset_btn',
					'class'	=> 'pull-right btn-default'
					)
				);
		}

		$group_col = (strpos('form-horizontal', $this->form_attrs['class']) !== FALSE ? 'col-lg-12 col-md-12 ' : '' );
		$output = '<div class="form-group form-action"><div class="'.$group_col.'clearfix">';

		foreach ($this->buttons as $button_attr)
		{
			$button_attr['name']	= $this->form_attrs['id'].'-'.$button_attr['name'];
			$button_attr['id']		= (isset($button_attr['id']) ? $button_attr['id'] : $button_attr['name']).'-btn';
			$button_attr['value']	= _x( $button_attr['value'] );
			$button_attr['class']	= 'btn btn-sm'.(isset($button_attr['class']) ? ' '.$button_attr['class'] : '');

			switch ($button_attr['type']) {
				case 'submit':
				case 'reset':
					$func = 'form_'.$button_attr['type'];

					$output .= $func( $button_attr );
					break;

				case 'button':
					$output .= form_button( $button_attr );
					break;

				case 'anchor':
					$output .= anchor( $button_attr );
					break;
			}
		}

		$output .= '</div></div>';

		return $output;
	}

	public function validate_submition()
	{
		$this->load->library('form_validation');

		foreach ($this->fields as $field)
		{
			$validation = 'trim|xss_clean';

			if ( array_key_exists('validation', $field) AND strlen($field['validation']) > 0 )
				$validation = 'trim|'.$field['validation'].'|xss_clean';

			$this->form_validation->set_rules($field['name'], $field['label'], $validation);

			$field_name = $field['name'];

			$this->form_data[$field_name] = (isset($field['callback']) ?
				call_user_func($field['callback'], $this->input->post($field_name)) :
				$this->input->post($field_name));
		}
			
		return $this->form_validation->run();
	}

	public function submited_data()
	{
		return $this->form_data;
	}
}

/* End of file Baka_form.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_form.php */