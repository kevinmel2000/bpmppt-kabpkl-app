<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Baka_form Extends Baka_lib
{
	private $form_action;

	private $form_attrs = array();

	private $form_data = array();

	private $has_fieldset = FALSE;

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
		$this->form_attrs['id']		= str_replace('_', '-', 'form-'.($id != '' ? $id : $name));
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
		$output	= form_open( $this->form_action, $this->form_attrs );
		
		// $output .= $this->show_alerts();

		foreach( $this->fields as $field )
		{
			$output .= $this->compile( $field );
		}

		if( $this->has_fieldset === TRUE )
			$output .= form_fieldset_close();

		$output .= $this->_form_actions();
		$output .= form_close();

		return $output;
	}

	protected function compile( $field )
	{
		$output			= '';
		$counter		= 0;
		$input_classes	= 'form-control input-sm';

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

		$field['id'] = str_replace('_', '-', isset($field['id']) ? $field['id'] : $field['name']);

		switch( $field['type'] )
		{
			case 'hidden':
				$output .= form_hidden($field['name'], $field['value']);
				break;

			case 'fieldset':
				$counter++;
				if ( $counter >= 2 )
					$output .= form_fieldset_close();

				$this->has_fieldset = TRUE;

				$output .= form_fieldset( $field['label'], array( 'id'=>'fieldset-'.$field['id'] ) );
				break;

			case 'number':
			case 'email':
			case 'url':
			case 'search':
			case 'tel':
			case 'password':
			case 'text':
				$output .= $this->_form_common(	$field['name'], $field['label'],
					form_input( array(
						'name'	=> $field['name'],
						'type'	=> $field['type'],
						'value'	=> set_value( $field['name'], $field['std'] ),
						'id'	=> $field['id'],
						'class'	=> $input_classes )),
					$field['id'], $field['desc'], $field['validation'] );
				break;

			case 'textarea':
				$output .= $this->_form_common(	$field['name'], $field['label'],
					form_textarea( array(
						'name'	=> $field['name'],
						'rows'	=> 3,
						'cols'	=> '',
						'value'	=> set_value( $field['name'], $field['std'] ),
						'id'	=> $field['id'],
						'class'	=> $input_classes )),
					$field['id'], $field['desc'], $field['validation'] );
				break;

			case 'upload':
				$output .= $this->_form_common(	$field['name'], $field['label'],
					form_upload( array(
						'name'	=> $field['name'],
						'id'	=> $field['id'],
						'class'	=> $input_classes )),
					$field['id'], $field['desc'], $field['validation'] );
				break;

			case 'multiselect':
			case 'dropdown':
				$output .= $this->_form_selectbox( $field['name'], $field['label'], $field['std'], $field['option'], $field['id'], $field['type'], $field['attr'], $field['desc'], $field['validation']);
				break;

			case 'radiobox':
			case 'checkbox':
				$output .= $this->_form_radiocheckbox( $field['name'], $field['label'], $field['std'], $field['option'], $field['id'], $field['type'], $field['desc'], $field['validation']);
				break;

			case 'subfield':
				$output .= $this->_form_subfield( $field['name'], $field['label'], $field['id'], $field['fields'], $field['desc'] );
				// $output .= $this->_form_radiocheckbox($field['name'], $field['label'], $field['std'], $field['option'], $field['type'], $field['desc'], $field['validation']);
				break;

			default:
				log_message('error', 'FORM ERROR: '.$field['type'].' Field type are not supported currently');
				break;
		}

		return $output;
	}

	private function _form_radiocheckbox( $name, $label, $std, $options, $id = '', $type = '', $desc = '', $validation = '' )
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


	private function _form_selectbox( $name, $label, $std, $option, $id = '', $type = '', $attr = '', $desc = '', $validation = '' )
	{
		$type	= ($type == 'dropdown' ? $type : 'multiselect');
		$attr	= 'class="form-control input-sm" id="input_'.$name.'" '.$attr;

		return $this->_form_common(	$name, $label, call_user_func_array('form_'.$type, array($name, $option, set_select($name, $std), $attr)), $id, $desc, $validation );
	}

	private function _form_common( $name, $label, $input, $id = '', $desc = '', $validation = '' )
	{
		$group		= 'form-group';
		$is_error	= (!is_array($desc) ? form_error($name, '<span class="help-block">', '</span>') : FALSE);
		
		if ($validation != '')
		{
			if (strpos('required', $validation) !== false)
			{
				$label .= ' <abbr title="Field ini arus diisi">*</abbr>';
				$group .= ' form-required';
			}

			if ( $is_error OR is_array($desc) )
				$group .= ' has-error';
		}

		$label_col = (strpos('form-horizontal', $this->form_attrs['class']) !== FALSE ? 'col-lg-3 col-md-3 ' : '' );
		$input_col = (strpos('form-horizontal', $this->form_attrs['class']) !== FALSE ? 'col-lg-9 col-md-9 ' : '' );

		$output  = '<div id="group-'.str_replace('_', '-', $name).'" class="'.$group.'">';

		if ($label != '' OR strpos('form-horizontal', $this->form_attrs['class']) !== FALSE )
			$output .= '	'.form_label( $label, $name, array('class'=> $label_col.'control-label') );
	
		$output .= '	<div class="'.$input_col.'">'.$input.$is_error;
		
		if ( !is_array($desc) AND $desc != '' )
			$output .= '<span class="help-block">'.$desc.'</span>';

		if ( is_array($desc) AND count($desc) > 0 )
			foreach ($desc as $keterangan)
				$output .= '<span class="help-block">'.$keterangan.'</span>';

		$output .= '</div></div>';

		log_message('debug', 'FORM DEBUG: Field '.$label.' loaded');

		return $output;
	}

	private function _form_subfield( $name, $label, $id = '', $fields = array(), $desc = '' )
	{
		$id = $id != '' ? $id : $name;
		$field_col	= '<div id="subfield-'.str_replace('_', '-', $id).'" class="row">';
		$errors		= array();
		$input_classes	= 'form-control input-sm';
		
		if ( count($fields) == 0)
		{
			log_message('error', 'FORM ERROR: Field '.$name.' has no subfield');
			return FALSE;
		}

		foreach ( $fields as $field )
		{
			$field_col .= '<div class="col-md-'.$field['col'].'">';
			$validation = '';

			if (isset($field['validation']) AND $field['validation'] != '')
			{
				if (strpos('required', $field['validation']) !== false)
					$field['label'] .= ' *';

				$validation = $field['validation'];
			}

			$field['name']	= $name.'_'.$field['name'];
			$field['id']	= str_replace('_', '-', 'input-'.$field['name']);

			switch( $field['type'] )
			{
				case 'number':
				case 'email':
				case 'url':
				case 'search':
				case 'tel':
				case 'password':
				case 'text':
					$field_col .= form_input( array(
						'name'	=> $field['name'],
						'type'	=> $field['type'],
						'value'	=> set_value( $field['name'], $field['std'] ),
						'id'	=> $field['id'],
						'class'	=> $input_classes,
						'placeholder' => $field['label'] ));
					break;

				case 'multiselect':
				case 'dropdown':
					$type	= ($field['type'] == 'dropdown' ? $field['type'] : 'multiselect');
					$attr	= 'class="form-control input-sm" id="'.$field['id'].'" placeholder="'.$field['label'].'"';
					$func	= 'form_'.$type;

					$field_col .= $func( $name.$field['name'], $field['option'], set_select($field['name'], $field['std']), $attr );
					break;

				// case 'radiobox':
				// case 'checkbox':
				// 	$field_col .= $this->_form_radiocheckbox($field['name'], $field['label'], $field['std'], $field['option'], $field['type'], $field['desc'], $field['validation']);
				// 	break;

				// case 'textarea':
				// 	$field_col .= $this->_form_common(	$field['name'], $field['label'],
				// 		form_textarea( array('name' => $field['name'],'rows' => 3,'cols' => '','value' => set_value($field['name'], $field['std']),'id' => $field['name'],'class' => $input_classes) ),
				// 		$field['desc'], $field['validation'] );
				// 	break;

				// case 'upload':
				// 	$field_col .= $this->_form_common(	$field['name'], $field['label'],
				// 		form_upload( array('name' => $field['name'], 'id' => $field['name'],'class' => $input_classes) ),
				// 		$field['desc'], $field['validation'] );
				// 	break;

				default:
					log_message('error', 'FORM ERROR: '.$field['type'].' Subfield type are not supported currently');
					break;
			}

			if ($is_error = form_error( $field['name'] ))
				$errors[] = $is_error;

			$field_col .= '</div>';
		}

		$field_col .= '</div>';

		$desc = ( count($errors) > 0 ? $errors : $desc );

		$output = $this->_form_common( $name, $label, $field_col, $id, $desc, $validation );

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
			if ( $field['type'] == 'subfield' )
			{
				foreach ( $field['fields'] as $subfield )
				{
					if (isset($subfield['validation']))
						$this->set_field_rules($field['name'].'_'.$subfield['name'], $subfield['label'], $subfield['validation']);
				}
			}
			else
			{
				if (isset($field['validation']))
					$this->set_field_rules($field['name'], $field['label'], $field['validation']);
			}
		}
			
		return $this->form_validation->run();
	}

	protected function set_field_rules( $field_name, $field_label, $validation_rules = '' )
	{
		$validation = 'trim|xss_clean';

		if ( strlen($validation_rules) > 0 )
			$validation = 'trim|'.$validation_rules.'|xss_clean';

		$this->form_validation->set_rules($field_name, $field_label, $validation);

		$this->form_data[$field_name] = (isset($field['callback']) ?
			call_user_func($field['callback'], $this->input->post($field_name)) :
			$this->input->post($field_name));
	}

	public function submited_data()
	{
		return $this->form_data;
	}
}

/* End of file Baka_form.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_form.php */