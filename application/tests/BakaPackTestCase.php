<?php

abstract class BakaPackTestCase extends PHPUnit_Framework_TestCase
{
	protected $CI;

	public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

		$this->CI =& get_instance();
    }
}