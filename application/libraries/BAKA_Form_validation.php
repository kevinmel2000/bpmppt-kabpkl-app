<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BAKA Form Validation Class
 *
 * Pre-processes global input data for security
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Validation
 * @author		Fery Wardiyanto
 */
class BAKA_Form_validation extends CI_Form_validation
{
	function __construct($rules = array())
	{
		parent::__construct($rules);

		$this->CI->load->library('Baka_pack/baka_users');

		log_message('debug', "#Baka_pack: Core Form Validation Class Initialized");
	}

	function valid_recaptcha( $code )
	{
		$resp = recaptcha_check_answer(
			get_app_setting('auth_recaptcha_public_key'),
			$this->ip_address(),
			$this->post('recaptcha_challenge_field'),
			$this->post('recaptcha_response_field') );

		if (!$resp->is_valid)
		{
			$this->set_message('valid_recaptcha', _x('auth_incorrect_captcha'));
			return FALSE;
		}
		
		return TRUE;
	}

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

	function is_username_blacklist( $username )
	{
		$blacklist	= explode(',', get_app_setting('auth_username_blacklist'));
		$prepend	= explode(',', get_app_setting('auth_username_blacklist_prepend'));
		$exceptions	= explode(',', get_app_setting('auth_username_exceptions'));
		
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

	function is_username_available( $username )
	{
		if ( ! $this->CI->baka_users->is_username_available( $username ) )
		{
			$this->set_message( 'is_username_available', _x('auth_username_in_use') );
			return FALSE;
		}

		return TRUE;
	}

	function is_email_available( $email )
	{
		if ( ! $this->CI->baka_users->is_email_available( $email ) )
		{
			$this->set_message( 'is_email_available', _x('auth_email_in_use') );
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file BAKA_Input.php */
/* Location: ./application/core/BAKA_Input.php */