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
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
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

    protected $_is_cli;

    function __construct()
    {
        parent::__construct();

        $this->_is_cli = php_sapi_name() === 'cli' OR defined('STDIN');

        $this->_template_path = APPPATH.'views/errors/';

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