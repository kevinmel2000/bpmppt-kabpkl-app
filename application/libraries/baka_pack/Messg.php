<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     CodeIgniter Baka Pack
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
        log_message('debug', "#Baka_pack: Messg Class Initialized");
    }

    /**
     * Setup messages
     *
     * @param   string        $level     Message Level
     * @param   string|array  $msg_item  Message Items
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

        if (is_array($msg_item) and count($msg_item) > 0)
        {
            foreach ($msg_item as $item)
            {
                self::set($level, $item);
            }
        }
        else
        {
            self::$messages[$level][] = $msg_item;
        }
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
        if ($level and isset(self::$messages[$level]))
        {
            return self::$messages[$level];
        }

        return self::$messages;
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