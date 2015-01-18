<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
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
            if ((is_numeric($page) && $page > 0) && $data_id === FALSE) {
                $data_id = $page;
                $page = 'form';
            }

            switch ($page)
            {
                case 'form':
                    $this->_form($driver, $data_id);
                    break;

                case 'laporan':
                    $this->laporan($driver, $data_id);
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

    public function laporan($driver = NULL, $data_id = NULL)
    {
        if (is_numeric($data_id))
        {
            $data = $this->izin->get_print($driver, $data_id);
            $this->load->theme('prints/products/'.$driver, $data, 'print');
        }
        else if ($data_id == 'setting')
        {
            $this->_template($driver, 'reports');
        }
        else
        {
            $this->set_panel_title('Laporan data');
            $laporan = $this->bpmppt->get_printform($driver);

            if (is_array($laporan))
            {
                $data_type = $laporan['data_type'];
                unset($laporan['data_type']);

                $data = $this->izin->do_report($data_type, $laporan);
                $this->load->theme('prints/reports/'.$data_type, $data, 'report');
            }
            else
            {
                $this->data['tool_buttons'] = $this->bpmppt->get_buttons();
                $this->data['panel_body'] = $laporan->generate();

                $this->load->theme('dataform', $this->data);
            }
        }
    }

    private function _data($driver, $id = FALSE)
    {
        if ($id == 'setting')
        {
            $this->_template($driver, 'products');
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
        $this->data['panel_body'] = $form->generate();

        $this->load->theme('dataform', $this->data);
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

    private function _template($driver, $type = 'products')
    {
        $type = $type != 'products' ? 'reports' : $type;
        $title = 'Editing template ';

        if ($type == 'products')
        {
            $title .= 'data ';
            $filter = array(
                '<?php foreach (unserialize($data_tembusan) as $tembusan) : ?>' => '<!-- start loop -->',
                '<?php endforeach ?>'                                           => '<!-- end loop -->',
                '<?php if (strlen($data_tembusan) > 0): ?>'                     => '<!-- start condition -->',
                '<?php endif ?>'                                                => '<!-- end condition -->',
                );
        }
        elseif ($type == 'reports')
        {
            $title .= 'Laporan ';
            $filter = array(
                '<?php if ($results) : $i = 1; foreach($results as $row) : ?>' => '<!-- start loop -->',
                '<?php $i++; endforeach; else : ?>'                            => '<!-- conditional loop -->',
                '<?php endif ?>'                                               => '<!-- end loop -->',
                '$row->'                                                       => '#',
                );
        }

        $this->set_panel_title($title.$this->izin->get_label($driver));
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $this->data['tool_buttons'][] = array(
            'data/setting' => 'Produk Template|default',
            'laporan/setting' => 'Laporan Template|default'
            );

        $this->data['panel_body'] = $this->izin->get_template_editor($type, $driver, $filter);

        $this->load->theme('dataform', $this->data);
    }
}

/* End of file layanan.php */
/* Location: ./application/controllers/layanan.php */
