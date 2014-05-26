<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
 * @package     CodeIgniter Baka Pack
 * @subpackage  Email
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * Email sender using native CI Email Class
 *
 * @param   string  $reciever  Email Reciever
 * @param   string  $subject   Email Subject
 * @param   object  $data      Email Content
 *
 * @return  void
 */
function emailer_send( $reciever, $subject, &$data )
{
    $ci =& get_instance();

    // Load Native CI Email Library & setup some configs
    $ci->load->library('email', array(
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
    $ci->email->from( Setting::get('skpd_email'), Setting::get('skpd_name') );
    $ci->email->reply_to( Setting::get('skpd_email'), Setting::get('skpd_name') );

    // Setup Reciever
    $ci->email->to( $reciever );
    $ci->email->cc( get_conf('app_author_email') );

    // Setup Email Content
    $ci->email->subject( _x('email_subject_'.$subject) );
    $ci->email->message( $ci->load->view('email/'.$subject.'-html', $data, TRUE));
    $ci->email->set_alt_message( $ci->load->view('email/'.$subject.'-txt', $data, TRUE));

    // Do send the email & clean up
    $ci->email->send();
    $ci->email->clear();
}

/* End of file emailer_helper.php */
/* Location: ./application/helpers/baka_pack/emailer_helper.php */