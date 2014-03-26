<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter core library that used on all of my projects
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
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Load template content
 * @param  string $file template content name
 * @return mixed        default CI view
 */
function load_view( $file )
{
	$CI_load =& get_instance()->load;

	return $CI_load->view( $file );
}

// -----------------------------------------------------------------------------

/**
 * Baka Title
 * @return	String
 */
function get_site_title()
{
	$themee =& get_instance()->themee;

	return $themee->get('site_title');
}

// -----------------------------------------------------------------------------

/**
 * Body Class
 * @return	String
 */
function get_body_class()
{
	$themee =& get_instance()->themee;

	return $themee->get('body_class');
}

// -----------------------------------------------------------------------------

/**
 * Body Class
 * @return	String
 */
function get_page_title()
{
	$themee =& get_instance()->themee;

	return $themee->get('page_title');
}

// -----------------------------------------------------------------------------

/**
 * Body Class
 * @return	String
 */
function get_navbar()
{
	$themee =& get_instance()->themee;

	return $themee->get_navbar();
}

function get_nav( $position )
{
	$themee =& get_instance()->themee;

	return $themee->get_nav( $position );
}

function add_script( $id, $source, $depend = '' , $version = NULL )
{
	$CI_theme =& get_instance()->themee;
	
	return $CI_theme->add_script( $id, $source, $depend = '', $version = NULL);
}

function add_style( $id, $source, $depend = '' , $version = NULL )
{
	$CI_theme =& get_instance()->themee;
	
	return $CI_theme->add_style( $id, $source, $depend = '', $version = NULL);
}

function get_foot()
{
	$CI_theme =& get_instance()->themee;
	
	return $CI_theme->load_scripts();
}

function load_styles()
{
	$CI_theme =& get_instance()->themee;
	
	return "<!-- Additional Stylesheets -->\n".$CI_theme->load_styles();
}

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

/* End of file html_helper.php */
/* Location: ./application/helpers/baka_pack/html_helper.php */