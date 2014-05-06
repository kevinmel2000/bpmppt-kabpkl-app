<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Everyone is permitted to copy and distribute verbatim or modified 
 * copies of this license document, and changing it is allowed as long 
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE 
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION 
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://www.wtfpl.net
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Auth Class
 *
 * @subpackage  Libraries
 * @category    Security
 */
class Authen
{
    /**
     * Codeigniter superobject
     * 
     * @var  mixed
     */
    protected static $_ci;

    /**
     * Default class constructor
     */
    public function __construct()
    {
        self::$_ci =& get_instance();

        self::$_ci->load->driver('authr');

        log_message('debug', "#Baka_pack: Authen Class Initialized");
    }
}

/* End of file Authen.php */
/* Location: ./application/libraries/baka_pack/Authen.php */