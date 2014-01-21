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
 * BAKA Theme Class
 *
 * @subpackage  Libraries
 * @category    Theme
 */
class Themee
{
    /**
     * Codeigniter superobject
     *
     * @var  mixed
     */
    protected static $_ci;

    private $_app_name;

    private $_theme_data    = array();

    private $_contents      = array();

    public $_scripts        = array();
    
    public $_styles         = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        self::$_ci =& get_instance();

        self::$_ci->load->library('user_agent');

        $this->_app_name = get_conf('app_name');

        $this->_theme_data['page_title'] = $this->_app_name;
        $this->_theme_data['site_title'] = $this->_app_name;
        $this->_theme_data['body_class'] = 'page';

        $this->add_script('jquery', 'asset/js/lib/jquery.min.js', '', '2.0.3');
        $this->add_script('baka_pack', 'asset/js/script.js', 'jquery' );
        $this->add_script('bootstrap', 'asset/vendor/bootstrap/js/bootstrap.min.js', 'jquery', '3.0.0' );
        $this->add_style( 'bootstrap', 'asset/vendor/bootstrap/css/bootstrap.min.css', '', '3.0.0' );
        $this->add_style( 'baka_pack', 'asset/css/style.css' );

        log_message('debug', "#Baka_pack: Theme Class Initialized");
    }

    // -------------------------------------------------------------------------

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
                $this->output->cache( get_conf('cache_lifetime') );

                log_message('debug', "#Baka_pack: cache activated");
            break;
        }
    }

    // -------------------------------------------------------------------------
    
    public static function verify_browser()
    {
        $min_browser    = get_conf('app_min_browser');
        $curent_version = explode('.', self::$_ci->agent->version());

        return ( $curent_version[0] <= $min_browser[self::$_ci->agent->browser()] ? TRUE : FALSE  );
    }

    // -------------------------------------------------------------------------
    
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

    // -------------------------------------------------------------------------

    public function add_navbar( $id, $class = '', $position = 'top' )
    {
        $class .= ' nav';

        $this->_theme_data['navbar'][$position][$id] = array(
            'class' => $class );
    }

    // -------------------------------------------------------------------------

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
                        'type'  => $type,
                        'label' => $label,
                        );
                    break;
                
                case 'devider':
                    $menus = array(
                        'type'  => $type,
                        );
                    break;
                
                case 'link':
                default:
                    $menus = array(
                        'name'  => $menu_id,
                        'type'  => $type,
                        'url'   => $url,
                        'label' => $label,
                        'attr'  => $attr,
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

    // -------------------------------------------------------------------------

    public function get_nav( $position )
    {
        if ( isset($this->_theme_data['navbar'][$position]) )
            return $this->make_menu( $this->_theme_data['navbar'][$position] );
        else
            log_message('error', '#Themee: '.$position." navbar doesn't exists.");
    }

    // -------------------------------------------------------------------------

    public function get_navbar()
    {
        $output  = '<header id="top" class="navbar navbar-default navbar-app navbar-static-top" role="banner">'
                 . '    <div class="container">'
                 . '        <div class="navbar-header">'
                 . '            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>'
                 . '            '.anchor(base_url(), get_conf('app_name'), 'class="navbar-brand"')
                 . '        </div>';

        if ( !self::verify_browser() AND Authen::is_logged_in() )
            $output .= '<div class="navbar-collapse collapse">'.$this->get_nav('top').'</div> <!--/.nav-collapse -->';

        $output .=  '</div></header>';

        return $output;
    }

    // -------------------------------------------------------------------------

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

                        $menu_item['attr']  = array_merge($menu_item['attr'], array('role'=>'menuitem', 'tabindex'=>'-1'));
                        
                        if ($has_child === TRUE)
                        {
                            $menu_item['label'] .= ' <b class="caret"></b>';
                            $menu_item['attr']  = array_merge($menu_item['attr'], array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'));
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

    // -------------------------------------------------------------------------

    public function add_script( $id, $source, $depend = '', $version = NULL )
    {
        if ( filter_var( base_url($source), FILTER_VALIDATE_URL) )
            $source .= '?ver='.($version != '' ? $version : get_conf('app_version'));

        if ( array_key_exists($depend, $this->_scripts) )
        {
            $this->_scripts = array_insert_after_node( $this->_scripts, $depend, $id, $source );
        }
        else
        {
            $this->_scripts[$id] = $source;
        }
    }

    // -------------------------------------------------------------------------

    public function load_scripts()
    {
        $output = '';
        $attr   = 'type="text/javascript" charset="'.get_charset().'"';

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
                    ">\n$(function(){\n$src\n});\n";
            }

            $output .= "</script>\n\t";
        }

        return $output;
    }

    // -------------------------------------------------------------------------

    public function add_style( $id, $source, $depend = '', $version = NULL )
    {
        $source = $source.'?ver='.($version != '' ? $version : get_conf('app_version'));

        if ( array_key_exists($depend, $this->_styles) )
        {
            $this->_styles = array_insert_after_node( $this->_styles, $depend, $id, $source );
        }
        else
        {
            $this->_styles[$id] = $source;
        }
    }

    // -------------------------------------------------------------------------

    public function load_styles()
    {
        $output = '';

        foreach ( $this->_styles as $id => $style )
        {
            $link = array(
                'id'    => $id,
                'rel'   => 'stylesheet',
                'type'  => 'text/css',
                'charset'=> get_charset() );

            if (strpos($style, '://') !== FALSE)
            {
                $link['href'] = $style;

                $output .= link_tag( $link )."\n\t";
            }
            else if( filter_var( base_url( $style ), FILTER_VALIDATE_URL) )
            {
                $link['href'] = base_url( $style );

                $output .= link_tag( $link )."\n\t";
            }
            else
            {
                $output = "<style id=\"$id\" rel=\"stylesheet\" ".get_charset()." type=\"text/css\">\n$style\n</style>\n\t";
            }
        }

        return $output;
    }

    // -------------------------------------------------------------------------

    public function get( $name )
    {
        if ( array_key_exists($name, $this->_theme_data) )
            return $this->_theme_data[$name];
        else
            log_message('error', "#Baka_pack: Themee->get Theme data ".$name." doesn't exists.");
    }

    // -------------------------------------------------------------------------

    public function set($name, $value)
    {
        $this->_contents[$name] = $value;
    }

    // -------------------------------------------------------------------------

    public function load($view = '' , $view_data = array(), $file = '', $return = FALSE)
    {
        $file || $file = 'index';

        $this->set('contents', self::$_ci->load->view( $view, $view_data, TRUE));

        if ( IS_AJAX )
        {
            log_message('debug', "#Baka_pack: Themee->load File ".$file." loaded as view via ajax.");

            return self::$_ci->load->view( $view, $view_data, FALSE);
        }
        else
        {
            log_message('debug', "#Baka_pack: Themee->load File ".$file." loaded as view.");

            return self::$_ci->load->view( $file, $this->_contents, $return );
        }
    }
}

/* End of file Themee.php */
/* Location: ./application/libraries/baka_pack/Themee.php */