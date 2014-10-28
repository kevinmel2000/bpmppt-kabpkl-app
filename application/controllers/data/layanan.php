<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
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

        $this->bitheme->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->data_navbar( 'data_sidebar', 'side' );

        $this->set_panel_title('Administrasi data');

        $this->data['page_link'] = 'data/layanan/';
    }

    public function index( $data_type = FALSE, $page = 'data', $data_id = FALSE )
    {
        if ( !$data_type )
        {
            $this->set_panel_title('Semua data perijinan');
            $modules = $this->bpmppt->get_modules();

            if (!empty($modules))
            {
                foreach($this->bpmppt->get_modules() as $link => $layanan)
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
            }
            else
            {
                $this->_notice( 'no-data-accessible' );
            }

            $this->load->theme('overview', $this->data);
        }
        else
        {
            $this->data['load_toolbar'] = TRUE;
            $this->data['page_link']   .= $data_type.'/';

            switch ( $page )
            {
                case 'form':
                    $this->form( $data_type, $data_id );
                    break;

                case 'cetak':
                    $this->cetak( $data_type, $data_id );
                    break;

                case 'hapus':
                    $this->ubah_status( 'deleted', $data_id, $this->data['page_link'] );
                    break;

                case 'delete':
                    $this->delete( $data_type, $data_id );
                    break;

                case 'ubah-status':
                    $this->ubah_status( $this->uri->segment(6) , $data_id, $this->data['page_link'] );
                    break;

                case 'data':
                    $this->data( $data_type, $data_id );
                    break;

                default:
                    if (is_numeric($page))
                    {
                        $this->data( $data_type, $page );
                    }
                    break;
            }
        }
    }

    public function data( $data_type, $id = FALSE )
    {
        if ($id == 'setting')
        {
            $this->data_out( $data_type );
        }
        else if (is_numeric($id))
        {
            redirect($this->data['page_link'].'form/'.$id);
        }
        else
        {
            $this->data['data_page'] = TRUE;
            $this->data['tool_buttons']['form']              = 'Baru|primary';
            $this->data['tool_buttons']['cetak']             = 'Laporan|info';
            $this->data['tool_buttons'][] = array(
                'data/status/semua'    => 'Semua',
                'data/status/pending'  => 'Pending',
                'data/status/approved' => 'Disetujui',
                'data/status/done'     => 'Selesai',
                'data/status/deleted'  => 'Dihapus'
                );
            $this->data['tool_buttons']['Template|default'] = array(
                'data/setting'  => 'Data',
                'cetak/setting' => 'Laporan',
                );

            $this->set_panel_title( 'Semua data '.$this->bpmppt->get_label( $data_type ) );

            $slug = $this->bpmppt->get_alias( $data_type );
            $stat = FALSE;

            switch ( $this->uri->segment(5) )
            {
                case 'status':
                    $stat   = $this->uri->segment(6);
                    $query  = $this->bpmppt->get_data_by_status( $stat, $slug );
                    break;

                case 'page':
                default:
                    $query = $this->bpmppt->get_data_by_type( $slug );
                    break;
            }

            $this->load->library('bitable', array(
                'base_url' => $this->data['page_link'],
                ));

            $grid = $this->bitable->set_column('Pengajuan',
                                    'callback_anchor:id|no_agenda, callback_format_datetime:created_on',
                                    '30%',
                                    '<strong>%s</strong><br><small class="text-muted">Diajukan pada: %s</small>')
                                ->set_column('Pemohon', 'petitioner', '40%', '<strong>%s</strong>')
                                ->set_column('Status', 'status, callback__x:status', '10%', '<span class="label label-%s">%s</span>');

            $grid->set_button('form', 'Lihat data');

            if ( $stat == 'deleted' )
            {
                $grid->set_button('delete', 'Hapus data secara permanen');
            }
            else
            {
                $grid->set_button('hapus', 'Hapus data');
            }

            $this->data['panel_body'] = $grid->generate( $query );

            $this->load->theme('dataform', $this->data);
        }
    }

    public function form( $data_type, $data_id = FALSE )
    {
        $data_obj = ( $data_id ? $this->bpmppt->get_fulldata_by_id( $data_id ) : FALSE );

        $this->set_panel_title( 'Input data '.$this->bpmppt->get_label( $data_type ) );
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $fields = array();

        if ( $data_obj )
        {
            $status = $data_obj->status;

            if ( $data_obj->status !== 'deleted' )
            {
                $h_link = 'hapus';
                $h_text = 'Hapus';
            }
            else
            {
                $h_link = 'delete';
                $h_text = 'Hapus Permanen';
            }

            $this->data['tool_buttons']['form'] = 'Baru|primary';
            $this->data['tool_buttons'][] = array(
                'cetak/'.$data_id => 'Cetak|info',
                $h_link.'/'.$data_id => $h_text.'|danger'
                );

            $this->data['tool_buttons']['Ubah status|default'] = array(
                'ubah-status/'.$data_id.'/pending/'  => 'Pending',
                'ubah-status/'.$data_id.'/approved/' => 'Disetujui',
                'ubah-status/'.$data_id.'/done/'     => 'Selesai' );

            $date   = ( $status != 'pending' ? ' pada: '.format_datetime( $data_obj->{$status.'_on'} ) : '' );
        }

        $this->data['panel_body'] = $this->bpmppt->get_form( $data_type, $data_obj, $data_id );

        $this->load->theme('dataform', $this->data);
    }

    public function cetak( $data_type, $data_id = FALSE )
    {
        if ( is_numeric($data_id) )
        {
            $data = $this->bpmppt->get_print($data_type, $data_id);
            $this->load->theme('prints/products/'.$data_type, $data, 'print');
        }
        else if ( $data_id == 'setting' )
        {
            $this->print_out($data_type);
        }
        else
        {
            $this->data['tool_buttons']['data'] = 'Kembali|default';
            $this->set_panel_title('Laporan data '.$this->bpmppt->get_label( $data_type ));

            $this->load->library('biform');

            $fields[] = array(
                'name'  => 'data_status',
                'label' => 'Status Pengajuan',
                'type'  => 'dropdown',
                'option'=> array(
                    'all'      => 'Semua',
                    'pending'  => 'Tertunda',
                    'approved' => 'Disetujui',
                    'done'     => 'Selesai' ),
                'desc'  => 'tentukan status dokumennya, pilih <em>Semua</em> untuk mencetak semua dokumen dengan jenis dokumen diatas, atau anda dapat sesuaikan dengan kebutuhan.' );

            $fields[] = array(
                'name'  => 'data_date',
                'label' => 'Bulan &amp; Tahun',
                'type'  => 'subfield',
                'fields'=> array(
                    array(
                        'name'  => 'month',
                        'label' => 'Bulan',
                        'type'  => 'dropdown',
                        'option'=> add_placeholder( get_month_assoc(), 'Pilih Bulan') ),
                    array(
                        'name'  => 'year',
                        'label' => 'Tahun',
                        'type'  => 'dropdown',
                        'option'=> add_placeholder( get_year_assoc(), 'Pilih Tahun') )
                    ),
                'desc'  => 'Tentukan tanggal dan bulan dokumen.' );

            $buttons[] = array(
                'name'  => 'do-print',
                'type'  => 'submit',
                'label' => 'Cetak sekarang',
                'class' => 'btn-primary pull-right' );

            $form = $this->biform->initialize( array(
                'name'    => 'print-'.$data_type,
                'action'  => current_url(),
                'extras'  => array('target' => 'Popup_Window'),
                'fields'  => $fields,
                'buttons' => $buttons,
                ));

            $script = "$('form[name=\"print-".$data_type."\"]').submit(function (e) {"
                    . "new Baka.popup('".current_url()."', 'Popup_Window', 800, 600);"
                    . "});";

            load_script('print-popup', $script);

            if ( $form_data = $form->validate_submition() )
            {
                $data = $this->bpmppt->do_report( $data_type, $form_data );

                $this->load->theme('prints/reports/'.$data_type, $data, 'report');
            }
            else
            {
                $this->data['panel_body'] = $form->generate();

                $this->load->theme('dataform', $this->data);
            }
        }
    }

    public function delete( $data_type, $data_id )
    {
        if ( $this->bpmppt->delete_data( $data_id, $this->bpmppt->get_alias($data_type) ) )
        {
            $this->session->set_flashdata('message', 'Dokumen dengan id #'.$data_id.' berhasil dihapus secara permanen.');
        }
        else
        {
            $this->session->set_flashdata('error', 'Terjadi kesalahan penghapusan dokumen sercara permanen.');
        }

        redirect( $this->data['page_link'] );
    }

    public function ubah_status( $new_status, $data_id, $redirect )
    {
        if ( $this->bpmppt->change_status( $data_id, $new_status ) )
        {
            $message = ' '.( $new_status != 'deleted' ? 'berhasil diganti menjadi ' : '' );

            $this->session->set_flashdata('success', 'Status dokumen dengan id #'.$data_id.$message._x('status_'.$new_status));
        }
        else
        {
            $this->session->set_flashdata('error', 'Terjadi kesalahan penggantian status dokumen dengan id #'.$data_id);
        }

        redirect( $this->data['page_link'] );
    }

    public function data_out( $data_type )
    {
        $this->set_panel_title( 'Editing template output '.$this->bpmppt->get_label( $data_type ) );
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $this->data['tool_buttons'][] = array(
            'data/setting' => 'Produk Template|default',
            'cetak/setting' => 'Laporan Template|default'
            );

        $this->data['panel_body'] = $this->bpmppt->get_template_editor( 'products', $data_type, array(
            '<?php foreach (unserialize($tambang_koor) as $koor) : ?>'      => '<!-- start loop -->',
            '<?php foreach (unserialize($data_tembusan) as $tembusan) : ?>' => '<!-- start loop -->',
            '<?php endforeach ?>'                                           => '<!-- end loop -->',
            '<?php if (strlen($data_tembusan) > 0): ?>'                     => '<!-- start condition -->',
            '<?php endif ?>'                                                => '<!-- end condition -->',
            ));

        $this->load->theme( 'dataform', $this->data );
    }

    public function print_out( $data_type )
    {
        $this->set_panel_title( 'Editing template output '.$this->bpmppt->get_label( $data_type ) );
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $this->data['tool_buttons'][] = array(
            'data/setting' => 'Produk Template|default',
            'cetak/setting' => 'Laporan Template|default'
            );

        $this->data['panel_body'] = $this->bpmppt->get_template_editor( 'reports', $data_type, array(
            '<?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>' => '<!-- start loop -->',
            '<?php $i++; endforeach; else : ?>'                                => '<!-- conditional loop -->',
            '<?php endif ?>'                                                   => '<!-- end loop -->',
            '$row->'                                                           => '#',
            ));

        $this->load->theme( 'dataform', $this->data );
    }
}

/* End of file layanan.php */
/* Location: ./application/controllers/layanan.php */
