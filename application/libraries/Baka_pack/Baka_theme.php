<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BAKA Theme Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Theme
 * @author		Fery Wardiyanto (http://github.com/feryardiant/)
 */
class Baka_theme Extends Baka_lib
{
	private $_app_name;

	protected $_theme_data = array();

	protected $_contents = array();

	public $_scripts = array();

	public function __construct()
	{
		$this->_app_name = $this->config_item('app_name');

		$this->_theme_data['page_title'] = $this->_app_name;
		$this->_theme_data['site_title'] = $this->_app_name;
		$this->_theme_data['body_class'] = 'page';

		$this->add_script('jquery', 'asset/vendor/jquery/jquery.min.js', '', '1.9');
		$this->add_script('bootstrap', 'asset/vendor/bootstrap/js/bootstrap.min.js', 'jquery', '3.0.0');

		log_message('debug', "#Baka_pack: Theme Class Initialized");
	}

	private function _caching()
	{
		switch (ENVIRONMENT)
		{
			case 'development':
				// noting :P
			break;
		
			case 'testing':
			case 'production':
				// Disable sodding IE7's constant cacheing!!
				$this->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
				$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
				$this->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
				$this->output->set_header('Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).' GMT' );
				$this->output->set_header('Pragma: no-cache');

				// Let CI do the caching instead of the browser
				$this->output->cache( $this->config_item('cache_lifetime') );

				log_message('debug', "#Baka_theme: cache activated");
			break;
		}
	}
	
	public function is_browser_jadul()
	{
		if ( ! $this->load->is_loaded('user_agent'))
			$this->load->library('user_agent');

		$min_browser	= $this->config_item('app_min_browser');
		$curent_version	= explode('.', $this->agent->version());

		return ($curent_version[0] <= $min_browser[$this->agent->browser()] ? TRUE : FALSE  );
	}
	
	/**
	 * Menetapkan judul halaman
	 * 
	 * @param string $the_title Judul halaman
	 */
	public function set_title( $the_title )
	{
		// Setup page title
		$this->_theme_data['page_title'] = $the_title;
		// setup site title
		$this->_theme_data['site_title'] .= ' - '.$the_title;
		// setup body classes and ids
		$body_class = url_title( $the_title, '-', TRUE );
		$this->_theme_data['body_class'] .= 'id="page-'.$body_class.'" class="page page-'.$body_class.'"';

		return $the_title;
	}

	public function add_navbar( $id, $class = '', $position = 'top' )
	{
		$class .= ' nav';

		$this->_theme_data['navbar'][$position][$id] = array(
			'class'	=> $class );
	}

	public function add_navmenu( $parent_id, $menu_id, $type = 'link', $url = '', $label = '', $attr = array(), $position = 'top' )
	{
		if (is_array($menu_id))
		{
			foreach ($menu_id as $key => $value)
			{
				$this->add_navmenu($parent_id, $key, $value['url'], $value['label'], $value['type'], $value['attr'], $value['position']);
			}
		}
		else
		{
			$url = ($url === '') ? current_url().'#' : $url;

			$id = $parent_id.'-'.$menu_id;

			switch ($type) {
				case 'header':
					$menus = array(
						'type'	=> $type,
						'label'	=> $label,
						);
					break;
				
				case 'devider':
					$menus = array(
						'type'	=> $type,
						);
					break;
				
				case 'link':
				default:
					$menus = array(
						'name'	=> $menu_id,
						'type'	=> $type,
						'url'	=> $url,
						'label'	=> $label,
						'attr'	=> $attr,
						);
					break;
			}

			if (!array_key_exists($parent_id, $this->_theme_data['navbar'][$position]))
			{
				$parent = explode('-', $parent_id);

				$this->_theme_data['navbar'][$position][${'parent'}[0]]['items'][$parent_id]['child'][$parent_id.'_sub']['class'] = 'dropdown-menu';
				$this->_theme_data['navbar'][$position][${'parent'}[0]]['items'][$parent_id]['child'][$parent_id.'_sub']['items'][$id] = $menus;
			}
			else
			{
				$this->_theme_data['navbar'][$position][$parent_id]['items'][$id] = $menus;
			}
		}
	}

	public function get_nav( $position )
	{
		if ( isset($this->_theme_data['navbar'][$position]) )
			return $this->make_menu( $this->_theme_data['navbar'][$position] );
		else
			log_message('error', '#Baka_theme: '.$position." navbar doesn't exists.");
	}

	public function get_navbar()
	{
		$output  = '<header id="top" class="navbar navbar-default navbar-app navbar-static-top" role="banner">'
				 . '	<div class="container">'
				 . '		<div class="navbar-header">'
				 . '			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>'
				 . '			'.anchor(base_url(), $this->config_item('app_name'), 'class="navbar-brand"')
				 . '		</div>';

		if (!is_browser_jadul() AND $this->baka_auth->is_logged_in())
			$output .= '<div class="navbar-collapse collapse">'.$this->get_nav('top').'</div> <!--/.nav-collapse -->';

		$output .=  '</div></header>';

		return $output;
	}

	/**
	 * creating menu on sidebar
	 * 
	 * @param  array  $links menu link list
	 * @param  string $name  menu name
	 * @param  string $class menu class
	 * @return mixed
	 */
	public function make_menu( $menu_array, $list_class = '' )
	{
		$output = '';

		foreach ($menu_array as $list_id => $list_item)
		{
			$class = isset($list_item['class']) ? $list_item['class'] : $list_class;

			$output .= '<ul id="'.$list_id.'" role="menu" class="'.$class.'">';

			foreach ($list_item['items'] as $menu_id => $menu_item)
			{
				$menu_class = '';
				
				switch ($menu_item['type'])
				{
					case 'header':
						$output .= '<li role="presentation" id="'.$menu_id.'" class="dropdown-header '.$menu_class.'">'.$menu_item['label'];
						break;
					case 'devider':
						$output .= '<li role="presentation" id="'.$menu_id.'" class="nav-divider '.$menu_class.'">';
						break;
					case 'link':
					default:
						if ($has_child = array_key_exists('child', $menu_item))
							$menu_class .= ' dropdown';

						if (strpos(current_url(), site_url($menu_item['url'])) !== FALSE)
							$menu_class .= ' active';

						$output .= '<li role="presentation" id="'.$menu_id.'" '.($menu_class != '' ? 'class="'.$menu_class.'"' : '').'>';

						$menu_item['attr']	= array_merge($menu_item['attr'], array('role'=>'menuitem', 'tabindex'=>'-1'));
						
						if ($has_child === TRUE)
						{
							$menu_item['label'] .= ' <b class="caret"></b>';
							$menu_item['attr']	= array_merge($menu_item['attr'], array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'));
						}

						$output .= anchor($menu_item['url'], '<span class="menu-text">'.$menu_item['label'].'</span>', $menu_item['attr']);

						if ($has_child === TRUE)
							$output .= $this->make_menu( $menu_item['child'], 'dropdown-menu' );

						break;
				}
				
				$output .= '</li>';
			}

			$output .= '</ul>';
		}

		return $output;
	}

	public function add_script( $id, $source, $depend = '', $version = NULL )
	{
		$source = $source.'?ver='.($version != '' ? $version : get_app_option('app_version'));

		if ( array_key_exists($depend, $this->_scripts) )
		{
			$this->_scripts = array_insert_after_node( $this->_scripts, $depend, $id, $source );
		}
		else
		{
			$this->_scripts[$id] = $source;
		}
	}

	public function load_scripts()
	{
		$output = '';
		$attr	= 'type="text/javascript" charset="'.get_charset().'"';

		foreach ( $this->_scripts as $id => $src )
		{
			$output .= "<script $attr id=\"$id\"";

			if (strpos($src, '://') !== FALSE)
			{
				$output .= " src=\"$src\">";
			}
			else
			{
				$script = base_url().$src;
				$output .= filter_var( $script, FILTER_VALIDATE_URL) ?
					" src=\"$script\">" :
					">\n$src";
			}

			$output .= "</script>\n\t";
		}

		return $output;
	}

	public function get( $name )
	{
		if ( array_key_exists($name, $this->_theme_data) )
			return $this->_theme_data[$name];
		else
			log_message('error', "#Baka_theme: Theme data ".$name." doesn't exists.");
	}

	public function set($name, $value)
	{
		$this->_contents[$name] = $value;
	}

	public function load($view = '' , $view_data = array(), $file = '', $return = FALSE)
	{
		$file || $file = 'index';

		$this->set('contents', $this->load->view( $view, $view_data, TRUE));

		log_message('debug', "#Baka_theme: File ".$file." loaded as view.");

		return $this->load->view( $file, $this->_contents, $return );
	}
}

/* End of file Baka_theme.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_theme.php */