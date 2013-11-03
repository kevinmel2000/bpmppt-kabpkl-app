<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BAKA Controller Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Fery Wardiyanto
 */
class BAKA_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if ( is_browser_jadul() AND !$this->input->is_cli_request() )
		{
			log_message('error', "error_browser_jadul");
			show_error(array('Peramban yang anda gunakan tidak memenuhi syarat minimal penggunaan aplikasi ini.','Silahkan gunakan '.anchor('http://www.mozilla.org/id/', 'Mozilla Firefox', 'target="_blank"').' atau '.anchor('https://www.google.com/intl/id/chrome/browser/', 'Google Chrome', 'target="_blank"').' biar lebih GREGET!'), 500, 'error_browser_jadul');
		}

		$this->authenticate();

		$this->data['load_toolbar']	= FALSE;
		$this->data['search_form']	= FALSE;
		$this->data['single_page']	= TRUE;
		$this->data['form_page']	= FALSE;

		$this->data['tool_buttons'] = array();

		$this->data['panel_title']	= '';
		$this->data['panel_body']	= '';

		log_message('debug', "#Baka_pack: Core Controller Class Initialized");
	}

	protected function _notice( $page )
	{
		redirect('notice/'.$page);
	}

	protected function authenticate()
	{
		if ( uri_string() == 'login' OR uri_string() == 'register' )
		{
			if ( $this->baka_auth->is_logged_in() )
			{
				// logged in
				redirect( 'dashboard' );
			}
			else if ( $this->baka_auth->is_logged_in(FALSE) )
			{
				// logged in, not activated
				redirect('resend');
			}

		}
		else if ( uri_string() != 'login' AND uri_string() != 'resend' AND uri_string() != 'forgot' AND strpos('notice', uri_string()) !== FALSE )
		{
			if ( ! $this->baka_auth->is_logged_in() AND ! $this->baka_auth->is_logged_in(FALSE) )
				redirect( 'login' );

			if ( $this->baka_auth->is_logged_in(FALSE) )
				redirect( 'resend' );
		}
	}
}

/* End of file BAKA_Controller.php */
/* Location: ./application/core/BAKA_Controller.php */