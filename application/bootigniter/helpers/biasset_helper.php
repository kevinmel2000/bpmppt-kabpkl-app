<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package     BootIgniter Pack
 * @subpackage  HTML
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     https://github.com/feryardiant/bootigniter/blob/master/license.md
 * @since       Version 0.1.5
 */

// -----------------------------------------------------------------------------

function get_scripts()
{
    $biasset =& get_instance()->biasset;

    return $biasset->get_loaded('scripts');
}

// -----------------------------------------------------------------------------

function get_styles()
{
    $biasset =& get_instance()->biasset;

    return $biasset->get_loaded('styles');
}

// -----------------------------------------------------------------------------

function load_script($id, $src = '', $ver = '', $dep = array())
{
    $biasset =& get_instance()->biasset;

    $biasset->load_script($id, $src, $ver, $dep);
}

// -----------------------------------------------------------------------------

function load_style($id, $src = '', $ver = '', $dep = array())
{
    $biasset =& get_instance()->biasset;

    $biasset->load_style($id, $src, $ver, $dep);
}


/* End of file biassets_helper.php */
/* Location: ./bootigniter/helpers/biassets_helper.php */
