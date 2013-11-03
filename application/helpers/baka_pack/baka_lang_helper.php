<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function _x( $lang_line, $replacement = '' )
{
	$CI_lang =& get_instance()->lang;

	$lang_line = ( $CI_lang->line( $lang_line ) ? $CI_lang->line( $lang_line ) : $lang_line );

	return ( $replacement != '' ? sprintf( $lang_line, $replacement) : $lang_line );
}