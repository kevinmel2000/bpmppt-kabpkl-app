<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BAKA Exceptions Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Exceptions
 * @author		Fery Wardiyanto
 */
class BAKA_Exceptions extends CI_Exceptions
{
	private $_template_path;

	private $_is_cli;

	function __construct()
	{
		parent::__construct();

		$this->_template_path = APPPATH.'views/errors/';

		$this->_is_cli = (php_sapi_name() === 'cli' OR defined('STDIN'));

		// $this->load =& load_class('Loader', 'core');

		log_message('debug', "#Baka_pack: Core Exceptions Class Initialized");
	}

	/**
	 * General Error Page Modifier
	 *
	 * @access	private
	 * @param	string	the heading
	 * @param	string	the message
	 * @param	string	the template name
	 * @param 	int		the status code
	 * @return	string
	 */
	function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		// print_pre(get_config());
		$heading = $heading;
		$message = '<p>'.implode('</p><p>', ( ! is_array($message)) ? array($message) : $message).'</p>';

		$alt = ( $this->_is_cli ) ? '-cli' : '' ;

		if (defined('PHPUNIT_TEST'))
			throw new PHPUnit_Framework_Exception($message, $status_code);

		set_status_header($status_code);

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		
		ob_start();
		include( $this->_template_path.$template.$alt.EXT );
		$buffer = ob_get_contents();
		ob_end_clean();
		
		return $buffer;
	}

	/**
	 * Native PHP error Modifier
	 *
	 * @access	private
	 * @param	string	the error severity
	 * @param	string	the error string
	 * @param	string	the error filepath
	 * @param	string	the error line number
	 * @return	string
	 */
	function show_php_error($severity, $message, $filepath, $line)
	{
		$severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];

		$filepath = str_replace("\\", "/", $filepath);

		// For safety reasons we do not show the full file path
		if (FALSE !== strpos($filepath, '/'))
		{
			$x = explode('/', $filepath);
			$filepath = $x[count($x)-2].'/'.end($x);
		}

		$alt = ( $this->_is_cli ? '_cli' : '_php' );

		if (ob_get_level() > $this->ob_level + 1)
			ob_end_flush();

		ob_start();
		include($this->_template_path.'error'.$alt.EXT);
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
	}
}

/* End of file BAKA_Exceptions.php */
/* Location: ./application/core/BAKA_Exceptions.php */