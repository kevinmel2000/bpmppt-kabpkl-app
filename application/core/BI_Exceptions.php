<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  BI_Exceptions
 * @category    Core
 */

// -----------------------------------------------------------------------------

class BI_Exceptions extends CI_Exceptions
{
    private $_template_path;

    function __construct()
    {
        parent::__construct();

        $this->_template_path = APPPATH.'views/errors/';

        log_message('debug', "#BootIgniter: Core Exceptions Class Initialized");
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

        $template = strpos($template, 'error_') == 0 ? str_replace('error_', '', $template) : $template;
        $template = ( IS_CLI ) ? 'cli' : $template ;

        set_status_header( $status_code );

        if ( ob_get_level() > $this->ob_level + 1 )
        {
            ob_end_flush();
        }

        ob_start();
        include $this->_template_path.$template.EXT;
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

        $template = IS_CLI ? 'cli' : 'php';

        if ( ob_get_level() > $this->ob_level + 1 )
        {
            ob_end_flush();
        }

        ob_start();
        include $this->_template_path.$template.EXT;
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

/* End of file BI_Exceptions.php */
/* Location: ./application/core/BI_Exceptions.php */
