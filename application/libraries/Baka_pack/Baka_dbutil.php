<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Baka_dbutil Extends Baka_lib
{
	private $_file_name = 'tmp_backup';
	
	private $_tmp_dir;
	
	private $_file_path;
	
	private $_ext = array('gzip', 'zip', 'txt');

	public $errors = array();

	public function __construct()
	{
		parent::__construct();

		$this->_file_name;

		$this->_tmp_dir	= FCPATH . config_item('cache_path') . 'tmp/';

		log_message('debug', "Baka_dbutil Class Initialized");
	}

	public function backup( $tables = array(), $ignores = array(), $file_name = '', $download = TRUE )
	{
		if ( !is_dir( $this->_tmp_dir ) )
		{
			$this->errors[] = 'Direktori '.$this->_tmp_dir.' belum ada pada server anda.';
			return FALSE;
		}

		if ( !is_writable( $this->_tmp_dir ) )
		{
			$this->errors[] = 'Anda tidak memiliki ijin untuk menulis pada direktori '.$this->_tmp_dir.'.';
			return FALSE;
		}

		// Setup file name
		$file_name || $file_name = $this->_file_name;
		// Setup file fullpath
		$this->_file_path = $this->_tmp_dir . $file_name . '.sql';

		if ( ! $this->_backup_command( $this->_file_path ) )
		{
			$this->errors[] = 'Proses backup gagal, ';
			return FALSE;
		}
		
		// Load the zip helper
		$this->load->library('zip');
		// Reading backed up database
		$this->zip->read_file( $this->_file_path );

		if ($download === TRUE)
			$this->zip->download( $file_name.'.zip' );
		else
			$this->zip->archive( $this->_file_path );
			
		$this->zip->clear_data();

		$this->clear( $this->_tmp_dir . $file_name );

		return TRUE;
	}

	public function restore_upload( $file_attr )
	{
		if ( ! isset($file_attr['tmp_name']) )
			return FALSE;
		
		if ( ! move_uploaded_file( $file_attr['tmp_name'], $this->_tmp_dir ) )
			return FALSE;

		if ( ! $this->load->is_loaded('baka_pack/baka_unzip'))
			$this->load->library('baka_pack/baka_unzip');

		if ( ! $this->baka_unzip->extract_all( $this->_tmp_dir ) )
		{
			$this->errors = $this->baka_unzip->errors;
			return FALSE;
		}

		// Restore to database
		if ( file_exists( $this->_tmp_dir.'db.sql' ) )
			$this->_restore_command( $this->_tmp_dir.'db.sql' );
		
		// Restore to database
		if ( file_exists( $this->_tmp_dir.'file.zip' ) )
			$this->_restore_files();
		
		// Hapus sampah :P
		@unlink($this->_tmp_dir);
	}

	private function _restore_files( $file_name )
	{
		if ( $this->baka_unzip->extract_all( $file_name ) )
			@unlink( $file_name );
	}

	private function _backup_command( $file_name )
	{
		if ( strlen( $this->db->password ) > 0 )
			$password = " -p" . $this->db->password;

		shell_exec( "mysqldump -u" . $this->db->username . $password . " --databases " . $this->db->database . " >" . $file_name );
		
		return ( file_exists( $file_name ) ? TRUE : FALSE );
	}

	private function _restore_command( $file_name )
	{
		if ( strlen( $this->db->password ) > 0 )
			$password = " -p" . $this->db->password;
		
		shell_exec( "mysql -u" . $this->db->username . $password . " <" . $file_name );

		// @unlink( $file_name );
	}

	public function clear( $file_path )
	{
		// Hapus sampah!
		@unlink( $file_path.'.sql' );
		@unlink( $file_path.'.zip' );
	}
	
	private function _clear_curr_state()
	{
		$dir_list = scandir($this->file_store_folder);
		if ( is_array($dir_list) ){
			foreach ( $dir_list as $file ){
				$full_path = $this->file_store_folder . DIRECTORY_SEPARATOR . $file;
				if ( is_file($full_path) ){
					@unlink($full_path);
				}
			}
		}
		
		/* cache folder */
		$dir_list = scandir($this->file_store_folder . DIRECTORY_SEPARATOR . "thumb");
		if ( is_array($dir_list) ){
			foreach ( $dir_list as $file ){
				$full_path = $this->file_store_folder . DIRECTORY_SEPARATOR . "thumb" . DIRECTORY_SEPARATOR . $file;
				if ( is_file($full_path) ){
					@unlink($full_path);
				}
			}
		}
	}
}

/* End of file Baka_dbutil.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_dbutil.php */