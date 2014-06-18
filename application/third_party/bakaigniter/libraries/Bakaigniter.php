<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package     Baka Igniter Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @version     Version 0.1.4
 * @since       Version 0.1.0
 */

// -----------------------------------------------------------------------------

/**
 * Baka Igniter Bootstrap Class
 *
 * @subpackage  Libraries
 * @category    Bootstrap
 */
class Bakaigniter
{
    /**
     * Codeigniter superobject
     *
     * @var  resource
     */
    protected $_ci;

    /**
     * Settings table name
     *
     * @var  string
     */
    protected $_setting_table;

    /**
     * All application settings data
     *
     * @var  array
     */
    protected $_settings;

    /**
     * All application settings data
     *
     * @var  array
     */
    protected $_configs;

    /**
     * Messages wrapper
     *
     * @var  array
     */
    protected $_messages = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        $this->_ci =& get_instance();

        $this->_ci->config->load('bakaigniter');
        $this->_ci->lang->load('bakaigniter');

        $this->_ci->load->driver('authr');
        $this->_ci->load->library('messg');
        $this->_ci->load->library('themee');
        $this->_ci->load->helpers(array('date', 'array', 'baka_array', 'baka_data'));

        $this->_table_name = get_conf('system_opt_table');

        $this->initialize();

        log_message('debug', "#BakaIgniter: Bakaigniter Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Initializing application settings
     *
     * @since   version 0.1.3
     * 
     * @return  void
     */
    protected function initialize()
    {
        $query = $this->_ci->db->get( $this->_table_name );

        foreach ( $query->result() as $row )
        {
            $this->_settings[$row->opt_key] = $row->opt_value;
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
    public function get_settings()
    {
        return (array) $this->_settings;
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
    public function is_setting_exists( $key )
    {
        return isset( $this->_settings[$key] );
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
    public function get_setting( $key )
    {
        if ( isset( $this->_settings[$key] ) )
        {
            return $this->_settings[$key];
        }
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
    public function edit_setting( $key, $val )
    {
        if ( ( $old = $this->get_setting( $key ) ) and $old != $val )
        {
            if ( $return = $this->_ci->db->update( $this->_table_name, array('opt_value' => $val), array('opt_key' => $key) ) )
            {
                log_message('debug', "#BakaIgniter: Setting->edit key {$key} has been updated to {$val}.");
            }

            return $return;
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
    public function set_setting( $key, $val )
    {
        if ( !isset( $this->_settings[$key] ) )
        {
            $data = array(
                'opt_key'   => $key,
                'opt_value' => $val
                );

            if ( $return = $this->_ci->db->insert( $this->_table_name, $data ) )
            {
                log_message('debug', "#BakaIgniter: Setting->edit key {$key} has been updated to {$val}.");
            }

            return $return;
        }

        log_message('error', "#BakaIgniter: Setting->set can not create new setting, key {$key} is still exists.");
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
    public function get_message( $level = FALSE )
    {
        if ($level and isset($this->_messages[$level]))
        {
            return $this->_messages[$level];
        }

        return $this->_messages;
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
    public function set_message( $level, $msg_item )
    {
        if (!in_array($level, array('success', 'info', 'warning', 'error')))
        {
            log_message('error', '#BakaIgniter: Messg->set Unkown message level "'.$level.'"');
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
    public function send_email( $reciever, $subject, &$data )
    {
        $email_conf = array(
            'protocol'      => $this->get_setting('email_protocol'),
            'mailpath'      => $this->get_setting('email_mailpath'),
            'smtp_host'     => $this->get_setting('email_smtp_host'),
            'smtp_user'     => $this->get_setting('email_smtp_user'),
            'smtp_pass'     => $this->get_setting('email_smtp_pass'),
            'smtp_port'     => $this->get_setting('email_smtp_port'),
            'smtp_timeout'  => $this->get_setting('email_smtp_timeout'),
            'wordwrap'      => $this->get_setting('email_wordwrap'),
            'wrapchars'     => 80,
            'mailtype'      => $this->get_setting('email_mailtype'),
            'charset'       => 'utf-8',
            'validate'      => TRUE,
            'priority'      => $this->get_setting('email_priority'),
            'crlf'          => "\r\n",
            'newline'       => "\r\n",
            );

        // Load Native CI Email Library & setup some configs
        $this->_ci->load->library('email', $email_conf);

        // Setup Email Sender
        $this->_ci->email->from( $this->get_setting('skpd_email'), $this->get_setting('skpd_name') );
        $this->_ci->email->reply_to( $this->get_setting('skpd_email'), $this->get_setting('skpd_name') );

        // Setup Reciever
        $this->_ci->email->to( $reciever );
        $this->_ci->email->cc( get_conf('app_author_email') );

        // Setup Email Content
        $this->_ci->email->subject( _x('email_subject_'.$subject) );
        $this->_ci->email->message( $this->_ci->load->view('email/'.$subject.'-html', $data, TRUE));
        $this->_ci->email->set_alt_message( $this->_ci->load->view('email/'.$subject.'-txt', $data, TRUE));

        // Do send the email & clean up
        $this->_ci->email->send();
        $this->_ci->email->clear();
    }
}

/* End of file Bakaigniter.php */
/* Location: ./application/third_party/bakaigniter/libraries/Bakaigniter.php */