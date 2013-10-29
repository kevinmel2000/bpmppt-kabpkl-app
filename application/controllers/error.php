<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->baka_theme->set_title('Error Page');
	}

	public function index( $request = '' )
	{
		$this->e404();
	}

	public function e404()
	{
		$this->data['heading'] = $this->baka_theme->set_title('404 Halaman tidak ditemukan');
		$this->data['message'] = 'The page you requested was not found.';

		log_message('error', '404 Page Not Found --> '.current_url());

		$this->baka_theme->load('errors/error_view', $this->data);
	}

	public function browser()
	{
		$this->data['heading'] = $this->baka_theme->set_title('Web browser anda sudah usang.');
		$this->data['message'] = 'Anda menggunakan versi web browser jadul, silahkan upgrade versi web browser terlebih dahulu untuk menggunakan aplikasi ini.';

		$this->baka_theme->load('errors/error_view', $this->data);
	}
}

/* End of file error.php */
/* Location: ./application/controllers/error.php */