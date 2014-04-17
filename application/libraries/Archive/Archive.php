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
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Archive Library Class
 *
 * @category    Archives
 * @subpackage  Drivers
 */
class Archive extends CI_Driver_Library
{
    /**
     * Codeigniter super object
     *
     * @var  mixed
     */
    private static $_ci;

    /**
     * valid drivers
     *
     * @var array
     */
    public $valid_drivers = array(
        'archive_zip',
        // 'archive_rar'
        );

    /**
     * Available formats
     *
     * @var  array
     */
    private $_formats = array();

    /**
     * Used archive format
     *
     * @var  string
     */
    private $_type;

    /**
     * Archive file path
     *
     * @var  string
     */
    private $_archive;

    private $_path_info = array();

    /**
     * Error wrapper
     *
     * @var  array
     */
    protected $_errors = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        self::$_ci =& get_instance();

        foreach ($this->valid_drivers as $supported)
        {
            $this->_formats[] = str_replace('archive_', '', $supported);
        }

        log_message('debug', "#Archive: Driver Initialized");
    }

    /**
     * Initialize archive file path
     *
     * @param   string  $file_path  Archive file path
     *
     * @return  bool
     */
    public function init($file_path)
    {
        $this->_type = get_ext($file_path);

        if (!in_array($this->_type, $this->_formats))
        {
            Messg::set('error', 'Sorry, but this format is unsupported currently.');
            return FALSE;
        }

        if (!is_file($file_path) AND !file_exists($file_path))
        {
            Messg::set('error', 'File '.$file_path.' is not on your server.');
            return FALSE;
        }

        if (!is_readable($file_path))
        {
            Messg::set('error', 'File '.$file_path.' is not readble.');
            return FALSE;
        }

        $this->_archive     = $this->{$this->_type}->_open($file_path);
        $this->_path_info   = pathinfo($file_path);

        return $this;
    }

    public function create($file_path)
    {
        $this->_type = get_ext($file_path);

        if (!in_array($this->_type, $this->_formats))
        {
            Messg::set('error', 'Sorry, but this format is unsupported currently.');
            return FALSE;
        }

        if (is_file($file_path) AND file_exists($file_path))
        {
            Messg::set('error', 'File '.$file_path.' is already exists.');
            return FALSE;
        }

        $dirname = dirname($file_path);

        if (!is_really_writable($dirname))
        {
            Messg::set('error', 'Directory '.$dirname.' is not writable.');
            return FALSE;
        }

        $this->_archive = $this->{$this->_type}->_create($file_path);

        return $this;
    }

    /**
     * Read archive file
     *
     * @return  mixed
     */
    public function read()
    {
        if ($this->_archive)
        {
            return $this->{$this->_type}->_read();
        }
        
        return FALSE;
    }

    /**
     * Extract archive file
     * 
     * @param   string  $target_dir  Extract target directory
     * @param   array   $file_names  Selected file(s) which will extracted
     *
     * @return  bool
     */
    public function extract($target_dir = '', $file_names = array())
    {
        if ($target_dir == '')
        {
            $target_dir = $this->_path_info['dirname'].'/'.$this->_path_info['filename'];
        }

        if (is_dir($target_dir))
        {
            Messg::set('error', 'Target '.$target_dir.' is already exists.');
            return FALSE;
        }

        if (!is_really_writable(dirname($target_dir)))
        {
            Messg::set('error', 'Target '.$target_dir.' is not writable.');
            return FALSE;
        }

        if ($this->_archive)
        {
            $this->{$this->_type}->_extract($target_dir, $file_names);
            $this->close();

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Close the archive file
     *
     * @return  void
     */
    public function close()
    {
        $this->{$this->_type}->_close();
    }

    /**
     * Display error messages
     *
     * @return  array
     */
    public function errors()
    {
        if (!empty($this->_errors))
        {
            return $this->_errors;
        }
    }
}

/* End of file Archive.php */
/* Location: ./application/libraries/Archive/Archive.php */