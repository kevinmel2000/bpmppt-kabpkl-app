<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

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
 * BAKA Controller Class
 *
 * @subpackage  Core
 * @category    Controller
 */
class BAKA_Controller extends CI_Controller
{
    protected $current_user;

    protected $_modules_arr = array();

    /**
     * Default class constructor
     */
    function __construct()
    {
        parent::__construct();

        Asssets::set_script('jquery',    'lib/jquery.min.js', '', '2.0.3');
        Asssets::set_script('baka-pack', 'script.js', 'jquery' );
        Asssets::set_script('bootstrap', 'lib/bootstrap.min.js', 'jquery', '3.0.0' );
        Asssets::set_style('lato-font',  '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic');
        Asssets::set_style('baka-pack',  'style.min.css');

        $script = "$('.twbs-tooltip').tooltip();";
        Asssets::set_script('bootstrap-tooltip-trigger', $script, 'bootstrap');

        if (Themee::verify_browser() AND !is_cli())
        {
            log_message('error', lang("error_browser_jadul"));
            show_error(array('Peramban yang anda gunakan tidak memenuhi syarat minimal penggunaan aplikasi ini.','Silahkan gunakan '.anchor('http://www.mozilla.org/id/', 'Mozilla Firefox', 'target="_blank"').' atau '.anchor('https://www.google.com/intl/id/chrome/browser/', 'Google Chrome', 'target="_blank"').' biar lebih GREGET!'), 500, 'error_browser_jadul');
        }

        if ($this->authr->is_logged_in())
        {
            $this->current_user = $this->authr->get_current_user();
            // Adding sub of main and user navbar
            $this->navbar();
        }

        $app_name = get_conf('app_name');

        $this->data['brand_link']  = anchor(base_url(), $app_name, 'class="navbar-brand"');

        $this->data['load_toolbar'] = FALSE;
        $this->data['search_form']  = FALSE;
        $this->data['single_page']  = TRUE;
        $this->data['form_page']    = FALSE;
        
        $this->data['need_print']   = FALSE;

        $this->data['tool_buttons'] = array();

        $this->data['panel_title']  = '';
        $this->data['panel_body']   = '';

        $this->data['footer_left']  = '&copy; '.Setting::get('skpd_name').' '.Setting::get('skpd_city');
        $this->data['footer_right'] = $app_name.' Ver. '.get_conf('app_version');

        log_message('debug', "#Baka_pack: Core Controller Class Initialized");
    }

    // -------------------------------------------------------------------------
    
    public function captcha()
    {
        echo $this->authr->captcha->generate();
    }

    // -------------------------------------------------------------------------

    /**
     * Redirecting to notice page
     *
     * @param   string  $page  Page name
     *
     * @return  void
     */
    protected function _notice($page)
    {
        redirect('notice/'.$page);
    }

    // -------------------------------------------------------------------------

    /**
     * User login verification
     *
     * @return  void
     */
    protected function verify_login($from = '')
    {
        if (!$this->authr->is_logged_in() AND !$this->authr->is_logged_in(FALSE) AND !is_cli())
        {
            redirect('login?from='.$from);
        }
        
        if ($this->authr->is_logged_in(FALSE) AND !is_cli())
        {
            redirect('resend');
        }
    }

    // -------------------------------------------------------------------------

    /**
     * User status verification
     *
     * @return  void
     */
    protected function verify_status()
    {
        if ($this->authr->is_logged_in() AND !is_cli())
        {
            redirect('data');
        }
        else if ($this->authr->is_logged_in(FALSE) AND !is_cli())
        {
            redirect('resend');
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Setup panel and page title
     *
     * @param  string  $panel_title  Title of the Panel
     */
    protected function set_panel_title($panel_title)
    {
        $this->data['panel_title'] = $this->themee->set_title($panel_title);
    }

    // -------------------------------------------------------------------------

    /**
     * Setup panel body content
     *
     * @param  string  $panel_body  Content of panel body
     */
    protected function set_panel_body($panel_body)
    {
        $this->data['panel_body'] = $panel_body;
    }

    // -------------------------------------------------------------------------

    protected function navbar()
    {
        // Adding main navbar
        $this->themee->add_navbar('main_navbar', 'navbar-nav');
        // Adding user navbar
        $this->themee->add_navbar('user_navbar', 'navbar-nav navbar-right');

        if ($this->authr->is_permited('doc_manage'))
        {
            // Adding dashboard menu to main navbar
            $this->themee->add_navmenu('main_navbar', 'dashboard', 'link', 'data', 'Data Layanan');
            // Adding submenu to main_navbar-data
            // $this->data_navbar('main_navbar-master', 'top');

        }

        if ( $this->authr->is_permited('internal_skpd_manage') )
        {
            // Adding admin menu to main navbar
            $this->themee->add_navmenu('main_navbar', 'admin', 'link', 'admin/', 'Administrasi');
        }
        else
        {
            $this->themee->add_navmenu('main_navbar', 'admin', 'link', 'profile/', 'Profil Saya');
        }
        // Adding account menu to user navbar
        $this->themee->add_navmenu('user_navbar', 'account', 'link', 'profile', $this->current_user['username']);
        // Adding submenu to main_navbar-admin
        // $this->admin_navbar('main_navbar-admin', 'top');
        // Adding submenu to user_navbar-account
        $this->account_navbar('user_navbar-account', 'top');
    }

    // -------------------------------------------------------------------------

    protected function data_navbar($parent, $position = 'top')
    {
        $link   = 'data/layanan/';
        $nama   = str_replace('/', '_', $link);

        $this->load->driver('bpmppt');

        $modules = $this->bpmppt->get_modules();

        if (count($modules) > 0)
        {
            // Overview
            $this->themee->add_navmenu($parent, 'overview', 'link', 'data/utama', 'Overview', array(), $position);
            // Laporan
            $this->themee->add_navmenu($parent, 'laporan', 'link', 'data/laporan', 'Laporan', array(), $position);
            // Devider
            $this->themee->add_navmenu($parent, $nama.'d', 'devider', '', '', array(), $position);
            // Header
            $this->themee->add_navmenu($parent, 'au_head', 'header', '', 'Data Perizinan', array(), $position);
            // Datas
            foreach ($modules as $class => $prop )
            {
                $this->themee->add_navmenu(
                    $parent,
                    $nama.$prop['alias'],
                    'link',
                    $link.$class,
                    $prop['label'],
                    array(),
                    $position);
            }
        }

        $this->_modules_arr = $this->bpmppt->get_modules_assoc();
    }

    // -------------------------------------------------------------------------

    protected function admin_navbar($parent, $position)
    {
        // Internal settings sub-menu
        // =====================================================================
        // Adding skpd sub-menu (if permited)
        if ($this->authr->is_permited('internal_skpd_manage'))
        {
            $this->themee->add_navmenu($parent, 'ai_skpd', 'link', 'admin/internal/skpd', 'SKPD', array(), $position);
        }

        // Adding application sub-menu (if permited)
        if ($this->authr->is_permited('internal_application_manage'))
        {
            $this->themee->add_navmenu($parent, 'ai_application', 'link', 'admin/internal/app', 'Pengaturan Aplikasi', array(), $position);
        }

        // Adding security sub-menu (if permited)
        // if ($this->authr->is_permited('internal_security_manage'))
        // {
        //     $this->themee->add_navmenu($parent, 'ai_security', 'link', 'admin/internal/keamanan', 'Keamanan', array(), $position);
        // }

        // $this->themee->add_navmenu(
        // $parent, 'ai_property', 'link', 'admin/internal/prop', 'Properti', array(), $position);

        // Users Management sub-menu (if permited)
        // =====================================================================
        // Adding Users menu header
        $this->themee->add_navmenu($parent, 'au_def', 'devider', '', '', array(), $position);
        $this->themee->add_navmenu($parent, 'au_head', 'header', '', 'Pengguna', array(), $position);
        
        // Adding Self Profile sub-menu
        $this->themee->add_navmenu($parent, 'au_me', 'link', 'profile', 'Profil Saya', array(), $position);

        // Adding Users sub-menu (if permited)
        if ($this->authr->is_permited('users_manage'))
        {
            $this->themee->add_navmenu($parent, 'au_users', 'link', 'admin/pengguna/data', 'Semua Pengguna', array(), $position);
        }

        // Adding Groups sub-menu (if permited)
        if ($this->authr->is_permited('roles_manage'))
        {
            $this->themee->add_navmenu($parent, 'au_groups', 'link', 'admin/pengguna/groups', 'Kelompok', array(), $position);
        }

        // Adding Perms sub-menu (if permited)
        if ($this->authr->is_permited('perms_manage'))
        {
            $this->themee->add_navmenu($parent, 'a_permission', 'link', 'admin/pengguna/permission', 'Hak akses', array(), $position);
        }

        // Application Mantenances sub-menu
        // =====================================================================
        if ($this->authr->is_permited('sys_manage'))
        {
            // Adding System sub-menu (if permited)
            $this->themee->add_navmenu($parent, 'ad_def', 'devider', '', '', array(), $position);
            $this->themee->add_navmenu($parent, 'ad_head', 'header', '', 'Perbaikan', array(), $position);

            // Adding System Log sub-menu (if permited)
            if ($this->authr->is_permited('sys_logs_manage'))
            {
                $this->themee->add_navmenu($parent, 'ad_sysinfo', 'link', 'admin/sistem/info', 'Informasi Sistem', array(), $position);
            }

            // Adding Backup & Restore sub-menu (if permited)
            if ($this->authr->is_permited('sys_backstore_manage'))
            {
                // Backup sub-menu
                $this->themee->add_navmenu($parent, 'ad_backup', 'link', 'admin/sistem/backup', 'Backup Database', array(), $position);
                // Restore sub-menu
                $this->themee->add_navmenu($parent, 'ad_restore', 'link', 'admin/sistem/restore', 'Restore Database', array(), $position);
            }

            // Adding System Log sub-menu (if permited)
            if ($this->authr->is_permited('sys_logs_manage'))
            {
                $this->themee->add_navmenu($parent, 'ad_syslogs', 'link', 'admin/sistem/logs', 'Aktifitas sistem', array(), $position);
            }
        }
    }

    // -------------------------------------------------------------------------

    protected function account_navbar($parent, $position)
    {
        // Adding submenu to user navbar profile
        $this->themee->add_navmenu($parent, 'profilse', 'link', 'profile', $this->current_user['username'], array(), $position);
        $this->themee->add_navmenu($parent, 'user_s', 'devider', '', '', array(), $position);
        $this->themee->add_navmenu($parent, 'user_logout', 'link', 'logout', 'Logout', array(), $position);
    }
}

/* End of file BAKA_Controller.php */
/* Location: ./application/core/BAKA_Controller.php */