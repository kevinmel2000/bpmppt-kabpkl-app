<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     CodeIgniter Baka Pack
 * @subpackage  HTML
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
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

    if (isset($navbar[$position]))
    {
        return make_menu( $navbar[$position], $responsivable);
    }

    log_message('error', '#Baka_pack: Themee->navbar '.$position.' doesn\'t exists.');
    return FALSE;
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
                    $list_attr['class'] .= 'nav-link';

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