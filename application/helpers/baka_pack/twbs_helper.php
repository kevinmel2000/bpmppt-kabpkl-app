<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
 * @subpackage  Twitter Bootstrap
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.4
 */


// -----------------------------------------------------------------------------
// Twitter Bootstrap helper
//
// Just another simplify to use twbs
// -----------------------------------------------------------------------------

/**
 * TWBS Label
 * 
 * @param   string
 * @param   string
 * @param   string
 * 
 * @return  string
 */
function twb_label($text, $class = 'default', $tag = 'span')
{
    return '<'.$tag.' class="label label-'.$class.'">'.$text.'</'.$tag.'>';
}

// -----------------------------------------------------------------------------

/**
 * TWBS Badge
 * 
 * @param   string
 * @param   string
 * 
 * @return  string
 */
function twb_badge($text, $tag = 'span')
{
    return '<'.$tag.' class="badge">'.$text.'</'.$tag.'>';
}

// -----------------------------------------------------------------------------

/**
 * TWBS Text
 * 
 * @param   string
 * @param   string
 * @param   string
 * 
 * @return  string
 */
function twb_text($text, $class = '', $tag = 'span')
{
    return '<'.$tag.' class="text-'.$class.'">'.$text.'</'.$tag.'>';
}

// -------------------------------------------------------------------------

/**
 * TWBS based column grids
 *
 * @param   int     $lg   Large column value
 * @param   int     $md   Medium column value
 * @param   int     $sm   Small column value
 * @param   int     $xs   Extra small column value
 * @param   int     $xxs  Extra extra small column value
 * 
 * @return  string
 */
function twbs_set_columns($lg = NULL, $md = NULL, $sm = NULL, $xs = NULL, $xxs = NULL)
{
    $grids = 12;

    for ($i = 1; $i <= $grids; $i++)
    {
        $grid[] = $i;
    }

    if (is_array($lg))
    {
        $col = array_set_defaults($lg, array(
            'lg'  => NULL,
            'md'  => NULL,
            'sm'  => NULL,
            'xs'  => NULL,
            'xxs' => NULL,
            ));

        return twbs_set_columns($col['lg'], $col['md'], $col['sm'], $col['xs'], $col['xxs']);
    }
    else
    {
        $out = '';

        if (!is_null($lg) and in_array($lg, $grid))
        {
            $out .= ' col-lg-'.$lg;
        }

        if (!is_null($md) and in_array($md, $grid))
        {
            $out .= ' col-md-'.$md;
        }

        if (!is_null($sm) and in_array($sm, $grid))
        {
            $out .= ' col-sm-'.$sm;
        }

        if (!is_null($xs) and in_array($xs, $grid))
        {
            $out .= ' col-xs-'.$xs;
        }

        if (!is_null($xxs) and in_array($xxs, $grid))
        {
            $out .= ' col-xxs-'.$xxs;
        }

        return trim($out);
    }
}

// -------------------------------------------------------------------------

/**
 * Twitter Bootstrap Dropdown Button(s)
 *
 * @param   array   $menu_list   List of dropdown menu
 * @param   string  $base_link   Based link to work with
 * @param   array   $attributes  Button attributes
 * 
 * @return  string
 */
function twbs_button_dropdown(array $menu_list, $base_link = '', $attributes = array())
{
    $attributes = array_set_defaults($attributes, array(
        'group-class' => '',
        'btn-type'    => '',
        'btn-text'    => '',
        ));

    $base_link || $base_link = base_url();

    if (substr($base_link, -1) != '/')
    {
        $base_link .= '/';
    }

    $output = '<div class="btn-group '.$attributes['group-class'].'">'
            . '<button type="button" class="btn btn-'.$attributes['btn-type'].' dropdown-toggle" data-toggle="dropdown">'
            . $attributes['btn-text'].' <span class="caret"></span>'
            . '</button>'
            . '<ul class="dropdown-menu dropdown-menu-right" role="menu">';

    foreach ($menu_list as $link => $title)
    {
        $output .= twb_text(anchor($base_link.$link, $title), 'left', 'li');
    }

    $output .= '</ul>'
            .  '</div>';

    return $output;
}

/* End of file assets_helper.php */
/* Location: ./application/helpers/baka_pack/assets_helper.php */