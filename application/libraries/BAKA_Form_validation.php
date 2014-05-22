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
 * BAKA Form Validation Class
 *
 * Pre-processes global input data for security
 * Extending native CI Form Validation
 *
 * @subpackage  Libraries
 * @category    Validation
 */
class BAKA_Form_validation extends CI_Form_validation
{
    /**
     * Default Class Constructor
     * 
     * @param   array
     * 
     * @return  void
     */
    function __construct( $rules = array() )
    {
        parent::__construct( $rules );

        log_message('debug', "#Baka_pack: Core Form_validation Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Validating Google reCaptcha input from user form
     * 
     * @param   string
     * 
     * @return  bool
     */
    function valid_recaptcha( $code )
    {
        $resp = recaptcha_check_answer(
                    Setting::get('auth_recaptcha_public_key'),
                    $this->ip_address(),
                    $this->post('recaptcha_challenge_field'),
                    $code );

        if ( !$resp->is_valid )
        {
            $this->set_message('valid_recaptcha', _x('auth_incorrect_captcha'));
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Validating Cool Captcha input from user form
     * 
     * @param   string
     * 
     * @return  bool
     */
    function valid_captcha( $code )
    {
        session_start();

        if ( $_SESSION['captcha'] != $code )
        {
            $this->set_message('valid_captcha', _x('auth_incorrect_captcha'));
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Validating are Username blacklisted or not
     * 
     * @param   string
     * 
     * @return  bool
     */
    function is_username_blacklist( $username )
    {
        foreach ( array( 'blacklist', 'blacklist_prepend', 'exceptions' ) as $setting )
        {
            $$setting  = array_map( 'trim', explode( ',', Setting::get( 'auth_username_'.$setting ) ) );
        }

        // Generate complete list of blacklisted names
        $full_blacklist = $blacklist;

        foreach ( $blacklist as $val )
        {
            foreach ( $blacklist_prepend as $v )
            {
                $full_blacklist[] = $v.$val;
            }
        }

        // Remove exceptions
        foreach ( $full_blacklist as $key => $name )
        {
            foreach ( $exceptions as $exc )
            {
                if ( $exc == $name )
                {
                    unset( $full_blacklist[$key] );
                    break;
                }
            }
        }
        
        $valid = TRUE;

        foreach ( $full_blacklist as $val )
        {
            if ( $username == $val )
            {
                $this->set_message('is_username_blacklist', _x('auth_username_blacklisted'));
                $valid = FALSE;
                break; 
            }
        }
         
         return $valid;
     }

    // -------------------------------------------------------------------------

    /**
     * Validating is Username available for new user
     * 
     * @param   string
     * 
     * @return  bool
     */
    function is_username_available( $username )
    {
        if ( $this->CI->authr->check_username( $username ) )
        {
            $this->set_message( 'is_username_available', _x('auth_username_in_use') );
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Validating is Email address available for new user
     * 
     * @param   string
     * 
     * @return  bool
     */
    function is_email_available( $email )
    {
        if ( $this->CI->authr->check_email( $email ) )
        {
            $this->set_message( 'is_email_available', _x('auth_email_in_use') );
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Validating is Username already exists
     * 
     * @param   string
     * 
     * @return  bool
     */
    function is_username_exists( $username )
    {
        if ( !$this->CI->authr->check_username( $username ) )
        {
            $this->set_message( 'is_username_available', _x('auth_username_not_exists') );
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    /**
     * Validating is Email address already exists
     * 
     * @param   string
     * 
     * @return  bool
     */
    function is_email_exists( $email )
    {
        if ( !$this->CI->authr->check_email( $email ) )
        {
            $this->set_message( 'is_email_available', _x('auth_email_not_exists') );
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    function valid_username_length( $string )
    {
        $min_length = Setting::get('auth_username_min_length');
        $max_length = Setting::get('auth_username_max_length');

        if ( !$this->min_length( $string, $min_length ) )
        {
            $this->set_message( 'valid_username_length', _x('auth_username_min_length', $min_length) );
            
            return FALSE;
        }

        if ( !$this->max_length( $string, $max_length ) )
        {
            $this->set_message( 'valid_username_length', _x('auth_username_max_length', $max_length) );
            
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    function valid_password_length( $string )
    {
        $min_length = Setting::get('auth_password_min_length');
        $max_length = Setting::get('auth_password_max_length');

        if ( !$this->min_length( $string, $min_length ) )
        {
            $this->set_message( 'valid_password_length', _x('auth_password_min_length', $min_length) );
            
            return FALSE;
        }

        if ( !$this->max_length( $string, $max_length ) )
        {
            $this->set_message( 'valid_password_length', _x('auth_password_max_length', $max_length) );
            
            return FALSE;
        }

        return TRUE;
    }
}

/* End of file BAKA_Form_validation.php */
/* Location: ./application/libraries/BAKA_Form_validation.php */