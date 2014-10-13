<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Biasset
 * @category    Asset Helpers
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
