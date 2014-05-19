<?php if (! defined('BASEPATH')) exit('No direct script access allowed'); 

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
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Errror Class
 *
 * PHP-Error handler for Codeigniter
 * PHP Error cannot take over 100% of CI's errors, at least not out of the box, but can
 * still be used for general PHP errors, such as for pointing out undefined variables
 *
 * @link        https://github.com/JosephLenton/PHP-Error/wiki/Example-Setup#code-igniter
 * @subpackage  Hooks
 * @category    Errors
 */
class Display
{
    /**
     * Codeigniter superobject
     *
     * @var  mixed
     */
    protected $_ci;

    /**
     * Error handler method
     *
     * @return  void
     */
    public function get_output()
    {
        $this->_ci =& get_instance();
        $output = $this->_ci->output->get_output();

        if (!defined('PROJECT_DIR'))
        {
            echo $output;
        }
    }
}

/* End of file Errror.php */
/* Location: ./application/hooks/Errror.php */
