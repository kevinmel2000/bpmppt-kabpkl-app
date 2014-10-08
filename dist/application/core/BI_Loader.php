<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BAKA Loader Class
 *
 * @subpackage  Core
 * @category    Loader
 */
class BI_Loader extends CI_Loader
{
    function theme($view, $vars = array(), $file = '', $return = FALSE)
    {
        $file || $file = 'index';

        if (IS_CLI)
        {
            log_message('debug', "#BootIgniter: Core Loader->theme File \"$file\" loaded as view via cli.");

            echo json_encode($var);
        }
        else if (IS_AJAX)
        {
            log_message('debug', "#BootIgniter: Core Loader->theme File \"$file\" loaded as view via ajax.");

            return $this->view($view, $vars, FALSE);
        }
        else
        {
            $data['contents'] = $this->view($view, $vars, TRUE);

            log_message('debug', "#BootIgniter: Core Loader->theme File \"$file\" loaded as view.");

            return $this->view($file, $data, $return);
        }
    }
}

/* End of file BI_Loader.php */
/* Location: ./application/core/BI_Loader.php */
