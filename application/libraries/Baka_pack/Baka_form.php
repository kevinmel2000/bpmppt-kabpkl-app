<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BAKA Form Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Form
 * @author		Fery Wardiyanto (http://github.com/feryardiant/)
 */
class Baka_form Extends Baka_lib
{
	private $form_action;

	private $form_attrs = array();

	private $form_data = array();

	private $has_fieldset = FALSE;

	private $fields	= array();

	private $buttons = array();

	private $show_action_btns = TRUE;

	public function __construct()
	{
		$this->load->library('form_validation');

		$this->load->helper('baka_pack/baka_form');

		log_message('debug', "#Baka_pack: Form Class Initialized");
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

	public function add_form_multipart( $action, $name, $id = '', $class = '', $method = 'post', $extra = array() )
	{
		$extra['enctype'] = 'multipart/form-data';

		return $this->add_form( $action, $name, $id, $class, $method, $extra );
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

	public function disable_buttons()
	{
		$this->show_action_btns = FALSE;
	}

	public function render()
	{
		$output	= form_open( $this->form_action, $this->form_attrs );
		
		$output .= form_alert();

		foreach( $this->fields as $field )
		{
			$output .= $this->compile( $field );
		}

		if( $this->has_fieldset === TRUE )
			$output .= form_fieldset_close();

		if ( $this->show_action_btns )
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

				if ( is_string( $field['attr'] ) )
				{
					$field['attr'] = array( $field['attr'] => '' );
				}

				$output .= form_fieldset( $field['label'], array_merge( $field['attr'], array( 'id'=>'fieldset-'.$field['id'] ) ) );

				$this->has_fieldset = TRUE;
				break;

			case 'date':
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
						'id'	=> $field['id'],
						'class'	=> $input_classes ), set_value( $field['name'], $field['std'] ), $field['attr']),
					$field['id'], $field['desc'], $field['validation'] );
				break;

			case 'datepicker':
				$output .= $this->_form_datepicker(
					$field['name'],
					$field['label'],
					$field['std'],
					$field['id'],
					$field['class'],
					$field['desc'],
					$field['validation'],
					$field['attr'],
					FALSE );
				break;

			case 'textarea':
				$output .= $this->_form_common(	$field['name'], $field['label'],
					form_textarea( array(
						'name'	=> $field['name'],
						'rows'	=> 3,
						'cols'	=> '',
						'id'	=> $field['id'],
						'class'	=> $input_classes ), set_value( $field['name'], $field['std'] ), $field['attr']),
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
				$output .= $this->_form_selectbox(
					$field['name'],
					$field['label'],
					$field['std'],
					$field['option'],
					$field['id'],
					$field['type'],
					$field['attr'],
					$field['desc'],
					$field['validation']);
				break;

			case 'radiobox':
			case 'checkbox':
				$output .= $this->_form_radiocheckbox(
					$field['name'],
					$field['label'],
					$field['option'],
					$field['std'],
					$field['id'],
					$field['type'],
					$field['desc'],
					$field['validation']);
				break;

			case 'subfield':
				$output .= $this->_form_subfield( $field['name'], $field['label'], $field['id'], $field['fields'], $field['desc'], $field['attr'] );
				break;

			case 'recaptcha':
				$this->load->helper('recaptcha');

				$output .= $this->_form_common(	$field['name'], $field['label'],
					recaptcha_get_html( get_app_setting('auth_recaptcha_public_key') ),
					$field['id'], $field['desc'], $field['validation'] );
				break;

			case 'captcha':
				$output .= $this->_form_captcha( $field['name'], $field['label'], $field['id'], $input_classes, $field['desc'], $field['validation'] );
				break;

			case 'static':
				$output .= $this->_form_common(	$field['name'], $field['label'],
					'<p id="'.$field['id'].'" class="form-control-static input-sm">'.$field['std'].'</p>',
					$field['id'], $field['desc'] );
				break;

			case 'custom':
				$output .= $this->_form_common(	$field['name'], $field['label'], $field['value'], $field['id'], $field['desc'], $field['validation'] );
				break;

			default:
				log_message('debug', '#Baka_form: '.$field['type'].' Field type are not supported currently');
				break;
		}

		return $output;
	}

	private function _form_datepicker( $name, $label, $std = '', $id = '', $class = '', $desc = '', $validation = '', $attr = '', $is_subfield = FALSE )
	{
		add_script( 'bt-tultip', 'asset/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js', 'bootstrap' );
		add_style( 'bt-tultip', 'asset/vendor/bootstrap-datepicker/css/datepicker.css' );

		$input = form_input( array(
					'name'	=> $name,
					'type'	=> 'text',
					'id'	=> $id,
					'class'	=> $class.' bs-datepicker' ), set_value( $name, $std ), $attr);

		if ( $is_subfield == FALSE )
		{
			return $this->_form_common(	$name, $label, $input, $id, $desc, $validation );
		}
		else
		{
			return $input;
		}
	}

	private function _form_radiocheckbox( $name, $label, $options, $std = '', $id = '', $type = '', $desc = '', $validation = '' )
	{
		$type	= ($type == 'checkbox' ? $type : 'radio');
		$input	= '';

		$field = ( $type == 'checkbox' ? $name.'[]' : $name );

		foreach( $options as $value => $option )
		{
			if ( is_array($std) )
			{
				$actived = (in_array($value, $std) ? TRUE : FALSE);
			}
			else if ( is_string($std) )
			{
				$actived = ($std == $value ? TRUE : FALSE);
			}

			$set_func	= 'set_'.$type;
			$form_func	= 'form_'.$type;

			$input .= '<div class="'.$type.'"><label>';
			$input .= $form_func( $field, $value, $set_func( $name, $value, $actived ) ).' '.$option;
			$input .= '</label></div>';
		}

		return $this->_form_common(	$name, $label, $input, $id, $desc, $validation );
	}

	private function _form_selectbox( $name, $label, $std, $option, $id = '', $type = '', $attr = '', $desc = '', $validation = '' )
	{
		$type	= ($type == 'dropdown' ? $type : 'multiselect');
		$attr	= 'class="form-control input-sm" id="input_'.$name.'" '.$attr;

		return $this->_form_common(	$name, $label, call_user_func_array('form_'.$type, array($name, $option, set_select($name, $std), $attr)), $id, $desc, $validation );
	}

	private function _form_captcha( $name, $label, $id = '', $class = '', $desc = '', $validation = '' )
	{
		$id = ( $id !== '' ? $id : $name );
		$captcha_url = base_url().get_app_config('cool_captcha_folder').'captcha'.EXT;

		$captcha = img( array(
			'src'	=> $captcha_url,
			'alt'	=> 'Cool captcha image',
			'id'	=> 'cool-captcha-'.$name.'-img',
			'class'	=> 'img',
			'width'	=> '200',
			'height'=> '70',
			'rel'	=> 'cool-captcha',
			));

		$captcha .= anchor( current_url().'#', 'Ganti teks', array(
			'class'	=> 'small',
			'class'	=> 'change-image',
			'onclick'=> "$(function() { $('#cool-captcha-".$name."-img').attr('src', '".$captcha_url."?'+Math.random());\n$('#cool-captcha-".$name."-input').focus();\nreturn false;})"));

		$captcha .= form_input( array(
			'name'	=> $name,
			'type'	=> 'text',
			'id'	=> 'cool-captcha-'.$id.'-input',
			'class'	=> $class,
			'value'	=> set_value( $name, '' ) ));

		return $this->_form_common(	$name, $label, $captcha, $id, $desc, $validation );
	}

	private function _form_subfield( $name, $label, $id = '', $fields = array(), $desc = '', $attr = '' )
	{
		$id = $id != '' ? $id : $name;
		$field_col	= '<div id="subfield-'.str_replace('_', '-', $id).'" class="row">';
		$errors		= array();
		$input_classes	= 'form-control input-sm';
		
		if ( count($fields) == 0)
		{
			log_message('debug', '#Baka_form: Field '.$name.' has no subfield');
			return FALSE;
		}

		foreach ( $fields as $field )
		{
			$field_col .= '<div class="col-md-'.$field['col'].'">';
			$validation = '';

			if (isset($field['validation']) AND $field['validation'] != '')
			{
				if (strpos('required', $field['validation']) !== FALSE)
					$field['label'] .= ' *';

				$validation = $field['validation'];
			}

			$field['name']	= $name.'_'.$field['name'];
			$field['id']	= str_replace('_', '-', 'input-'.$field['name']);

			$field['attr'] = ( isset($field['attr']) ? $field['attr'] : $attr );

			switch( $field['type'] )
			{
				case 'date':
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
						'id'	=> $field['id'],
						'placeholder' => $field['label'],
						'class'	=> $input_classes ) , set_value( $field['name'], $field['std'] ), $field['attr']);
					break;

				case 'datepicker':
					$field_col .= $this->_form_datepicker(
						$field['name'], $field['label'], $field['std'], $field['id'], $input_classes, '', $field['validation'], $field['attr'], TRUE );
					break;

				case 'static':
					$field_col .= '<p id="'.$field['id'].'" class="form-control-static input-sm">'.$field['std'].'</p>';
					break;

				case 'multiselect':
				case 'dropdown':
					$type	= ($field['type'] == 'dropdown' ? $field['type'] : 'multiselect');
					$attr	= 'class="form-control input-sm" id="'.$field['id'].'" placeholder="'.$field['label'].'" '.$field['attr'];
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
					log_message('debug', '#Baka_form: '.$field['type'].' Subfield type are not supported currently');
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

	private function _form_common( $name, $label, $input, $id = '', $desc = '', $validation = '' )
	{
		$group		= 'form-group';
		$is_error	= (!is_array($desc) ? form_error($name, '<span class="help-block">', '</span>') : FALSE);
		
		if ($validation != '')
		{
			if (FALSE !== strpos($validation, 'required'))
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
			$output .= '	'.form_label( $label, $id, array('class'=> $label_col.'control-label') );
	
		$output .= '	<div class="'.$input_col.'">'.$input.$is_error;
		
		if ( !is_array($desc) AND $desc != '' )
			$output .= '<span class="help-block">'.$desc.'</span>';

		if ( is_array($desc) AND count($desc) > 0 )
			foreach ($desc as $keterangan)
				$output .= '<span class="help-block">'.$keterangan.'</span>';

		$output .= '</div></div>';

		return $output;
	}

	private function _form_actions()
	{
		if ( count($this->buttons) == 0 )
		{
			$this->buttons = array(
				array(
					'name'	=> 'submit',
					'type'	=> 'submit',
					'label'	=> 'submit_btn',
					'class'	=> 'pull-left btn-primary'
					),
				array(
					'name'	=> 'reset',
					'type'	=> 'reset',
					'label'	=> 'reset_btn',
					'class'	=> 'pull-right btn-default'
					)
				);
		}

		$group_col = (strpos('form-horizontal', $this->form_attrs['class']) !== FALSE ? 'col-lg-12 col-md-12 ' : '' );
		$output = '<div class="form-group form-action"><div class="'.$group_col.'clearfix">';

		$button_attr = array();

		foreach ($this->buttons as $attr)
		{
			$button_attr['name']	= $this->form_attrs['id'].'-'.$attr['name'];
			$button_attr['id']		= (isset($attr['id']) ? $attr['id'] : $button_attr['name']).'-btn';
			$button_attr['class']	= 'btn btn-sm'.( isset($attr['class']) ? ' '.$attr['class'] : '');

			switch ($attr['type']) {
				case 'submit':
				case 'reset':
					$func = 'form_'.$attr['type'];
					$button_attr['value'] = _x( $attr['label'] );

					$output .= $func( $button_attr );
					break;

				case 'button':
					$button_attr['content'] = _x( $attr['label'] );
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

	public function validate_submition()
	{
		foreach ($this->fields as $field)
		{
			if ( $field['type'] == 'subfield' )
			{
				foreach ( $field['fields'] as $subfield )
				{
					$this->set_field_rules(
						$field['name'].'_'.$subfield['name'],									// Subfield Name
						$subfield['label'],														// Subfield Label
						$subfield['type'],
						(isset($subfield['validation'])	? $subfield['validation']	: ''),		// Subfield Validation	(jika ada)
						(isset($subfield['callback'])	? $subfield['callback']		: '') );	// Subfield Callback	(jika ada)
				}
			}
			else if ( $field['type'] != 'static' AND $field['type'] != 'fieldset' )
			{
				$this->set_field_rules(
					$field['name'],														// Field Name
					$field['label'],													// Field Label
					$field['type'],
					(isset($field['validation'])	? $field['validation']	: ''),		// Field Validation	(jika ada)
					(isset($field['callback'])		? $field['callback']	: '') );	// Field Callback	(jika ada)
			}
		}

		return $this->form_validation->run();
	}

	public function validation_errors()
	{
		return validation_errors();
	}

	protected function set_field_rules( $field_name, $field_label, $field_type, $validation_rules = '', $callback = '' )
	{
		$array_field	= ( $field_type == 'checkbox' OR $field_type == 'multiselect' ? TRUE : FALSE );

		$validation		= ( $array_field ? 'xss_clean|' : 'trim|xss_clean|' );

		if ( strlen($validation_rules) > 0 )
			$validation .= $validation_rules;

		$this->form_validation->set_rules( $field_name, $field_label, $validation);

		if ( strlen($callback) > 0 AND is_callable($callback))
			$this->form_data[$field_name] = call_user_func( $callback, $this->input->post($field_name) );
		else
			$this->form_data[$field_name] = $this->input->post( $field_name );
	}

	public function submited_data()
	{
		return $this->form_data;
	}
}

/* End of file Baka_form.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_form.php */