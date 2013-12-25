<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BAKA Form Validation Class
 *
 * Pre-processes global input data for security
 * Extending native CI Form Validation
 *
 * @package     Baka_pack
 * @subpackage  Libraries
 * @category    Validation
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @license     GNU GPL v3 license. See file COPYRIGHT for details.
 */
class BAKA_Form_validation extends CI_Form_validation
{
    /**
     * Default Class Constructor
     * @param   array
     * @return  void
     */
    function __construct( $rules = array() )
    {
        parent::__construct($rules);

        $this->CI->load->library('baka_pack/baka_users');

        log_message('debug', "#Baka_pack: Core Form Validation Class Initialized");
    }

    /**
     * Validating Google reCaptcha input from user form
     * 
     * @param   string
     * @return  bool
     */
    function valid_recaptcha( $code )
    {
        $resp = recaptcha_check_answer(
                    Setting::get('auth_recaptcha_public_key'),
                    $this->ip_address(),
                    $this->post('recaptcha_challenge_field'),
                    $code );

        if (!$resp->is_valid)
        {
            $this->set_message('valid_recaptcha', _x('auth_incorrect_captcha'));
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Validating Cool Captcha input from user form
     * 
     * @param   string
     * @return  bool
     */
    function valid_captcha( $code )
    {
        session_start();

        if ($_SESSION['captcha'] != $code)
        {
            $this->set_message('valid_captcha', _x('auth_incorrect_captcha'));
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Validating are Username blacklisted or not
     * 
     * @param   string
     * @return  bool
     */
    function is_username_blacklist( $username )
    {
        $blacklist  = array_map('trim', explode(',', Setting::get('auth_username_blacklist')));
        $prepend    = array_map('trim', explode(',', Setting::get('auth_username_blacklist_prepend')));
        $exceptions = array_map('trim', explode(',', Setting::get('auth_username_exceptions')));

        // Generate complete list of blacklisted names
        $full_blacklist = $blacklist;

        foreach($blacklist as $val)
        {
            foreach($prepend as $v)
            {
                $full_blacklist[] = $v.$val;
            }
        }

        // Remove exceptions
        foreach($full_blacklist as $key => $name)
        {
            foreach($exceptions as $exc)
            {
                if($exc == $name)
                {
                    unset($full_blacklist[$key]);
                    break;
                }
            }
        }
        
        $valid = TRUE;

        foreach($full_blacklist as $val)
        {
            if($username == $val)
            {
                $this->set_message('is_username_blacklist', _x('auth_username_blacklisted'));
                $valid = FALSE;
                break; 
            }
        }
         
         return $valid;
     }

    /**
     * Validating is Username available for new user
     * 
     * @param   string
     * @return  bool
     */
    function is_username_available( $username )
    {
        if ( ! $this->CI->baka_users->is_username_available( $username ) )
        {
            $this->set_message( 'is_username_available', _x('auth_username_in_use') );
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Validating is Email address available for new user
     * 
     * @param   string
     * @return  bool
     */
    function is_email_available( $email )
    {
        if ( ! $this->CI->baka_users->is_email_available( $email ) )
        {
            $this->set_message( 'is_email_available', _x('auth_email_in_use') );
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Validating is Username already exists
     * 
     * @param   string
     * @return  bool
     */
    function is_username_exists( $username )
    {
        if ( $this->is_username_available( $username ) === TRUE  )
        {
            $this->set_message( 'is_username_available', _x('auth_username_not_exists') );
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Validating is Email address already exists
     * 
     * @param   string
     * @return  bool
     */
    function is_email_exists( $email )
    {
        if ( $this->is_email_available( $email ) === TRUE )
        {
            $this->set_message( 'is_email_available', _x('auth_email_not_exists') );
            return FALSE;
        }

        return TRUE;
    }
}

/* End of file BAKA_Input.php */
/* Location: ./libraries/BAKA_Form_validation.php */