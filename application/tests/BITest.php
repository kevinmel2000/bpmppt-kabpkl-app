<?php
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Bpmppt_TestCase
 * @category    Unit Test
 */

// -----------------------------------------------------------------------------

abstract class Bpmppt_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Reference to CodeIgniter
     *
     * @var resource
     */
	protected static $CI;

    public static function setUpBeforeClass()
    {
        static::$CI =& get_instance();
    }
}
