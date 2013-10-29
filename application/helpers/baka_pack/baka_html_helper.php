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

/**
 * Baka Head
 * 
 * Load All contents for head section, like CSS & JS files
 * @return	String	Meybe ;P
 */
function baka_head()
{
	$stylesheets = Baka_theme::get('styles');

	if( !empty( $stylesheets ) )
	{
		echo "<!-- Start CSS -->\n";
		foreach ( $stylesheets as $style )
		{
			echo $style;
		}
		echo "<!-- End CSS -->\n";
	}
	
	$javascripts = Baka_theme::get('scripts');

	if( !empty( $javascripts['head'] ) )
	{
		echo "<!-- JS Head Start -->\n";
		foreach ( $javascripts['head'] as $script )
		{
			echo $script;
		}
		echo "<!-- JS Head End -->\n";
	}
}

function baka_foot()
{
	$javascripts = Baka_theme::get('scripts');
	
	if( !empty( $javascripts['foot'] ) )
	{
		echo "<!-- JS Foot Start -->\n";
		foreach ( $javascripts['foot'] as $script )
		{
			echo $script;
		}
		echo "<!-- JS Foot End -->\n";
	}
}


/* End of file assets_helper.php */
/* Location: ./application/helpers/aplikasi/assets_helper.php */