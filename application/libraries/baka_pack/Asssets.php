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
 * BAKA Printing Class
 *
 * @subpackage  Libraries
 * @category    Printing
 */
class Asssets
{
    /**
     * Codeigniter superobject
     *
     * @var  mixed
     */
    protected static $_ci;

    protected static $configs   = array();

    protected static $_data     = array();

    public static $_scripts  = array();

    protected static $_styles   = array();

    public function __construct()
    {
        self::$_ci =& get_instance();

        // self::$_scripts['head'] = array();
        // self::$_scripts['foot'] = array();

        $this->set_body_attr('id', self::$_ci->router->fetch_class() );

        // print_pre(self::$_scripts);

        log_message('debug', "#Baka_pack: Theme Class Initialized");
    }

    // -------------------------------------------------------------------------

    public function set_title($page_title)
    {
        $this->set_body_attr('class', url_title($page_title, '-', TRUE) );
    }

    // -------------------------------------------------------------------------

    private function set_body_attr($key, $val)
    {
        if (!in_array($key, array('id', 'class')))
        {
            log_message('error', 'Asssets lib: '.$key.' body attribute is not supported.');
            return FALSE;
        }

        if ($key == 'id')
        {
            self::$_data['body']['id'] = 'page-'.$val;
            self::$_data['body']['class'] = 'page '.$val;
        }
        else if ($key == 'class')
        {
            self::$_data['body']['class'] .= ' '.$val;
        }
    }

    // -------------------------------------------------------------------------

    public static function get_body_attrs()
    {
        $attrs = '';

        foreach (self::$_data['body'] as $key => $val)
        {
            $attrs .= $key.'="'.$val.'" ';
        }

        echo $attrs;
    }

    // -------------------------------------------------------------------------

    public static function set_script($id, $source_path, $depend = '', $version = '', $in_foot = TRUE)
    {
        $version || $version = get_conf('app_version');
        $pos = (!$in_foot ? 'head' : 'foot');

        $path = 'asset/js/';
        $url_pattern = "/^(http(s?):\/\/|(\/\/?))/";

        if (file_exists(FCPATH.$path.$source_path))
        {
            $source_file = base_url($path.$source_path).'?ver='.$version;
        }
        else if (preg_match($url_pattern, $source_path))
        {
            $source_file = $source_path.'?ver='.$version;
        }
        else
        {
            $source_file = $source_path;
        }

        if (preg_match($url_pattern, $source_file))
        {
            if (isset(self::$_scripts[$pos][$depend]))
            {
                foreach (self::$_scripts[$pos] as $dep_id => $dep_url)
                {
                    $temp_scripts[$dep_id] = $dep_url;

                    if ($dep_id === $depend)
                        $temp_scripts[$id] = $source_file;
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
    
    public static function get_script($pos)
    {
        if (isset(self::$_scripts[$pos]))
            return self::$_scripts[$pos];

        return FALSE;
    }

    // -------------------------------------------------------------------------

    public static function set_style($id, $source_path, $depend = '', $version = NULL)
    {
        $version || $version = get_conf('app_version');
        $path = 'asset/css/';
        $url_pattern = "/^(http(s?):\/\/|(\/\/?))/";

        if (file_exists(FCPATH.$path.$source_path))
        {
            $source_file = base_url($path.$source_path).'?ver='.$version;
        }
        else if (preg_match($url_pattern, $source_path))
        {
            $source_file = $source_path.'?ver='.$version;
        }
        else
        {
            $source_file = $source_path;
        }

        if (preg_match($url_pattern, $source_file))
        {
            if (isset(self::$_styles[$depend]))
            {
                foreach (self::$_styles as $dep_id => $dep_url)
                {
                    $temp_styles[$dep_id] = $dep_url;

                    if ($dep_id === $depend)
                        $temp_styles[$id] = $source_file;
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

    public function get_styles()
    {
        if (isset(self::$_styles))
            return self::$_styles;

        return FALSE;
    }
}

/* End of file Asssets.php */
/* Location: ./application/libraries/baka_pack/Asssets.php */