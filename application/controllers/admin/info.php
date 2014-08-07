<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Info Class
 *
 * @subpackage  Controller
 */
class Info extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login(uri_string());

        if ( !$this->authr->is_permited('sys_manage') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->themee->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->admin_navbar( 'admin_sidebar', 'side' );

        $this->set_panel_title('Informasi sistem');
    }

    public function index()
    {
        if ( !$this->authr->is_permited('sys_logs_manage') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->set_panel_title('Informasi Sistem');

        $this->load->library('utily');
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
            'label' => 'Informasi Database',
            'value' => $this->utily->get_db_info() );

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

        $this->load->library('former');

        $form = $this->former->init( array(
            'name'      => 'info',
            'action'    => current_url(),
            'fields'    => $fields,
            'no_buttons'=> TRUE,
            ));

        $this->set_panel_body($form->generate());

        $this->load->theme('pages/panel_info', $this->data);
    }
}

/* End of file info.php */
/* Location: ./application/controllers/admin/info.php */