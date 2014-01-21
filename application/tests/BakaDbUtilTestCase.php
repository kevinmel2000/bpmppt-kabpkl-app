<?php require 'BakaPackTestCase.php';

class BakaDbUtilTestCase extends BakaPackTestCase
{
	public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

		$this->CI->load->library('baka_pack/utily');
    }

    public function testBackup()
    {
    	if ( $this->CI->utily->backup() )
    	{
	    	$this->assertTrue( TRUE );

	    	return $this->CI->utily->messages();
    	}
	    else
	    {
	    	$this->assertFalse( FALSE );

	    	return $this->CI->utily->errors();
	    }

    	// return $this->CI->utily->backup();
    }
}