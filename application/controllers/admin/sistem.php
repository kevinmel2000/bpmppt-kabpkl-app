<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Sistem
 * @category    Controller
 */

// -----------------------------------------------------------------------------

class Sistem extends BI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login(uri_string());

        if ( !is_user_can('setting_application') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->bitheme->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->admin_navbar( 'admin_sidebar', 'side' );

        $this->bitheme->set_title('Pemeliharaan Sistem');
    }

    public function index()
    {
        $this->info();
    }

    public function info()
    {
        if ( !is_user_can('debug_application') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->set_panel_title('Informasi Sistem');

        $this->load->library('utily');
        $this->load->library('table');
        $this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-hover table-condensed">' ));

        $server_info = $this->utily->get_server_info();
        $table_head = array(
            array( 'data' => 'Nama',  'style' => 'width:26%' ),
            array( 'data' => 'Nilai', 'style' => 'width:74%' )
            );

        if ($php_version = $server_info['php_version'])
        {
            $fields['php-version'] = array(
                'type'  => 'static',
                'label' => 'Versi PHP',
                'std'   => $php_version,
                );
        }

        if ($server = $server_info['server'])
        {
            $this->table->set_heading($table_head);
            foreach ($server as $key => $val)
            {
                $this->table->add_row($key, $val);
            }

            $fields['server-info'] = array(
                'type'  => 'custom',
                'label' => 'Informasi Server',
                'std'   => $this->table->generate()
                );
        }

        if ($db = $server_info['db'])
        {
            $this->table->set_heading($table_head);
            foreach ($db as $key => $val)
            {
                $this->table->add_row($key, $val);
            }

            $fields['db-info'] = array(
                'type'  => 'custom',
                'label' => 'Informasi Database',
                'std'   => $this->table->generate()
                );
        }

        if ($php_extensions = $server_info['php_extensions'])
        {
            $this->table->set_heading(array(
                array( 'data'  => 'Nama',  'style' => 'width:26%' ),
                array( 'data'  => 'Versi', 'style' => 'width:74%' )
                ));

            foreach ($php_extensions as $key => $val)
            {
                $this->table->add_row($key, $val);
            }

            $fields['php-extensions'] = array(
                'type'  => 'custom',
                'label' => 'Extensi Terinstall',
                'std'   => $this->table->generate()
                );
        }

        if ($php_configs = $server_info['php_configs'])
        {
            $this->table->set_heading($table_head);
            foreach ($php_configs as $key => $val)
            {
                $this->table->add_row(array(
                    array( 'data' => $val['name'], 'id' => $key ),
                    array( 'data' => $val['value'] ),
                    ));
            }

            $fields['php-configs'] = array(
                'type'  => 'custom',
                'label' => 'Konfigurasi',
                'std'   => $this->table->generate()
                );
        }

        if ($apache_mods = $server_info['apache_mods'])
        {
            $this->table->set_heading('Nama');
            foreach ($apache_mods as $mod)
            {
                $this->table->add_row($mod);
            }

            $fields['apache-mods'] = array(
                'type'  => 'custom',
                'label' => 'Module Apache',
                'std'   => $this->table->generate()
                );
        }

        $this->load->library('biform');

        $form = $this->biform->initialize( array(
            'name'      => 'info',
            'action'    => current_url(),
            'fields'    => $fields,
            'no_buttons'=> TRUE,
            ));

        $this->set_panel_body($form->generate());

        $this->load->theme('dataform', $this->data);
    }

    public function logs( $file = '' )
    {
        if ( !is_user_can('debug_application') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->load->helper('directory');
        $this->set_panel_title('Aktifitas Sistem');
        $this->bitheme->add_navbar( 'log_sidebar', 'nav-tabs nav-stacked nav-tabs-left', 'panel' );

        $latest   = '';
        $log_path = config_item('log_path');
        $scan_dir = directory_map($log_path);

        arsort( $scan_dir );

        foreach ( $scan_dir as $log )
        {
            if ( $log != 'index.html' and $log != 'view.php' )
            {
                $log   = strtolower(str_replace(EXT, '', $log));
                $label = format_date(str_replace('log-', '', $log));
                $link  = 'admin/sistem/logs/';

                $this->bitheme->add_navmenu( 'log_sidebar', $log, 'link', $link.$log, $label, array(), 'panel' );
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
                        $state[1] = str_replace(FCPATH, '', $state[1]);
                        $date = explode(' --> ', $state[1]);
                        $line[] = array(
                            'time'  => format_time($date[0]),
                            'state' => twbs_label($state[0], strtolower($state[0])),
                            'msg'   => (strpos($date[1], 'Severity: ') === false) ? $date[1] : twbs_label($date[1], strtolower($state[0])).' '.$date[2]
                            );
                    }
                }
            }

            $this->data['count_log'] = 'Terdapat '.count( $line ).' catatan error.';

            $this->load->library('table');

            $this->table->set_heading('Waktu', 'Status', 'Pesan');
            $this->table->set_template(array(
                'table_open' => '<table class="table table-striped table-bordered table-hover table-condensed">'
                ));

            arsort( $line );
            $panel_body = $this->table->generate( $line );
        }
        else
        {
            $panel_body = 'Pilih tanggal.';
        }

        $this->data['panel_body'] = $panel_body;

        $this->load->theme('syslogs', $this->data);
    }

    public function backup()
    {
        if ( !is_user_can('backstore_application') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->set_panel_title('Cadangkan Basis Data');
        $this->load->library('utily');

        $fields['backup-all'] = array(
            'type'  => 'switch',
            'label' => 'Backup semua tabel',
            'std'   => 1
            );

        $fields['backup-table'] = array(
            'type'  => 'checkbox',
            'label' => 'Backup beberapa tabel',
            'option'=> $this->utily->list_tables(),
            'fold'  => array(
                'key'   => 'backup-all',
                'value' => 0
                ),
            'validation'=> ''
            );

        $fields['backup-dl'] = array(
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

        $fields['backup-list'] = array(
            'type'  => 'custom',
            'label' => 'Daftar backup',
            'std'   => $backup_list
            );

        $buttons['do-backup'] = array(
            'type'  => 'submit',
            'label' => 'lang:backup_btn',
            'class' => 'btn-primary pull-right'
            );

        $this->load->library('biform');

        $form = $this->biform->initialize(array(
            'name'    => 'backup',
            'action'  => current_url(),
            'fields'  => $fields,
            'buttons' => $buttons,
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
                $this->session->set_flashdata('success', get_message('success'));
            }
            else
            {
                $this->session->set_flashdata('error', get_message('error'));
            }

            redirect( current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('dataform', $this->data);
    }

    public function restore()
    {
        if ( !is_user_can('backstore_application') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->set_panel_title('Pemulihan Basis Data');
        $this->load->library('utily');

        $fields['restore-from-backup'] = array(
            'type'  => 'switch',
            'label' => 'Restor dari backup sebelumnya',
            'std'   => 1
            );

        $fields['restore-file-upload'] = array(
            'type'  => 'upload',
            'label' => 'Restore dari berkas',
            'fold'  => array(
                'key'   => 'restore-from-backup',
                'value' => 0
                ),
            'file_limit'    => 1,
            'allowed_types' => 'zip|sql',
            'desc'  => 'Pilih berkas yang akan digunakan untuk me-restore database'
            );

        if ($list_backups = $this->utily->list_backups())
        {
            foreach ($list_backups as $key => $value)
            {
                $backup_list[$key] = $value['date'];
            }

            $fields['restore-backups-list'] = array(
                'type'  => 'radio',
                'label' => 'Daftar backup',
                'fold'  => array(
                    'key'   => 'restore-from-backup',
                    'value' => 1
                    ),
                'option' => $backup_list
                );
        }
        else
        {
            $fields['restore-backups-list'] = array(
                'type'  => 'static',
                'label' => 'Daftar backup',
                'fold'  => array(
                    'key'   => 'restore-from-backup',
                    'value' => 1
                    ),
                'std' => 'Belum ada backup'
                );
        }

        $buttons[]= array(
            'name'  => 'do-restore',
            'type'  => 'submit',
            'label' => 'lang:restore_btn',
            'class' => 'btn-primary pull-right'
            );

        $this->load->library('biform');

        $form = $this->biform->initialize( array(
            'name'    => 'restore',
            'action'  => current_url(),
            'fields'  => $fields,
            'buttons' => $buttons,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            // print_pre($form_data);
            $upload    = FALSE;
            $file_name = $form_data['restore-backups-list'];

            if ($form_data['restore-from-backup'] != 1)
            {
                $upload    = TRUE;
                $file_name = $form_data['restore-file-upload'];
            }

            if ( $this->utily->restore($file_name, $upload) )
            {
                $this->session->set_flashdata('success', get_message('success'));
            }
            else
            {
                $this->session->set_flashdata('error', get_message('error'));
            }

            redirect( current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('dataform', $this->data);
    }

    public function updates()
    {
        if ( !is_user_can('backstore_application') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->set_panel_title('System Updater');
        $this->load->library('biupdate');
        $this->load->library('table');
        $this->load->library('biform');
        $this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered table-hover table-condensed">' ));

        $this->table->set_heading(array(
            array( 'data'  => 'SHA',     'style' => 'width:12%' ),
            array( 'data'  => 'Time',    'style' => 'width:23%' ),
            array( 'data'  => 'Message', 'style' => 'width:65%' ),
            ));

        $new_update = $this->biupdate->is_new_available() ?: false;
        $message = $new_update ? 'New version available, with message: '.$new_update['message'] : 'You are using latest version';
        $fields['latest'] = array(
            'type'  => 'static',
            'label' => 'Latest',
            'std'   => twbs_badge($message, $new_update ? 'danger' : 'info'),
            );

        if ($changelogs = $this->biupdate->get_all())
        {
            foreach ($changelogs as $log)
            {
                $this->table->add_row(substr($log->sha, 0, 7), $log->timestamp, $log->message);
            }
        }
        else
        {
            $this->table->add_row(array( 'data'  => 'Kosong', 'colspan' => '3' ));
        }

        $fields['changelogs'] = array(
            'type'  => 'custom',
            'label' => 'Change logs',
            'std'   => $this->table->generate()
            );

        $buttons['do-update'] = array(
            'type'  => 'submit',
            'label' => 'Update sekarang',
            'class' => 'btn-primary'
            );

        if ($new_update == FALSE)
        {
            $buttons['do-update']['disabled'] = TRUE;
        }

        $form = $this->biform->initialize(array(
            'name'    => 'restore',
            'action'  => current_url(),
            'fields'  => $fields,
            'buttons' => $buttons,
            'hiddens' => $new_update ? array('archive-url' => $new_update['archive']) : array(),
            ));

        // print_pre($this->biupdate->_do_update(APPPATH.'storage/tmp/creasico-bpmppt-4ebea40'));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $this->biupdate->download($form_data['archive-url']) )
            {
                $this->session->set_flashdata('success', 'Download Success');
            }
            else
            {
                $this->session->set_flashdata('error', get_message('error'));
            }

            redirect( uri_string() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('dataform', $this->data);
    }
}

/* End of file Sistem.php */
/* Location: ./application/controllers/admin/Sistem.php */
