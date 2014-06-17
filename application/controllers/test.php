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
 * Test Class
 *
 * @subpackage  Controller
 */
class Test extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['panel_body'] = '<button type="button" class="btn btn-default">test</button>';

        // $this->load->view('pages/panel_test', $this->data);
        $this->load->theme('pages/panel_test', $this->data);
    }

    public function cli($param)
    {
        print "Type your message. Type '.' on a line by itself when you're done";

        $fp        = fopen('php://stdin', 'r');
        $last_line = false;
        $message   = '';

        while (!$last_line)
        {
            // read the special file to get the user input from keyboard
            $next_line = fgets($fp, 1024);

            if (".\n" === $next_line) // ORA NGARUH NANG WINDOWS :v
            {
              $last_line = true;
            }
            else
            {
              $message .= $next_line;
            }
        }

        if ($last_line == true)
        {
            print $message;
            exit(1);
        }

        echo $param;
    }
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */