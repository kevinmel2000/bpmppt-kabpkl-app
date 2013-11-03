<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_lang_code( $uppercase = FALSE )
{
	$CI_config =& get_instance()->config;

	$output = array_search($CI_config->item('language'), $CI_config->item('language_codes'));

	return ($uppercase == TRUE) ? strtoupper($output) : $output ;
}

function get_charset( $uppercase = FALSE )
{
	$CI_config =& get_instance()->config;

	$output = $CI_config->item('charset');

	return ($uppercase == TRUE) ? strtoupper($output) : strtolower($output) ;
}

function is_browser_jadul()
{
	$CI =& get_instance();
	return $CI->baka_theme->is_browser_jadul();
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
		print_pre( $anu );
	else
		echo $anu;
}

/* End of file baka_common_helper.php */
/* Location: ./application/helpers/baka_common_helper.php */