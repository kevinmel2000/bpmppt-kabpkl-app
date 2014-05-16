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

function set_script($id, $source, $depend = '' , $version = '', $in_foot = TRUE )
{
    return Asssets::set_script($id, $source, $depend, $version, $in_foot);
}

// -----------------------------------------------------------------------------

function load_scripts($pos)
{
    $output = '';
    $attr   = 'type="text/javascript"';

    $base_attr = parse_attrs(array(
        'type'    => 'text/javascript',
        'charset' => get_charset(),
        ));

    if ($scripts = Asssets::get_script($pos))
    {
        $output .= "<!-- ".ucfirst($pos)."er Scripts -->\n";

        foreach ($scripts as $src_id => $src_path)
        {
            $script_attr = parse_attrs(array(
                'src' => $src_path,
                'id'  => $src_id,
                ));

            $output .= "<script $script_attr $base_attr></script>\n";
        }

        $adds = Asssets::get_script('src');

        if ($pos == 'foot' and $adds != FALSE)
        {
            $output .= "<!-- Additional Scripts -->\n<script $base_attr>\n$(function() {\n";
            $i = 0;

            foreach ($adds as $add_id => $add_src)
            {
                $output .= "// $add_id\n";
                $output .= $add_src;

                $i++;

                if ($i > 0 and $i != count(Asssets::get_script('src')))
                {
                    $output .= "\n\n";
                }
            }

            $output .= "\n});\n</script>\n";
        }
    }
    
    return $output;
}

// -----------------------------------------------------------------------------

function set_style($id, $source, $depend = '' , $version = NULL )
{
    return Asssets::set_style($id, $source, $depend, $version);
}

// -----------------------------------------------------------------------------

function load_styles()
{
    $output  = '';
    $styles  = Asssets::get_styles();

    // put additional stylesheet into defferent plase ;)
    if (isset($styles['src']))
    {
        $adds = $styles['src'];
        unset($styles['src']);
    }

    $base_attr = parse_attrs(array(
        'rel'     => 'stylesheet',
        'type'    => 'text/css',
        'charset' => get_charset(),
        ));

    foreach ($styles as $src_id => $src_path)
    {
        $link_attr = parse_attrs(array(
            'href' => $src_path,
            'id'   => $src_id,
            ));

        $output .= '<link '.$link_attr.$base_attr.'>';
    }

    // put additional stylesheet into defferent plase ;)
    if (isset($adds))
    {
        $output .= "<!-- Additional Styles -->\n<style $base_attr>\n";
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


/* End of file assets_helper.php */
/* Location: ./application/helpers/baka_pack/assets_helper.php */