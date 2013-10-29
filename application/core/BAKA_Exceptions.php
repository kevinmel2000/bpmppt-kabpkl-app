<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BAKA Exceptions Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Exceptions
 * @author		Fery Wardiyanto
 * @link		http://codeigniter.com/user_guide/libraries/exceptions.html
 */
class BAKA_Exceptions extends CI_Exceptions
{
	protected $_template_path;

	function __construct()
	{
		parent::__construct();

		$this->_template_path = APPPATH.'views/errors/';

		// $this->load =& load_class('Loader', 'core');

		log_message('debug', "BAKA Exceptions Class Initialized");
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
		set_status_header($status_code);

		$message = '<p>'.implode('</p><p>', ( ! is_array($message)) ? array($message) : $message).'</p>';

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		
		ob_start();
		include( $this->_template_path.$template.EXT );
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

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}

		ob_start();
		include($this->_template_path.'error_php'.EXT);
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
	}
}

/* End of file BAKA_Exceptions.php */
/* Location: ./application/core/BAKA_Exceptions.php */