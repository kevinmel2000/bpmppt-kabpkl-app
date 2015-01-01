<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Layanan
 * @category    Controller
 */

// -----------------------------------------------------------------------------

class Layanan extends BI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login(uri_string());
        $this->load->library('bpmppt');

        $this->bpmppt->get_navigation();
        $this->set_panel_title('Administrasi data');

        $this->data['page_link'] = 'layanan/';
    }

    public function index($driver = FALSE, $page = 'data', $data_id = FALSE)
    {
        if (!$driver)
        {
            $this->overview();
        }
        elseif (in_array($driver, array('laporan', 'overview')))
        {
            $this->$driver();
        }
        else
        {
            $this->data['load_toolbar'] = TRUE;
            $this->data['page_link'] .= $driver.'/';

            switch ($page)
            {
                case 'form':
                    $this->_form($driver, $data_id);
                    break;

                case 'cetak':
                    $this->_print($driver, $data_id);
                    break;

                case 'hapus':
                    $this->_change_status('deleted', $data_id, $this->data['page_link']);
                    break;

                case 'delete':
                    $this->_delete($driver, $data_id);
                    break;

                case 'ubah-status':
                    $this->_change_status($this->uri->segment(6) , $data_id, $this->data['page_link']);
                    break;

                case 'data':
                    $this->_data($driver, $data_id);
                    break;
            }
        }
    }

    public function overview()
    {
        $this->set_panel_title('Semua data perijinan');

        if ($overviews = $this->bpmppt->get_overview())
        {
            $this->data['panel_body'] = $overviews;
            $this->load->theme('overview', $this->data);
        }
        else
        {
            $this->_notice('no-data-accessible');
        }
    }

    public function laporan()
    {
        $this->set_panel_title('Laporan data');
        $this->load->library('biform');

        foreach ( $this->izin->get_drivers(TRUE) as $module => $prop )
        {
            $modules[$module] = $prop->label;
        }

        $fields[]   = array(
            'name'  => 'data_type',
            'label' => 'Pilih data perijinan',
            'type'  => 'dropdown',
            'option'=> $modules,
            'validation'=> 'required',
            'desc'  => 'Pilih jenis dokumen yang ingin dicetak. Terdapat '.count( $this->_drivers_arr ).' yang dapat anda cetak.' );

        $fields[]   = array(
            'name'  => 'data_status',
            'label' => 'Status Pengajuan',
            'type'  => 'radio',
            'std'  => 'all',
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
                    'label' => 'Bulan',
                    'type'  => 'dropdown',
                    'option'=> add_placeholder( get_month_assoc(), 'Pilih Bulan') ),
                array(
                    'name' => 'year',
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

        $form = $this->biform->initialize( array(
            'name'      => 'print-all',
            'action'    => current_url(),
            'extras'    => array('target' => 'Popup_Window'),
            'fields'    => $fields,
            'buttons'   => $buttons,
            ));

        $script = "$('form[name=\"print-all\"]').submit(function (e) {"
                . "new Baka.popup('".current_url()."', 'Popup_Window', 800, 600);"
                . "});";

        load_script('print-popup', $script, '', 'bootigniter');

        if ( $form_data = $form->validate_submition() )
        {
            $data_type = $form_data['data_type'];
            unset($form_data['data_type']);

            $data = $this->izin->do_report( $data_type, $form_data );

            $this->load->theme('prints/reports/'.$data_type, $data, 'report');
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('dataform', $this->data);
    }

    private function _data($driver, $id = FALSE)
    {
        if ($id == 'setting')
        {
            $this->data_out($driver);
        }
        else if (is_numeric($id))
        {
            redirect($this->data['page_link'].'form/'.$id);
        }
        else
        {
            $this->data['data_page'] = TRUE;

            $form = $this->bpmppt->get_datatable($driver, $this->data['page_link']);

            $this->data['tool_buttons'] = $this->bpmppt->get_buttons();
            $this->data['panel_body'] = $form;

            $this->load->theme('dataform', $this->data);
        }
    }

    private function _form($driver, $data_id = FALSE)
    {
        $this->set_panel_title('Input data '.$this->izin->get_label($driver));

        $form = $this->bpmppt->get_dataform($driver, $data_id);

        $this->data['tool_buttons'] = $this->bpmppt->get_buttons();
        $this->data['panel_body'] = $form;

        $this->load->theme('dataform', $this->data);
    }

    private function _print($driver, $data_id = FALSE)
    {
        if (is_numeric($data_id))
        {
            $data = $this->izin->get_print($driver, $data_id);
            $this->load->theme('prints/products/'.$driver, $data, 'print');
        }
        else if ($data_id == 'setting')
        {
            $this->_print_out($driver);
        }
        else
        {
            $this->data['tool_buttons']['data'] = 'Kembali|default';
            $this->set_panel_title('Laporan data '.$this->izin->get_label($driver));

            $this->load->library('biform');

            $fields['data_status'] = array(
                'label' => 'Status Pengajuan',
                'type'  => 'dropdown',
                'option'=> array(
                    'all'      => 'Semua',
                    'pending'  => 'Tertunda',
                    'approved' => 'Disetujui',
                    'done'     => 'Selesai'),
                'desc'  => 'tentukan status dokumennya, pilih <em>Semua</em> untuk mencetak semua dokumen dengan jenis dokumen diatas, atau anda dapat sesuaikan dengan kebutuhan.');

            $fields['data_date'] = array(
                'label' => 'Bulan &amp; Tahun',
                'type'  => 'subfield',
                'fields'=> array(
                    array(
                        'name'  => 'month',
                        'label' => 'Bulan',
                        'type'  => 'dropdown',
                        'option'=> add_placeholder(get_month_assoc(), 'Pilih Bulan')),
                    array(
                        'name'  => 'year',
                        'label' => 'Tahun',
                        'type'  => 'dropdown',
                        'option'=> add_placeholder(get_year_assoc(), 'Pilih Tahun'))
                    ),
                'desc'  => 'Tentukan tanggal dan bulan dokumen.');

            $buttons[] = array(
                'name'  => 'do-print',
                'type'  => 'submit',
                'label' => 'Cetak sekarang',
                'class' => 'btn-primary pull-right');

            $form = $this->biform->initialize(array(
                'name'    => 'print-'.$driver,
                'action'  => current_url(),
                'extras'  => array('target' => 'Popup_Window'),
                'fields'  => $fields,
                'buttons' => $buttons,
                ));

            $script = "$('form[name=\"print-".$driver."\"]').submit(function (e) {"
                    . "new Baka.popup('".current_url()."', 'Popup_Window', 800, 600);"
                    . "});";

            load_script('print-popup', $script);

            if ($form_data = $form->validate_submition())
            {
                $data = $this->izin->do_report($driver, $form_data);

                $this->load->theme('prints/reports/'.$driver, $data, 'report');
            }
            else
            {
                $this->data['panel_body'] = $form->generate();

                $this->load->theme('dataform', $this->data);
            }
        }
    }

    private function _delete($driver, $data_id)
    {
        if ($this->izin->delete_data($data_id, $this->izin->get_alias($driver)))
        {
            $this->session->set_flashdata('message', 'Dokumen dengan id #'.$data_id.' berhasil dihapus secara permanen.');
        }
        else
        {
            $this->session->set_flashdata('error', 'Terjadi kesalahan penghapusan dokumen sercara permanen.');
        }

        redirect($this->data['page_link']);
    }

    private function _change_status($new_status, $data_id, $redirect)
    {
        if ($this->izin->change_status($data_id, $new_status))
        {
            $message = ' '.($new_status != 'deleted' ? 'berhasil diganti menjadi ' : '');

            $this->session->set_flashdata('success', 'Status dokumen dengan id #'.$data_id.$message._x('status_'.$new_status));
        }
        else
        {
            $this->session->set_flashdata('error', 'Terjadi kesalahan penggantian status dokumen dengan id #'.$data_id);
        }

        redirect($this->data['page_link']);
    }

    private function _data_out($driver)
    {
        $this->set_panel_title('Editing template output '.$this->izin->get_label($driver));
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $this->data['tool_buttons'][] = array(
            'data/setting' => 'Produk Template|default',
            'cetak/setting' => 'Laporan Template|default'
            );

        $this->data['panel_body'] = $this->izin->get_template_editor('products', $driver, array(
            '<?php foreach (unserialize($tambang_koor) as $koor) : ?>'      => '<!-- start loop -->',
            '<?php foreach (unserialize($data_tembusan) as $tembusan) : ?>' => '<!-- start loop -->',
            '<?php endforeach ?>'                                           => '<!-- end loop -->',
            '<?php if (strlen($data_tembusan) > 0): ?>'                     => '<!-- start condition -->',
            '<?php endif ?>'                                                => '<!-- end condition -->',
            ));

        $this->load->theme('dataform', $this->data);
    }

    private function _print_out($driver)
    {
        $this->set_panel_title('Editing template output '.$this->izin->get_label($driver));
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $this->data['tool_buttons'][] = array(
            'data/setting' => 'Produk Template|default',
            'cetak/setting' => 'Laporan Template|default'
            );

        $this->data['panel_body'] = $this->izin->get_template_editor('reports', $driver, array(
            '<?php if ($results) : $i = 1; foreach($results as $row) : ?>' => '<!-- start loop -->',
            '<?php $i++; endforeach; else : ?>'                                => '<!-- conditional loop -->',
            '<?php endif ?>'                                                   => '<!-- end loop -->',
            '$row->'                                                           => '#',
            ));

        $this->load->theme('dataform', $this->data);
    }
}

/* End of file layanan.php */
/* Location: ./application/controllers/layanan.php */
