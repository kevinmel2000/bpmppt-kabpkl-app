<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Everyone is permitted to copy and distribute verbatim or modified 
 * copies of this license document, and changing it is allowed as long 
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE 
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION 
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://www.wtfpl.net
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