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

        // $this->authenticate();

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
            if ( Authen::is_logged_in() )
                redirect( 'dashboard' );
            else if ( Authen::is_logged_in(FALSE) )
                redirect('resend');
        }
        else if ( uri_string() != 'login' AND uri_string() != 'resend' AND uri_string() != 'forgot' AND strpos(current_url(), 'auth') === FALSE AND strpos(current_url(), 'notice') === FALSE )
        {
            if ( !Authen::is_logged_in() AND !Authen::is_logged_in(FALSE) )
                redirect( 'login' );

            if ( Authen::is_logged_in(FALSE) )
                redirect( 'resend' );
        }
    }

    /**
     * User login verification
     *
     * @return  void
     */
    protected function verify_login()
    {
        if ( !Authen::is_logged_in() AND !Authen::is_logged_in(FALSE) )
            redirect( 'login' );
        
        if ( Authen::is_logged_in(FALSE) )
            redirect( 'resend' );
    }

    /**
     * User status verification
     *
     * @return  void
     */
    protected function verify_status()
    {
        if ( Authen::is_logged_in() )
            redirect( 'dashboard' );
        else if ( Authen::is_logged_in(FALSE) )
            redirect('resend');
    }
}

/* End of file BAKA_Controller.php */
/* Location: ./application/core/BAKA_Controller.php */