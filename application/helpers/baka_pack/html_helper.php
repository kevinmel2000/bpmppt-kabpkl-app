<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

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
function load_view($file )
{
    $CI_load =& get_instance()->load;

    return $CI_load->view($file );
}

// -----------------------------------------------------------------------------

/**
 * Baka Title
 * @return  String
 */
function get_site_title()
{
    $themee =& get_instance()->themee;

    return $themee->get('site_title');
}

// -----------------------------------------------------------------------------

/**
 * Body Class
 * @return  String
 */
function get_body_class()
{
    $themee =& get_instance()->themee;

    return $themee->get('body_class');
}

// -----------------------------------------------------------------------------

/**
 * Body Class
 * @return  String
 */
function get_page_title()
{
    $themee =& get_instance()->themee;

    return $themee->get('page_title');
}

// -----------------------------------------------------------------------------

/**
 * Body Class
 * @return  String
 */
function get_navbar()
{
    $themee =& get_instance()->themee;

    return $themee->get_navbar();
}

// -------------------------------------------------------------------------

function get_nav($position )
{
    $themee =& get_instance()->themee;

    return $themee->get_nav($position );
}

// -------------------------------------------------------------------------

function set_script($id, $source, $depend = '' , $version = '', $in_foot = TRUE )
{
    return Asssets::set_script($id, $source, $depend, $version, $in_foot);
}

// -------------------------------------------------------------------------

function load_scripts($pos)
{
    $output = '';
    $attr   = 'type="text/javascript"';

    if ($scripts = Asssets::get_script($pos))
    {
        $output .= "<!-- ".ucfirst($pos)."er Scripts -->\n";

        foreach ($scripts as $src_id => $src_path)
        {
            $output .= "<script src=\"$src_path\" id=\"$src_id\" $attr></script>\n";
        }

        $adds = Asssets::get_script('src');

        if ($pos == 'foot' and $adds != FALSE)
        {
            $output .= "<!-- Additional Scripts -->\n<script $attr>\n$(function() {\n";
            $i = 0;

            foreach ($adds as $add_id => $add_src)
            {
                $output .= "// $add_id\n";
                $output .= $add_src;

                $i++;

                if ($i > 0 and $i != count(Asssets::get_script('src')))
                    $output .= "\n\n";
            }

            $output .= "\n});\n</script>\n";
        }
    }
    
    return $output;
}

// -------------------------------------------------------------------------

function add_style($id, $source, $depend = '' , $version = NULL )
{
    return Asssets::set_style($id, $source, $depend, $version);
}

// -------------------------------------------------------------------------

function load_styles()
{
    $output  = '';
    $charset = get_charset();
    $styles  = Asssets::get_styles();

    // put additional stylesheet into defferent plase ;)
    if (isset($styles['src']))
    {
        $adds = $styles['src'];
        unset($styles['src']);
    }

    foreach ($styles as $src_id => $src_path)
    {
        $output .= link_tag(array(
                    'id'        => $src_id,
                    'href'      => $src_path,
                    'rel'       => 'stylesheet',
                    'type'      => 'text/css',
                    'charset'   => $charset,
                    ))."\n";
    }

    // put additional stylesheet into defferent plase ;)
    if (isset($adds))
    {
        $output .= "<!-- Additional Styles -->\n<style rel=\"stylesheet\" $charset type=\"text/css\">\n";
        $i = 0;

        foreach ($adds as $add_id => $add_src)
        {
            $output .= "// $add_id\n";
            $output .= $add_src;

            $i++;

            if ($i > 0 and $i != count($adds))
                $output .= "\n\n";
        }

        $output .= "</style>\n";
    }

    return $output;
}

// -------------------------------------------------------------------------

function get_lang_code($uppercase = FALSE )
{
    $output = array_search(config_item('language'), config_item('language_codes'));
    return ($uppercase == TRUE) ? strtoupper($output) : $output ;
}

// -------------------------------------------------------------------------

function get_charset($uppercase = FALSE )
{
    $output = config_item('charset');
    return ($uppercase == TRUE) ? strtoupper($output) : strtolower($output) ;
}

/* End of file html_helper.php */
/* Location: ./application/helpers/baka_pack/html_helper.php */