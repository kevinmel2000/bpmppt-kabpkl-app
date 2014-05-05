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
 * Test Class
 *
 * @subpackage  Controller
 */
class Test extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login();
    }

    private function index()
    {
        return;
    }

    public function modal()
    {
        $this->data['panel_body'] = '<button type="button" class="btn btn-default">test</button>';

        $this->load->theme('pages/panel_test', $this->data);
    }
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */