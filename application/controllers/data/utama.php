<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

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
    private $modules_arr = array();
    private $modules_count_arr = array();

    public function __construct()
    {
        parent::__construct();

        $this->verify_login();

        $this->themee->set_title('Dashboard');

        $this->themee->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->data_navbar( 'data_sidebar', 'side' );

        $this->modules_arr          = $this->bpmppt->get_modules_assoc();

        $this->data['page_link'] = 'data/';
    }

    public function index()
    {
        redirect('dashboard');
    }

    public function stat()
    {
        $this->data['panel_title']  = $this->themee->set_title('Semua data perijinan');
        $this->data['data_type']    = $this->modules_arr;

        if ( !empty($this->modules_arr) )
        {
            $this->data['load_toolbar'] = TRUE;
            // $this->data['search_form']   = TRUE;
            $this->data['page_link'] .= 'layanan/index/';

            foreach ($this->modules_arr as $alias => $name)
            {
                $this->data['tool_buttons']['Baru:dd|primary'][$alias.'/form'] = $name;
                $this->data['counter'][$alias] = $this->bpmppt->count_data($alias);
            }

            $this->data['tool_buttons']['utama/laporan'] = 'Laporan|default';
            $this->data['panel_body']   = '' /*$this->bpmppt->get_tables( $this->data['page_link'] )*/;
            

            $this->load->theme('pages/panel_alldata', $this->data);
        }
        else
        {
            $this->_notice( 'no-data-accessible' );
        }
    }

    public function laporan()
    {
        $this->data['panel_title'] = $this->themee->set_title('Laporan data');

        foreach ( $this->bpmppt->get_modules_object() as $module )
        {
            $modules[$module->link] = $module->label;
        }

        $fields[]   = array(
            'name'  => 'data_type',
            'label' => 'Pilih data perijinan',
            'type'  => 'dropdown',
            'option'=> add_placeholder( $modules ),
            'validation'=> 'required',
            'desc'  => 'Pilih jenis dokumen yang ingin dicetak. Terdapat '.count( $modules ).' yang dapat anda cetak.' );

        $fields[]   = array(
            'name'  => 'data_status',
            'label' => 'Status Pengajuan',
            'type'  => 'dropdown',
            'option'=> array(
                'all'       => 'Semua',
                'pending'   => 'Tertunda',
                'approved'  => 'Disetujui',
                'done'      => 'Selesai' ),
            'desc'  => 'tentukan status dokumennya, pilih <em>Semua</em> untuk mencetak semua dokumen dengan jenis dokumen diatas, atau anda dapat sesuaikan dengan kebutuhan.' );

        $fields[]   = array(
            'name'  => 'data_date',
            'label' => 'Bulan &amp; Tahun',
            'type'  => 'subfield',
            'fields'=> array(
                array(
                    'name' => 'data_month',
                    'col'   => 6,
                    'label' => 'Bulan',
                    'type'  => 'dropdown',
                    'option'=> add_placeholder( get_month_assoc(), 'Pilih Bulan') ),
                array(
                    'name' => 'data_year',
                    'col'   => 6,
                    'label' => 'Tahun',
                    'type'  => 'dropdown',
                    'option'=> add_placeholder( get_year_assoc(), 'Pilih Tahun') )
                ),
            'desc'  => 'Tentukan tanggal dan bulan dokumen.' );

        // $fields[]    = array(
        //  'name'  => 'data_sort',
        //  'label' => 'Urutan',
        //  'type'  => 'radio',
        //  'option'=> array(
        //      'asc'   => 'Ascending',
        //      'des'   => 'Descending'),
        //  'std'   => 'asc',
        //  'desc'  => 'Tentukan jenis pengurutan output dokumen.' );

        // $fields[]    = array(
        //  'name'  => 'data_output',
        //  'label' => 'Pilihan Output',
        //  'type'  => 'radio',
        //  'option'=> array(
        //      'print' => 'Cetak Langsung',
        //      'excel' => 'Export ke file MS Excel'),
        //  'std'   => 'print' );

        $buttons[]= array(
            'name'  => 'do-print',
            'type'  => 'submit',
            'label' => 'Cetak sekarang',
            'class' => 'btn-primary pull-right' );

        $form = $this->baka_form->add_form(
                                    current_url(),
                                    'internal-skpd',
                                    '', '', 'post',
                                    array('target' => '_blank') )
                                ->add_fields( $fields )
                                ->add_buttons( $buttons );

        if ( $form->validate_submition() )
        {
            $submited_data = $form->submited_data();

            $data = $this->bpmppt->skpd_properties();
            $data['layanan'] = $this->bpmppt->get_label($submited_data['data_type']);
            $data['results'] = array();

            $this->load->theme('prints/reports/'.$submited_data['data_type'], $data, 'laporan');
        }
        else
        {
            $this->data['panel_body'] = $form->render();

            $this->load->theme('pages/panel_form', $this->data);
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