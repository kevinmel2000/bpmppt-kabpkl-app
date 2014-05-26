<?php

abstract class BakaPack_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Reference to CodeIgniter
     * 
     * @var resource
     */
    protected $ci;

    public function setUp()
    {
        $this->ci =& get_instance();
    }
}