<?php require 'BakaPackTestCase.php';

class BakaDbUtilTestCase extends BakaPackTestCase
{
	public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

		$this->CI->load->library('Baka_pack/baka_dbutil');
    }

    public function testBackup()
    {
    	if ( $this->CI->baka_dbutil->backup() )
    	{
	    	$this->assertTrue( TRUE );

	    	return $this->CI->baka_dbutil->messages();
    	}
	    else
	    {
	    	$this->assertFalse( FALSE );

	    	return $this->CI->baka_dbutil->errors();
	    }

    	// return $this->CI->baka_dbutil->backup();
    }
}