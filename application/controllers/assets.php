<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
 * Assets Class
 *
 * @subpackage  Controller
 */
class Assets extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function css()
    {
        echo 'this css assets';
    }

    public function js($pos = 'foot')
    {
        if ($scripts = Asssets::get_script($pos))
        {
            $output = '';

            foreach ($scripts as $id => $path)
            {
                $handler = fopen($path, "rb");
                $script = file_get_contents($handler);
                fclose($handler);

                // $context = stream_context_create(array(
                //     'http' => array(
                //         'method'  => "GET",
                //         'header'  => "Content-Type: text/javascript\n",
                //         'content' => $script,
                //         )
                //     ));

                $output .= "// $id\n";
                $output .= $script."\n";
            }

            echo $output;
        }
        else
        {
            echo 'null';
        }
    }
}

/* End of file assets.php */
/* Location: ./application/controllers/assets.php */