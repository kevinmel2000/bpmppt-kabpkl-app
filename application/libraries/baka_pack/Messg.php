<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * CodeIgniter Baka Pack
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
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Message Class
 *
 * @subpackage  Libraries
 * @category    Messages
 */
class Messg
{
    /**
     * Messages wrapper
     *
     * @var  array
     */
    protected static $messages = array();

    protected static $levels = array('success', 'info', 'warning', 'error');

    /**
     * Default class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Baka_pack: Main Library Class Initialized");
    }

    /**
     * Setup messages
     *
     * @param   string  $level     Message Level
     * @param   string  $msg_item  Message Items
     *
     * @return  void
     */
    public static function set($level, $msg_item)
    {
        if (!in_array($level, self::$levels))
        {
            log_message('error', '#Baka_pack: Messg->set Unkown message level "'.$level.'"');
            return FALSE;
        }

        self::$messages[$level][] = $msg_item;
    }

    /**
     * Get all messages
     *
     * @param   string  $level Message Level
     *
     * @return  array
     */
    public static function get($level = FALSE)
    {
        if (!empty(self::$messages))
        {
            if ($level)
                return self::$messages[$level];

            return self::$messages;
        }
    }

    /**
     * Clean up
     *
     * @return  void
     */
    public static function clear()
    {
        self::$messages = array();
    }
}

/* End of file Messg.php */
/* Location: ./application/libraries/Baka_pack/Messg.php */