<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function _x( $lang_line, $default = '' )
{
	$CI_lang =& get_instance()->lang;

	if ($default == '')
		$default = $lang_line;

	return $CI_lang->line( $lang_line ) ? $CI_lang->line( $lang_line ) : $default ;
}