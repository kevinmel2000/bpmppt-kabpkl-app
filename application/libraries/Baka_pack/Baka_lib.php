<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Baka_lib
{
	/** @var array message wrapper */
	private $_messages	= array();

	/** @var array error wrapper */
	private $_errors	= array();

	public function __construct()
	{
		// $this->load->library('user_agent');
		// 
		$this->_app_init();

		log_message('debug', "Baka_lib Class Initialized");
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
	 *
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

	protected function _app_init()
	{
		if (!empty( $this->errors ))
		{
			foreach( $this->errors as $error)
			{
				log_message( 'error', $error );
			}
		}

		if (!empty( $this->_messages ))
		{
			foreach( $this->_messages as $message)
			{
				log_message( 'debug', $message );
			}
		}
	}

	public function config_item( $item )
	{
		return $this->config->item( 'baka_'.$item );
	}
	
	public function is_browser_jadul()
	{
		$min_browser	= $this->config_item('app_min_browser');
		$curent_version	= explode('.', $this->agent->version());

		return ($curent_version[0] <= $min_browser[$this->agent->browser()] ? TRUE : FALSE  );
	}
}

/* End of file Baka_lib.php */
/* Location: ./application/libraries/Baka_pack/Baka_lib.php */