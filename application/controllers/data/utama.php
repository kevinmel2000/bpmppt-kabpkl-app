<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * Utama Class
 *
 * @subpackage  Controller
 */
class Utama extends BI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login(uri_string());

        $this->bitheme->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
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

            load_script('chartjs-trigger', $script, '', 'chartjs');

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
