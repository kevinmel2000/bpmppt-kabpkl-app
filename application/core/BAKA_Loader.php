<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Loader Class
 *
 * @subpackage  Libraries
 * @category    Loader
 */
class BAKA_Loader extends CI_Loader
{
    /**
     * Default class Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    // -------------------------------------------------------------------------

    function theme( $view, $vars = array(), $file = '', $return = FALSE )
    {
        $file || $file = 'index';

        $data['contents'] = $this->view( $view, $vars, TRUE);

        if ( IS_AJAX )
        {
            log_message('debug', "#Baka_pack: Loader->theme File ".$file." loaded as view via ajax.");

            return $this->view( $view, $vars, FALSE);
        }
        else
        {
            log_message('debug', "#Baka_pack: Loader->theme File ".$file." loaded as view.");

            return $this->view( $file, $data, $return );
        }
    }
}

/* End of file BAKA_Loader.php */
/* Location: ./application/core/BAKA_Loader.php */