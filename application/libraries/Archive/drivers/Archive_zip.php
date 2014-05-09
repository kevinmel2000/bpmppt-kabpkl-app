<?php if (! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Baka_pack Archive Drivers
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
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Archive Zip Driver Class
 *
 * @category    Archives
 * @subpackage  Drivers
 */
class Archive_zip extends CI_Driver
{
    private static $_zip;

    private static $_flags = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        if (class_exists('ZipArchive'))
        {
            self::$_zip = new ZipArchive;
        }

        self::$_flags = array(
            'overwrite' => ZipArchive::OVERWRITE,
            'create'    => ZipArchive::CREATE,
            'excl'      => ZipArchive::EXCL,
            'checkcons' => ZipArchive::CHECKCONS
            );

        log_message('debug', "#Archive_driver: Zip Class Initialized");
    }

    public function _open($file_path, $flag = null)
    {
        if (!is_null($flag) and isset(self::$_flags[$flag]))
        {
            $flag = self::$_flags[$flag];
        }

        return self::$_zip->open($file_path, $flag);
    }

    public function _read()
    {
        $ret = array();

        for ($i = 0; $i < self::$_zip->numFiles ; $i++)
        {
            $content = self::$_zip->statIndex($i);
            
            $ret[$i]['name']    = $content['name'];
            $ret[$i]['type']    = get_ext($content['name']);
            $ret[$i]['size']    = format_size($content['size']);
            $ret[$i]['crc']     = $content['crc'];
            $ret[$i]['csize']   = $content['comp_size'];
            $ret[$i]['mtime']   = $content['mtime'];
            $ret[$i]['cmethod'] = $content['comp_method'];
        }

        return $ret;
    }

    public function _extract($dir_path, $file_names = array())
    {
        if (!empty($file_names))
        {
            self::$_zip->extractTo($dir_path, $file_names);
        }
        else
        {
            self::$_zip->extractTo($dir_path);
        }
    }

    public function _create($file_path)
    {
        return $this->_open($file_path, 'create');
    }

    public function _close()
    {
        self::$_zip->close();
    }
}

/* End of file Archive_zip.php */
/* Location: ./application/libraries/Archive/drivers/Archive_zip.php */