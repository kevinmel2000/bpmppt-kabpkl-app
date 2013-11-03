<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class App_users extends CI_Model
{
	public function __construct()
	{
		if ( ! $this->load->is_loaded('table'))
			$this->load->library('table');

		log_message('debug', "#Baka_pack: User Application model Class Initialized");
	}
}