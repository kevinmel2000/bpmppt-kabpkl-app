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
 * BAKA Library Class
 *
 * @subpackage  Libraries
 * @category    Libraries
 */
class Baka_lib
{
    /** @var array message wrapper */
    protected $messages = array();

    /** @var array error wrapper */
    protected $errors   = array();

    public function __construct()
    {
        log_message('debug', "#Baka_pack: Main Library Class Initialized");
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access  public
     * @param   $var
     * @return  mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function config_item( $item )
    {
        return $this->config->item( 'baka_'.$item );
    }

    public function set_message( $message = '', $rep = '' )
    {
        $messages = _x( $message, $rep );

        $this->messages[] = $messages;

        log_message( 'debug', '#Baka_pack debug: '.$messages );
    }

    public function set_error( $error = '', $rep = '' )
    {
        $errors = _x( $error, $rep );

        $this->errors[] = $errors;

        log_message( 'error', '#Baka_pack error: '.$errors );
    }

    public function messages()
    {
        return $this->messages;
    }

    public function errors()
    {
        return $this->errors;
    }
}

/* End of file Baka_lib.php */
/* Location: ./application/libraries/Baka_pack/Baka_lib.php */