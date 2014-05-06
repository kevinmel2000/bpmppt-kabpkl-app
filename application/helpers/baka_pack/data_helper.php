<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Everyone is permitted to copy and distribute verbatim or modified 
 * copies of this license document, and changing it is allowed as long 
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE 
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION 
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://www.wtfpl.net
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

function add_placeholder( $array, $placeholder = '---', $langify = FALSE )
{
	$output[''] = $placeholder;

	foreach( $array as $key => $value )
	{
		$output[$key] = ( $langify ? _x( $value ) : $value );
	}

	return $output;
}

// -----------------------------------------------------------------------------

/**
 * Convert Boolean to String
 *
 * @param   bool    $bool  Variable that you want to convert
 * @param   bool    $uc    Are you want return it uppercased
 *
 * @return  string
 */
function bool_to_str( $bool, $uc = FALSE )
{
	$ret = $bool ? 'ya' : 'tidak';

	return $uc ? strtoupper( $ret ) : $ret;
}

// -----------------------------------------------------------------------------

/**
 * Convert Boolean to Integer
 *
 * @param   bool    $bool  Variable that you want to convert
 *
 * @return  string
 */
function bool_to_int( $bool )
{
	return $bool ? 1 : 0;
}

/* End of file data_helper.php */
/* Location: ./application/helpers/baka_pack/data_helper.php */