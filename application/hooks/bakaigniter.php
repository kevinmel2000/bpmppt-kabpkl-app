<?php if (! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * @package     Baka Igniter Pack
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
class Bakaigniter
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

        log_message('debug', "#BakaIgniter: Hooks Class Initialized");
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
