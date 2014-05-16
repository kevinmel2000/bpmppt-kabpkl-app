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