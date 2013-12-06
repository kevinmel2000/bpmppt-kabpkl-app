<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bpmppt_test extends BAKA_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->driver('bpmppt');
	}

	public function index( $page = '' )
	{
		if ( $page != '' )
			$this->_notice( $page );
	}

	public function get( $file = '' )
	{
		if ( $file =='' )
			echo 'Empty';
		else
			print_pre($this->bpmppt->get_form($file));
	}

	public function ijin( $type = '' )
	{
		print_pre( $this->bpmppt->get_data( $type, array('status' => 'deleted') ) );
	}

	public function form( $type = '', $data_id = FALSE )
	{
		print_pre( $this->bpmppt->get_form( $type, $data_id ) );
	}
}