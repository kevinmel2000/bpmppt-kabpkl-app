<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class App_users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		log_message('debug', "#Baka_pack: User Application model Class Initialized");
	}

	public function create_user( $user_data, $use_username )
	{
		$email_activation =  get_app_config('email_activation');

		if ( $data = $this->baka_auth->create_user(
			$use_username ? $user_data['username'] : '',
			$user_data['email'],
			$user_data['password'],
			$email_activation ) )
		{
			// success
			$this->load->library('baka_pack/baka_email');

			if ( $email_activation )
			{
				// send "activate" email
				$data['activation_period'] = get_app_setting('auth_email_activation_expire') / 3600;

				$this->baka_email->send('activate', $user_data['email'], $data);

				$this->baka_lib->set_message('email_activation_sent');
			}
			else if ( get_app_config('email_account_details'))
			{
				// send "welcome" email
				$this->baka_email->send('welcome', $user_data['email'], $data);

				$this->baka_lib->set_message('email_welcome_sent');
			}

			// Clear password (just for any case)
			unset($data['password']); 

			$this->baka_lib->set_message('auth_registration_success');

			return $data;
		}
		else
		{
			$this->baka_lib->set_error('auth_registration_failed');

			return FALSE;
		}
	}

	public function update_user( $user_id, $user_data )
	{
		return false;
	}
}