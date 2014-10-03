<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BootIgniter Pack
 * @subpackage  Biasset
 * @category    Asset Helpers
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://github.com/feryardiant/bootigniter/blob/master/LICENSE
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


/* End of file biasset_helper.php */
/* Location: ./bootigniter/helpers/biasset_helper.php */
