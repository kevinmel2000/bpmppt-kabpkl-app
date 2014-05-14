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
class BakaControllerTest extends PHPUnit_Framework_TestCase
{
    private $_ci;
    private $_bc = FALSE;

    public function setUp()
    {
        $this->_ci =& get_instance();

        if (class_exists('BAKA_Controller'))
        {
            $this->_bc = new BAKA_Controller;
        }
    }

    public function testInstance()
    {
        $this->assertNotFalse($this->_bc);

        $this->assertContainsOnlyInstancesOf('BAKA_Controller', array($this->_bc));

        $this->assertContainsOnlyInstancesOf('CI_Controller', array($this->_bc));

        $this->assertNotCount(0, $this->_bc->data);
    }

    public function testPanelContent()
    {
        $this->assertContains('panel_title', $this->_bc->data);

        $this->assertContains('panel_body', $this->_bc->data);
    }
}

/* End of file BAKA_Controller.php */
/* Location: ./application/core/BAKA_Controller.php */