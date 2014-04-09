<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

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
 * Utama Class
 *
 * @subpackage  Controller
 */
class Utama extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login();

        $this->themee->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->data_navbar( 'data_sidebar', 'side' );

        $this->themee->set_title('Dashboard');

        $this->data['page_link'] = 'data/utama/';

        if ($this->data['page_link'] != $this->uri->uri_string().'/')
            redirect($this->data['page_link']);
    }

    public function index()
    {
        $this->data['panel_title']  = $this->themee->set_title('Semua data perijinan');
        $modules = $this->bpmppt->get_modules();

        if ( !empty($modules) )
        {
            // $this->data['load_toolbar'] = TRUE;
            // $this->data['search_form']   = TRUE;

            foreach($modules as $link => $layanan)
            {
                $this->data['panel_body'][$link] = array(
                    'label' => $layanan['label'],
                    'alias' => $layanan['alias'],
                    'total' => $this->bpmppt->count_data($layanan['alias']),
                    'pending' => $this->bpmppt->count_data($layanan['alias'], array('status' => 'pending')),
                    'approved' => $this->bpmppt->count_data($layanan['alias'], array('status' => 'approved')),
                    'deleted' => $this->bpmppt->count_data($layanan['alias'], array('status' => 'deleted')),
                    'done' => $this->bpmppt->count_data($layanan['alias'], array('status' => 'done')),
                    );
            }
            

            $this->load->theme('pages/panel_alldata', $this->data);
        }
        else
        {
            $this->_notice( 'no-data-accessible' );
        }
    }

    public function cetak( $data_type, $data_id = FALSE )
    {
        $data = $this->bpmppt->skpd_properties();

        // $data = array_merge( (array) $data, (array) $this->bpmppt->get_fulldata_by_id( $data_id ) );

        $this->load->theme('prints/reports/'.$data_type, $data, 'laporan');
    }
}

/* End of file utama.php */
/* Location: ./application/controllers/utama.php */