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
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Email Class
 *
 * @subpackage  Libraries
 * @category    Email
 */
class Baka_email Extends Baka_lib
{
    public function __construct()
    {
        $this->initialize();

        log_message('debug', "#Baka_pack: Email Class Initialized");
    }

    public function initialize()
    {
        $config['protocol']         = Setting::get('email_protocol');
        $config['mailpath']         = Setting::get('email_mailpath');
        $config['smtp_host']        = Setting::get('email_smtp_host');
        $config['smtp_user']        = Setting::get('email_smtp_user');
        $config['smtp_pass']        = Setting::get('email_smtp_pass');
        $config['smtp_port']        = Setting::get('email_smtp_port');
        $config['smtp_timeout']     = Setting::get('email_smtp_timeout');
        $config['wordwrap']         = Setting::get('email_wordwrap');
        $config['wrapchars']        = 80;
        $config['mailtype']         = Setting::get('email_mailtype');
        $config['charset']          = 'utf-8';
        $config['validate']         = TRUE;
        $config['priority']         = Setting::get('email_priority');
        $config['crlf']             = "\r\n";
        $config['newline']          = "\r\n";

        $this->load->library('email', $config);
    }

    public function send( $email_reciever, $subject, &$data )
    {
        $this->email->from( Setting::get('skpd_email'), Setting::get('skpd_name') );
        $this->email->reply_to( Setting::get('skpd_email'), Setting::get('skpd_name') );

        $this->email->to( $email_reciever );
        $this->email->cc( get_app_config('app_author_email') );

        $this->email->subject( _x('email_subject_'.$subject) );
        $this->email->message($this->load->view('email/'.$subject.'-html', $data, TRUE));
        $this->email->set_alt_message($this->load->view('email/'.$subject.'-txt', $data, TRUE));

        $this->email->send();
        $this->email->clear();
    }
}

/* End of file Baka_email.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_email.php */