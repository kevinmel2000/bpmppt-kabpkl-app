<?php
/**
 * @package     BPMPPT App v0.1.6 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  BakaPack_TestCase
 * @category    Unit test
 */

// -----------------------------------------------------------------------------


class BakaPack_TestCase extends Bpmppt_TestCase
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

    public function testCoreInstance()
    {
        $BC = new BI_Controller;
        $this->assertContainsOnlyInstancesOf('CI_Controller', array($BC));

        $BE = new BI_Exceptions;
        $this->assertContainsOnlyInstancesOf('CI_Exceptions', array($BE));

        $BE = new BI_Loader;
        $this->assertContainsOnlyInstancesOf('CI_Loader', array($BE));
    }
}
