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
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Email
 * @author		Fery Wardiyanto (http://github.com/feryardiant/)
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
		$config['protocol']			= get_app_setting('email_protocol');
		$config['mailpath']			= get_app_setting('email_mailpath');
		$config['smtp_host']		= get_app_setting('email_smtp_host');
		$config['smtp_user']		= get_app_setting('email_smtp_user');
		$config['smtp_pass']		= get_app_setting('email_smtp_pass');
		$config['smtp_port']		= get_app_setting('email_smtp_port');
		$config['smtp_timeout']		= get_app_setting('email_smtp_timeout');
		$config['wordwrap']			= get_app_setting('email_wordwrap');
		$config['wrapchars']		= 80;
		$config['mailtype']			= get_app_setting('email_mailtype');
		$config['charset']			= 'utf-8';
		$config['validate']			= TRUE;
		$config['priority']			= get_app_setting('email_priority');
		$config['crlf']				= "\r\n";
		$config['newline']			= "\r\n";

		$this->load->library('email', $config);
	}

	public function send( $email_reciever, $subject, &$data )
	{
		$this->email->from( get_app_setting('skpd_email'), get_app_setting('skpd_name') );
		$this->email->reply_to( get_app_setting('skpd_email'), get_app_setting('skpd_name') );

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