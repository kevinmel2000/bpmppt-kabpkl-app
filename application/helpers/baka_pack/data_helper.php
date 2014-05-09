<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 * 
 * NOTICE OF LICENSE
 * 
 * Licensed under the Open Software License version 3.0
 * 
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Baka_pack
 * @subpackage  Data
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
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
	$bool = (bool) $bool;
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