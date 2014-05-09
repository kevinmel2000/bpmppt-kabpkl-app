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
 * Info Class
 *
 * @subpackage  Controller
 */
class Info extends BAKA_Controller
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

        $this->set_panel_title('Informasi sistem');
    }

    public function index()
    {
        if ( !$this->authr->is_permited('users_manage') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->set_panel_title('Semua data pengguna');

        $this->load->library('table');

        $this->table->set_heading(array(
            array(
                'data' => 'Nama',
                'width' => '30%',
                ),
            array(
                'data' => 'Nilai',
                'width' => '70%',
                ),
            ));

        $this->table->set_template( array('table_open' => '<table class="table table-striped table-bordered table-hover table-condensed">' ) );

        $this->table->add_row('Versi PHP', phpversion());

        $extensions = '<dl class="dl-horizontal">';
        foreach (get_loaded_extensions() as $i => $ext)
        {
            $extensions .= '<dt>'.$ext.'</dt><dd>'.phpversion($ext).'</dd>';
        }
        $extensions .= '</dl>';

        $this->table->add_row('Extensi PHP', $extensions);

        $this->set_panel_body($this->table->generate());

        $this->load->theme('pages/panel_data', $this->data);
    }
}

/* End of file info.php */
/* Location: ./application/controllers/admin/info.php */