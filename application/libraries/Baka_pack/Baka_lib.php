<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * BAKA Library Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Fery Wardiyanto (http://github.com/feryardiant/)
 */
class Baka_lib
{
	/** @var array message wrapper */
	private $messages	= array();

	/** @var array error wrapper */
	private $errors		= array();

	public function __construct()
	{
		log_message('debug', "#Baka_pack: Main Library Class Initialized");
	}

	/**
	 * __call
	 * Acts as a simple way to call model methods without loads of stupid alias'
	 */
	public function __call($method, $arguments)
	{
		if ( !method_exists( $this->baka_lib, $method) )
			throw new Exception('Undefined method Baka_lib::' . $method . '() called');
		else
			return call_user_func_array( array($this->baka_lib, $method), $arguments);
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

	public function config_item( $item )
	{
		return $this->config->item( 'baka_'.$item );
	}

	private function set_message( $message = '', $rep = '' )
	{
		$messages = _x( $message, $rep );

		$this->messages[] = $messages;

		log_message( 'debug', '#Baka_pack debug: '.$messages );
	}

	private function set_error( $error = '', $rep = '' )
	{
		$errors = _x( $error, $rep );

		$this->errors[] = $errors;

		log_message( 'error', '#Baka_pack error: '.$errors );
	}

	public function messages()
	{
		return $this->messages;
	}

	public function errors()
	{
		return $this->errors;
	}
}

/* End of file Baka_lib.php */
/* Location: ./application/libraries/Baka_pack/Baka_lib.php */