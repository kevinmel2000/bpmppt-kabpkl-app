<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

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

        $this->verify_login(uri_string());

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
                    'name' => 'month',
                    'col'   => 6,
                    'label' => 'Bulan',
                    'type'  => 'dropdown',
                    'option'=> add_placeholder( get_month_assoc(), 'Pilih Bulan') ),
                array(
                    'name' => 'year',
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

        $this->load->library('former');

        $form = $this->former->init( array(
            'name'      => 'print-all',
            'action'    => current_url(),
            'extras'    => array('target' => '_blank'),
            'fields'    => $fields,
            'buttons'   => $buttons,
            ));

        if ( $filter_data = $form->validate_submition() )
        {
            $type = $filter_data['data_type'];
            unset($filter_data['data_type']);

            $wheres['type'] = $this->bpmppt->get_alias($type);

            if ( $filter_data['data_date_month'] )
            {
                $wheres['month'] = $filter_data['data_date_month'];
            }

            if ( $filter_data['data_date_year'] )
            {
                $wheres['year'] = $filter_data['data_date_year'];
            }

            if ( $filter_data['data_status'] != 'all' )
            {
                $wheres['status'] = $filter_data['data_status'];
            }

            $data            = $this->bpmppt->skpd_properties();
            $data['layanan'] = $this->bpmppt->get_label($type);
            $data['results'] = $this->bpmppt->get_report($wheres);

            $this->load->theme('prints/reports/'.$type, $data, 'laporan');
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