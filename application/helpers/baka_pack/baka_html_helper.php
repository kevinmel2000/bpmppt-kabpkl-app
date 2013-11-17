<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

/**
 * Baka Title
 * @return	String
 */
function get_site_title()
{
	$baka_theme =& get_instance()->baka_theme;

	return $baka_theme->get('site_title');
}

/**
 * Body Class
 * @return	String
 */
function get_body_class()
{
	$baka_theme =& get_instance()->baka_theme;

	return $baka_theme->get('body_class');
}

/**
 * Body Class
 * @return	String
 */
function get_page_title()
{
	$baka_theme =& get_instance()->baka_theme;

	return $baka_theme->get('page_title');
}

/**
 * Body Class
 * @return	String
 */
function get_navbar()
{
	$baka_theme =& get_instance()->baka_theme;

	return $baka_theme->get_navbar();
}

function get_nav( $position )
{
	$baka_theme =& get_instance()->baka_theme;

	return $baka_theme->get_nav( $position );
}

function add_script( $id, $source, $depend = '' , $version = NULL )
{
	$CI_theme =& get_instance()->baka_theme;
	
	return $CI_theme->add_script( $id, $source, $depend = '', $version = NULL);
}

function add_style( $id, $source, $depend = '' , $version = NULL )
{
	$CI_theme =& get_instance()->baka_theme;
	
	return $CI_theme->add_style( $id, $source, $depend = '', $version = NULL);
}

function get_foot()
{
	$CI_theme =& get_instance()->baka_theme;
	
	return $CI_theme->load_scripts();
}

function load_styles()
{
	$CI_theme =& get_instance()->baka_theme;
	
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

function is_browser_jadul()
{
	$CI =& get_instance();
	return $CI->baka_theme->is_browser_jadul();
}


/* End of file assets_helper.php */
/* Location: ./application/helpers/aplikasi/assets_helper.php */