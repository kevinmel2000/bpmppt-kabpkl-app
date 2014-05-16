<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

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
 * @subpackage  HTML
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * Load template content
 * 
 * @param  string $file template content name
 * @return mixed        default CI view
 */
function load_view($file)
{
    $CI_load =& get_instance()->load;

    return $CI_load->view($file);
}

// -----------------------------------------------------------------------------

/**
 * Get site title
 * 
 * @return  String
 */
function get_site_title()
{
    $themee =& get_instance()->themee;

    return $themee->get('site_title');
}

// -----------------------------------------------------------------------------

/**
 * Get body attributes
 * 
 * @return  String
 */
function get_body_attrs()
{
    $themee =& get_instance()->themee;

    return parse_attrs($themee->get('body_attr'));
}

// -----------------------------------------------------------------------------

/**
 * Get page title
 * 
 * @return  String
 */
function get_page_title()
{
    $themee =& get_instance()->themee;

    return $themee->get('page_title');
}

// -----------------------------------------------------------------------------

/**
 * Get navigation bar
 * 
 * @return  String
 */
function get_navbar()
{
    $themee =& get_instance()->themee;

    if ( $themee->get('authenticated'))
    {
        return get_nav('top');
    }
}

// -----------------------------------------------------------------------------

/**
 * Get navigation menu
 *
 * @param   string  $position       Navigation menu position
 * @param   bool    $responsivable  Are you need it responsive?
 * @return  string
 */
function get_nav($position, $responsivable = FALSE)
{
    $themee =& get_instance()->themee;
    $navbar = $themee->get('navbar');

    if (!isset($navbar[$position]))
    {
        log_message('error', '#Baka_pack: Themee->navbar '.$position.' doesn\'t exists.');
        return FALSE;
    }

    return make_menu( $navbar[$position], $responsivable);
}



// -----------------------------------------------------------------------------

/**
 * Creating menu list of navbar
 * 
 * @param  array  $links menu link list
 * @param  string $name  menu name
 * @param  string $class menu class
 * 
 * @return string
 */
function make_menu($menu_array, $responsivable = FALSE)
{
    $output = '';

    foreach ($menu_array as $list_id => $list_item)
    {
        $class = isset($list_item['class']) ? $list_item['class'] : '';

        $output .= '<ul id="'.$list_id.'" role="menu" class="'.$class.'">';

        foreach ($list_item['items'] as $menu_id => $menu_item)
        {
            $list_attr = array(
                'role'  => 'presentation',
                'id'    => str_replace('_', '-', $menu_id),
                'class' => '',
               );

            switch ($menu_item['type'])
            {
                case 'header':
                    $list_attr['class'] .= 'dropdown-header';

                    $output .= '<li '.parse_attrs($list_attr).'>'.$menu_item['label'];
                    break;

                case 'devider':
                    $list_attr['class'] .= 'nav-divider';

                    $output .= '<li '.parse_attrs($list_attr).'>';
                    break;

                case 'link':
                    $list_attr['class'] .= 'twbs-tooltip nav-link';
                    $list_attr['data-toggle']    = 'tooltip';
                    $list_attr['data-placement'] = 'left';

                    if (strpos(current_url(), site_url($menu_item['url'])) !== FALSE)
                    {
                        $list_attr['class'] .= ' active';
                    }

                    if ($has_child = array_key_exists('child', $menu_item))
                    {
                        $list_attr['class'] .= ' dropdown';
                    }

                    $output .= '<li '.parse_attrs($list_attr).'>';

                    $menu_item['attr']  = array_merge($menu_item['attr'], array('role'=>'menuitem', 'tabindex'=>'-1'));
                    
                    if ($has_child === TRUE)
                    {
                        $menu_item['label'] .= ' <b class="caret"></b>';
                        $menu_item['attr']  = array_merge($menu_item['attr'], array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'));
                    }

                    $anchor_pre = '<span class="menu-text">';

                    if ($responsivable)
                    {
                        $anchor_pre = '<i class="fa fa-file visible-sm"></i><span class="menu-text hidden-sm">';
                    }

                    $output .= anchor($menu_item['url'], $anchor_pre.$menu_item['label'].'</span>', $menu_item['attr']);

                    if ($has_child === TRUE)
                    {
                        $output .= make_menu( $menu_item['child'], 'dropdown-menu');
                    }
                    break;
            }

            $output .= '</li>';
        }

        $output .= '</ul>';
    }

    return $output;
}

// -----------------------------------------------------------------------------

function get_lang_code($uppercase = FALSE)
{
    $output = array_search(config_item('language'), config_item('language_codes'));

    return ($uppercase == TRUE) ? strtoupper($output) : $output ;
}

// -----------------------------------------------------------------------------

function get_charset($uppercase = FALSE)
{
    $output = config_item('charset');

    return ($uppercase == TRUE) ? strtoupper($output) : strtolower($output) ;
}

// -----------------------------------------------------------------------------

/**
 * Parsing array into html attributes
 *
 * @todo    adding validations
 * @since   0.1.4
 * @param   array   $attributes  Attributes array
 * @return  string
 */
function parse_attrs(array $attributes)
{
    $attr = '';
    $i    = 0;

    foreach ($attributes as $key => $val)
    {
        $attr .= $key.'="'.$val.'" ';
    }

    return $attr;
}


/* End of file assets_helper.php */
/* Location: ./application/helpers/baka_pack/assets_helper.php */