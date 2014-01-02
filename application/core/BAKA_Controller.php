<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
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
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Controller Class
 *
 * @subpackage  Libraries
 * @category    Libraries
 */
class BAKA_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ( Themee::verify_browser() AND !(php_sapi_name() === 'cli' OR defined('STDIN')) )
        {
            log_message('error', "error_browser_jadul");
            show_error(array('Peramban yang anda gunakan tidak memenuhi syarat minimal penggunaan aplikasi ini.','Silahkan gunakan '.anchor('http://www.mozilla.org/id/', 'Mozilla Firefox', 'target="_blank"').' atau '.anchor('https://www.google.com/intl/id/chrome/browser/', 'Google Chrome', 'target="_blank"').' biar lebih GREGET!'), 500, 'error_browser_jadul');
        }

        $this->authenticate();

        $this->data['load_toolbar'] = FALSE;
        $this->data['search_form']  = FALSE;
        $this->data['single_page']  = TRUE;
        $this->data['form_page']    = FALSE;
        
        $this->data['need_print']   = FALSE;

        $this->data['tool_buttons'] = array();

        $this->data['panel_title']  = '';
        $this->data['panel_body']   = '';

        log_message('debug', "#Baka_pack: Core Controller Class Initialized");
    }

    protected function _notice( $page )
    {
        redirect('notice/'.$page);
    }

    protected function authenticate()
    {
        if ( uri_string() == 'login' OR uri_string() == 'register' )
        {
            if ( $this->authen->is_logged_in() )
            {
                // logged in
                redirect( 'dashboard' );
            }
            else if ( $this->authen->is_logged_in(FALSE) )
            {
                // logged in, not activated
                redirect('resend');
            }
        }
        else if ( uri_string() != 'login' AND uri_string() != 'resend' AND uri_string() != 'forgot' AND strpos(current_url(), 'auth') === FALSE AND strpos(current_url(), 'notice') === FALSE )
        {
            if ( !$this->authen->is_logged_in() AND !$this->authen->is_logged_in(FALSE) )
                redirect( 'login' );

            if ( $this->authen->is_logged_in(FALSE) )
                redirect( 'resend' );
        }
    }

    /**
     * Email sender using native CI Email Class
     *
     * @param   string  $reciever  Email Reciever
     * @param   string  $subject   Email Subject
     * @param   object  $data      Email Content
     *
     * @return  void
     */
    protected function send_email( $reciever, $subject, &$data )
    {
        // Load Native CI Email Library & setup some configs
        $this->load->library('email', array(
            'protocol'      => Setting::get('email_protocol'),
            'mailpath'      => Setting::get('email_mailpath'),
            'smtp_host'     => Setting::get('email_smtp_host'),
            'smtp_user'     => Setting::get('email_smtp_user'),
            'smtp_pass'     => Setting::get('email_smtp_pass'),
            'smtp_port'     => Setting::get('email_smtp_port'),
            'smtp_timeout'  => Setting::get('email_smtp_timeout'),
            'wordwrap'      => Setting::get('email_wordwrap'),
            'wrapchars'     => 80,
            'mailtype'      => Setting::get('email_mailtype'),
            'charset'       => 'utf-8',
            'validate'      => TRUE,
            'priority'      => Setting::get('email_priority'),
            'crlf'          => "\r\n",
            'newline'       => "\r\n",
            ));

        // Setup Email Sender
        $this->email->from( Setting::get('skpd_email'), Setting::get('skpd_name') );
        $this->email->reply_to( Setting::get('skpd_email'), Setting::get('skpd_name') );

        // Setup Reciever
        $this->email->to( $reciever );
        $this->email->cc( get_conf('app_author_email') );

        // Setup Email Content
        $this->email->subject( _x('email_subject_'.$subject) );
        $this->email->message( $this->load->view('email/'.$subject.'-html', $data, TRUE));
        $this->email->set_alt_message( $this->load->view('email/'.$subject.'-txt', $data, TRUE));

        // Do send the email & clean up
        $this->email->send();
        $this->email->clear();
    }
}

/* End of file BAKA_Controller.php */
/* Location: ./application/core/BAKA_Controller.php */