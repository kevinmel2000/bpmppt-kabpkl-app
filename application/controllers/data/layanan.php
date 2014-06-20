<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
 * Layanan Class
 *
 * @subpackage  Controller
 */
class Layanan extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login(uri_string());

        $this->themee->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
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
        // $this->data['search_form']   = TRUE;
        
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
            $this->data['tool_buttons']['form']              = 'Baru|primary';
            $this->data['tool_buttons']['cetak']             = 'Laporan|info';
            $this->data['tool_buttons']['Status:dd|default'] = array(
                'data/status/semua'     => 'Semua',
                'data/status/pending'   => 'Pending',
                'data/status/approved'  => 'Disetujui',
                'data/status/done'      => 'Selesai',
                'data/status/deleted'   => 'Dihapus'
                );
            $this->data['tool_buttons']['Template:dd|default'] = array(
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

            $this->load->library('gridr', array(
                'base_url'   => $this->data['page_link'],
                ));

            $grid = $this->gridr->set_column('Pengajuan',
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

            $this->load->theme('pages/panel_data', $this->data);
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

            $this->data['tool_buttons']['form'] = 'Baru|primary';
            $this->data['tool_buttons']['aksi|default']['cetak/'.$data_id] = 'Cetak';

            if ( $data_obj->status !== 'deleted' )
            {
                $this->data['tool_buttons']['aksi|default']['hapus/'.$data_id] = 'Hapus&message="Anda yakin ingin menghapus data nomor '.$data_obj->surat_nomor.'"';
            }
            else
            {
                $this->data['tool_buttons']['aksi|default']['delete/'.$data_id] = 'Hapus Permanen&message="Anda yakin ingin menghapus data nomor '.$data_obj->surat_nomor.'"';
            }

            $this->data['tool_buttons']['Ubah status:dd|default'] = array(
                'ubah-status/'.$data_id.'/pending/'  => 'Pending',
                'ubah-status/'.$data_id.'/approved/' => 'Disetujui',
                'ubah-status/'.$data_id.'/done/'     => 'Selesai' );

            $date   = ( $status != 'pending' ? ' pada: '.format_datetime( $data_obj->{$status.'_on'} ) : '' );
        }

        $this->data['panel_body'] = $this->bpmppt->get_form( $data_type, $data_obj, $data_id );

        $this->load->theme('pages/panel_form', $this->data);
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

            $fields[] = array(
                'name'  => 'data_status',
                'label' => 'Status Pengajuan',
                'type'  => 'dropdown',
                'option'=> array(
                    'all'       => 'Semua',
                    'pending'   => 'Tertunda',
                    'approved'  => 'Disetujui',
                    'done'      => 'Selesai' ),
                'desc'  => 'tentukan status dokumennya, pilih <em>Semua</em> untuk mencetak semua dokumen dengan jenis dokumen diatas, atau anda dapat sesuaikan dengan kebutuhan.' );

            $fields[] = array(
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

            $buttons[] = array(
                'name'  => 'do-print',
                'type'  => 'submit',
                'label' => 'Cetak sekarang',
                'class' => 'btn-primary pull-right' );

            $this->load->library('former');

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

                $wheres['type'] = $this->bpmppt->get_alias($data_type);

                if ( $form_data['data_date_month'] )
                {
                    $wheres['month'] = $form_data['data_date_month'];
                }

                if ( $form_data['data_date_year'] )
                {
                    $wheres['year'] = $form_data['data_date_year'];
                }

                if ( $form_data['data_status'] != 'all' )
                {
                    $wheres['status'] = $form_data['data_status'];
                }

                $data['submited'] = $form_data;
                $data['layanan']  = $this->bpmppt->get_label( $data_type );
                $data['results']  = $this->bpmppt->get_report( $wheres );

                print_pre($data['results']);

                // $this->load->theme('prints/reports/'.$data_type, $data, 'laporan');
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

    public function data_out( $data_type )
    {
        $modul_slug = $this->bpmppt->get_alias( $data_type );
        $data_label = $this->bpmppt->get_label( $data_type );

        $this->set_panel_title( 'Editing template output '.$data_label );
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $this->load->helper('file');

        $file_path    = APPPATH.'views/prints/products/'.$data_type.'.php';
        $file_content = read_file($file_path);

        $file_content = str_replace('<?php if (strlen($data_tembusan) > 0): ?>', '<!-- start loop -->', $file_content);
        $file_content = str_replace('<?php endif ?>', '<!-- end loop -->', $file_content);

        $file_content = str_replace('<?php', '{%', $file_content);
        $file_content = str_replace('?>', '%}', $file_content);

        $fields[] = array(
            'name'  => 'tmpl-editor',
            'type'  => 'editor',
            'height'=> 300,
            'label' => 'Template Editor',
            'std'   => $file_content,
            'left-desc'=> TRUE,
            'desc'  => 'Ubah dan sesuaikan template Print out dokumen '.$data_label.' sesuai dengan keinginan anda.<br>'
                    .  '<b>CATATAN: jangan mengubah isi dari text yang diapit oleh kurung kurawal "{...}" karna itu merupakan variabel data untuk output dokumen ini.</b><br>'
                    .  'Jika anda hendak memindahkan posisi, cut dan paste keseluruhan text termasuk kurung kurawalnya <i>misal: {text}</i> ke posisi baru yang anda inginkan.',
            );

        $this->load->library('former');

        $form = $this->former->init( array(
            'name'      => 'template-'.$modul_slug,
            'action'    => current_url(),
            'fields'    => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $form_data['tmpl-editor'] = str_replace('{%', '<?php', $form_data['tmpl-editor']);
            $form_data['tmpl-editor'] = str_replace('%}', '?>', $form_data['tmpl-editor']);

            $form_data['tmpl-editor'] = str_replace('<!-- start loop -->', '<?php if (strlen($data_tembusan) > 0): ?>', $form_data['tmpl-editor']);
            $form_data['tmpl-editor'] = str_replace('<!-- end loop -->', '<?php endif ?>', $form_data['tmpl-editor']);

            if (write_file($file_path.'', html_entity_decode($form_data['tmpl-editor'])))
            {
                $this->session->set_flashdata( 'success', 'Template '.$data_label.' berhasil diperbarui' );
            }
            else
            {
                $this->session->set_flashdata( 'error', 'Template gagal diperbarui' );
            }

            redirect(current_url());
        }
        else
        {
            $this->data['panel_body'] = $form->generate();

            $this->load->theme('pages/panel_form', $this->data);
        }
    }

    public function print_out( $data_type )
    {
        $modul_slug = $this->bpmppt->get_alias( $data_type );
        $data_label = $this->bpmppt->get_label( $data_type );

        $this->set_panel_title( 'Editing template output '.$data_label );
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $this->load->helper('file');

        $file_path    = APPPATH.'views/prints/reports/'.$data_type.'.php';
        $file_content = read_file($file_path);

        $file_content = str_replace('<?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>', '<!-- start loop -->', $file_content);
        $file_content = str_replace('<?php $i++; endforeach; else : ?>', '<!-- conditional loop -->', $file_content);
        $file_content = str_replace('<?php endif ?>', '<!-- end loop -->', $file_content);

        $file_content = str_replace('$row->', '#', $file_content);

        $file_content = str_replace('<?php', '{%', $file_content);
        $file_content = str_replace('?>', '%}', $file_content);

        $fields[] = array(
            'name'  => 'tmpl-editor',
            'type'  => 'editor',
            'height'=> 300,
            'label' => 'Template Editor',
            'std'   => $file_content,
            'left-desc'=> TRUE,
            'desc'  => 'Ubah dan sesuaikan template Print out dokumen '.$data_label.' sesuai dengan keinginan anda.<br>'
                    .  '<b>CATATAN: jangan mengubah isi dari text yang diapit oleh kurung kurawal "{...}" karna itu merupakan variabel data untuk output dokumen ini.</b><br>'
                    .  'Jika anda hendak memindahkan posisi, cut dan paste keseluruhan text termasuk kurung kurawalnya <i>misal: {text}</i> ke posisi baru yang anda inginkan.',
            );

        $this->load->library('former');

        $form = $this->former->init( array(
            'name'      => 'template-'.$modul_slug,
            'action'    => current_url(),
            'fields'    => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $form_data['tmpl-editor'] = str_replace('#', '$row->', $form_data['tmpl-editor']);

            $form_data['tmpl-editor'] = str_replace('{%', '<?php', $form_data['tmpl-editor']);
            $form_data['tmpl-editor'] = str_replace('%}', '?>', $form_data['tmpl-editor']);

            $form_data['tmpl-editor'] = str_replace('<!-- start loop -->', '<?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>', $form_data['tmpl-editor']);
            $form_data['tmpl-editor'] = str_replace('<!-- conditional loop -->', '<?php $i++; endforeach; else : ?>', $form_data['tmpl-editor']);
            $form_data['tmpl-editor'] = str_replace('<!-- end loop -->', '<?php endif ?>', $form_data['tmpl-editor']);

            if (write_file($file_path.'', html_entity_decode($form_data['tmpl-editor'])))
            {
                $this->session->set_flashdata( 'success', 'Template '.$data_label.' berhasil diperbarui' );
            }
            else
            {
                $this->session->set_flashdata( 'error', 'Template gagal diperbarui' );
            }

            redirect(current_url());
        }
        else
        {
            $this->data['panel_body'] = $form->generate();

            $this->load->theme('pages/panel_form', $this->data);
        }
    }
}

/* End of file layanan.php */
/* Location: ./application/controllers/layanan.php */