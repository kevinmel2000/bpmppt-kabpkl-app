<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function get_counter_text( $count = NULL )
{
	if ( (int) $count > 0 )
	{
		$limit = get_app_setting('app_data_show_limit');

		if ( $count >= $limit )
			return 'Menampilkan '.$limit.' data dari total '.$count.' data keseluruhan';
		else
			return 'Menampilkan '.$count.' dari keseluruhan data';
	}
	else
		return 'Belum ada data';
}

function pagination( $page_link, $data_count )
{
	$ci =& get_instance();
	$ci->load->library('pagination');

	$ci->pagination->initialize( array(
		'base_url'			=> $page_link,
		'total_rows'		=> $data_count,
		'per_page'			=> get_app_setting('app_data_show_limit'),
		'uri_segment'		=> 4,
		'num_links'			=> 3,
		'full_tag_open'		=> '<ul class="pagination pagination-sm pull-right">',
		'full_tag_close'	=> '</ul>',
		'first_link'		=> 'First',
		'first_tag_open'	=> '<li>',
		'first_tag_close'	=> '<li>',
		'last_link'			=> 'Last',
		'last_tag_open'		=> '<li>',
		'last_tag_close'	=> '<li>',
		'next_link'			=> 'Next',
		'next_tag_open'		=> '<li>',
		'next_tag_close'	=> '<li>',
		'prev_link'			=> 'Prev',
		'prev_tag_open'		=> '<li>',
		'prev_tag_close'	=> '<li>',
		'cur_tag_open'		=> '<li class="active"><span>',
		'cur_tag_close'		=> '</span><li>',
		'num_tag_open'		=> '<li>',
		'num_tag_close'		=> '<li>',
		) ); 

	return $ci->pagination->create_links();
}


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