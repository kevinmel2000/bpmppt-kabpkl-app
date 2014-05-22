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