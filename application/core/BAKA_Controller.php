<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BAKA Controller Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Fery Wardiyanto
 */
class BAKA_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if ( is_browser_jadul() )
		{
			log_message('error', "error_browser_jadul");
			show_error(array('Peramban yang anda gunakan tidak memenuhi syarat minimal penggunaan aplikasi ini.','Silahkan gunakan '.anchor('http://www.mozilla.org/id/', 'Mozilla Firefox', 'target="_blank"').' atau '.anchor('https://www.google.com/intl/id/chrome/browser/', 'Google Chrome', 'target="_blank"').' biar lebih GREGET!'), 500, 'error_browser_jadul');
		}

		log_message('debug', "BAKA Controller Class Initialized");
	}
}

/* End of file BAKA_Controller.php */
/* Location: ./application/core/BAKA_Controller.php */