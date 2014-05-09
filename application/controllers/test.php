<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
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
 * @license     http://opensource.org/licenses/OSL-3.0
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