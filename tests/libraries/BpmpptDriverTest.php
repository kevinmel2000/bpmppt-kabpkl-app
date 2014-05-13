<?php

/**
 * BPMPPT driver
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
 * @package     BPMPPT_tests
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 1.0
 * @filesource
 */

// =============================================================================

/**
 * BPMPPT Driver
 *
 * @subpackage  Drivers
 * @category    Application
 */
class BpmpptDriverTest extends PHPUnit_Framework_TestCase
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

/* End of file Bpmppt.php */
/* Location: ./application/libraries/Bpmppt/Bpmppt.php */