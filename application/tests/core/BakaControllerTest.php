<?php
/**
 * @package     BootIgniter Pack
 * @subpackage  BakaControllerTest
 * @category    Unit test
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://github.com/feryardiant/bootigniter/blob/master/LICENSE
 * @since       Version 0.1.5
 */

// -----------------------------------------------------------------------------

class BakaControllerTest extends Bpmppt_TestCase
{
    private $_bc = FALSE;

    public function setUp()
    {
        if (class_exists('BI_Controller'))
        {
            $this->_bc = new BI_Controller;
        }
    }

    public function testInstance()
    {
        // $this->assertNotFalse($this->_bc);

        $this->assertContainsOnlyInstancesOf('BI_Controller', array($this->_bc));

        $this->assertContainsOnlyInstancesOf('CI_Controller', array($this->_bc));

    }

    public function testPanelContent()
    {
        $this->assertContains('panel_title', $this->_bc->data);

        $this->assertContains('panel_body', $this->_bc->data);
    }
}

/* End of file BAKA_Controller.php */
/* Location: ./application/core/BAKA_Controller.php */
