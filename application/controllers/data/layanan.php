<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
 * Layanan Class
 *
 * @subpackage  Controller
 */
class Layanan extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login();

        $this->themee->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->data_navbar( 'data_sidebar', 'side' );

        $this->themee->set_title('Administrasi data');

        $this->data['page_link'] = 'data/layanan/';
    }

    public function index( $data_type = FALSE, $page = 'data', $data_id = FALSE )
    {
        if ( !$data_type )
        {
            $this->data['panel_title']  = $this->themee->set_title('Semua data perijinan');
            $modules = $this->bpmppt->get_modules();
            
            if (!empty($modules))
            {
                foreach($this->bpmppt->get_modules() as $link => $layanan)
                {
                    $this->data['panel_body'][$link] = array(
                        'label'     => $layanan['label'],
                        'alias'     => $layanan['alias'],
                        'total'     => $this->bpmppt->count_data($layanan['alias']),
                        'pending'   => $this->bpmppt->count_data($layanan['alias'], array('status' => 'pending')),
                        'approved'  => $this->bpmppt->count_data($layanan['alias'], array('status' => 'approved')),
                        'deleted'   => $this->bpmppt->count_data($layanan['alias'], array('status' => 'deleted')),
                        'done'      => $this->bpmppt->count_data($layanan['alias'], array('status' => 'done')),
                        );
                }
            }
            else
            {
                $this->_notice( 'no-data-accessible' );
            }

            $this->load->theme('pages/panel_alldata', $this->data);
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
                    $this->ubah_status( $this->uri->segment(7) , $data_id, $this->data['page_link'] );
                    break;

                case 'data':
                    $this->data( $data_type );
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
        // $this->data['search_form']   = TRUE;
        
        if ($id)
        {
            redirect($this->data['page_link'].'form/'.$id);
        }

        $this->data['tool_buttons']['form']              = 'Baru|primary';
        $this->data['tool_buttons']['cetak']             = 'Laporan|info';
        $this->data['tool_buttons']['Status:dd|default'] = array(
            'data/status/semua'     => 'Semua',
            'data/status/pending'   => 'Pending',
            'data/status/approved'  => 'Disetujui',
            'data/status/done'      => 'Selesai',
            'data/status/deleted'   => 'Dihapus'
            );

        $this->data['panel_title'] = $this->themee->set_title( 'Semua data ' . $this->bpmppt->get_label( $data_type ) );

        $slug = $this->bpmppt->get_alias( $data_type );
        $stat  = FALSE;

        switch ( $this->uri->segment(6) )
        {
            case 'status':
                $stat   = $this->uri->segment(7);
                $query  = $this->bpmppt->get_data_by_status( $stat, $slug );
                break;
            
            case 'page':
            default:
                $query = $this->bpmppt->get_data_by_type( $slug );
                break;
        }

        $this->load->library('baka_pack/gridr');

        $grid = $this->gridr->identifier('id')
                            ->set_baseurl($this->data['page_link'])
                            ->set_column('Pengajuan',
                                'callback_anchor:id|no_agenda, callback_format_datetime:created_on',
                                '30%',
                                FALSE,
                                '<strong>%s</strong><br><small class="text-muted">Diajukan pada: %s</small>')
                            ->set_column('Pemohon', 'petitioner', '40%', FALSE, '<strong>%s</strong>')
                            ->set_column('Status', 'status, callback__x:status', '10%', FALSE, '<span class="label label-%s">%s</span>');

        $grid->set_buttons('form/', 'eye-open', 'primary', 'Lihat data');

        if ( $stat == 'deleted' )
            $grid->set_buttons('delete/', 'trash', 'danger', 'Hapus data secara permanen');
        else
            $grid->set_buttons('hapus/', 'trash', 'danger', 'Hapus data');

        $this->data['panel_body']    = $grid->make_table( $query );

        $this->load->theme('pages/panel_data', $this->data);
    }

    public function form( $data_type, $data_id = FALSE )
    {
        $modul_slug = $this->bpmppt->get_alias( $data_type );
        $data_obj   = ( $data_id ? $this->bpmppt->get_fulldata_by_id( $data_id ) : FALSE );

        $this->data['panel_title']  = $this->themee->set_title( 'Input data ' . $this->bpmppt->get_label( $data_type ) );
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $fields = array();

        if ( $data_obj )
        {
            $status = $data_obj->status;

            $this->data['tool_buttons']['form'] = 'Baru|primary';
            $this->data['tool_buttons']['aksi|default']['cetak/'.$data_id] = 'Cetak';

            if ( $data_obj->status !== 'deleted' )
                $this->data['tool_buttons']['aksi|default']['hapus/'.$data_id] = 'Hapus&message="Anda yakin ingin menghapus data nomor '.$data_obj->surat_nomor.'"';
            else
                $this->data['tool_buttons']['aksi|default']['delete/'.$data_id] = 'Hapus Permanen&message="Anda yakin ingin menghapus data nomor '.$data_obj->surat_nomor.'"';

            $this->data['tool_buttons']['Ubah status:dd|default']   = array(
                'ubah-status/'.$data_id.'/pending/'     => 'Pending',
                'ubah-status/'.$data_id.'/approved/'    => 'Disetujui',
                'ubah-status/'.$data_id.'/done/'        => 'Selesai' );

            $date   = ( $status != 'pending' ? ' pada: '.format_datetime( $data_obj->{$status.'_on'} ) : '' );

            // $fields[]   = array(
            //     'name'  => $modul_slug.'_pemohon_jabatan',
            //     'label' => 'Status Pengajuan',
            //     'type'  => 'static',
            //     'std'   => '<span class="label label-'.$status.'">'._x('status_'.$status).'</span>'.$date );
        }

        if ( $data_type != 'imb' )
        {
            $data_label = 'Permohonan';

            if ($data_type == 'tdp')
                $data_label = 'Agenda';
            
            if ($data_type == 'siup')
                $data_label = 'SIUP';

            $fields[]   = array(
                'name'  => $modul_slug.'_surat',
                'label' => 'No. &amp; Tgl. '.$data_label,
                'type'  => 'subfield',
                'attr'  => ( $data_obj ? 'disabled' : ''),
                'fields'=> array(
                    array(
                        'col'   => '6',
                        'name'  => 'nomor',
                        'label' => 'Nomor',
                        'type'  => 'text',
                        'std'   => ( $data_obj ? $data_obj->surat_nomor : ''),
                        'validation'=> ( !$data_obj ? 'required' : '' ) ),
                    array(
                        'col'   => '6',
                        'name'  => 'tanggal',
                        'label' => 'Tanggal',
                        'type'  => 'datepicker',
                        'std'   => ( $data_obj ? format_date( $data_obj->surat_tanggal ) : ''),
                        'validation'=> ( !$data_obj ? 'required' : '' ),
                        'callback'=> 'string_to_date' ),
                    )
                );
        }

        $this->load->library('baka_pack/former');

        $no_buttons = $data_id != '' ? TRUE : FALSE ;

        $form = $this->former->init( array(
            'name'       => $modul_slug,
            'action'     => current_url(),
            'fields'     => array_merge( $fields, $this->bpmppt->get_form( $data_type, $data_obj )),
            'no_buttons' => $no_buttons,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $data_type == 'imb' )
            {
                $form_data[$modul_slug.'_surat_nomor'] = 614;
            }

            if ( $data_type == 'iup' )
            {
                $i = 0;
                $koor_fn = $modul_slug.'_tambang_koor';

                foreach ($_POST[$koor_fn.'_no'] as $no)
                {
                    foreach (array('no', 'gb-1', 'gb-2', 'gb-3', 'gl-1', 'gl-2', 'gl-3', 'lsu') as $name)
                    {
                        $koor_name = $koor_fn.'_'.$name;
                        $koordinat[$i][$name] = isset($_POST[$koor_name][$i]) ? $_POST[$koor_name][$i] : 0;
                        unset($_POST[$koor_name][$i]);
                    }

                    $i++;
                }

                $form_data[$modul_slug.'_tambang_koor'] = serialize($koordinat);
            }

            foreach ($this->bpmppt->$data_type->fields as $field)
            {
                if (!isset($form_data[$modul_slug.$field]))
                    $form_data[$modul_slug.$field] = '';
            }

            unset($form_data[$modul_slug]);

            // var_dump($form_data);

            $data_id = $this->bpmppt->simpan( $modul_slug, $form_data );
            
            foreach ( $this->bpmppt->messages() as $level => $message )
            {
                $this->session->set_flashdata( $level, $message );
            }

            redirect( $this->data['page_link'].'form/'.$data_id );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    public function cetak( $data_type, $data_id = FALSE )
    {
        if ( $data_id )
        {
            $data = array_merge(
                    (array) $this->bpmppt->skpd_properties(),
                    (array) $this->bpmppt->get_fulldata_by_id($data_id));

            $this->load->theme('prints/products/'.$data_type, $data, 'print');
        }
        else
        {
            $this->data['tool_buttons']['data'] = 'Kembali|default';

            $this->data['panel_title'] = $this->themee->set_title('Laporan data '.$this->bpmppt->get_label( $data_type ));

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

            $this->load->library('baka_pack/former');

            $form = $this->former->init( array(
                'name'      => 'print-'.$data_type,
                'action'    => current_url(),
                'extras'    => array('target' => '_blank'),
                'fields'    => $fields,
                'buttons'   => $buttons,
                ));

            if ( $form_data = $form->validate_submition() )
            {
                $data = $this->bpmppt->skpd_properties();

                $data['submited'] = $form_data;
                $data['layanan']  = $this->bpmppt->get_label( $data_type );
                $data['results']  = $this->bpmppt->get_report( $data_type, $form->submited_data() );

                $this->load->theme('prints/reports/'.$data_type, $data, 'laporan');
            }
            else
            {
                $this->data['panel_body'] = $form->generate();

                $this->load->theme('pages/panel_form', $this->data);
            }
        }
    }

    public function delete( $data_type, $data_id )
    {
        if ( $this->bpmppt->delete_data( $data_id, $this->bpmppt->get_alias($data_type) ) )
        {
            $this->session->set_flashdata('message',
                array('Dokumen dengan id #'.$data_id.' berhasil dihapus secara permanen.'));
        }
        else
        {
            $this->session->set_flashdata('error',
                array('Terjadi kesalahan penghapusan dokumen sercara permanen.'));
        }

        redirect( $this->data['page_link'] );
    }

    public function ubah_status( $new_status, $data_id, $redirect )
    {
        if ( $this->bpmppt->change_status( $data_id, $new_status ) )
        {
            $message = ' '.( $new_status != 'deleted' ? 'berhasil diganti menjadi ' : '' );

            $this->session->set_flashdata('success',
                array('Status dokumen dengan id #'.$data_id.$message._x('status_'.$new_status)) );
        }
        else
        {
            $this->session->set_flashdata('error',
                array('Terjadi kesalahan penggantian status dokumen dengan id #'.$data_id) );
        }

        redirect( $this->data['page_link'] );
    }
}

/* End of file layanan.php */
/* Location: ./application/controllers/layanan.php */