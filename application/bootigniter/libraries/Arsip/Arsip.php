<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Arsip
 * @category    Drivers
 */

// -----------------------------------------------------------------------------

class Arsip extends CI_Driver_Library
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
        'arsip_zip',
        // 'arsip_rar'
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
     * Arsip file path
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
            $this->_formats[] = str_replace('arsip_', '', $supported);
        }

        log_message('debug', "#Arsip: Driver Initialized");
    }

    /**
     * Initialize archive file path
     *
     * @param   string  $file_path  Arsip file path
     *
     * @return  bool
     */
    public function init($file_path, $overwrite = FALSE)
    {
        $this->_type = get_ext($file_path);
        $error = FALSE;

        if (!in_array($this->_type, $this->_formats))
        {
            set_message('error', 'Sorry, but '.$this->_type.' format is unsupported currently.');
            $error = TRUE;
        }

        if (!is_file($file_path) AND !file_exists($file_path))
        {
            set_message('error', 'File '.$file_path.' is not on your server.');
            $error = TRUE;
        }

        if (!is_readable($file_path))
        {
            set_message('error', 'File '.$file_path.' is not readble.');
            $error = TRUE;
        }

        if ($overwrite === FALSE and is_dir($target_dir))
        {
            set_message('error', 'Target '.$target_dir.' is already exists.');
            return FALSE;
        }

        if (!$error)
        {
            $flag = $overwrite ? 'overwrite' : null;
            $this->_archive   = $this->{$this->_type}->_open($file_path, $flag);
            $this->_path_info = pathinfo($file_path);
        }

        return $this;
    }

    public function create($file_path)
    {
        $this->_type = get_ext($file_path);

        if (!in_array($this->_type, $this->_formats))
        {
            set_message('error', 'Sorry, but '.$this->_type.' format is unsupported currently.');
            return FALSE;
        }

        if (is_file($file_path) AND file_exists($file_path))
        {
            set_message('error', 'File '.$file_path.' is already exists.');
            return FALSE;
        }

        $dirname = dirname($file_path);

        if (!is_really_writable($dirname))
        {
            set_message('error', 'Directory '.$dirname.' is not writable.');
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
        $target_dir or $target_dir = $this->_path_info['dirname'].DIRECTORY_SEPARATOR.$this->_path_info['filename'];

        if (!is_really_writable(dirname($target_dir)))
        {
            set_message('error', 'Target '.$target_dir.' is not writable.');
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

/* End of file Arsip.php */
/* Location: ./bootigniter/libraries/Arsip/Arsip.php */
