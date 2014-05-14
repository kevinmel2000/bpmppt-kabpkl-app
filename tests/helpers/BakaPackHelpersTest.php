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
 * @subpackage  Email
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

class BakaPackHelpersTest extends BakaPack_TestCase
{
    private $_helpers = array(
        'array',
        'asssets',
        'common',
        'data',
        'emailer',
        'former',
        'twbs',
        );

    private $_count = 0;

    public function setUp()
    {
        parent::setUp();

        foreach ($this->_helpers as $helper)
        {
            if (!$this->ci->load->is_loaded('baka_pack/'.$helper))
            {
                $this->ci->load->helper('baka_pack/'.$helper);
            }

            $this->_count++;
        }
    }

    public function testLoadedHelpers()
    {
        $this->assertNotCount(0, $this->_helpers);

        $this->assertCount($this->_count, $this->_helpers);

        $this->assertEquals($this->_count, count($this->_helpers));
    }

    public function testLogin()
    {
        $this->assertFalse(FALSE);
    }
}

/* End of file emailer_helper.php */
/* Location: ./application/helpers/baka_pack/emailer_helper.php */