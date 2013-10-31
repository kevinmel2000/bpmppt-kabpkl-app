<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Baka_zip
 * Digunakan untuk mengelola file .ZIP
 *
 * @author		Fery Wardiyanto
 * @access		public
 * @package		Baka_app
 * @since		1.0
 * @version		1.0
 */

class Baka_zip Extends Baka_lib
{
	/** @var object ZipArchive alias */
	private $archive ;

	public function __construct()
	{
		parent::__construct();

		/** @var ZipArchive load native PHP class */
		$this->archive = new ZipArchive();

		log_message('debug', "Baka_zip Class Initialized");
	}

	public function extract_all( $file_path, $dir_name = FALSE, $file_names = array() )
	{
		if ( $this->read_file( $file_path ) )
		{
			$dir_path = ( $dir_name !== FALSE ? $dir_name : dirname( $file_path ));

			$this->extract_file( $dir_path, $file_names );

			$this->close_file();

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Opening .ZIP file
	 * @param	string	$file_path	File yang akan dibuka lengkap dengan path direktori.
	 * @return	mixed				ZipArchive default return
	 */
	public function read_file( $file_path )
	{
		if ( !is_file( $file_path ) AND !file_exists( $file_path ) )
		{
			$this->errors('#Baka_zip: File '.$file_path.' tidak ada pada server anda');
			return FALSE;
		}

		if ( !is_readable( $file_path ) )
		{
			$this->errors('#Baka_zip: File '.$file_path.' tidak dapat dibaca');
			return FALSE;
		}

		return $this->archive->open( $file_path );
	}

	/**
	 * Mendapatkan isi yang ada didalam .ZIP file
	 * @return	array	isi file
	 */
	public function get_contents()
	{
		$list_file = array();

		for ( $i = 0; $i < $this->zip->numFiles ; $i++ )
		{
			$stat_data = $this->zip->statIndex($i);

			if ( $stat_data['size'] > 0 )
				array_push($list_file, $stat_data['name']);
		}

		return $list_file;
	}

	/**
	 * Meng-extrak semua atau sebagian isi dari .ZIP file
	 * @param	string	$dir_path	Path direktori extract
	 * @param	array	$file_names	Nama file tertentu (optional)
	 * @return	void
	 */
	public function extract_file( $dir_path, $file_names = array() )
	{
		if ( !is_dir( $dir_path ) )
		{
			$this->errors($#Baka_zip: dir_path.' bukanlah sebuah direktori');
			return FALSE;
		}

		if ( !is_writable( $dir_path ) )
		{
			$this->errors('#Baka_zip: Anda tidak memiliki ijin untuk menulis pada direktori '.$dir_path);
			return FALSE;
		}

		if ( count( $file_names ) > 0 )
		{
			$this->archive->extractTo( $dir_path, $file_names );
		}
		else
		{
			$this->archive->extractTo( $dir_path );
		}
	}

	/**
	 * Menutup .ZIP file
	 * @return	void
	 */
	public function close_file()
	{
		$this->zip->close();
	}
}

/* End of file Baka_zip.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_zip.php */