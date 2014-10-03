<?php
/**
 * @package     BootIgniter Pack
 * @subpackage  Bpmppt_TestCase
 * @category    Unit Test
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://github.com/feryardiant/bootigniter/blob/master/LICENSE
 * @since       Version 0.1.5
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
