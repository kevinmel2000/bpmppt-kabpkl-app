<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     CodeIgniter Baka Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
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

        $this->verify_login(uri_string());

        $this->themee->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->data_navbar( 'data_sidebar', 'side' );

        $this->set_panel_title('Dashboard');

        $this->data['page_link'] = 'data/utama/';

        if ($this->data['page_link'] != $this->uri->uri_string().'/')
        {
            redirect($this->data['page_link']);
        }
    }

    public function index()
    {
        $this->set_panel_title('Semua data perijinan');
        $modules = $this->bpmppt->get_modules();

        if ( !empty($modules) )
        {
            // $this->data['load_toolbar'] = TRUE;
            // $this->data['search_form']   = TRUE;

            foreach($modules as $link => $layanan)
            {
                $this->data['panel_body'][$link] = array(
                    'label'    => $layanan['label'],
                    'alias'    => $layanan['alias'],
                    'total'    => $this->bpmppt->count_data($layanan['alias']),
                    'pending'  => $this->bpmppt->count_data($layanan['alias'], array('status' => 'pending')),
                    'approved' => $this->bpmppt->count_data($layanan['alias'], array('status' => 'approved')),
                    'deleted'  => $this->bpmppt->count_data($layanan['alias'], array('status' => 'deleted')),
                    'done'     => $this->bpmppt->count_data($layanan['alias'], array('status' => 'done')),
                    );
            }
            
            Asssets::set_script('chartjs', 'lib/chart.min.js', '', 'master');

            $script = "$('.charts').each(function () {\n"
                    . "    var el = $(this),\n"
                    . "        ctx = el.get(0).getContext('2d'),\n"
                    . "        data = [\n"
                    . "            { value: el.data('pending'),  color: '#f0ad4e'},\n"
                    . "            { value: el.data('approved'), color: '#428bca'},\n"
                    . "            { value: el.data('deleted'),  color: '#d9534f'},\n"
                    . "            { value: el.data('done'),     color: '#5cb85c'},\n"
                    . "        ],\n"
                    . "        options = {\n"
                    . "            segmentShowStroke : false\n"
                    . "        },\n"
                    . "        myNewChart = new Chart(ctx).Doughnut(data, options);\n"
                    . "});";

            Asssets::set_script('chartjs-trigger', $script, 'chartjs');

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