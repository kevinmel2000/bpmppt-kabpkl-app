<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function _x( $lang_line, $replacement = '' )
{
	$CI_lang =& get_instance()->lang;

	$lang_line = ( $CI_lang->line( $lang_line ) ? $CI_lang->line( $lang_line ) : $lang_line );

	return ( $replacement != '' ? sprintf( $lang_line, $replacement) : $lang_line );
}

function return_bytes($val)
{
	$val	= trim($val);
	$last	= strtolower($val[strlen($val)-1]);

	switch($last) {
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	}

	return $val;
}

function format_size( $size )
{
	$sizes = Array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
	$y = $sizes[0];

	for ($i = 1; (($i < count($sizes)) && ($size >= 1024)); $i++)  {
		$size = $size / 1024;
		$y  = $sizes[$i];
	}
	return round($size, 2).' <span class="muted">'.$y.'</span>';
}

function format_date( $string = '' )
{
	$string = $string != '' ? strtotime( $string ) : time();

	return date( get_app_setting('app_date_format'), $string);
}

function format_datetime( $string = '' )
{
	$string = $string != '' ? strtotime( $string ) : time();

	return date( get_app_setting('app_datetime_format'), $string);
}

function string_to_date( $string = '' )
{
	$string = $string != '' ? strtotime( $string ) : time();

	return date( 'Y-m-d', $string);
}

function string_to_datetime( $string = '' )
{
	$string = $string != '' ? strtotime( $string ) : time();

	return date( 'Y-m-d H:i:s', $string);
}

function baka_get_umur( $lahir, $sampai = '' )
{
	$tgllahir = strtotime($lahir);
	$sekarang = ($sampai == '') ? time() : strtotime($sampai) ;

	$umur = ($tgllahir < 0) ? ( $sekarang + ($tgllahir * -1) ) : $sekarang - $tgllahir; 

	$tahun = 60 * 60 * 24 * 365;

	$tahunlahir = $umur / $tahun;

	return floor($tahunlahir);
}

function second_to_day( $second )
{
	return $second / 60 / 60 / 24;
}

function baka_echo( $anu )
{
	if ( is_array( $anu ) OR is_object( $anu ) )
		var_dump( $anu );
		// print_pre( $anu );
	else
		echo $anu;
}

/** --------------------------------------------------------------------
 * Twitter Bootstrap helper
 *
 * Just another simplify to use twbs
 * --------------------------------------------------------------------- */

/**
 * TWBS Label
 * @param  string
 * @param  string
 * @param  string
 * @return string
 */
function twb_label( $text, $class = 'default', $tag = 'span' )
{
	return '<'.$tag.' class="label label-'.$class.'">'.$text.'</'.$tag.'>';
}

/**
 * TWBS Badge
 * @param  string
 * @param  string
 * @return string
 */
function twb_badge( $text, $tag = 'span' )
{
	return '<'.$tag.' class="badge">'.$text.'</'.$tag.'>';
}

/**
 * TWBS Text
 * @param  string
 * @param  string
 * @param  string
 * @return string
 */
function twb_text( $text, $class = '', $tag = 'span' )
{
	return '<'.$tag.' class="text-'.$class.'">'.$text.'</'.$tag.'>';
}

function make_tag( $texts, $limit = 10 )
{
	$out = '';
	$i = 0;

	foreach ( explode(',', $texts) as $text )
	{
		$out .= twb_label( $text, 'info' ).' ';

		if (++$i == $limit) break;
	}

	return $out;
}

/* End of file baka_common_helper.php */
/* Location: ./application/helpers/baka_common_helper.php */