<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function add_placeholder( $array, $placeholder = '---', $langify = FALSE )
{
	$output[''] = $placeholder;

	foreach( $array as $key => $value )
	{
		$output[$key] = ( $langify ? _x( $value ) : $value );
	}

	return $output;
}

function get_month_assoc()
{
	$CI =& get_instance();
	$CI->load->language('calendar');
	
	$output = array();

	for ( $i=1; $i<=12; $i++ )
	{
		$month = date('F', mktime(0, 0, 0, $i, 1));
		$output[$i] = _x( 'cal_'.strtolower($month) );
	}

	return $output;
}

function get_year_assoc( $interfal = 10 )
{
	$output = array();

	for ( $i=0; $i<=$interfal; $i++ )
	{
		$output[$i] = ($i === 0) ? date('Y') : date('Y', mktime(0, 0, 0, $i, 1, date('Y')-$i));
	}

	return $output;
}

function bool_to_str( $bool, $true = 'TRUE', $false = '' )
{
	return (bool) $bool ? $true : $false;
}

/* End of file app_data_helper.php */
/* Location: ./application/helpers/app/app_data_helper.php */