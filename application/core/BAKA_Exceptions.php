<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
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
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Exceptions Class
 *
 * @subpackage  Core
 * @category    Exceptions
 */
class BAKA_Exceptions extends CI_Exceptions
{
    private $_template_path;

    private $_is_cli;

    function __construct()
    {
        parent::__construct();

        $this->_template_path = APPPATH.'views/errors/';

        if (defined('PHPUNIT_TEST'))
        {
            $this->_is_cli = FALSE;
        }
        else
        {
            $this->_is_cli = (php_sapi_name() === 'cli' OR defined('STDIN'));
        }

        // $this->load =& load_class('Loader', 'core');

        log_message('debug', "#Baka_pack: Core Exceptions Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * General Error Page Modifier
     *
     * @access  private
     * @param   string   the heading
     * @param   string   the message
     * @param   string   the template name
     * @param   int      the status code
     * @return  string
     */
    function show_error( $heading, $message, $template = 'error_general', $status_code = 500 )
    {
        // print_pre(get_config());
        $heading = $heading;
        $message = '<p>'.implode('</p><p>', ( ! is_array($message)) ? array($message) : $message).'</p>';

        $alt = ( $this->_is_cli ) ? '-cli' : '' ;

        set_status_header( $status_code );

        if ( ob_get_level() > $this->ob_level + 1 )
        {
            ob_end_flush();
        }
        
        ob_start();
        include( $this->_template_path.$template.$alt.EXT );
        $buffer = ob_get_contents();
        ob_end_clean();
        
        return $buffer;
    }

    // -------------------------------------------------------------------------

    /**
     * Native PHP error Modifier
     *
     * @access  private
     * @param   string  the error severity
     * @param   string  the error string
     * @param   string  the error filepath
     * @param   string  the error line number
     * 
     * @return  string
     */
    function show_php_error( $severity, $message, $filepath, $line )
    {
        $severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];

        $filepath = str_replace("\\", "/", $filepath);

        // For safety reasons we do not show the full file path
        if (FALSE !== strpos($filepath, '/'))
        {
            $x = explode('/', $filepath);
            $filepath = $x[count($x)-2].'/'.end($x);
        }

        $alt = ( $this->_is_cli ? '_cli' : '_php' );

        if ( ob_get_level() > $this->ob_level + 1 )
        {
            ob_end_flush();
        }

        ob_start();
        include( $this->_template_path.'error'.$alt.EXT );
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }

    // -------------------------------------------------------------------------

    /**
     * 404 Page Not Found Handler
     *
     * @access  private
     * @param   string  $page       The page
     * @param   bool    $log_error  Log it or not
     *
     * @return  string
     */
    function show_404($page = '', $log_error = TRUE)
    {
        $heading = "404 Page Not Found";
        $message = "The page you requested was not found.";
        $page || $page = current_url();

        // By default we log this, but allow a dev to skip it
        if ($log_error)
        {
            log_message('error', '404 Page Not Found --> '.$page);
        }

        echo $this->show_error($heading, $message, 'error_404', 404);
        exit;
    }
}

/* End of file BAKA_Exceptions.php */
/* Location: ./application/core/BAKA_Exceptions.php */