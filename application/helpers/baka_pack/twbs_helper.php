<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
 * @subpackage  Common
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
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
 * @return  string
 */
function twbs_set_columns($lg = NULL, $md = NULL, $sm = NULL, $xs = NULL, $xxs = NULL)
{
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

        if (!is_null($lg))
        {
            $out .= ' col-lg-'.$lg;
        }

        if (!is_null($md))
        {
            $out .= ' col-md-'.$md;
        }

        if (!is_null($sm))
        {
            $out .= ' col-sm-'.$sm;
        }

        if (!is_null($xs))
        {
            $out .= ' col-xs-'.$xs;
        }

        if (!is_null($xxs))
        {
            $out .= ' col-xxs-'.$xxs;
        }

        return $out;
    }
}