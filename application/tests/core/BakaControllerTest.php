<?php

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
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
 * @package     Baka_test_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1.4
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Controller Class
 *
 * @subpackage  Core
 * @category    Controller
 */
class BakaControllerTest extends Bpmppt_TestCase
{
    private $_bc = FALSE;

    public function setUp()
    {
        if (class_exists('BI_Controller'))
        {
            $this->_bc = new BI_Controller;
        }
    }

    public function testInstance()
    {
        // $this->assertNotFalse($this->_bc);

        $this->assertContainsOnlyInstancesOf('BI_Controller', array($this->_bc));

        $this->assertContainsOnlyInstancesOf('CI_Controller', array($this->_bc));

    }

    public function testPanelContent()
    {
        $this->assertContains('panel_title', $this->_bc->data);

        $this->assertContains('panel_body', $this->_bc->data);
    }
}

/* End of file BAKA_Controller.php */
/* Location: ./application/core/BAKA_Controller.php */
