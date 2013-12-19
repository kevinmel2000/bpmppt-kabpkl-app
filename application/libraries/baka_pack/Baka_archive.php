<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BAKA Zip Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Archives
 * @author		Fery Wardiyanto (http://github.com/feryardiant/)
 */
class Baka_archive Extends Baka_lib
{
	/** @var object ZipArchive alias */
	private $archive ;

	public function __construct()
	{
		/** @var ZipArchive load native PHP class */
		$this->archive = new ZipArchive();

		log_message('debug', "#Baka_pack: Archive Class Initialized");
	}

	public function extract_all( $file_path, $dir_name = FALSE, $file_names = array() )
	{
		if ( ! $this->read_file( $file_path ) )
			return FALSE;

		$dir_path = ( $dir_name !== FALSE ? $dir_name : dirname( $file_path ));

		$this->extract_file( $dir_path, $file_names );

		$this->close_file();

		return TRUE;
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
			$this->set_error('file_not_exists', 'File '.$file_path.' tidak ada pada server anda');
			return FALSE;
		}

		if ( !is_readable( $file_path ) )
		{
			$this->set_error('file_unreadable', 'File '.$file_path.' tidak dapat dibaca');
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

		for ( $i = 0; $i < $this->archive->numFiles ; $i++ )
		{
			$stat_data = $this->archive->statIndex($i);

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
			$this->set_error('directory_not_exists', $dir_path.' bukanlah sebuah direktori');
			return FALSE;
		}

		if ( !is_writable( $dir_path ) )
		{
			$this->set_error('directory_unwritable', 'Anda tidak memiliki ijin untuk menulis pada direktori '.$dir_path);
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
		$this->archive->close();
	}
}

/* End of file Baka_archive.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_archive.php */