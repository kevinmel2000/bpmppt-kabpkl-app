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
 * @version     Version 0.1.4
 * @since       Version 0.1.0
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Library Class
 *
 * @since       version 0.1.3
 * @subpackage  Libraries
 * @category    Settings
 */
class BakaPackSettingTest extends PHPUnit_Framework_TestCase
{
    private $ci;

    public function setUp()
    {
        $this->ci =& get_instance();
    }

    public function testLogin()
    {
        $this->assertFalse(FALSE);
    }
}

/* End of file Setting.php */
/* Location: ./application/libraries/Baka_pack/Setting.php */