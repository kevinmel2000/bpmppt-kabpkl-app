<?php if (! defined('BASEPATH')) exit('No direct script access allowed'); 

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
 * BAKA Library Class
 *
 * @since       version 0.1.3
 * @subpackage  Libraries
 * @category    Settings
 */
class Setting
{
    /**
     * Codeigniter superobject
     *
     * @var  mixed
     */
    protected static $_ci;

    /**
     * Settings table name
     *
     * @var  string
     */
    private static $_table_name;

    /**
     * All application settings placeholder
     *
     * @var  array
     */
    private static $_settings = array();

    /**
     * Default constructor
     */
    public function __construct()
    {
        // Load CI super object
        self::$_ci =& get_instance();

        // Load Setting helper
        // self::$_ci->load->helper('baka_pack/setting');

        self::$_table_name = get_conf('system_opt_table');

        // Loading Authentication Driver
        self::$_ci->load->driver('authr');

        self::init();

        log_message('debug', "#Baka_pack: Setting Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Initializing application settings
     *
     * @since   version 0.1.3
     * 
     * @return  void
     */
    protected static function init()
    {
        $query = self::$_ci->db->get(self::$_table_name);

        if ($query->num_rows() == 0)
        {
            log_message('error', "#Baka_pack: Setting table is empty");
            return FALSE;
        }

        foreach ($query->result() as $row)
        {
            self::$_settings[$row->opt_key] = $row->opt_value;
        }

        $query->free_result();
    }

    // -------------------------------------------------------------------------

    /**
     * Get all application settings in array
     *
     * @since   version 0.1.3
     * 
     * @return  array
     */
    public static function get_all()
    {
        return (array) self::$_settings;
    }

    // -------------------------------------------------------------------------

    /**
     * Is application setting is exists?
     *
     * @since   version 0.1.3
     * @param   string  $key  Setting key name
     *
     * @return  bool
     */
    public static function is_exists($key)
    {
        return isset(self::$_settings[$key]);
    }

    // -------------------------------------------------------------------------

    /**
     * Get application setting
     *
     * @since   version 0.1.3
     * @param   string  $key  Setting key name
     *
     * @return  mixed
     */
    public static function get($key)
    {
        if (!self::is_exists($key))
        {
            log_message('error', "#Baka_pack: Setting->get key '{$key}' is not exists");
            return FALSE;
        }

        return self::$_settings[$key];
    }

    // -------------------------------------------------------------------------

    /**
     * Edit existing application setting by key
     *
     * @since   version 0.1.3
     * @param   string  $key  Setting key name
     * @param   mixed   $val  Setting values
     *
     * @return  mixed
     */
    public static function edit($key, $val)
    {
        $old = self::get($key);

        if ($old != $val and $old !== FALSE)
        {
            log_message('debug', "#Baka_pack: Setting->edit key {$key} has been updated to {$val}.");

            return self::$_ci->db->update(
                self::$_table_name,
                array('opt_value' => $val),
                array('opt_key' => $key)
                );
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Set up new application setting
     *
     * @since   version 0.1.3
     * @param   string  $key  Setting key name
     * @param   mixed   $val  Setting values
     *
     * @return  mixed
     */
    public static function set($key, $val)
    {
        if (!self::is_exists($key))
        {
            return self::$_ci->db>insert(
                self::$_table_name,
                array('opt_key' => $key, 'opt_value' => $val)
                );
        }

        log_message('error', "#Baka_pack: Setting->set can not create new setting, key {$key} is still exists.");
        return FALSE;
    }
}

/* End of file Setting.php */
/* Location: ./application/libraries/Baka_pack/Setting.php */