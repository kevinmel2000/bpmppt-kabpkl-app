<?php if (! defined('BASEPATH')) exit('No direct script access allowed'); 

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
 * Hooks Class
 *
 * @subpackage  Hooks
 * @category    Hooks
 */
class Baka_pack
{
    /**
     * Codeigniter superobject
     *
     * @var  resource
     */
    protected $_ci;

    /**
     * PHP-Error Options
     *
     * @link  https://github.com/JosephLenton/PHP-Error/wiki/Options
     * @var   array
     */
    protected $error_conf = array(
        // 'clear_all_buffers'         => FALSE,
        'application_folders'       => '',
        'application_root'          => '',
        'background_text'           => '',
        'catch_ajax_errors'         => TRUE,
        'catch_supressed_errors'    => FALSE,
        'catch_class_not_found'     => TRUE,
        'display_line_numbers'      => TRUE,
        'enable_saving'             => FALSE,
        // 'error_reporting_on'        => -1,
        // 'error_reporting_off'       => '',
        'ignore_folders'            => '',
        'save_url'                  => '',
        'server_name'               => '',
        'wordpress'                 => FALSE,
        );

    /**
     * Default class constructor
     */
    public function __construct()
    {
        $this->_ci =& get_instance();

        log_message('debug', "#Baka_pack: Hooks Class Initialized");
    }

    /**
     * Error handler method
     *
     * @return  void
     */
    public function get_output()
    {
        $output = $this->_ci->output->get_output();

        if (!defined('PROJECT_DIR'))
        {
            return;
        }
    }

    /**
     * Error handler method
     *
     * @link    https://github.com/JosephLenton/PHP-Error/wiki/Options
     * @return  void
     */
    public function error_handler()
    {
        /**
         * PHP_Error Options Array
         *
         * @var   array
         */
        $this->error_conf['application_folders'] = APPPATH;
        $this->error_conf['ignore_folders']      = BASEPATH;

        // var_dump(APPPATH);
        if (!class_exists('\php_error\ErrorHandler'))
        {
            require_once(APPPATH.'libraries/vendor/php_error'.EXT);
        }

        $handler = new \php_error\ErrorHandler($this->error_conf);

        switch (ENVIRONMENT)
        {
            case 'development':
                $handler->turnOn();
                break;
        
            case 'testing':
            case 'production':
                $handler->turnOff();
                break;
        }
    }
}

/* End of file Errror.php */
/* Location: ./application/hooks/Errror.php */
