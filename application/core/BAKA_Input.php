<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BAKA Input Class
 *
 * Pre-processes global input data for security
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Input
 * @author		Fery Wardiyanto
 */
class BAKA_Input extends CI_Input
{
	function __construct()
	{
		parent::__construct();

		log_message('debug', "#Baka_pack: Core Input Class Initialized");
	}

	function valid_recaptcha( $code )
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer(
			get_app_setting('auth_recaptcha_public_key'),
			$this->ip_address(),
			$this->post('recaptcha_challenge_field'),
			$this->post('recaptcha_response_field') );

		if (!$resp->is_valid)
		{
			$this->form_validation->set_message('valid_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		
		return TRUE;
	}

	function valid_captcha( $code )
	{
		session_start();

		if ($_SESSION['captcha'] != $code)
		{
			$this->form_validation->set_message('valid_captcha', $this->lang->line('auth_incorrect_captcha'));
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
				$this->form_validation->set_message('is_username_blacklist', $this->lang->line('auth_username_blacklisted'));
				$valid = FALSE;
				break; 
			}
		}
		 
		 return $valid;
	 }

	function is_username_exists( $username )
	{
		return $this->baka_users->is_username_exists( $username );
	}

	function is_email_exists( $username )
	{
		return $this->baka_users->is_email_exists( $username );
	}
}

/* End of file BAKA_Input.php */
/* Location: ./application/core/BAKA_Input.php */