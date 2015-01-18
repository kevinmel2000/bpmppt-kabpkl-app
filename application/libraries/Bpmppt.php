<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Bpmppt
 * @category    Libraries
 */

// -----------------------------------------------------------------------------

class Bpmppt
{
    protected
        $_ci,
        $izin,
        $driver,
        $tool_buttons = array(),
        $drivers = array();

    public
        $statuses = array();

    public function __construct()
    {
        $this->_ci =& get_instance();
        $this->izin =& $this->_ci->izin;

        $this->_ci->load->model('bpmppt_model');
        $this->_ci->load->driver('izin');
        $this->_ci->lang->load('bpmppt');

        foreach (array('pending', 'approved', 'deleted', 'done') as $status)
        {
            $this->statuses[$status] = $this->_ci->lang->line($status);
        }

        $this->drivers = $this->izin->get_drivers();

        log_message('debug', '#BPMPPT: Library initialized.');
    }

    public function __call($method, $args)
    {
        if (!method_exists($this->_ci->bpmppt_model, $method))
        {
            show_error('Undefined method Izin::'.$method.'() called', 500, 'An Error Eas Encountered');
        }

        return call_user_func_array(array($this->_ci->bpmppt_model, $method), $args);
    }

    public function get_buttons()
    {
        if (!empty($this->tool_buttons))
        {
            return $this->tool_buttons;
        }
    }

    public function get_navigation()
    {
        $_theme =& $this->_ci->bitheme;
        $_theme->add_navbar('data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side');

        if (!empty($this->drivers))
        {
            $link = 'layanan/';
            $nama = str_replace('/', '_', $link);

            $_theme->add_navmenu('data_sidebar', 'overview', 'link', $link.'overview', 'Overview', array(), 'side');
            $_theme->add_navmenu('data_sidebar', 'laporan', 'link', $link.'laporan', 'Laporan', array(), 'side');
            $_theme->add_navmenu('data_sidebar', $nama.'d', 'devider', '', '', array(), 'side');
            $_theme->add_navmenu('data_sidebar', 'au_head', 'header', '', 'Data Perizinan', array(), 'side');

            foreach ($this->drivers as $name => $driver)
            {
                $alias = $nama.$driver['alias'];
                $_link = $link.$name;
                $label = $driver['label'];

                $_theme->add_navmenu('data_sidebar', $alias, 'link', $_link, $label, array(), 'side');
            }
        }
    }

    public function get_overview()
    {
        if (!empty($this->drivers))
        {
            $overviews = array();

            foreach ($this->drivers as $name => $driver)
            {
                $overviews[$name] = array(
                    'label' => $driver['label'],
                    'alias' => $driver['alias'],
                    'total' => $this->izin->count_data($driver['alias']),
                    'chart' => array(
                        'id'     => $name.'-chart',
                        'class'  => 'charts',
                        'width'  => '100px',
                        'height' => '100px',
                        ),
                    );

                foreach (array_keys($this->statuses) as $status)
                {
                    $_stat = $this->izin->count_data($driver['alias'], array('status' => $status))  ?: 0;

                    $overviews[$name][$status] = $_stat;
                    $overviews[$name]['chart']['data-'.$status] = $_stat;
                }
            }

            return $overviews;
        }

        return FALSE;
    }

    public function get_datatable($driver, $page_link)
    {
        $this->tool_buttons['data'] = 'Kembali|default';
        $this->tool_buttons['form']  = 'Baru|primary';
        $this->tool_buttons['laporan'] = 'Laporan|info';
        $this->tool_buttons['Template|default'] = array(
            'data/setting'  => 'Data',
            'laporan/setting' => 'Laporan',
            );
        $this->tool_buttons[0] = array(
            'data/status/semua' => 'Semua',
            );

        foreach ($this->statuses as $s_link => $s_label)
        {
            $this->tool_buttons[0]['data/status/'.$s_link] = $s_label;
        }

        $slug = $this->izin->get_alias($driver);
        $stat = FALSE;

        switch ($this->_ci->uri->segment(4))
        {
            case 'status':
                $stat  = $this->_ci->uri->segment(5);
                $query = $this->izin->get_data_by_status($stat, $slug);
                break;

            case 'page':
            default:
                $query = $this->izin->get_data_by_type($slug);
                break;
        }

        $this->_ci->load->library('bitable', array(
            'base_url' => $page_link,
            ));

        $grid = $this->_ci->bitable->set_column('Pengajuan',
                                'callback_anchor:id|no_agenda, callback_format_datetime:created_on',
                                '30%',
                                '<strong>%s</strong><br><small class="text-muted">Diajukan pada: %s</small>')
                            ->set_column('Pemohon', 'petitioner', '40%', '<strong>%s</strong>')
                            ->set_column('Status', 'status, callback__x:status', '10%', '<span class="label label-%s">%s</span>');

        $grid->set_button('form', 'Lihat data');

        if ($stat == 'deleted')
        {
            $grid->set_button('delete', 'Hapus data secara permanen');
        }
        else
        {
            $grid->set_button('hapus', 'Hapus data');
        }

        return $grid->generate($query);
    }

    public function get_dataform($driver, $data_id = FALSE)
    {
        $this->_ci->load->library('biform');
        $this->tool_buttons['data'] = 'Kembali|default';
        $data_obj = $data_id ? $this->izin->get_fulldata_by_id($data_id) : FALSE;

        if ($data_obj)
        {
            if ($data_obj->status != 'deleted')
            {
                $h_link = 'hapus';
                $h_text = 'Hapus';
            }
            else
            {
                $h_link = 'delete';
                $h_text = 'Hapus Permanen';
            }

            $this->tool_buttons['form'] = 'Baru|primary';
            $this->tool_buttons[] = array(
                'laporan/'.$data_id => 'Cetak|info',
                $h_link.'/'.$data_id => $h_text.'|danger'
                );

            foreach ($this->statuses as $_link => $_label)
            {
                if ($_link != $data_obj->status)
                {
                    $s_link = 'ubah-status/'.$data_id.$_link.'/';
                    $this->tool_buttons['Ubah status|default'][$s_link] = $_label;
                }
            }
        }

        $form = $this->_ci->biform->initialize(array(
            'name'   => $this->izin->get_alias($driver),
            'action' => current_url(),
            'fields' => $this->izin->get_form_fields($driver, $data_obj, $data_id),
            ));

        if ($form_data = $form->validate_submition())
        {
            if ($new_id = $this->izin->simpan($form_data, $data_id))
            {
                $new_id = $data_id == FALSE ? '/'.$new_id : '' ;
            }

            foreach (get_message() as $type => $item)
            {
                $this->_ci->session->set_flashdata($type, $item);
            }

            redirect(current_url().$new_id);
        }

        return $form;
    }

    public function get_printform($driver = NULL)
    {
        $this->tool_buttons['data'] = 'Kembali|default';

        $this->_ci->load->library('biform');

        if (!$driver)
        {
            foreach ($this->izin->get_drivers(TRUE) as $module => $prop)
            {
                $modules[$module] = $prop->label;
            }

            $fields['data_type'] = array(
                'label' => 'Pilih data perijinan',
                'type'  => 'dropdown',
                'option'=> $modules,
                'desc'  => 'Pilih jenis dokumen yang ingin dicetak. Terdapat '.count($this->drivers).' yang dapat anda cetak.'
                );
        }

        $option = array('all' => 'Semua');
        foreach ($this->statuses as $s_link => $s_label)
        {
            if ($s_link != 'deleted')
            {
                $option[$s_link] = $s_label;
            }
        }

        $fields['data_status'] = array(
            'label' => 'Status Pengajuan',
            'type' => 'radio',
            'std' => 'all',
            'option' => $option,
            'desc' => 'tentukan status dokumennya, pilih <em>Semua</em> untuk mencetak semua dokumen dengan jenis dokumen diatas, atau anda dapat sesuaikan dengan kebutuhan.' );

        $fields['data_date'] = array(
            'label' => 'Bulan &amp; Tahun',
            'type'  => 'subfield',
            'fields'=> array(
                'month' => array(
                    'label' => 'Bulan',
                    'type'  => 'dropdown',
                    'option'=> add_placeholder( get_month_assoc(), 'Pilih Bulan')
                    ),
                'year' => array(
                    'label' => 'Tahun',
                    'type'  => 'dropdown',
                    'option'=> add_placeholder( get_year_assoc(), 'Pilih Tahun')
                    )
                ),
            'desc'  => 'Tentukan tanggal dan bulan dokumen.',
            );

        $buttons['do-print']= array(
            'type'  => 'submit',
            'label' => 'Cetak sekarang',
            'class' => 'btn-primary pull-right'
            );

        $form = $this->_ci->biform->initialize( array(
            'name'    => 'print-all',
            'action'  => current_url(),
            'fields'  => $fields,
            'buttons' => $buttons,
            ));

        if ($form_data = $form->validate_submition())
        {
            return $form_data;
        }
        else
        {
            return $form;
        }
    }
}
