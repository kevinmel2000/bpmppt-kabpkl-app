<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| File Upload
| -------------------------------------------------------------------------
| CodeIgniter's File Uploading Class permits files to be uploaded. You can
| set various preferences, restricting the type and size of the files.
|
|	http://codeigniter.com/user_guide/libraries/file_uploading.html
|
*/

/**
 * The path to the folder where the upload should be placed. The folder must
 * be writable and the path can be absolute or relative.
 */
$config['upload_path'] = APPPATH.'storage/upload/';

/**
 * If set to TRUE the file name will be converted to a random encrypted
 * string. This can be useful if you would like the file saved with a name
 * that can not be discerned by the person uploading it.
 */
$config['encrypt_name'] = TRUE;

/* End of file upload.php */
/* Location: ./application/config/upload.php */
