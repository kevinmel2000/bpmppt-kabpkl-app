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
            'option'=> add_placeholder( $modules ),
            'validation'=> 'required',
            'desc'  => 'Pilih jenis dokumen yang ingin dicetak. Terdapat '.count( $this->_modules_arr ).' yang dapat anda cetak.' );

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
            $submited_data = $form->submited_data();

            $data = $this->bpmppt->skpd_properties();
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