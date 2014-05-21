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
 * Laporan Class
 *
 * @subpackage  Controller
 */
class Laporan extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login();

        $this->themee->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->data_navbar( 'data_sidebar', 'side' );

        $this->set_panel_title('Laporan');

        $this->data['page_link'] = 'data/laporan/';
    }

    public function index()
    {
        $this->set_panel_title('Laporan data');

        foreach ( $this->bpmppt->get_modules(TRUE) as $module => $prop )
        {
            $modules[$module] = $prop->label;
        }

        $fields[]   = array(
            'name'  => 'data_type',
            'label' => 'Pilih data perijinan',
            'type'  => 'dropdown',
            'option'=> $modules,
            'validation'=> 'required',
            'desc'  => 'Pilih jenis dokumen yang ingin dicetak. Terdapat '.count( $this->_modules_arr ).' yang dapat anda cetak.' );

        $fields[]   = array(
            'name'  => 'data_status',
            'label' => 'Status Pengajuan',
            'type'  => 'radio',
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

        $buttons[]= array(
            'name'  => 'do-print',
            'type'  => 'submit',
            'label' => 'Cetak sekarang',
            'class' => 'btn-primary pull-right' );

        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name'      => 'print-all',
            'action'    => current_url(),
            'extras'    => array('target' => '_blank'),
            'fields'    => $fields,
            'buttons'   => $buttons,
            ));

        if ( $form->validate_submition() )
        {
            $submited_data   = $form->submited_data();
            $data            = $this->bpmppt->skpd_properties();
            $data['layanan'] = $this->bpmppt->get_label($submited_data['data_type']);
            $data['results'] = array();

            $this->load->theme('prints/reports/'.$submited_data['data_type'], $data, 'laporan');
        }
        else
        {
            $this->data['panel_body'] = $form->generate();

            $this->load->theme('pages/panel_form', $this->data);
        }
    }
}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */