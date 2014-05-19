<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     CodeIgniter Baka Pack
 * @subpackage  Form
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

function set_toolbar( $tool_buttons, $page_link )
{
	if ( count($tool_buttons) == 0 )
		return FALSE;

	$btn_class	= 'btn '; 
	$output		= '<div class="btn-toolbar">';

	foreach ( $tool_buttons as $url => $label )
	{
		$output	.= '<div class="btn-group">';
		
		if ( is_array($label) )
		{
			$s_btn		= explode('|', $url);
			$dropdown	= ( strpos($s_btn[0], ':dd') !== FALSE ? TRUE : FALSE );

			if ( $dropdown )
			{
				$output .= '<button type="button" class="'.$btn_class.( isset($s_btn[1]) ? 'btn-'.$s_btn[1] : '' ).' dropdown-toggle" data-toggle="dropdown">'.str_replace(':dd', '', $s_btn[0]).' <span class="caret"></span></button>';
				$output .= '<ul class="dropdown-menu" role="menu">';
			}

			foreach ( $label as $l_url => $l_label )
			{
				$l_attr = '';

				if ( strpos($l_label, '&') !== FALSE )
				{
					$l_tmp = explode('&', $l_label);

					$l_label = $l_tmp[0];

					$l_attr = _parse_data_attr( $l_tmp[1] );
				}

				$item_id = 'toolbar-btn-'.str_replace(' ', '-', strtolower($l_label));
				$item = anchor( $page_link.$l_url, $l_label,
					'id="'.$item_id.'" class="'.( $dropdown ? '' : $btn_class.( isset($s_btn[1]) ? 'btn-'.$s_btn[1] : '' ) ).'" '.$l_attr );
				
				$output	.= ( $dropdown ? '<li>'.$item.'</li>' : $item );
			}

			if ( $dropdown )
				$output .= '</ul>';
		}
		else
		{
			$button	 = explode('|', $label);
			$output	.= anchor( $page_link.$url, $button[0], 'id="toolbar-btn-'.str_replace(' ', '-', strtolower($button[0])).'" class="'.$btn_class.( isset($button[1]) ? 'btn-'.$button[1] : '' ).'"' );
		}

		$output	.= '</div>';
	}
	
	$output	.= '</div>';

	return $output;
}

function _parse_data_attr( $string )
{
	$output = '';

	if ( strpos($string, ',') !== FALSE )
	{
		foreach ( explode(',', $string) as $data )
		{
			$output .= _parse_data_attr( $data );
		}
	}
	else
	{
		$output .= ' data-'.$string;
	}

	return $output;
}

function form_search( $target )
{
	$output  = form_open( $target, array('name'=>'search-bar', 'method'=>'get'));
	$output .= '<div class="input-group input-group-sm">';
	$output .= form_input(array('name'=>'search', 'id'=>'search', 'value'=>set_value('search'), 'class'=>'form-control', 'type'=>'search'));
	$output .= '<span class="input-group-btn">'.form_submit(array('id'=>'s','class'=>'btn btn-default', 'value'=>'Cari')).'</span>';
	$output .= '</div><!-- /input-group -->';
	$output .= form_close();

	return $output;
}

function form_alert()
{
	$ci =& get_instance();

	$messages	= array();
	$class		= 'warning';

	if ( $messages	= $ci->session->flashdata('message') )
	{
		$class = 'warning';
	}
	else if ( $messages	= $ci->session->flashdata('success') )
	{
		$class = 'success';
	}
	else if ( $messages	= $ci->session->flashdata('info') )
	{
		$class = 'info';
	}
	else if ( $messages	= $ci->session->flashdata('error') )
	{
		$class = 'danger';
	}

	$output = '';

	$dismiss = '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>';

	if ( is_array( $messages ) AND count( $messages ) > 0 )
	{
		$output .= '<div class="alert alert-'.$class.'">'.$dismiss.'<ul>';
		
		foreach ( $messages as $message )
		{
			$output .= '<li>'.$message.'</li>';
		}

		$output .= '</ul></div>';
	}
	else if ( is_string( $messages ) AND strlen( $messages ) > 0 )
	{
		$output = '<div class="alert alert-'.$class.'">'.$dismiss.'<p>'.$messages.'</p></div>';
	}

	return $output;
}

function form_persyaratan( $caption, $persyaratan = array(), $syarats = '' )
{
	$values = $syarats != '' ? unserialize($syarats) : array();

	if (is_array($persyaratan) && count($persyaratan) > 0)
	{
		$output  = form_fieldset($caption);
		$output .= "<div id=\"control_input_syarat_pengajuan\" class=\"control-group\">\n\t";
		$output .= form_hidden( 'total_syarat', count($persyaratan));
		$output .= form_label( 'Persyaratan', 'input_syarat_pengajuan', array('class'=>'control-label'));
		$output .= "\n\t<div class=\"controls\">";

		foreach ($persyaratan as $id => $syarat)
		{
			$output .= form_label( form_checkbox(array('name'=>'surat_syarat[]','id'=>'input_syarat_'.$id,'value'=>$id,'checked'=>in_array($id, $values))).' '.$syarat, 'input_syarat_'.$id, array('class'=>'checkbox'));
		}

		$output .= "\n\t</div>\n</div>";
		$output .= form_fieldset_close();

		return $output;
	}
}

/* End of file former_helper.php */
/* Location: ./application/helpers/baka_pack/former_helper.php */