<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BAKA Printing Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Printing
 * @author		Fery Wardiyanto (http://github.com/feryardiant/)
 */
class Baka_print Extends Baka_lib
{
	private $_printer;
	
	private $_host;

	private $_port;

	private $_print_type;

	private $_dim_x;
	private $_dim_y;
	private $_auto_size;

	public function __construct()
	{
		$this->initialize();

		log_message('debug', "#Baka_pack: Email Class Initialized");
	}

	
}

/* End of file Baka_print.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_print.php */