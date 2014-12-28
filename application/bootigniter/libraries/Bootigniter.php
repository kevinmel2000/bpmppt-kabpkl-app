<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bootigniter
 * @category    Libraries
 */

// -----------------------------------------------------------------------------

class Bootigniter
{
    /**
     * BootIgniter Version
     *
     * @var  resource
     */
    const VERSION = '0.1.6';

    /**
     * Bakaigniter instance object
     *
     * @var  resource
     */
    private static $_instance;

    /**
     * Codeigniter instance object
     *
     * @var  resource
     */
    protected $_ci;

    /**
     * Package properties
     *
     * @var  object
     */
    protected static $_package;

    /**
     * All application settings data
     *
     * @var  array
     */
    protected static $_settings;

    /**
     * Messages wrapper
     *
     * @var  array
     */
    protected $_messages = array();

    /**
     * Messages Types
     *
     * @var  array
     */
    public $_message_types = array('success', 'info', 'warning', 'error');

    /**
     * Default class constructor
     */
    public function __construct()
    {
        // Get instanciation of CI Super Object
        $this->_ci =& get_instance();

        if (config_item('migration_enabled') === TRUE)
        {
            $this->_ci->load->library('migration');
            $this->_ci->migration->current();
        }

        // Load database
        $this->_ci->load->database();

        // Loading base configuration
        $this->_ci->config->load('bootigniter');
        // Loading Application configuration
        $this->_ci->config->load('application');
        // Loading base language translation
        $this->_ci->lang->load('bootigniter');

        if ($query = $this->_ci->db->get(config_item('bi_setting_table')))
        {
            foreach ($query->result() as $row)
            {
                static::$_settings[$row->key] = $row->value;
            }
        }
        // print_pre(static::$_settings);$this->_ci->load->helper('file');

        // Load helpers
        $this->_ci->load->helpers(array('url', 'date', 'file', 'array', 'biarray', 'bidata'));
        // Load Authentication Library
        $this->_ci->load->driver('biauth');
        $this->_ci->load->library('bitheme');
        $this->_ci->load->library('biasset');

        $package = read_file(FCPATH.'package.json');
        static::$_package = json_decode($package);
        // print_pre(static::$_package);

        log_message('debug', "#BootIgniter: BootIgniter Class Initialized");

        self::$_instance =& $this;
    }

    // -------------------------------------------------------------------------

    /**
     * BootIgniter instanciable method
     *
     * @return  resource
     */
    public static function &get_instance()
    {
        if (!self::$_instance)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    // -------------------------------------------------------------------------

    /**
     * Initializing application settings
     *
     * @return  void
     */
    protected function initialize()
    {
        if ($query = $this->_ci->db->get(config_item('bi_setting_table')))
        {
            foreach ($query->result() as $row)
            {
                static::$_settings[$row->key] = $row->value;
            }
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Get all application settings in array
     *
     * @return  array
     */
    public static function get_settings()
    {
        return (array) static::$_settings;
    }

    // -------------------------------------------------------------------------

    /**
     * Is application setting is exists?
     *
     * @param   string  $key  Setting key name
     *
     * @return  bool
     */
    public function is_setting_exists($key)
    {
        return isset(static::$_settings[$key]);
    }

    // -------------------------------------------------------------------------

    /**
     * Get application setting
     *
     * @param   string  $key  Setting key name
     *
     * @return  mixed
     */
    public static function get_setting($key)
    {
        if (isset(static::$_settings[$key]))
        {
            return static::$_settings[$key];
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Edit existing application setting by key
     *
     * @param   string  $key  Setting key name
     * @param   mixed   $val  Setting values
     *
     * @return  mixed
     */
    public function edit_setting($key, $val = null)
    {
        if ($key == 'auth_login_attempt_expire' or $key == 'auth_email_act_expire')
        {
            $val *= 86400;
        }

        $return = TRUE;

        if (is_array($key) and is_null($val))
        {
            $this->_ci->db->trans_start();

            foreach ($key as $k => $v)
            {
                if (!$this->edit_setting($k, $v))
                {
                    $return = FALSE;
                    break;
                }
            }

            $this->_ci->db->trans_complete();
        }
        else
        {
            if (($old = static::get_setting($key)) and $old != $val)
            {
                if (!$this->_ci->db->update(config_item('bi_setting_table'), array('value' => $val), array('key' => $key)))
                {
                    log_message('error', "#BootIgniter: Setting->edit key {$key} has been updated to {$val}.");
                    $return = FALSE;
                }
            }
        }

        return $return;
    }

    // -------------------------------------------------------------------------

    /**
     * Set up new application setting
     *
     * @param   string  $key  Setting key name
     * @param   mixed   $val  Setting values
     *
     * @return  mixed
     */
    public function set_setting($key, $val)
    {
        if (!isset(static::$_settings[$key]))
        {
            $data = array(
                'key'   => $key,
                'value' => $val
                );

            if ($return = $this->_ci->db->insert(config_item('bi_setting_table'), $data))
            {
                log_message('debug', "#BootIgniter: Setting->edit key {$key} has been updated to {$val}.");
            }

            return $return;
        }

        log_message('error', "#BootIgniter: Setting->set can not create new setting, key {$key} is still exists.");
        return FALSE;
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

    public static function app($key)
    {
        if (property_exists(static::$_package, $key))
        {
            return static::$_package->$key;
        }
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
        if (!in_array($level, $this->_message_types))
        {
            log_message('error', '#BootIgniter: set_message Unkown message level "'.$level.'"');
            return FALSE;
        }

        if (is_array($msg_item) and count($msg_item) > 0)
        {
            foreach ($msg_item as $item)
            {
                $this->set_message($level, $item);
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

    // -------------------------------------------------------------------------

    /**
     * Email sender helper
     *
     * @param   string  $reciever  Email reciepant
     * @param   string  $subject   Email Subject
     * @param   object  $data      Email data
     * @return  void
     */
    public function send_email($reciever, $subject, &$data)
    {
        if ($email_protocol = static::get_setting('email_protocol'))
        {
            // Load Native CI Email Library & setup some configs
            $this->_ci->load->library('email');

            $email = $this->_ci->email->initialize(array(
                'protocol'      => $email_protocol,
                'mailpath'      => static::get_setting('email_mailpath'),
                'smtp_host'     => static::get_setting('email_smtp_host'),
                'smtp_user'     => static::get_setting('email_smtp_user'),
                'smtp_pass'     => static::get_setting('email_smtp_pass'),
                'smtp_port'     => static::get_setting('email_smtp_port'),
                'smtp_timeout'  => static::get_setting('email_smtp_timeout'),
                'wordwrap'      => static::get_setting('email_wordwrap'),
                'wrapchars'     => 80,
                'mailtype'      => static::get_setting('email_mailtype'),
                'charset'       => 'utf-8',
                'validate'      => TRUE,
                'priority'      => static::get_setting('email_priority'),
                'crlf'          => "\r\n",
                'newline'       => "\r\n",
                ));

            // Setup Email Sender
            $email->from(static::get_setting('skpd_email'), static::get_setting('skpd_name'));
            $email->reply_to(static::get_setting('skpd_email'), static::get_setting('skpd_name'));

            // Setup Reciever
            $email->to($reciever);

            if ($author = Bootigniter::app('author_email'))
            {
                $email->cc($author->email);
            }

            if (substr($subject, 0, 5) == 'lang:')
            {
                $subject = str_replace('lang:', '', $subject);
                $subject = _x('email_subject_'.$subject);
            }

            // Setup Email Content
            $email->subject($subject);
            $email->message($this->_ci->load->view('email/'.$subject.'-html', $data, TRUE));
            $email->set_alt_message($this->_ci->load->view('email/'.$subject.'-txt', $data, TRUE));

            // Do send the email & clean up
            $return = $email->send();
            $email->clear();

            return $return;
        }

        return FALSE;
    }
}

/* End of file Bakaigniter.php */
/* Location: ./bootigniter/libraries/Bakaigniter.php */
