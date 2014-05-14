<?php

/**
 * Baka_pack Archive Drivers
 *
 * My very own Codeigniter core library that used on all of my projects
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
 * @package     Archive_test
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Archive Library Class
 *
 * @category    Archives
 * @subpackage  Drivers
 */
class ArchiveDriverTest extends PHPUnit_Framework_TestCase
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

/* End of file Archive.php */
/* Location: ./application/libraries/Archive/Archive.php */