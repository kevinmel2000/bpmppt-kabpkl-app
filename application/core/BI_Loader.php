<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BootIgniter Pack
 * @subpackage  BI_Loader
 * @category    Core
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://github.com/feryardiant/bootigniter/blob/master/LICENSE
 * @since       Version 0.1.5
 */

// -----------------------------------------------------------------------------

class BI_Loader extends CI_Loader
{
    public function script($id, $src = '', $ver = '', $dep = array())
    {
        $CI =& get_instance();
        $CI->biasset->load_script($id, $src, $ver, $dep);
    }

    // -------------------------------------------------------------------------

    public function style($id, $src = '', $ver = '', $dep = array())
    {
        $CI =& get_instance();
        $CI->biasset->load_style($id, $src, $ver, $dep);
    }

    // -------------------------------------------------------------------------

    public function theme($view, $vars = array(), $file = '', $return = FALSE)
    {
        $file || $file = 'main';

        if (IS_CLI and !defined('PHPUNIT_TEST'))
        {
            log_message('debug', "#BootIgniter: Core Loader->theme File \"$file\" loaded as view via cli.");
            echo json_encode($vars);
        }
        else if (IS_AJAX)
        {
            log_message('debug', "#BootIgniter: Core Loader->theme File \"$file\" loaded as view via ajax.");
            return $this->view($view, $vars, FALSE);
        }
        else
        {
            $data['contents'] = $this->view($view, $vars, TRUE);
            return $this->view('layouts/'.$file, $data, $return);
        }
    }
}

/* End of file BI_Loader.php */
/* Location: ./application/core/BI_Loader.php */
