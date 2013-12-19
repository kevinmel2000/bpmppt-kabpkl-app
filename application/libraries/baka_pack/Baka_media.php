<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * BAKA Media Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Media file
 * @author		Fery Wardiyanto (http://github.com/feryardiant/)
 */
class Baka_media extends Baka_lib
{
	protected $upload_dir;

	protected $thumb_dir;
	
	protected $allowed_types;

	protected $upload_max_size;

	private $upload_conf = array();

	private $resize_conf = array();

	private $media_field = 'userfile';

	private $media_path;

	private $media_data = array();

	private $media_errors = array();

	public function __construct()
	{
		$this->allowed_types	= explode('|', $this->config_item('allowed_types'));
		
		$this->upload_max_size	= return_bytes( ini_get('upload_max_filesize') );

		$this->upload_dir	= $this->config_item('upload_dir');

		$this->thumb_dir	= $this->upload_dir.'thumbs/';

		log_message('debug', "#Baka_pack: Media Class Initialized");
	}
	
	public function uploaded_data()
	{
		return $this->media_data;
	}
	
	/**
	 * It must be the uploading method
	 * 
	 * @param	Array	Image data that want to be resize.
	 * @return	void	Resized image
	 */
	public function upload( $field = 'userfile', $path = '' )
	{
		$this->media_field	= $field;
		$this->media_path	= $this->upload_dir . $path;

		$this->upload_conf['upload_path']	= realpath( $this->media_path );
		$this->upload_conf['allowed_types']	= $this->config_item('allowed_types');
		$this->upload_conf['encrypt_name']	= $this->config_item('encrypt');
		$this->upload_conf['max_size']		= $this->upload_max_size;

		return $this;
	}
	
	/**
	 * It must be the resizing method
	 * 
	 * @param	Array	Image data that want to be resize.
	 * @return	void	Resized image
	 */
	public function resize( $source_image )
	{
		$this->resize_conf	= array(
			'source_image'	=> $source_image['full_path'],
			'new_image'		=> $source_image['file_path'] . '/thumbs' . $source_image['file_name'],
			'width'			=> $this->config_item('thumb_width'),
			'height'		=> $this->config_item('thumb_height'),
			);

		return $this;
	}

	/**
	 * Just do uploading
	 * 
	 * @return mixed something lah
	 */
	public function go( $field = '' )
	{
		$field || $field = $this->media_field;

		$this->load->library('upload', $this->upload_conf);

		if ($output['return'] = $this->upload->do_upload( $field ))
		{
			$this->media_data = $this->upload->data();

			if (!empty($this->resize_conf))
			{
				$this->load->library('image_lib', $this->resize_conf);

				$output['return']	= $this->image_lib->resize();

				$output['messages']	= $output['return'] ?
					'Berhasil mengubah ukuran citra: '.$source_image['file_name'] :
					$this->image_lib->display_errors();
			}
			else
			{
				$output['messages'] = $this->upload->data();
			}
		}
		else
		{
			$output['messages'] = $this->upload->display_errors();
		}

		return $output;
	}

	public function do_multiple( $field = '' )
	{
		$field || $field = $this->media_field;

		$this->load->library('upload', $this->upload_conf);

		// modifikasi disini
		// looping $_FILES dan buat array baru
		foreach( $_FILES[$field] as $key => $values )
		{
			$i = 1;
			foreach( $values as $value )
			{
				$field_name = "file_".$i;
				$_FILES[$field_name][$key] = $value;
				$i++;	
			}
		}

		// hapus array awal, karena kita sudah memiliki array baru
		unset( $_FILES[$field] );

		foreach( $_FILES as $field_name => $key )
		{
			$output[] = $this->do($field_name);
		}

		return $output;
	}
	
	public function fine_uploader( $path = '' )
	{
		if( $this->input->get('qqfile') )
		{
			$file = $this->input->get('qqfile');
		}
		else if( $_FILES['qqfile'] )
		{
			$file = $_FILES['qqfile']['tmp_name'];
		}
		
		if( !$this->security->xss_clean($file) )
		{
			$errors[] = 'File error.';
		}
		
		$ext = pathinfo( $file, PATHINFO_EXTENSION );
		
		mt_srand();
		$file_name = md5( $file.uniqid( mt_rand() ) ).'.'.$ext;
		$full_path = $this->media_path . $file_name;

		if ( !in_array( $ext, $this->allowed_types ) )
		{
			$errors[] = 'File type not allowed.';
		}

		if ( $this->input->get('qqfile') )
		{
			$input		= fopen('php://input' , 'r');
			$temp		= tmpfile();
			$realSize	= stream_copy_to_stream($input, $temp);
			fclose($input);

			if( $realSize <= $this->upload_max_size )
			{
				$target = fopen($full_path, 'w');
				fseek($temp, 0, SEEK_SET);
				stream_copy_to_stream($temp, $target);
				fclose($target);
			}
			else
			{
				$errors[] = 'File too large.';
			}
		}
		else if ($_FILES['qqfile'])
		{
			if( $_FILES['qqfile']['size'] <= $this->upload_max_size )
			{
				move_uploaded_file($_FILES['qqfile']['tmp_name'], $full_path);
			}
			else
			{
				$errors[] = 'File too large.';
			}
		}

		if( count( $errors ) > 0 )
		{
			foreach( $errors as $error )
			{
				$this->set_message( $error, 'error' );
			}
				
			return false;
		}
		else
		{
			$image = getimagesize($full_path);

			$this->media_data = array(
				'file_name'		=> $file_name,
				'file_path'		=> $this->media_path,
				'file_url'		=> site_url( $this->media_path ),
				'full_path'		=> $full_path,
				'raw_name'		=> str_replace($ext, '', $file_name),
				'client_name'	=> $file,
				'file_type'		=> $image['mime'],
				'file_ext'		=> $ext,
				'file_size'		=> filesize($full_path),
				'image_width'	=> $image[0],
				'image_height'	=> $image[1],
				);

			return true;
		}
	}
}

/* End of file Baka_media.php */
/* Location: ./application/libraries/Baka_pack/Baka_media.php */
