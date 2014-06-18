<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * @package     Baka Igniter Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @version     Version 0.1.4
 * @since       Version 0.1.0
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

    protected static $levels   = array('success', 'info', 'warning', 'error');

    /**
     * Default class constructor
     */
    public function __construct()
    {
        log_message('debug', "#BakaIgniter: Messg Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Get all messages
     *
     * @param   string  $level Message Level
     *
     * @return  array
     */
    public function get_message($level = FALSE)
    {
        if ($level and isset($this->_messages[$level]))
        {
            return $this->_messages[$level];
        }

        return $this->_messages;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup messages
     *
     * @param   string        $level     Message Level
     * @param   string|array  $msg_item  Message Items
     *
     * @return  void
     */
    public function set_message($level, $msg_item)
    {
        if (!in_array($level, array('success', 'info', 'warning', 'error')))
        {
            log_message('error', '#BakaIgniter: Messg->set Unkown message level "'.$level.'"');
            return FALSE;
        }

        if (is_array($msg_item) and count($msg_item) > 0)
        {
            foreach ($msg_item as $item)
            {
                self::set($level, $item);
            }
        }
        else
        {
            $this->_messages[$level][] = $msg_item;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Clean up
     *
     * @return  void
     */
    public function clear_message()
    {
        $this->_messages = array();
    }
}

/* End of file Messg.php */
/* Location: ./application/third_party/bakaigniter/libraries/Messg.php */