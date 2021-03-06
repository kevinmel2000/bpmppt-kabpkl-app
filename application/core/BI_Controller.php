<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  BI_Controller
 * @category    Core
 */

// -----------------------------------------------------------------------------

class BI_Controller extends CI_Controller {
    protected $current_user;

    protected $_defCon = 'layanan';

    protected $_drivers_arr = array();

    /**
     * Default class constructor
     */
    function __construct() {
        parent::__construct();

        if ($current_user = $this->biauth->get_current_user()) {
            $this->current_user = $current_user;

            if (isset($this->current_user['status']) and $this->current_user['status'] == 1) {
                $this->navbar();
            }
        }

        $this->data['brand_link'] = anchor('/', Bootigniter::app('name'), 'class="navbar-brand"');

        $this->data['load_toolbar'] = FALSE;
        $this->data['data_page'] = FALSE;

        // $this->data['need_print']   = FALSE;

        $this->data['tool_buttons'] = array();

        $this->data['panel_title'] = '';
        $this->data['panel_body'] = '';

        $this->data['footer_left'] = '&copy; ' . Bootigniter::get_setting('skpd_name') . ' ' . Bootigniter::get_setting('skpd_city');
        $this->data['footer_right'] = Bootigniter::app('name') . ' Ver. ' . Bootigniter::VERSION;

        log_message('debug', "#BootIgniter: Core Controller Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Redirecting to notice page
     *
     * @param   string  $page  Page name
     *
     * @return  void
     */
    protected function _notice($page) {
        redirect('notice/' . $page);
    }

    // -------------------------------------------------------------------------

    /**
     * User login verification
     *
     * @return  void
     */
    protected function verify_login($from = '') {
        if (!$this->biauth->is_logged_in() AND !$this->biauth->is_logged_in(FALSE)) {
            redirect('login?from=' . $from);
        }

        if ($this->biauth->is_logged_in(FALSE)) {
            redirect('resend');
        }
    }

    // -------------------------------------------------------------------------

    /**
     * User status verification
     *
     * @return  void
     */
    protected function verify_status() {
        if ($this->biauth->is_logged_in()) {
            redirect($this->_defCon);
        } elseif ($this->biauth->is_logged_in(FALSE)) {
            redirect('resend');
        }
    }

    // -------------------------------------------------------------------------

    protected function bi_setting($key) {
        return Bootigniter::get_setting($key);
    }

    // -------------------------------------------------------------------------

    /**
     * Setup panel and page title
     *
     * @param  string  $panel_title  Title of the Panel
     */
    protected function set_panel_title($panel_title) {
        $this->data['panel_title'] = $this->bitheme->set_title($panel_title);
    }

    // -------------------------------------------------------------------------

    /**
     * Setup panel body content
     *
     * @param  string  $panel_body  Content of panel body
     */
    protected function set_panel_body($panel_body) {
        $this->data['panel_body'] = $panel_body;
    }

    // -------------------------------------------------------------------------

    protected function navbar() {
        // Adding main navbar
        $this->bitheme->add_navbar('main_navbar', 'navbar-nav');
        // Adding user navbar
        $this->bitheme->add_navbar('user_navbar', 'navbar-nav navbar-right');

        if (is_user_can('manage_data')) {
            // Adding dashboard menu to main navbar
            $this->bitheme->add_navmenu('main_navbar', 'dashboard', 'link', 'layanan', 'Data Layanan');
        }

        if (is_user_can('admin_application')) {
            // Adding admin menu to main navbar
            $this->bitheme->add_navmenu('main_navbar', 'admin', 'link', 'admin/', 'Administrasi');
        } else {
            $this->bitheme->add_navmenu('main_navbar', 'admin', 'link', 'profile/', 'Profil Saya');
        }

        // Adding account menu to user navbar
        $this->bitheme->add_navmenu('user_navbar', 'account', 'link', 'profile', $this->current_user['display']);
        // Adding submenu to main_navbar-admin
        // $this->admin_navbar('main_navbar-admin', 'top');
        // Adding submenu to user_navbar-account
        $this->account_navbar('user_navbar-account', 'top');
    }

    // -------------------------------------------------------------------------

    protected function admin_navbar($parent, $position) {
        // Internal settings sub-menu
        // =====================================================================
        // Adding skpd sub-menu (if permited)
        if (is_user_can('admin_application') && is_user_can('setting_application')) {
            $this->bitheme->add_navmenu($parent, 'ai_skpd', 'link', 'admin/internal/skpd', 'SKPD', array(), $position);
            $this->bitheme->add_navmenu($parent, 'ai_application', 'link', 'admin/internal/app', 'Aplikasi', array(), $position);
            $this->bitheme->add_navmenu($parent, 'ai_security', 'link', 'admin/internal/security', 'Keamanan', array(), $position);
        }

        // $this->bitheme->add_navmenu(
        // $parent, 'ai_property', 'link', 'admin/internal/prop', 'Properti', array(), $position);

        // Users Management sub-menu (if permited)
        // =====================================================================
        // Adding Users menu header
        $this->bitheme->add_navmenu($parent, 'au_def', 'devider', '', '', array(), $position);
        $this->bitheme->add_navmenu($parent, 'au_head', 'header', '', 'Pengguna', array(), $position);

        // Adding Self Profile sub-menu
        $this->bitheme->add_navmenu($parent, 'au_me', 'link', 'profile', 'Profil Saya', array(), $position);

        // Adding Users sub-menu (if permited)
        if (is_user_can('manage_users')) {
            $this->bitheme->add_navmenu($parent, 'au_users', 'link', 'admin/pengguna/data', 'Semua Pengguna', array(), $position);
        }

        // Adding Groups sub-menu (if permited)
        if (is_user_can('manage_groups')) {
            $this->bitheme->add_navmenu($parent, 'au_groups', 'link', 'admin/pengguna/groups', 'Kelompok', array(), $position);
        }

        // Application Mantenances sub-menu
        // =====================================================================
        if (is_user_can('setting_application')) {
            // Adding System sub-menu (if permited)
            $this->bitheme->add_navmenu($parent, 'ad_def', 'devider', '', '', array(), $position);
            $this->bitheme->add_navmenu($parent, 'ad_head', 'header', '', 'Perbaikan', array(), $position);

            // Adding System Log sub-menu (if permited)
            if (is_user_can('debug_application')) {
                $this->bitheme->add_navmenu($parent, 'ad_sysinfo', 'link', 'admin/sistem/info', 'Informasi Sistem', array(), $position);
                $this->bitheme->add_navmenu($parent, 'ad_syslogs', 'link', 'admin/sistem/logs', 'Aktifitas sistem', array(), $position);
            }

            // Adding Backup & Restore sub-menu (if permited)
            // if (is_user_can('backstore_application')) {
            //     $this->bitheme->add_navmenu($parent, 'ad_updates', 'link', 'admin/sistem/updates', 'Pembaruan Sistem', array(), $position);
            // }

            // Adding Backup & Restore sub-menu (if permited)
            if (is_user_can('backstore_application')) {
                $this->bitheme->add_navmenu($parent, 'ad_backup', 'link', 'admin/sistem/backup', 'Backup Database', array(), $position);
                $this->bitheme->add_navmenu($parent, 'ad_restore', 'link', 'admin/sistem/restore', 'Restore Database', array(), $position);
            }
        }
    }

    // -------------------------------------------------------------------------

    protected function account_navbar($parent, $position) {
        // Adding submenu to user navbar profile
        $this->bitheme->add_navmenu($parent, 'profilse', 'link', 'profile', $this->current_user['username'], array(), $position);
        $this->bitheme->add_navmenu($parent, 'user_s', 'devider', '', '', array(), $position);
        $this->bitheme->add_navmenu($parent, 'user_logout', 'link', 'logout', 'Logout', array(), $position);
    }
}

/* End of file BI_Controller.php */
/* Location: ./application/core/BI_Controller.php */
