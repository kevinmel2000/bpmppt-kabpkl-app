<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BootIgniter Pack
 * @subpackage  BI_Form_validation
 * @category    Libraries
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://github.com/feryardiant/bootigniter/blob/master/LICENSE
 * @since       Version 0.1.5
 */

// -----------------------------------------------------------------------------

class BI_Form_validation extends CI_Form_validation
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

        log_message('debug', "#BootIgniter: Form_validation Class Initialized");
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
                    Bootigniter::get_setting('auth_recaptcha_public_key'),
                    $this->ip_address(),
                    $this->post('recaptcha_challenge_field'),
                    $code );

        if ( !$resp->is_valid )
        {
            $this->set_message('valid_recaptcha', _x('biauth_incorrect_captcha'));
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
        if ( $this->CI->session->userdata('captcha') != $code )
        {
            $this->set_message('valid_captcha', _x('biauth_incorrect_captcha'));
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
        if ( !$this->CI->biauth->is_username_allowed( $username ) )
        {
            $this->set_message('is_username_blacklist', _x('biauth_username_blacklisted'));
            return FALSE;
        }

        return TRUE;
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
        if ( $this->CI->biauth->is_username_exists( $username ) )
        {
            $this->set_message( 'is_username_available', _x('biauth_username_in_use') );
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
        if ( $this->CI->biauth->is_email_exists( $email ) )
        {
            $this->set_message( 'is_email_available', _x('biauth_email_in_use') );
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
        if ( !$this->CI->biauth->is_username_exists( $username ) )
        {
            $this->set_message( 'is_username_exists', _x('biauth_username_not_exists') );
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
        if ( !$this->CI->biauth->is_email_exists( $email ) )
        {
            $this->set_message( 'is_email_exists', _x('biauth_email_not_exists') );
            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    function valid_username_length( $string )
    {
        $min_length = Bootigniter::get_setting('auth_username_length_min');
        $max_length = Bootigniter::get_setting('auth_username_length_max');

        if ( !$this->min_length( $string, $min_length ) )
        {
            $this->set_message( 'valid_username_length', _x('biauth_username_length_min', $min_length) );

            return FALSE;
        }

        if ( !$this->max_length( $string, $max_length ) )
        {
            $this->set_message( 'valid_username_length', _x('biauth_username_length_max', $max_length) );

            return FALSE;
        }

        return TRUE;
    }

    // -------------------------------------------------------------------------

    function valid_password_length( $string )
    {
        $min_length = Bootigniter::get_setting('auth_password_length_min');
        $max_length = Bootigniter::get_setting('auth_password_length_max');

        if ( !$this->min_length( $string, $min_length ) )
        {
            $this->set_message( 'valid_password_length', _x('biauth_password_length_min', $min_length) );

            return FALSE;
        }

        if ( !$this->max_length( $string, $max_length ) )
        {
            $this->set_message( 'valid_password_length', _x('biauth_password_length_max', $max_length) );

            return FALSE;
        }

        return TRUE;
    }
}

/* End of file BI_Form_validation.php */
/* Location: ./application/libraries/BI_Form_validation.php */
