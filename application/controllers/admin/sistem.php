<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Everyone is permitted to copy and distribute verbatim or modified 
 * copies of this license document, and changing it is allowed as long 
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE 
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION 
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://www.wtfpl.net
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * Sistem Class
 *
 * @subpackage  Controller
 */
class Sistem extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login();

        if ( !$this->authr->is_permited('sys_manage') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->themee->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->admin_navbar( 'admin_sidebar', 'side' );

        $this->themee->set_title('Pemeliharaan Sistem');
    }

    public function index()
    {
        $this->info();
    }

    public function info()
    {
        if ( !$this->authr->is_permited('sys_logs_manage') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->set_panel_title('Informasi Sistem');

        $this->load->library('baka_pack/utily');
        $this->load->library('table');

        $server_info = $this->utily->get_server_info();

        // print_pre($this->db);

        $fields[]   = array(
            'name'  => 'php-version',
            'type'  => 'static',
            'label' => 'Versi PHP',
            'std'   => $server_info['php_version'] );

        $this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-hover table-condensed">' ));
        $this->table->set_heading(array(
            array(
                'data' => 'Nama',
                'width' => '26%',
                ),
            array(
                'data' => 'Nilai',
                'width' => '74%',
                )
            ));

        foreach ($server_info['server'] as $key => $val)
        {
            $this->table->add_row($key, $val);
        }

        $fields[]   = array(
            'name'  => 'server-info',
            'type'  => 'custom',
            'label' => 'Informasi Server',
            'value' => $this->table->generate() );

        $this->table->set_heading(array(
            array(
                'data' => 'Nama',
                'width' => '26%',
                ),
            array(
                'data' => 'Nilai',
                'width' => '74%',
                )
            ));

        foreach ($server_info['db'] as $key => $val)
        {
            $this->table->add_row($key, $val);
        }

        $fields[]   = array(
            'name'  => 'db-info',
            'type'  => 'custom',
            'label' => 'Informasi Server',
            'value' => $this->table->generate() );

        $this->table->set_heading(array(
            array(
                'data' => 'Nama',
                'width' => '26%',
                ),
            array(
                'data' => 'Versi',
                'width' => '74%',
                )
            ));

        foreach ($server_info['php_extensions'] as $key => $val)
        {
            $this->table->add_row($key, $val);
        }

        $fields[]   = array(
            'name'  => 'php-extensions',
            'type'  => 'custom',
            'label' => 'Extensi Terinstall',
            'value' => $this->table->generate() );

        $this->table->set_heading(array(
            array(
                'data' => 'Nama',
                'width' => '26%',
                ),
            array(
                'data' => 'Nilai',
                'width' => '74%',
                ),
            ));

        foreach ($server_info['php_configs'] as $key => $val)
        {
            // $class = ($val['global'] != $val['local'] ? 'danger' : '');

            $this->table->add_row(array(
                array(
                    'data' => $val['name'],
                    'id' => $key,
                    ),
                array(
                    'data' => $val['value'],
                    ),
                ));
        }

        $fields[]   = array(
            'name'  => 'php-configs',
            'type'  => 'custom',
            'label' => 'Konfigurasi',
            'value' => $this->table->generate() );

        $this->table->set_heading('Nama');

        foreach ($server_info['apache_mods'] as $mod)
        {
            $this->table->add_row($mod);
        }

        $fields[]   = array(
            'name'  => 'apache-mods',
            'type'  => 'custom',
            'label' => 'Module Apache',
            'value' => $this->table->generate() );

        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name'      => 'info',
            'action'    => current_url(),
            'fields'    => $fields,
            'no_buttons'=> TRUE,
            ));

        $this->set_panel_body($form->generate());

        $this->load->theme('pages/panel_info', $this->data);
    }

    public function backup()
    {
        if ( !$this->authr->is_permited('sys_backstore_manage') )
            $this->_notice( 'access-denied' );

        $this->set_panel_title('Cadangkan Basis Data');

        $this->load->library('baka_pack/utily');

        $fields[]   = array(
            'name'  => 'db-driver',
            'type'  => 'static',
            'label' => 'Database driver',
            'std'   => $this->utily->get_info('driver') );

        $fields[]   = array(
            'name'  => 'host-info',
            'type'  => 'static',
            'label' => 'Host info',
            'std'   => $this->utily->get_info('host_info') );

        $fields[]   = array(
            'name'  => 'server-info',
            'type'  => 'static',
            'label' => 'Server info',
            'std'   => $this->utily->get_info('server_info').' Version. '.$this->utily->get_info('server_version') );

        $fields[]   = array(
            'name'  => 'backup-all',
            'type'  => 'switch',
            'label' => 'Backup semua tabel',
            'std'   => 1
            );

        $fields[]   = array(
            'name'  => 'backup-table',
            'type'  => 'checkbox',
            'label' => 'Backup beberapa tabel',
            'option'=> $this->utily->list_tables(),
            'fold'  => array(
                'key' => 'backup-all',
                'value' => 0 ),
            'validation'=> '' );

        $fields[]   = array(
            'name'  => 'backup-dl',
            'type'  => 'switch',
            'label' => 'Download backup',
            'std'   => 0
            );

        $backup_list = '<ol>';

        if ($list_backups = $this->utily->list_backups())
        {
            foreach ($list_backups as $key => $value)
            {
                $backup_list .= '<li class="form-control-static">'.anchor('application/storage/backup/'.$key.'.zip', $value['date']).'</li>';
            }
        }
        else
        {
            $backup_list .= '<li class="form-control-static">Belum ada backup</li>';
        }

        $backup_list .= '</ol>';

        $fields[]   = array(
            'name'  => 'backup-list',
            'type'  => 'custom',
            'label' => 'Daftar backup',
            'value' => $backup_list );

        $buttons[]= array(
            'name'  => 'do-backup',
            'type'  => 'submit',
            'label' => 'lang:backup_btn',
            'class' => 'btn-primary pull-right' );

        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name'      => 'backup',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $tables = array();

            if ($form_data['backup-all'] != 1)
            {
                $tables = $form_data['backup-table'];
            }

            $download = FALSE;

            if ($form_data['backup-dl'] == 1)
            {
                $download = TRUE;
            }

            if ( $this->utily->backup($tables, $download) )
            {
                $this->session->set_flashdata('success', Messg::get('success'));
            }
            else
            {
                $this->session->set_flashdata('error', Messg::get('error'));
            }

            redirect( current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    public function restore()
    {
        if ( !$this->authr->is_permited('sys_backstore_manage') )
            $this->_notice( 'access-denied' );

        $this->set_panel_title('Pemulihan Basis Data');

        $this->load->library('baka_pack/utily');

        $fields[]   = array(
            'name'  => 'restore-from-backup',
            'type'  => 'switch',
            'label' => 'Restor dari backup sebelumnya',
            'std'   => 1
            );

        $fields[]   = array(
            'name'  => 'restore-file-upload',
            'type'  => 'upload',
            'label' => 'Restore dari berkas',
            'fold'  => array(
                'key' => 'restore-from-backup',
                'value' => 0 ),
            'file_limit' => 1,
            'allowed_types' => 'zip|sql',
            'desc'  => 'Pilih berkas yang akan digunakan untuk me-restore database' );

        if ($list_backups = $this->utily->list_backups())
        {
            foreach ($list_backups as $key => $value)
            {
                $backup_list[$key] = $value['date'];
            }

            $fields[]   = array(
                'name'  => 'restore-backups-list',
                'type'  => 'radio',
                'label' => 'Daftar backup',
                'fold'  => array(
                    'key' => 'restore-from-backup',
                    'value' => 1 ),
                'option' => $backup_list );
        }
        else
        {
            $fields[]   = array(
                'name'  => 'restore-backups-list',
                'type'  => 'static',
                'label' => 'Daftar backup',
                'fold'  => array(
                    'key' => 'restore-from-backup',
                    'value' => 1 ),
                'std' => 'Belum ada backup' );
        }

        $buttons[]= array(
            'name'  => 'do-restore',
            'type'  => 'submit',
            'label' => 'lang:restore_btn',
            'class' => 'btn-primary pull-right' );

        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name'      => 'restore',
            'action'    => current_url(),
            'fields'    => $fields,
            'buttons'   => $buttons,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            // print_pre($form_data);
            $upload = FALSE;
            $file_name = $form_data['restore-backups-list'];

            if ($form_data['restore-from-backup'] != 1)
            {
                $upload = TRUE;
                $file_name = $form_data['restore-file-upload'];
            }

            // var_dump($file_name);

            if ( $this->utily->restore($file_name, $upload) )
            {
                $this->session->set_flashdata('success', Messg::get('success'));
            }
            else
            {
                $this->session->set_flashdata('error', Messg::get('error'));
            }

            redirect( current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    public function logs( $file = '' )
    {
        if ( !$this->authr->is_permited('sys_logs_manage') )
            $this->_notice( 'access-denied' );

        $this->load->helper('directory');

        $this->set_panel_title('Aktifitas Sistem');

        $this->themee->add_navbar( 'log_sidebar', 'nav-tabs nav-stacked nav-tabs-left', 'panel' );

        $latest   = '';
        $log_path = config_item('log_path');
        $scan_dir = directory_map($log_path);

        arsort( $scan_dir );

        foreach ( $scan_dir as $log )
        {
            if ( $log != 'index.html' and $log != 'view.php' )
            {
                $log    = strtolower(str_replace(EXT, '', $log));
                $label  = format_date(str_replace('log-', '', $log));
                $link   = 'admin/sistem/logs/';

                $this->themee->add_navmenu( 'log_sidebar', $log, 'link', $link.$log, $label, array(), 'panel' );
            }
        }

        if ( $file != '' )
        {
            if ( !$this->load->is_loaded('file') )
            {
                $this->load->helper('file');
            }
            
            $this->data['panel_title'] .= ' Tanggal '.format_date(str_replace('log-', '', $file));

            foreach ( file( $log_path.$file.EXT, FILE_IGNORE_NEW_LINES ) as $log_line )
            {
                if ( strlen($log_line) > 0 AND !is_null($log_line) AND $log_line != '' )
                {
                    $state = explode(' - ', $log_line);

                    if ( isset($state[1]) )
                    {
                        $date = explode(' --> ', $state[1]);

                        $line[] = array(
                            'time'  => format_time( $date[0] ),
                            'state' => twb_label( $state[0], strtolower( $state[0] ) ),
                            'msg'   => ( strpos( $date[1], 'Severity: ' ) === false)
                                ? $date[1] : twb_label( $date[1], strtolower( $state[0] ) ).' '.$date[2] );
                    }
                }
            }

            $this->data['count_log'] = 'Terdapat '.count( $line ).' catatan error.';

            $this->load->library('table');

            $this->table->set_heading('Waktu', 'Status', 'Pesan');
            $this->table->set_template( array(
                'table_open' => '<table class="table table-striped table-bordered table-hover table-condensed">' ) );

            arsort( $line );

            $panel_body = $this->table->generate( $line );
        }
        else
        {
            $panel_body = 'Pilih tanggal.';
        }

        $this->data['panel_body'] = $panel_body;

        $this->load->theme('pages/syslogs', $this->data);
    }
}

/* End of file Sistem.php */
/* Location: ./application/controllers/admin/Sistem.php */