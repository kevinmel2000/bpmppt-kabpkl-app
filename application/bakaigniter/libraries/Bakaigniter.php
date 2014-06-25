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
     * Codeigniter instance object
     *
     * @var  resource
     */
    protected $_ci;

    /**
     * Bakaigniter instance object
     *
     * @var  resource
     */
    private static $_instance;

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
     * Messages Types
     *
     * @var  array
     */
    public $_message_types = array( 'success', 'info', 'warning', 'error' );

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

        self::$_instance = $this;

        $this->_ci->config->load('bakaigniter');
        $this->_ci->lang->load('bakaigniter');

        $this->_ci->load->driver('authr');
        $this->_ci->load->library('themee');
        $this->_ci->load->helpers(array('date', 'array', 'baka_array', 'baka_data'));

        $this->_table_name = get_conf('system_opt_table');

        $this->initialize();

        log_message('debug', "#BakaIgniter: Bakaigniter Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * BakaIgniter instanciable method
     *
     * @return  resource
     */
    public static function &get_instance()
    {
        if ( !self::$_instance )
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
    public function edit_setting( $key, $val = null )
    {
        if ( $key == 'auth_login_attempt_expire' or $key == 'auth_email_act_expire' )
        {
            $val *= 86400;
        }

        $return = FALSE;

        if ( is_array($key) and is_null($val) )
        {
            $this->_ci->db->trans_start();

            foreach ( $key as $k => $v )
            {
                $return = $this->edit_setting( $k, $v );
            }

            $this->_ci->db->trans_complete();
        }
        else
        {
            if ( ( $old = $this->get_setting($key) ) and $old != $val )
            {
                if ( $this->_ci->db->update( $this->_table_name, array('opt_value' => $val), array('opt_key' => $key) ) )
                {
                    log_message('debug', "#BakaIgniter: Setting->edit key {$key} has been updated to {$val}.");
                    $return = TRUE;
                }
            }
        }

        return $return;
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
        if (!in_array($level, $this->_message_types))
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
        if ( $email_protocol = $this->get_setting('email_protocol') )
        {
            // Load Native CI Email Library & setup some configs
            $this->_ci->load->library('email', array(
                'protocol'      => $email_protocol,
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
                ));

            // Setup Email Sender
            $this->_ci->email->from( $this->get_setting('skpd_email'), $this->get_setting('skpd_name') );
            $this->_ci->email->reply_to( $this->get_setting('skpd_email'), $this->get_setting('skpd_name') );

            // Setup Reciever
            $this->_ci->email->to( $reciever );

            if ( $author_email = get_conf('app_author_email') )
            {
                $this->_ci->email->cc( $author_email );
            }

            if ( substr($subject, 0, 5) == 'lang:' )
            {
                $subject = str_replace('lang:', '', $subject);
                $subject = _x('email_subject_'.$subject);
            }

            // Setup Email Content
            $this->_ci->email->subject( $subject );
            $this->_ci->email->message( $this->_ci->load->view('email/'.$subject.'-html', $data, TRUE));
            $this->_ci->email->set_alt_message( $this->_ci->load->view('email/'.$subject.'-txt', $data, TRUE));

            // Do send the email & clean up
            $return = $this->_ci->email->send();
            $this->_ci->email->clear();

            return $return;
        }

        return FALSE;
    }
}

/* End of file Bakaigniter.php */
/* Location: ./application/third_party/bakaigniter/libraries/Bakaigniter.php */
