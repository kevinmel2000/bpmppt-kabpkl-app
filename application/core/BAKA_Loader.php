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
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Loader Class
 *
 * @subpackage  Core
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

        log_message('debug', "#Baka_pack: Core Loader Class Initialized");
    }

    // -------------------------------------------------------------------------

    function theme($view, $vars = array(), $file = '', $return = FALSE)
    {
        $file || $file = 'index';
        $CI =& get_instance();

        if (php_sapi_name() === 'cli' OR defined('STDIN'))
        {
            echo json_encode($var);
        }
        else if (IS_AJAX)
        {
            log_message('debug', "#Baka_pack: Core Loader->theme File \"$file\" loaded as view via ajax.");

            return $this->view($view, $vars, FALSE);
        }
        else if (($captcha = $CI->input->get('captcha')) and $captcha = 'gen')
        {
            $CI->authr->captcha_img();
        }
        else
        {
            $data['contents'] = $this->view($view, $vars, TRUE);

            log_message('debug', "#Baka_pack: Core Loader->theme File \"$file\" loaded as view.");

            return $this->view($file, $data, $return);
        }

        // if (!IS_AJAX)
        // {
        //     $data['contents'] = $this->view($view, $vars, TRUE);

        //     log_message('debug', "#Baka_pack: Loader->theme File \"$file\" loaded as view.");

        //     return $this->view($file, $data, $return);
        // }
    }
}

/* End of file BAKA_Loader.php */
/* Location: ./application/core/BAKA_Loader.php */