<?php

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
