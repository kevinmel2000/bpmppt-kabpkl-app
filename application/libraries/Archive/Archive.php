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
 * @package     Bapa Pack Archive
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
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
    public $_ci;

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
        $this->_ci =& get_instance();

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
        $error = FALSE;

        if (!in_array($this->_type, $this->_formats))
        {
            Messg::set('error', 'Sorry, but this File type is unsupported currently.');
            $error = TRUE;
        }

        if (!is_file($file_path) AND !file_exists($file_path))
        {
            Messg::set('error', 'File '.$file_path.' is not on your server.');
            $error = TRUE;
        }

        if (!is_readable($file_path))
        {
            Messg::set('error', 'File '.$file_path.' is not readble.');
            $error = TRUE;
        }

        if (!$error)
        {
            $this->_archive     = $this->{$this->_type}->_open($file_path);
            $this->_path_info   = pathinfo($file_path);
        }

        return $this;
    }

    public function create($file_path)
    {
        $this->_type = get_ext($file_path);

        if (!in_array($this->_type, $this->_formats))
        {
            Messg::set('error', 'Sorry, but '.$this->_type.' format is unsupported currently.');
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
    public function extract($target_dir = '', $file_names = array(), $overwrite = FALSE)
    {
        if ($target_dir == '')
        {
            $target_dir = $this->_path_info['dirname'].'/'.$this->_path_info['filename'];
        }

        if ($overwrite === FALSE and is_dir($target_dir))
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

            return $target_dir;
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