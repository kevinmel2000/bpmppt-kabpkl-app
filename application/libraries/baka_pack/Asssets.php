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
 * BAKA Asssets Class
 *
 * @subpackage  Libraries
 * @category    Assets
 */
class Asssets
{
    /**
     * Codeigniter superobject
     *
     * @var  resource
     */
    protected static $_ci;

    /**
     * Configurations
     *
     * @var  array
     */
    protected static $configs   = array();

    /**
     * Datas
     *
     * @var  array
     */
    protected static $_data     = array();

    /**
     * Scripts Wrapper
     *
     * @var  array
     */
    protected static $_scripts  = array();

    /**
     * Styles Wrapper
     *
     * @var  array
     */
    protected static $_styles   = array();

    /**
     * Class Constructor
     */
    public function __construct()
    {
        self::$_ci =& get_instance();

        log_message('debug', "#Baka_pack: Asssets Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Setup the scripts that you want to loaded on the page
     *
     * @param   string  $id           Script Identifier
     * @param   string  $source_path  Script Path
     * @param   string  $depend       Id of script depend on
     * @param   string  $version      Version number of the script
     * @param   bool    $in_foot      load in foot or head
     * @return  void
     */
    public static function set_script($id, $source_path, $depend = '', $version = '', $in_foot = TRUE)
    {
        $pos = (!$in_foot ? 'head' : 'foot');

        $source_file = self::get_asset('js', $id, $source_path, $version);

        if (self::valid_url($source_file))
        {
            if (isset(self::$_scripts[$pos][$depend]))
            {
                foreach (self::$_scripts[$pos] as $dep_id => $dep_url)
                {
                    $temp_scripts[$dep_id] = $dep_url;

                    if ($dep_id === $depend)
                    {
                        $temp_scripts[$id] = $source_file;
                    }
                }

                self::$_scripts[$pos] = $temp_scripts;
            }
            else
            {
                self::$_scripts[$pos][$id] = $source_file;
            }
        }
        else
        {
            self::$_scripts['src'][$id] = $source_file;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Get all scripts you need on the page
     *
     * @return  array
     */
    public static function get_script($pos)
    {
        if (isset(self::$_scripts[$pos]))
        {
            return self::$_scripts[$pos];
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Setup the styles that you want to loaded on the page
     *
     * @param   string  $id           Style Identifier
     * @param   string  $source_path  Style Path
     * @param   string  $depend       Id of style depend on
     * @param   string  $version      Version number of the style
     * @return  void
     */
    public static function set_style($id, $source_path, $depend = '', $version = NULL)
    {
        $source_file = self::get_asset('css', $id, $source_path, $version);

        if (self::valid_url($source_file))
        {
            if (isset(self::$_styles[$depend]))
            {
                foreach (self::$_styles as $dep_id => $dep_url)
                {
                    $temp_styles[$dep_id] = $dep_url;

                    if ($dep_id === $depend)
                    {
                        $temp_styles[$id] = $source_file;
                    }
                }

                self::$_styles = $temp_styles;
            }
            else
            {
                self::$_styles[$id] = $source_file;
            }
        }
        else
        {
            self::$_styles['src'][$id] = $source_file;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Get all styles you need on the page
     *
     * @return  array
     */
    public static function get_styles()
    {
        if (isset(self::$_styles))
        {
            return self::$_styles;
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Make sure the required assets are in right place :P
     *
     * @param   string  $type         Asset type (css|js)
     * @param   string  $id           Asset Identifier which can't be redundant
     * @param   string  $source_path  Asset path
     * @param   string  $version      Asset Version number
     * @return  string
     */
    protected static function get_asset($type, $id, $source_path, $version = '')
    {
        $version || $version = get_conf('app_version');
        $path   = 'asset/'.$type.'/';
        $output = '';

        $version = (strpos($source_path, '?') !== FALSE ? '&' :  '?').'ver='.$version;

        if (file_exists(FCPATH.$path.$source_path))
        {
            $output = base_url($path.$source_path);
            // $output = base_url($path.$source_path).$version;
        }
        else if (self::valid_url($source_path))
        {
            $output = $source_path;
            // $output = $source_path.$version;
        }
        else
        {
            $output = $source_path;
        }

        return $output;
    }

    // -------------------------------------------------------------------------

    protected static function valid_url($url)
    {
        $url_pattern = "/^(http(s?):\/\/|(\/\/?))/";

        return preg_match($url_pattern, $url) ? TRUE : FALSE;
    }
}

/* End of file Asssets.php */
/* Location: ./application/libraries/baka_pack/Asssets.php */