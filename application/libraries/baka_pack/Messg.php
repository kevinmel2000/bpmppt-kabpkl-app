<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

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