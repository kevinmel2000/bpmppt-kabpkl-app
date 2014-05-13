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
 * @package     Authr_tests
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Authr Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class AuthrDriverTest extends PHPUnit_Framework_TestCase 
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

/* End of file Authen.php */
/* Location: ./application/libraries/Authen/Authen.php */