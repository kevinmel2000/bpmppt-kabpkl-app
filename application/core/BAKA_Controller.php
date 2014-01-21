<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter core library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Controller Class
 *
 * @subpackage  Libraries
 * @category    Libraries
 */
class BAKA_Controller extends CI_Controller
{
    protected $current_user;

    /**
     * Default class constructor
     */
    function __construct()
    {
        parent::__construct();

        if ( Themee::verify_browser() AND !(php_sapi_name() === 'cli' OR defined('STDIN')) )
        {
            log_message('error', "error_browser_jadul");
            show_error(array('Peramban yang anda gunakan tidak memenuhi syarat minimal penggunaan aplikasi ini.','Silahkan gunakan '.anchor('http://www.mozilla.org/id/', 'Mozilla Firefox', 'target="_blank"').' atau '.anchor('https://www.google.com/intl/id/chrome/browser/', 'Google Chrome', 'target="_blank"').' biar lebih GREGET!'), 500, 'error_browser_jadul');
        }

        if ( Authen::is_logged_in() )
        {
            $this->current_user = $this->authen->get_current_user();
            // Adding sub of main and user navbar
            $this->navbar();
        }

        $this->data['load_toolbar'] = FALSE;
        $this->data['search_form']  = FALSE;
        $this->data['single_page']  = TRUE;
        $this->data['form_page']    = FALSE;
        
        $this->data['need_print']   = FALSE;

        $this->data['tool_buttons'] = array();

        $this->data['panel_title']  = '';
        $this->data['panel_body']   = '';

        log_message('debug', "#Baka_pack: Core Controller Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Redirecting to notice page
     *
     * @param   string  $page  Page name
     *
     * @return  void
     */
    protected function _notice( $page )
    {
        redirect('notice/'.$page);
    }

    // -------------------------------------------------------------------------

    /**
     * User login verification
     *
     * @return  void
     */
    protected function verify_login()
    {
        if ( !Authen::is_logged_in() AND !Authen::is_logged_in(FALSE) )
            redirect( 'login' );
        
        if ( Authen::is_logged_in(FALSE) )
            redirect( 'resend' );
    }

    // -------------------------------------------------------------------------

    /**
     * User status verification
     *
     * @return  void
     */
    protected function verify_status()
    {
        if ( Authen::is_logged_in() )
            redirect( 'dashboard' );
        else if ( Authen::is_logged_in(FALSE) )
            redirect('resend');
    }

    // -------------------------------------------------------------------------

    protected function navbar()
    {
        // Adding main navbar
        $this->themee->add_navbar( 'main_navbar', 'navbar-nav' );
        // Adding user navbar
        $this->themee->add_navbar( 'user_navbar', 'navbar-nav navbar-right' );

        if ( is_permited('doc_manage') )
        {
            // Adding dashboard menu to main navbar
            $this->themee->add_navmenu( 'main_navbar', 'dashboard', 'link', 'dashboard', 'Dashboard' );
            // Adding data menu to main navbar
            $this->themee->add_navmenu( 'main_navbar', 'master', 'link', 'data', 'Data Perijinan' );

            // Adding submenu to main_navbar-data
            $this->data_navbar( 'main_navbar-master', 'top' );
        }

        // Adding admin menu to main navbar
        $this->themee->add_navmenu( 'main_navbar', 'admin', 'link', 'admin', 'Administrasi' );
        // Adding account menu to user navbar
        $this->themee->add_navmenu( 'user_navbar', 'account', 'link', 'profile', $this->current_user['username'] );
        // Adding submenu to main_navbar-admin
        $this->admin_navbar( 'main_navbar-admin', 'top' );
        // Adding submenu to user_navbar-account
        $this->account_navbar( 'user_navbar-account', 'top' );
    }

    // -------------------------------------------------------------------------

    protected function data_navbar( $parent, $position = 'top' )
    {
        $link   = 'data/layanan/';
        $nama   = str_replace('/', '_', $link);

        $this->load->driver('bpmppt');

        $modules = $this->bpmppt->get_modules();

        if ( count( $modules ) > 0 )
        {
            $this->themee->add_navmenu( $parent, 'dashboard', 'link', 'dashboard', 'Statistik', array(), $position );
            // $this->themee->add_navmenu( $parent, $nama.'laporan', 'link', 'data/utama/laporan', 'Laporan', array(), $position );
            $this->themee->add_navmenu( $parent, $nama.'d', 'devider', '', '', array(), $position );

            foreach ( $modules as $class => $prop )
            {
                $this->themee->add_navmenu(
                    $parent,
                    $nama.$prop['alias'],
                    'link',
                    $link.'index/'.$class,
                    $prop['label'],
                    array(),
                    $position );
            }
        }
    }

    // -------------------------------------------------------------------------

    protected function admin_navbar( $parent_id, $position )
    {
        // Internal settings sub-menu
        // =====================================================================
        // Adding skpd sub-menu (if permited)
        if ( is_permited('internal_skpd_manage') )
            $this->themee->add_navmenu(
                $parent_id, 'ai_skpd', 'link', 'admin/internal/skpd', 'SKPD', array(), $position );

        // Adding application sub-menu (if permited)
        if ( is_permited('internal_application_manage') )
            $this->themee->add_navmenu(
                $parent_id, 'ai_application', 'link', 'admin/internal/app', 'Aplikasi', array(), $position );

        // Adding security sub-menu (if permited)
        if ( is_permited('internal_security_manage') )
            $this->themee->add_navmenu(
                $parent_id, 'ai_security', 'link', 'admin/internal/keamanan', 'Keamanan', array(), $position );

        // $this->themee->add_navmenu(
        // $parent_id, 'ai_property', 'link', 'admin/internal/prop', 'Properti', array(), $position );

        // Users Management sub-menu (if permited)
        // =====================================================================
        // Adding Users menu header
        $this->themee->add_navmenu( $parent_id, 'au_def', 'devider', '', '', array(), $position);
        $this->themee->add_navmenu(
            $parent_id, 'au_head', 'header', '', 'Pengguna', array(), $position);
        
        // Adding Self Profile sub-menu
        $this->themee->add_navmenu(
            $parent_id, 'au_me', 'link', 'profile', 'Profil Saya', array(), $position );

        // Adding Users sub-menu (if permited)
        if ( is_permited('users_manage') )
            $this->themee->add_navmenu(
                $parent_id, 'au_users', 'link', 'admin/pengguna/data', 'Semua Pengguna', array(), $position );

        // Adding Groups sub-menu (if permited)
        if ( is_permited('roles_manage') )
            $this->themee->add_navmenu(
                $parent_id, 'au_groups', 'link', 'admin/pengguna/groups', 'Kelompok', array(), $position );

        // Adding Perms sub-menu (if permited)
        if ( is_permited('perms_manage') )
            $this->themee->add_navmenu(
                $parent_id, 'a_permission', 'link', 'admin/pengguna/permission', 'Hak akses', array(), $position );

        // Application Mantenances sub-menu
        // =====================================================================
        if ( is_permited('sys_manage') )
        {
            // Adding System sub-menu (if permited)
            $this->themee->add_navmenu( $parent_id, 'ad_def', 'devider', '', '', array(), $position);
            $this->themee->add_navmenu(
                $parent_id, 'ad_head', 'header', '', 'Perbaikan', array(), $position);

            // Adding Backup & Restore sub-menu (if permited)
            if ( is_permited('sys_backstore_manage') )
            {
                // Backup sub-menu
                $this->themee->add_navmenu(
                    $parent_id, 'ad_backup', 'link', 'admin/maintenance/dbbackup', 'Backup Database', array(), $position );
                // Restore sub-menu
                $this->themee->add_navmenu(
                    $parent_id, 'ad_restore', 'link', 'admin/maintenance/dbrestore', 'Restore Restore', array(), $position );
            }

            // Adding System Log sub-menu (if permited)
            if ( is_permited('sys_logs_manage') )
                $this->themee->add_navmenu(
                    $parent_id, 'ad_syslogs', 'link', 'admin/maintenance/syslogs', 'Aktifitas sistem', array(), $position );
        }
    }

    // -------------------------------------------------------------------------

    protected function account_navbar( $parent_id, $position )
    {
        // Adding submenu to user navbar profile
        $this->themee->add_navmenu( $parent_id, 'profilse', 'link', 'profile', $this->current_user['username'], array(), $position );
        $this->themee->add_navmenu( $parent_id, 'user_s', 'devider', '', '', array(), $position);
        $this->themee->add_navmenu( $parent_id, 'user_logout', 'link', 'logout', 'Logout', array(), $position );
    }
}

/* End of file BAKA_Controller.php */
/* Location: ./application/core/BAKA_Controller.php */