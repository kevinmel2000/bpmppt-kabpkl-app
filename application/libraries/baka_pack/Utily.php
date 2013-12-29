<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter core library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Database Utility Class
 *
 * @subpackage  Libraries
 * @category    Database
 */
class Utily
{
    /**
     * Codeigniter superobject
     *
     * @var  mixed
     */
    protected static $_ci;

    protected $_file_name;

    protected $_temp_path;

    protected $_file_path;

    /**
     * Default class constructor
     */
    public function __construct()
    {
        self::$_ci =& get_instance();

        $this->_file_name   = 'backup_'.str_replace(' ', '_', strtolower(get_conf('app_name')));

        $this->_temp_path   = get_conf('temp_path');

        log_message('debug', "#Baka_pack: Database Utility Class Initialized");
    }

    public function backup( $tables = array(), $ignores = array(), $file_name = '', $download = TRUE )
    {
        if ( !is_dir( $this->_temp_path ) )
        {
            $this->set_error('dbutil_backup_folder_not_exists', 'Direktori '.$this->_temp_path.' belum ada pada server anda.', $this->_temp_path);
            return FALSE;
        }

        if ( !is_writable( $this->_temp_path ) )
        {
            $this->set_error('dbutil_backup_folder_not_writable', 'Anda tidak memiliki ijin untuk menulis pada direktori '.$this->_temp_path.'.', $this->_temp_path);
            return FALSE;
        }

        // Setup file name
        $file_name || $file_name = $this->_file_name;
        // Setup file fullpath
        $this->_file_path = $this->_temp_path . $file_name . '.sql';

        if ( ! $this->_backup_command( $this->_file_path ) )
        {
            $this->set_error('dbutil_backup_process_failed', 'Proses backup database gagal.');
            return FALSE;
        }
        
        // Load the zip helper
        self::$_ci->load->library('zip');

        // Reading backed up database
        $this->zip->read_file( $this->_file_path );

        if ($download === TRUE)
            $this->zip->download( $file_name.'.zip' );
        else
            $this->zip->archive( $this->_file_path );
            
        $this->zip->clear_data();

        $this->clear( $this->_file_path );

        $this->set_message('dbutil_backup_process_success', 'Proses backup database berhasil.');
        return TRUE;
    }

    public function restore_upload( $field_name )
    {
        $config['upload_path']  = $this->_temp_path;
        $config['allowed_types']= 'zip';
        $config['file_name']    = $this->_file_name;

        self::$_ci->load->library('upload', $config);

        if ( self::$_ci->upload->do_upload( $field_name ) )
        {
            $upload_data = self::$_ci->upload->data();

            // Restore to database
            return $this->_restore_files( $this->_temp_path . $this->_file_name . '.zip' );
        }
        else
        {
            $this->set_error('dbutil_upload_failed', 'Proses upload database gagal. '.self::$_ci->upload->display_errors());
            return FALSE;
        }
    }

    protected function _restore_files( $file_path )
    {
        self::$_ci->load->library('baka_pack/Baka_archive');

        if ( ! file_exists( $file_path ) )
        {
            $this->set_error('file_not_found', 'Berkas %s tidak ada. ', $file_path);
            return FALSE;
        }

        // Extract uploaded file
        if ( ! $this->baka_archive->extract_all( $file_path, $this->_temp_path ) )
            return FALSE;

        $this->clear( $file_path );

        // Restore to database
        if ( file_exists( $this->_temp_path . $this->_file_name ) )
            $this->_restore_command( $this->_temp_path . $this->_file_name );

        $this->set_message('dbutil_restore_success', 'Restorasi database berhasil');
        return TRUE;
    }

    protected function _backup_command( $file_name )
    {
        if ( strlen( self::$_ci->db->password ) > 0 )
            $password = " -p" . self::$_ci->db->password;

        shell_exec( "mysqldump -u" . self::$_ci->db->username . $password . " --databases " . self::$_ci->db->database . " >" . $file_name );
        
        return ( file_exists( $file_name ) ? TRUE : FALSE );
    }

    protected function _restore_command( $file_name )
    {
        if ( strlen( self::$_ci->db->password ) > 0 )
            $password = " -p" . self::$_ci->db->password;
        
        shell_exec( "mysql -u" . self::$_ci->db->username . $password . " <" . $file_name );

        $this->clear( $file_name );
    }

    public function clear( $file_path )
    {
        // Hapus sampah!
        @unlink( $file_path );
    }
}

/* End of file Utily.php */
/* Location: ./application/libraries/baka_pack/Utily.php */